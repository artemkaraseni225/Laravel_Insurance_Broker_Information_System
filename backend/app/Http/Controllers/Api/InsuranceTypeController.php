<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InsuranceTypeResource;
use App\Models\InsuranceType;

class InsuranceTypeController extends Controller
{
    public function index()
    {
        $insuranceTypes = InsuranceType::query()
            ->where('status', 'active')
            ->with(['tariffs' => fn ($query) => $query->where('status', 'active')])
            ->get();

        return InsuranceTypeResource::collection($insuranceTypes);
    }
}
