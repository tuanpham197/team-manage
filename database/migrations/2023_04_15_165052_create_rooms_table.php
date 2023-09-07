<?php

declare(strict_types=1);

use App\Enums\MessageTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChanelsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('custom_name')->nullable();
            $table->string('custom_avatar')->nullable();
            $table->text('last_message')->nullable();
            $table->dateTime('last_message_at')->nullable();
            $table->integer('last_message_type')->default(MessageTypeEnum::TEXT);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chanels');
    }
}
