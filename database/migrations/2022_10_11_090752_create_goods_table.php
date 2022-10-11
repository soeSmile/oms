<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('goods', static function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id')->unsigned()->comment('ID бренда');
            $table->decimal('width_box')->nullable()->comment('Ширина (в коробке)');
            $table->decimal('height_box')->nullable()->comment('Высота (в коробке)');
            $table->decimal('length_box')->nullable()->comment('Длина (в коробке)');
            $table->decimal('weight_gross')->nullable()->comment('Вес (брутто)');
            $table->decimal('volume')->nullable()->comment('Объем');
            $table->boolean('deposit')->default(false)->comment('Залог (да/нет)');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
};
