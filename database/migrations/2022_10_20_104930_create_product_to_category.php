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
        Schema::create('product_to_category', static function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('category_id');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_to_category');
    }
};
