<?php

namespace Database\Seeders;

use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class InsuranceCompanySeeder extends Seeder
{
    // Названия вымышленные — намеренно не используем реальные
    // страховые компании с придуманными ценами.
    public function run(): void
    {
        foreach (['СтрахПлюс', 'ГарантАсист'] as $name) {
            InsuranceCompany::firstOrCreate(['name' => $name]);
        }
    }
}
