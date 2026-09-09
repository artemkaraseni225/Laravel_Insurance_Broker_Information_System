<?php

namespace App\Services\Insurance\Calculators;

use App\Models\Tariff;

class HealthPriceCalculator implements PriceCalculatorInterface
{
    public function calculate(Tariff $tariff, array $params): float
    {
        $price = (float) $tariff->base_price;

        $age = (int) $params['age'];
        if ($age > 60) {
            $price *= 1.6;
        } elseif ($age > 40) {
            $price *= 1.3;
        }

        $termMonths = (int) $params['term_months'];
        $price *= $termMonths / 12;

        $options = $params['options'] ?? [];

        if (in_array('dental_addon', $options, true)) {
            $price += 15;
        }

        if (in_array('sports_addon', $options, true)) {
            $price *= 1.1; // +10% за травмоопасные виды спорта
        }

        return round($price, 2);
    }
}
