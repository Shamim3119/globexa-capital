<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('left_side')->nullable();
            $table->string('right_side')->nullable();
            $table->decimal('balance', 10, 2)->unsigned()->default(0);
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE clients AUTO_INCREMENT = 1000');

        $clientId = DB::table('clients')->insertGetId([
            'name'       => 'Globexa Capital Ltd',
            'address'    => null,
            'phone'     => null,
            'password'   => Hash::make('123456'),
            'balance'    => 0,
            'photo'      => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clients')
            ->where('id', $clientId)
            ->update([
                'left_side' => base_convert($clientId, 10, 36) . 'L',
                'right_side' => base_convert($clientId, 10, 36) . 'R',
            ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};