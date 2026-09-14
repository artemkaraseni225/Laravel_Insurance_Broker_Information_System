<?php

namespace App\Http\Requests\Application;

use App\Http\Requests\Calculator\CalculateInsuranceRequest;

// Заявка принимает ровно те же входные данные, что и расчёт
// в калькуляторе
// тариф, срок, доп. опции и age/property_value в зависимости от
// типа. Переиспользуем валидацию вместо дублирования правил.
class CreateApplicationRequest extends CalculateInsuranceRequest
{
}
