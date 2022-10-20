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
        Schema::create('brands', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Brand name');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
