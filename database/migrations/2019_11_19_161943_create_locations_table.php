<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->double('latitude', 9,6);
            $table->double('longitude', 9,6);
            
            $table->string('name', 60);
            
            $table->unsignedBigInteger('user_id');
           // $table->foreign('user_id')->references('id')->on('users');
        });
        
          Schema::table('locations', function($table) {
       $table->foreign('user_id')->references('id')->on('users');
          });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
