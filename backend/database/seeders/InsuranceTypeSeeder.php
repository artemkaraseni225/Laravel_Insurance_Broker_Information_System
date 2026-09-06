<?php

namespace Database\Seeders;

use App\Models\InsuranceType;
use Illuminate\Database\Seeder;

class InsuranceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Автострахование (ОСАГО)',
                'code' => 'auto',
                'description' => 'Обязательное страхование автогражданской ответственности',
            ],
            [
                'name' => 'Страхование имущества',
                'code' => 'property',
                'description' => 'Страхование недвижимого и движимого имущества',
            ],
            [
                'name' => 'Страхование здоровья',
                'code' => 'health',
                'description' => 'Добровольное медицинское страхование',
            ],
        ];

        foreach ($types as $type) {
            InsuranceType::firstOrCreate(['code' => $type['code']], $type);
        }
    }
}
