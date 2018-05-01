<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe', function (Blueprint $table) {
            $table->bigIncrements('id')
                  ->unsigned();
            $table->string('name');
            $table->string('image_url');
            $table->string('publisher');
            $table->string('source_url');
            $table->timestamps();
        });
        // set PK (id) to start at 100000
        DB::update("ALTER TABLE recipe AUTO_INCREMENT = 100000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}
