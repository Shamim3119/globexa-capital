<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_devices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->string('device_id', 191);

            $table->string('device_name')->nullable();

            $table->string('platform', 50)->nullable();

            $table->timestamp('verified_at')->nullable();

            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();

            $table->unique([
                'client_id',
                'device_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_devices');
    }
};