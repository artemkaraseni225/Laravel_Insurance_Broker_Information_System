<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_type_id')->constrained('insurance_types')->restrictOnDelete();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('base_price', 12, 2)->default(0);
            $table->string('status', 50)->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
