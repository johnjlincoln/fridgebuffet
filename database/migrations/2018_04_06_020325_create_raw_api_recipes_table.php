<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawApiRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_tblRawApiRecipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->string('recipe_title');
            $table->string('recipe_source_url');
            $table->string('recipe_f2f_url', 100);
            $table->string('recipe_publisher', 100);
            $table->string('recipe_publisher_url', 100);
            $table->decimal('recipe_social_rank' 16, 14);
            $table->timestamps()
                  ->useCurrent();
                  
            $table->foreign('recipe_id')
                  ->references('recipe_id')
                  ->on('tblRecipe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_api_recipes');
    }
}
