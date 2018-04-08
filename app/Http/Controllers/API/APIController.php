<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\API\apiRecipe;
use App\Models\API\apiRecipeData;

class APIController extends Controller
{

    /**
     * Retrieve a collection of recipe_ids along with recipe metadata from F2F API.
     *
     * @param  int  $api_page - Page of F2F results to search
     * @return \Illuminate\Http\Response
     */
    public function getRecipes($api_page = 1)
    {
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
        $recipes = $response->recipes;
        // echo($api_page);

        foreach ($recipes as $recipe) {
            // json_decode($recipe);
            // print_r($recipe);
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getRecipeData($id)
    {
        $get_url = 'http://food2fork.com/api/get?key=' . env('F2F_API_KEY') . '&rId=' . $id;
    }
}
