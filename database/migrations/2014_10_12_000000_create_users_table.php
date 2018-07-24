<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 6)->unique();
            $table->string('user_name', 30)->unique();
            $table->string('user_full_name', 50);
            $table->string('user_password', 64);
            $table->string('email', 50)->unique();
            $table->string('reset_password_token', 512)->nullable();
            $table->string('thumbnail')->default('default.jpg');
            $table->tinyInteger('user_status')->default(0);
            $table->integer('position_id')->default(0);
            $table->integer('department_id')->default(0);
            $table->integer('role_id')->default(0);
            $table->tinyInteger('is_admin')->default('0');
            $table->integer('branch_id')->default(0);
            $table->timestamp('created_at');
            $table->integer('created_by');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
