<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recipe_id');
            $table->string('name');
            $table->string('description');
            $table->string('tag');
            $table->timestamps();

            $table->foreign('recipe_id')
                  ->references('id')->on('recipe')
                  ->onDelete('cascade');
        });
        // set PK (id) to start at 100000
        DB::update("ALTER TABLE ingredient AUTO_INCREMENT = 100000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredient');
    }
}
