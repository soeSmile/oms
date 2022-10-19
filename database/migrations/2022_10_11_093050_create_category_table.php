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
        Schema::create('categories', static function (Blueprint $table) {
            $table->id();
            $table->text('code')->nullable()->comment('Category code');
            $table->bigInteger('parent_id')->nullable()->comment('Parent ID');
            $table->text('name')->comment('English name');
        });

        DB::statement('CREATE INDEX name_idx ON categories USING gin (name gin_trgm_ops)');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
