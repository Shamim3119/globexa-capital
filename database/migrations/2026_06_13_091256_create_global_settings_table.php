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
            $table->integer('gen_comm_level')->unsigned()->nullable();
            $table->decimal('min_deposit', 10, 2)->unsigned()->nullable();
            $table->decimal('min_activation', 10, 2)->unsigned()->nullable();
            $table->decimal('min_withdrawal', 10, 2)->unsigned()->nullable();
            $table->decimal('max_deposit', 10, 2)->unsigned()->nullable();
            $table->decimal('max_activation', 10, 2)->unsigned()->nullable();
            $table->decimal('max_withdrawal', 10, 2)->unsigned()->nullable();
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
