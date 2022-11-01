<?php

use App\Services\Event\EventEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('events', static function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('event')->comment(EventEnum::class);
            $table->unsignedBigInteger('user_id')->default(0)->comment('User. 0 - Default or System');
            $table->ipAddress('ip')->nullable()->comment('IP address');
            $table->jsonb('data')->comment('Data');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
