<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\apiRecipe;
use App\Models\API\apiRecipeData;

class apiController extends Controller
{

    /**
     * Retrieves a page of recipes from the F2F API, loads them into apiRecipe
     * models, and saves those models.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewRecipes()
    {
        // Grab a recipe from the last page retrieved to determine the next page to retrieve
        $recipe_from_last_page = apiRecipe::orderBy('api_recipe_page', 'desc')->first();
        $api_page = $recipe_from_last_page->api_recipe_page + 1;

        // Configure cURL
        $params = [
            'key'  => env('F2F_API_KEY'),
            'page' => $api_page
        ];
        $defaults = [
            CURLOPT_URL            => 'http://food2fork.com/api/search',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        // Send request
        $response = curl_exec($ch);

        // Check for errors and display the error message
        // TODO: logger? json return? Not this though
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);

        // Save new models
        // TODO: handle failure
        foreach ($response->recipes as $recipe) {
            $new_api_recipe = apiRecipe::create([
                'api_f2f_id'               => $recipe->recipe_id,
                'api_recipe_title'         => $recipe->title,
                'api_recipe_image_url'     => strlen($recipe->image_url) > 191 ? 'too long' : $recipe->image_url,
                'api_recipe_source_url'    => strlen($recipe->source_url) > 191 ? 'too long' : $recipe->source_url,
                'api_recipe_f2f_url'       => strlen($recipe->f2f_url) > 191 ? 'too long' : $recipe->f2f_url,
                'api_recipe_publisher'     => $recipe->publisher,
                'api_recipe_publisher_url' => strlen($recipe->publisher_url) > 191 ? 'too long' : $recipe->publisher_url,
                'api_recipe_social_rank'   => $recipe->social_rank,
                'api_recipe_page'          => (int)$api_page
            ]);
        }
        // TODO: return response!
    }

    /**
     * Retrieves data for an apiRecipe from the F2F API, loads the data into apiRecipeData
     * models, and saves those models. This function loads apiRecipeData models for the
     * first apiRecipe that has not had its data pulled.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecipeData()
    {
        // Grab any apiRecipe that has not had its data pulled
        $recipe = apiRecipe::dataNotPulled()->first();

        // Configure cURL
        $params = [
            'key' => env('F2F_API_KEY'),
            'rId' => $recipe->api_f2f_id
        ];
        $defaults = [
            CURLOPT_URL            => 'http://food2fork.com/api/get',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true
        ];
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        // Send request
        $response = curl_exec($ch);

        // Check for errors and display the error message
        // TODO: logger? json return? Not this though
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);

        // Save new models
        foreach ($response->recipe->ingredients as $ingredient) {
            $new_api_recipe_data = apiRecipeData::create([
                'api_id'              => $recipe->id,
                'api_f2f_id'          => $recipe->api_f2f_id,
                'api_ingredient_data' => isset($ingredient) ? $ingredient : 'not found'
            ]);
        }
        // TODO: logger? do this whole thing as 1 transaction? handle failures?

        // Mark the apiRecipe as having its data pulled
        $recipe->api_recipe_data_pulled = true;
        $success = $recipe->save();

        // TODO: logger? handle failures? return response!
        echo $success ? "Recipe " . $recipe->api_f2f_id . " pulled!" : "Pull failed on recipe " . $recipe->api_f2f_id . "failed...";
    }
}