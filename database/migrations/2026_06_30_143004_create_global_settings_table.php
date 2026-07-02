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
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('gen_comm_level')->nullable();

            $table->decimal('min_deposit', 10, 2)->unsigned()->nullable();
            $table->decimal('min_activation', 10, 2)->unsigned()->nullable();
            $table->decimal('min_withdrawal', 10, 2)->unsigned()->nullable();

            $table->decimal('max_deposit', 10, 2)->unsigned()->nullable();
            $table->decimal('max_activation', 10, 2)->unsigned()->nullable();
            $table->decimal('max_withdrawal', 10, 2)->unsigned()->nullable();

            $table->unsignedInteger('dep_comm_level');

            $table->decimal('ref_comm', 10, 2)->nullable();

            $table->decimal('deposit_rate', 10, 2)->default(0.00);
            $table->decimal('withdraw_rate', 10, 2)->default(0.00);
            $table->decimal('ivr_com', 10, 2)->default(0.00);

            $table->integer('inv_charge_level')->default(3);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_settings');
    }
};
