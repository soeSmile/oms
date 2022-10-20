<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('goods', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Good name (EN)');
            $table->integer('brand_id')->unsigned()->comment('ID brand');
            $table->decimal('width_box')->nullable()->comment('Width (in box)');
            $table->decimal('height_box')->nullable()->comment('Height (in box)');
            $table->decimal('length_box')->nullable()->comment('Length (in box)');
            $table->decimal('weight_gross')->nullable()->comment('Weight (gross)');
            $table->decimal('volume')->nullable();
            $table->boolean('deposit')->default(false)->comment('Deposit good');
        });

        DB::statement('CREATE INDEX good_name_idx ON goods USING gin (name gin_trgm_ops)');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
};
