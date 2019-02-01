<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreComputerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('store_computers',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->string('uid')->nullable();
            $table->string('hashcode')->nullable();
            $table->string('register')->nullable();
            $table->string('kiosk')->nullable();
            $table->string('server')->nullable();
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
        Schema::drop('store_computers');
    }
}
