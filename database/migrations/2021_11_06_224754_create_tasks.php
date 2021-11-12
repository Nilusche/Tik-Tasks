<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->integer('priority')->default(1);
            $table->decimal('estimatedEffort')->nullable();
            $table->decimal('totalEffort')->nullable();
            $table->boolean('completed')->default(false);
            $table->boolean('visibility')->default(true);
            $table->timestamps();
            $table->dateTime('deadline')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->foreignId('users_id')->constrained()->default(0);
            $table->dateTime('alarmdate')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();

        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
