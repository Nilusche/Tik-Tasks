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
            $table->boolean('completed')->default(false)->nullable();
            $table->boolean('visibility')->default(true)->nullable();

            $table->timestamps();
            $table->dateTime('deadline')->nullable();
            $table->dateTime('alarmdate')->nullable();
            $table->integer('alarmdateInteger')->nullable();
            

            $table->text('calendarICS')->default('#')->nullable();
            $table->text('calendarGoogle')->default('#')->nullable();
            $table->text('calendarWebOutlook')->default('#')->nullable();

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
