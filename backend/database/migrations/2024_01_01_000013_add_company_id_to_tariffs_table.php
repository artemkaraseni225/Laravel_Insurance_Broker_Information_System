<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable()
                ->after('insurance_type_id')
                ->constrained('insurance_companies')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tariffs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
        });
    }
};
