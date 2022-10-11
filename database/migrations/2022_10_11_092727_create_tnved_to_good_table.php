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
        Schema::create('tnved_to_good', static function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->primary()->comment('ID товара');
            $table->text('tnved')->comment('Код ТНВЭД');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tnved_to_good');
    }
};
