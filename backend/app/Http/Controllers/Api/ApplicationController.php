<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateApplicationRequest;
use App\Models\Application;
use App\Models\Tariff;
use App\Services\Insurance\CalculatorService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    public function __construct(private CalculatorService $calculatorService)
    {
    }

    public function store(CreateApplicationRequest $request)
    {
        // Заявки подаёт только клиент — у брокера/админа нет профиля customer
        Gate::authorize('is-customer');

        $customer = $request->user()->customer;
        $data = $request->validated();

        $tariff = Tariff::with('insuranceType')->findOrFail($data['tariff_id']);

        if ($tariff->insuranceType->code !== $data['insurance_type']) {
            throw ValidationException::withMessages([
                'tariff_id' => ['Выбранный тариф не относится к указанному типу страхования.'],
            ]);
        }

        // Цену считаем на бэке заново через тот же CalculatorService,
        $price = $this->calculatorService->calculate($tariff, $data['insurance_type'], $data);

        // insurance_type/tariff_id уже есть в отдельных колонках —
        // в JSON кладём только специфичные для расчёта параметры
        $insuranceData = collect($data)->except(['insurance_type', 'tariff_id'])->toArray();

        $application = Application::create([
            'customer_id' => $customer->id,
            'insurance_type_id' => $tariff->insurance_type_id,
            'tariff_id' => $tariff->id,
            'status' => ApplicationStatus::New,
            'calculated_price' => $price,
            'insurance_data' => $insuranceData,
        ]);

        return response()->json([
            'application' => $application->load(['insuranceType', 'tariff.company']),
        ], 201);
    }
}
