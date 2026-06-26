<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_slots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('left_amount', 10, 2)->unsigned()->nullable();
            $table->decimal('right_amount', 10, 2)->unsigned()->nullable();
            $table->decimal('salary_ammount', 10, 2)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slots');
    }
};
