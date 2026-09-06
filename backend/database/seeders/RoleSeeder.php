<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['customer', 'broker', 'admin'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
