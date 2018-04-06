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
            $table->unsignedInteger('api_f2f_id');
            $table->string('api_recipe_title');
            $table->string('api_recipe_source_url');
            $table->string('api_recipe_f2f_url', 100);
            $table->string('api_recipe_publisher', 100);
            $table->string('api_recipe_publisher_url', 100);
            $table->decimal('api_recipe_social_rank' 16, 14);
            $table->integer('assigned_recipe_id')
                  ->nullable();
            $table->dateTime('date_assigned')
                  ->nullable();

            $table->timestamps()
                  ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_tblRawApiRecipes');
    }
}
