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
        Schema::create('api_raw_api_recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_f2f_id');
            $table->string('api_recipe_title');
            $table->string('api_recipe_image_url');
            $table->string('api_recipe_source_url');
            $table->string('api_recipe_f2f_url');
            $table->string('api_recipe_publisher');
            $table->string('api_recipe_publisher_url');
            $table->decimal('api_recipe_social_rank');
            $table->unsignedInteger('api_recipe_page');
            $table->boolean('api_recipe_data_pulled')
                  ->default(false);
            $table->integer('assigned_recipe_id')
                  ->nullable();
            $table->dateTime('date_assigned')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_raw_api_recipes');
    }
}
