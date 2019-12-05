<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->string('type', 10);
            $table->unsignedBigInteger('user_id');
            
        });
        
         Schema::table('transport_types', function($table) {
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
        Schema::dropIfExists('transport_types');
    }
}
