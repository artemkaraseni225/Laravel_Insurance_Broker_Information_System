<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained('applications')->restrictOnDelete();
            $table->string('policy_number', 100)->unique();
            $table->string('status', 50)->default('pending_payment');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('premium', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
