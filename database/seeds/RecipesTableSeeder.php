<?php

/**
 * Seeder for the Recipes Table
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

use Illuminate\Database\Seeder;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes')->insert([
            'name'       => 'Classic Grilled Cheese',
            'image_url'  => 'http://capstonevt.org/sites/default/files/Grilled-Cheese-Sandwiches_1.jpg',
            'publisher'  => 'FridgeBuffet',
            'source_url' => 'https://fridgebuffet.com',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('recipes')->insert([
            'name'       => 'Classic Tomato Soup',
            'image_url'  => 'https://domestocrat.files.wordpress.com/2012/11/img_6521.jpg',
            'publisher'  => 'FridgeBuffet',
            'source_url' => 'https://fridgebuffet.com',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('recipes')->insert([
            'name'       => 'Classic Bread Bowl',
            'image_url'  => 'https://domestocrat.files.wordpress.com/2012/09/img_4333.jpg',
            'publisher'  => 'FridgeBuffet',
            'source_url' => 'https://fridgebuffet.com',
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
