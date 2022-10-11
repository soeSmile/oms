<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('hscode_to_good', function (Blueprint $table) {
            $table->bigInteger('good_id')->primary()->comment('ID товара');
            $table->text('hscode')->comment('Код HS Code. Аналог ТНВЭД для европы');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('hscode_to_good');
    }
};
