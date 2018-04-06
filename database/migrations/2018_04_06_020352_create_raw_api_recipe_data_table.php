<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawApiRecipeDataTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('api_tblRawApiRecipeData', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('api_id');
            $table->unsignedInteger('api_f2f_id');
            $table->string('ingredient_data');
            $table->integer('assigned_recipe_id')
                  ->nullable();
            $table->dateTime('date_assigned')
                  ->nullable();

            $table->timestamps()
                  ->useCurrent();

            $table->foreign('api_id')
                  ->references('id')
                  ->on('api_tblRawApiRecipes');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('api_tblRawApiRecipeData');
    }
}
