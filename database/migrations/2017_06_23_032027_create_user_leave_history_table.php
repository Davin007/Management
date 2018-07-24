<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLeaveHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_leave_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_leave_id');
            $table->integer('from_status_id');
            $table->integer('to_status_id');
            $table->integer('from_assignee');
            $table->integer('to_assignee');
            $table->datetime('certified_at');
            $table->integer('certified_by');
            $table->dateTime('approved_at');
            $table->integer('approved_by');
            $table->dateTime('rejected_at');
            $table->integer('rejected_by');
            $table->dateTime('closed_at');
            $table->integer('closed_by');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_leave_history');
    }
}
