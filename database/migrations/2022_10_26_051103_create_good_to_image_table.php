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
        Schema::create('good_to_image', static function (Blueprint $table) {
            $table->id();
            $table->text('path')->comment('Image path');
            $table->text('name')->comment('Image name');
            $table->unsignedBigInteger('good_id')->index();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('good_to_image');
    }
};
