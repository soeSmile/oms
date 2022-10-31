<?php

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm');

        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->boolean('confirm')->default(false);
            $table->uuid('confirm_key')->nullable()->unique();
            $table->smallInteger('time_zone', false, true)->default(3);
            $table->string('password');
            $table->smallInteger('role', false, true)->default(2)->comment(RoleEnum::class);
            $table->string('img')->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        $data = [
            [
                'name'       => 'Admin',
                'email'      => 'admin@yandex.ru',
                'phone'      => '333222333222',
                'password'   => bcrypt('qwerty12'),
                'role'       => RoleEnum::Admin->value,
                'confirm'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Manager',
                'email'      => 'manager@yandex.ru',
                'phone'      => '333222333222',
                'password'   => bcrypt('qwerty12'),
                'role'       => RoleEnum::Manager->value,
                'confirm'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            User::query()->create($item);
        }
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
