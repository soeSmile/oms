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
        Schema::create('number_to_good', static function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->comment('ID товара');
            $table->text('number')->comment('Каталожный номер');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('number_to_good');
    }
};
