import { useEffect, useState } from 'react';
import api from '../services/api';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
  CardFooter,
} from '@/components/ui/card';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

// Захардкоженные опции формы на тип страхования — соответствуют
// тому, что реально понимает CalculatorService на бэке (неделя 4).
// Никакой динамики из БД, как и решили раньше.
const TYPE_FIELDS = {
  auto: {
    options: [
      { key: 'no_accident_history', label: 'Без аварий в истории (скидка 10%)' },
      { key: 'additional_driver', label: 'Доп. водитель (+15%)' },
      { key: 'roadside_assistance', label: 'Помощь на дороге (+20)' },
    ],
  },
  property: {
    options: [
      { key: 'security_system_discount', label: 'Есть охранная сигнализация (скидка 8%)' },
      { key: 'full_coverage', label: 'Расширенное покрытие (+25%)' },
    ],
  },
  health: {
    options: [
      { key: 'dental_addon', label: 'Стоматология (+15)' },
      { key: 'sports_addon', label: 'Экстремальные виды спорта (+10%)' },
    ],
  },
};

function Calculator() {
  const [insuranceTypes, setInsuranceTypes] = useState([]);
  const [loadingTypes, setLoadingTypes] = useState(true);

  const [typeCode, setTypeCode] = useState('');
  const [tariffId, setTariffId] = useState('');
  const [age, setAge] = useState('');
  const [propertyValue, setPropertyValue] = useState('');
  const [termMonths, setTermMonths] = useState('12');
  const [options, setOptions] = useState({});

  const [result, setResult] = useState(null);
  const [error, setError] = useState(null);
  const [submitting, setSubmitting] = useState(false);

  // Список типов + тарифов грузим один раз при заходе на страницу
  useEffect(() => {
    api
      .get('/insurance-types')
      .then(({ data }) => setInsuranceTypes(data.data))
      .catch(() => setError('Не удалось загрузить типы страхования'))
      .finally(() => setLoadingTypes(false));
  }, []);

  const selectedType = insuranceTypes.find((t) => t.code === typeCode);
  const fieldsConfig = TYPE_FIELDS[typeCode];

  function handleTypeChange(code) {
    setTypeCode(code);
    setTariffId('');
    setOptions({});
    setResult(null);
  }

  function toggleOption(key, checked) {
    setOptions((prev) => ({ ...prev, [key]: checked }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setError(null);
    setResult(null);
    setSubmitting(true);

    const selectedOptions = Object.entries(options)
      .filter(([, checked]) => checked)
      .map(([key]) => key);

    const payload = {
      insurance_type: typeCode,
      tariff_id: Number(tariffId),
      term_months: Number(termMonths),
      options: selectedOptions,
    };

    if (typeCode === 'auto' || typeCode === 'health') {
      payload.age = Number(age);
    }

    if (typeCode === 'property') {
      payload.property_value = Number(propertyValue);
    }

    try {
      const { data } = await api.post('/calculator/quote', payload);
      setResult(data);
    } catch (err) {
      if (err.response?.status === 422) {
        const messages = Object.values(err.response.data.errors ?? {}).flat();
        setError(messages[0] ?? 'Проверьте введённые данные');
      } else {
        setError('Не удалось рассчитать стоимость');
      }
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <div className="flex min-h-screen items-center justify-center bg-muted/40 py-10">
      <Card className="w-full max-w-md">
        <CardHeader>
          <CardTitle>Калькулятор страховки</CardTitle>
          <CardDescription>Выбери тип страхования и параметры</CardDescription>
        </CardHeader>
        <form onSubmit={handleSubmit}>
          <CardContent className="space-y-4">
            <div className="space-y-2">
              <Label>Тип страхования</Label>
              <Select value={typeCode} onValueChange={handleTypeChange} disabled={loadingTypes}>
                <SelectTrigger>
                  <SelectValue placeholder={loadingTypes ? 'Загрузка...' : 'Выберите тип'} />
                </SelectTrigger>
                <SelectContent>
                  {insuranceTypes.map((type) => (
                    <SelectItem key={type.code} value={type.code}>
                      {type.name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            {selectedType && (
              <div className="space-y-2">
                <Label>Тариф</Label>
                <Select value={tariffId} onValueChange={setTariffId}>
                  <SelectTrigger>
                    <SelectValue placeholder="Выберите тариф" />
                  </SelectTrigger>
                  <SelectContent>
                    {selectedType.tariffs.map((tariff) => (
                      <SelectItem key={tariff.id} value={String(tariff.id)}>
                        {tariff.company ? `${tariff.company.name} — ` : ''}
                        {tariff.name} — от {tariff.base_price} / год
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>
            )}

            {(typeCode === 'auto' || typeCode === 'health') && (
              <div className="space-y-2">
                <Label htmlFor="age">Возраст</Label>
                <Input
                  id="age"
                  type="number"
                  value={age}
                  onChange={(e) => setAge(e.target.value)}
                  required
                />
              </div>
            )}

            {typeCode === 'property' && (
              <div className="space-y-2">
                <Label htmlFor="property_value">Стоимость имущества</Label>
                <Input
                  id="property_value"
                  type="number"
                  value={propertyValue}
                  onChange={(e) => setPropertyValue(e.target.value)}
                  required
                />
              </div>
            )}

            {typeCode && (
              <div className="space-y-2">
                <Label htmlFor="term_months">Срок (мес.)</Label>
                <Input
                  id="term_months"
                  type="number"
                  min="1"
                  max="60"
                  value={termMonths}
                  onChange={(e) => setTermMonths(e.target.value)}
                  required
                />
              </div>
            )}

            {fieldsConfig && (
              <div className="space-y-2">
                <Label>Доп. опции</Label>
                {fieldsConfig.options.map((option) => (
                  <div key={option.key} className="flex items-center gap-2">
                    <Checkbox
                      id={option.key}
                      checked={!!options[option.key]}
                      onCheckedChange={(checked) => toggleOption(option.key, checked)}
                    />
                    <Label htmlFor={option.key} className="font-normal">
                      {option.label}
                    </Label>
                  </div>
                ))}
              </div>
            )}

            {error && <p className="text-sm text-destructive">{error}</p>}

            {result && (
              <div className="rounded-md border bg-muted p-4 text-center">
                <p className="text-sm text-muted-foreground">Итоговая стоимость</p>
                <p className="text-2xl font-bold">{result.calculated_price}</p>
              </div>
            )}
          </CardContent>
          <CardFooter>
            <Button type="submit" className="w-full" disabled={submitting || !typeCode || !tariffId}>
              {submitting ? 'Считаем...' : 'Рассчитать'}
            </Button>
          </CardFooter>
        </form>
      </Card>
    </div>
  );
}

export default Calculator;
