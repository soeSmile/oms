<?php

use App\Enum\LocaleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('category_translate', static function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->comment('Категория');
            $table->string('locale')->default(LocaleEnum::RU->value)->comment('Локаль. LocaleEnum::class');
            $table->text('name')->comment('Наименование');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translate');
    }
};
