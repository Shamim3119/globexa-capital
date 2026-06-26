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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('deposit_by')->unsigned()->nullable();
            $table->integer('currency_id')->unsigned()->nullable();
            $table->decimal('amount', 10, 2)->unsigned()->nullable();
            $table->timestamp('deposit_at')->nullable();
            $table->timestamp('deposit_accept')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->string('remarks'); 
            $table->string('deposit_doc');  
            $table->string('trxid');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
