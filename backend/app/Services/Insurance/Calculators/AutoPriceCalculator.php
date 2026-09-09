<?php

namespace App\Services\Insurance\Calculators;

use App\Models\Tariff;

class AutoPriceCalculator implements PriceCalculatorInterface
{
    public function calculate(Tariff $tariff, array $params): float
    {
        $price = (float) $tariff->base_price;

        // Молодые водители — выше риск
        $age = (int) $params['age'];
        if ($age < 21) {
            $price *= 1.5;
        } elseif ($age < 25) {
            $price *= 1.2;
        }

        // Годовая база приводится к выбранному сроку (в месяцах)
        $termMonths = (int) $params['term_months'];
        $price *= $termMonths / 12;

        $options = $params['options'] ?? [];

        if (in_array('no_accident_history', $options, true)) {
            $price *= 0.9; // скидка 10% за безаварийную историю
        }

        if (in_array('additional_driver', $options, true)) {
            $price *= 1.15; // +15% за второго водителя
        }

        if (in_array('roadside_assistance', $options, true)) {
            $price += 20; // фиксированная доплата за помощь на дороге
        }

        return round($price, 2);
    }
}
