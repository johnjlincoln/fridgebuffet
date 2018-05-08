<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPlaceholderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('instructions');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('recipes');
    }

    /**
     * There's no going back...these must burn.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructions');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('recipes');
    }
}
