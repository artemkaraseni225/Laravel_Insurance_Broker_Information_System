<?php

namespace App\Services\Insurance;

use App\Models\Tariff;
use App\Services\Insurance\Calculators\AutoPriceCalculator;
use App\Services\Insurance\Calculators\HealthPriceCalculator;
use App\Services\Insurance\Calculators\PriceCalculatorInterface;
use App\Services\Insurance\Calculators\PropertyPriceCalculator;
use InvalidArgumentException;

class CalculatorService
{
    /**
     * @var array<string, class-string<PriceCalculatorInterface>>
     */
    private array $calculators = [
        'auto' => AutoPriceCalculator::class,
        'property' => PropertyPriceCalculator::class,
        'health' => HealthPriceCalculator::class,
    ];

    public function calculate(Tariff $tariff, string $insuranceTypeCode, array $params): float
    {
        $calculatorClass = $this->calculators[$insuranceTypeCode]
            ?? throw new InvalidArgumentException("Нет калькулятора для типа: {$insuranceTypeCode}");

        /** @var PriceCalculatorInterface $calculator */
        $calculator = app($calculatorClass);

        return $calculator->calculate($tariff, $params);
    }
}
