<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
            
            $table->double('start_latitude', 9,6);
            $table->double('start_longitude', 9,6);
            $table->double('end_latitude', 9,6);
            $table->double('end_longitude', 9,6);
            
            $table->enum('mode', ['car', 'publicTransport', 'bicycle','pedestrian','carpool'])->nullable();
            $table->enum('engine', ['diesel', 'gasoline', 'electric'])->nullable();
            
            $table->integer('travelTime');
            $table->integer('distance');
            $table->double('co2emissions',7,3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('trips');
    }
}
