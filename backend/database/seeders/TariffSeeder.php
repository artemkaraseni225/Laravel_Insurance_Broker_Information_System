<?php

namespace Database\Seeders;

use App\Models\InsuranceType;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    public function run(): void
    {
        $tariffs = [
            'auto' => [
                ['name' => 'Базовый', 'base_price' => 1200],
                ['name' => 'Расширенный', 'base_price' => 2500],
            ],
            'property' => [
                ['name' => 'Базовый', 'base_price' => 800],
                ['name' => 'Премиум', 'base_price' => 2000],
            ],
            'health' => [
                ['name' => 'Базовый', 'base_price' => 1500],
                ['name' => 'Премиум', 'base_price' => 3500],
            ],
        ];

        foreach ($tariffs as $code => $items) {
            $type = InsuranceType::where('code', $code)->first();

            if (! $type) {
                continue;
            }

            foreach ($items as $item) {
                Tariff::firstOrCreate(
                    ['insurance_type_id' => $type->id, 'name' => $item['name']],
                    ['base_price' => $item['base_price']]
                );
            }
        }
    }
}
