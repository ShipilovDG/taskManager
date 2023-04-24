<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('executor_task', function (Blueprint $table) {
            $table->unsignedBigInteger('executor_id')->nullable()->default(null)->unsigned();
            $table->foreign('executor_id')->references('id')->on('executors');;
            $table->unsignedBigInteger('task_id')->nullable()->default(null)->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executor_task');
    }
};
