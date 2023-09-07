<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTasksTable extends Migration
{
    public function up()
    {
        Schema::create('order_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->unsignedBigInteger('after_task_id');
            $table->foreign('after_task_id')->references('id')->on('tasks');

            $table->unsignedBigInteger('before_task_id');
            $table->foreign('before_task_id')->references('id')->on('tasks');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_tasks');
    }
}
