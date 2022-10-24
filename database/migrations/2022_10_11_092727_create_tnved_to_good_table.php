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
        Schema::create('good_to_tnved', static function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->comment('ID good');
            $table->text('tnved')->comment('Code TNVED');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('good_to_tnved');
    }
};
