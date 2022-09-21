<?php

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
            $table->string('name')->comment('Имя');
            $table->string('surname')->nullable()->comment('Фамилия');
            $table->string('phone')->comment('Телефон');
            $table->string('email')->unique();
            $table->boolean('confirm')->default(false)->comment('Метка подтверждения пользователя');
            $table->uuid('confirm_key')->nullable()->unique()->comment('Ключ для подтверждения.');
            $table->smallInteger('time_zone', false, true)->default(3)->comment('Временная зона пользователя');
            $table->string('password')->nullable();
            $table->smallInteger('role', false, true)->default(4)->comment('Роль. RoleEnum');
            $table->string('img')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'name'       => 'Admin',
                'email'      => 'admin@yandex.ru',
                'phone'      => '333222333222',
                'password'   => bcrypt('qwerty12'),
                'role'       => 1,
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
