<?php

namespace App\Services\Insurance\Calculators;

use App\Models\Tariff;

class PropertyPriceCalculator implements PriceCalculatorInterface
{
    public function calculate(Tariff $tariff, array $params): float
    {
        $price = (float) $tariff->base_price;

        // Премия растёт вместе со стоимостью имущества
        $propertyValue = (float) $params['property_value'];
        $price += $propertyValue * 0.002; // 0.2% от стоимости имущества

        $termMonths = (int) $params['term_months'];
        $price *= $termMonths / 12;

        $options = $params['options'] ?? [];

        if (in_array('security_system_discount', $options, true)) {
            $price *= 0.92; // скидка 8% за сигнализацию/охрану
        }

        if (in_array('full_coverage', $options, true)) {
            $price *= 1.25; // расширенное покрытие: пожар + кража + стихия
        }

        return round($price, 2);
    }
}
