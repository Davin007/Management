<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControllerMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controller_method',function (Blueprint $table){
            $table->increments('id');
            $table->string('controller_action',255);
            $table->string('description', 255);
            $table->dateTime('created_at');
            $table->integer('created_by')->nullable();
            $table->dateTime('updated_at')->nullable();
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
        Schema::drop('controller_method');
    }
}
