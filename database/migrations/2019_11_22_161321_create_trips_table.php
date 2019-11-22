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
            
            $table->double('start_lattitude', 9,6);
            $table->double('start_longtitude', 9,6);
            $table->double('end_lattitude', 9,6);
            $table->double('end_longtitude', 9,6);
            
            $table->enum('mode', ['car', 'publicTransport', 'bicycle','pedestrian'])->nullable();
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
