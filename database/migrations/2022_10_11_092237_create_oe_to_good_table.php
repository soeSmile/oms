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
        Schema::create('good_to_oe', static function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->comment('ID good')->index();
            $table->text('oe')->comment('ОЕ/ОЕМ');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('good_to_oe');
    }
};
