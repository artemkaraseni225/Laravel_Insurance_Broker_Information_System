<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calculator\CalculateInsuranceRequest;
use App\Models\Tariff;
use App\Services\Insurance\CalculatorService;
use Illuminate\Validation\ValidationException;

class CalculatorController extends Controller
{
    public function __construct(private CalculatorService $calculatorService)
    {
    }

    public function quote(CalculateInsuranceRequest $request)
    {
        $data = $request->validated();

        $tariff = Tariff::with('insuranceType')->findOrFail($data['tariff_id']);

        if ($tariff->insuranceType->code !== $data['insurance_type']) {
            throw ValidationException::withMessages([
                'tariff_id' => ['Выбранный тариф не относится к указанному типу страхования.'],
            ]);
        }

        $price = $this->calculatorService->calculate($tariff, $data['insurance_type'], $data);

        return response()->json([
            'insurance_type' => $data['insurance_type'],
            'tariff' => $tariff->only(['id', 'name', 'base_price']),
            'term_months' => $data['term_months'],
            'options' => $data['options'] ?? [],
            'calculated_price' => $price,
        ]);
    }
}
