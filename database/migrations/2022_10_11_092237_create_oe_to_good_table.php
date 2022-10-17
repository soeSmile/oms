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
        Schema::create('oe_to_good', static function (Blueprint $table) {
            $table->unsignedBigInteger('good_id')->comment('ID good');
            $table->text('oe')->comment('ОЕ/ОЕМ');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oe_to_good');
    }
};
