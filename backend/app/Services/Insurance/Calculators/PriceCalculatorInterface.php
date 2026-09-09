<?php

namespace App\Services\Insurance\Calculators;

use App\Models\Tariff;

interface PriceCalculatorInterface
{
    /**
     * @param Tariff $tariff Выбранный тариф (несёт base_price)
     * @param array $params Провалидированные параметры запроса (age/property_value/term_months/options и т.д.)
     */
    public function calculate(Tariff $tariff, array $params): float;
}
