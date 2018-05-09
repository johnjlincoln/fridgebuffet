<?php

/**
 * Seeder for the Ingredients Table
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Grab the IDs of the 3 seeder recipes
        $grilled_cheese_id = DB::table('recipes')->where('name', 'Classic Grilled Cheese')->value('id');
        $tomato_soup_id    = DB::table('recipes')->where('name', 'Classic Tomato Soup')->value('id');
        $bread_bowl_id     = DB::table('recipes')->where('name', 'Classic Bread Bowl')->value('id');

        // Grilled Cheese

        DB::table('ingredients')->insert([
            'recipe_id'   => $grilled_cheese_id,
            'name'        => 'Sourdough Bread',
            'description' => 'Sourdough Bread',
            'tag'         => 'Bread',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $grilled_cheese_id,
            'name'        => 'Aged Sharp Cheddar Cheese',
            'description' => 'Aged Sharp Cheddar Cheese',
            'tag'         => 'Cheese',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $grilled_cheese_id,
            'name'        => 'Butter',
            'description' => 'Butter',
            'tag'         => 'Butter',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        // Tomato Soup

        DB::table('ingredients')->insert([
            'recipe_id'   => $tomato_soup_id,
            'name'        => 'Peeled Tomatoes',
            'description' => 'Peeled Tomatoes',
            'tag'         => 'Tomato',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $tomato_soup_id,
            'name'        => 'Heavy Cream',
            'description' => 'Heavy Cream',
            'tag'         => 'Cream',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $tomato_soup_id,
            'name'        => 'Vegetable Broth',
            'description' => 'Vegetable Broth',
            'tag'         => 'Broth',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $tomato_soup_id,
            'name'        => 'Basil',
            'description' => 'Fresh Basil',
            'tag'         => 'Spice',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        // Bread Bowl

        DB::table('ingredients')->insert([
            'recipe_id'   => $bread_bowl_id,
            'name'        => 'Egg',
            'description' => 'Egg',
            'tag'         => 'Egg',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $bread_bowl_id,
            'name'        => 'Yeast',
            'description' => 'Yeast',
            'tag'         => 'Yeast',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $bread_bowl_id,
            'name'        => 'Flour',
            'description' => 'Flour',
            'tag'         => 'Flour',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('ingredients')->insert([
            'recipe_id'   => $bread_bowl_id,
            'name'        => 'Salt',
            'description' => 'Salt',
            'tag'         => 'Salt',
            'created_at'  => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
