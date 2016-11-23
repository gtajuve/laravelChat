<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('message_team', function (Blueprint $table) {
           $table->integer('message_id')->unsighed()->index();
            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade');

            $table->integer('team_id')->unsighed()->index();
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('message_team');
    }
}
