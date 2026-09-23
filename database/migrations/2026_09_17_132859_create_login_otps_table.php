<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_otps', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->string('device_id', 191);

            $table->string('otp_hash');

            $table->timestamp('expires_at');

            $table->unsignedTinyInteger('attempts')
                ->default(0);

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index([
                'client_id',
                'device_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_otps');
    }
};