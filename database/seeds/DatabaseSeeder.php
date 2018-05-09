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
     * Run the database seeds. DO NOT add seeders for the API tables to this class. API seeders should be called manually if needed.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RecipesTableSeeder::class,
            IngredientsTableSeeder::class,
        ]);
    }
}
