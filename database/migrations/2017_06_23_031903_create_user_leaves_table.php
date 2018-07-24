<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_leaves', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('leave_id');
            $table->string('leave_title', 100)->unique();
            $table->float('eave_duration');
            $table->date('leave_from');
            $table->date('leave_till');
            $table->string('leave_reason', 255);
            $table->integer('leave_assignee');
            $table->integer('leave_status_id');
            $table->timestamp('created_at');
            $table->integer('created_by');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_leaves');
    }
}
