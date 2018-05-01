<?php

/**
 * Database Seeder
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RecipesTableSeeder::class,
            IngredientsTableSeeder::class,
            InstructionsTableSeeder::class,
        ]);
    }
}
