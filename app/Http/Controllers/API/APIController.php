<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\apiRecipe;
use App\Models\API\apiRecipeData;

class APIController extends Controller
{

    /**
     * TODO: robust comments - doc autor comments on all new files
     * Retrieve a collection of recipe_ids along with recipe metadata from F2F API.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewRecipes()
    {
        $recipe_from_last_page = apiRecipe::orderBy('api_recipe_page', 'desc')->first();
        $api_page = $recipe_from_last_page->api_recipe_page + 1;
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
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);
        // saves new models - does not report / handle
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
    }

    /**
     * Retrieve data for a recipe_id from F2F API.
     * TODO: doc comment on how this grabs the top recipe with no data then gets it
     * @return \Illuminate\Http\Response
     */
    public function getRecipeData()
    {
        $recipe = apiRecipe::dataNotPulled()->first();
        $params = [
            'key'  => env('F2F_API_KEY'),
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
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);
        // print_r($response);
        foreach ($response->recipe->ingredients as $ingredient) {
            $new_api_recipe_data = apiRecipeData::create([
                'api_id'              => $recipe->id,
                'api_f2f_id'          => $recipe->api_f2f_id,
                'api_ingredient_data' => isset($ingredient) ? $ingredient : 'not found'
            ]);
        }
        // TODO:: do this whole thing as 1 transaction
        $recipe->api_recipe_data_pulled = true;
        $success = $recipe->save();
        echo $success ? "Recipe " . $recipe->api_f2f_id . " pulled!" : "Pull failed on recipe " . $recipe->api_f2f_id . "failed...";
    }
}
