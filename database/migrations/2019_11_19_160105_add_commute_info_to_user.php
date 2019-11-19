<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommuteInfoToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->double('lattitude', 9,6);
            $table->double('longtitude', 9,6);
            $table->string('fuel_type', 10).nullable();
            $table->double('fuel_consumption', 5,2).nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['lattitude', 'longtitude', 'fuel_type', 'fuel_consumption']);
        });
    }
}
