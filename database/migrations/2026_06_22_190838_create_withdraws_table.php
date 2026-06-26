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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('withdraw_by')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->decimal('amount', 10, 2)->unsigned()->nullable();
            $table->timestamp('withdraw_at')->nullable();
            $table->timestamp('withdraw_apply')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('remarks'); 
            $table->string('withdraw_doc');  
            $table->string('trxid');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
