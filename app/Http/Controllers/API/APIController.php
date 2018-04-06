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

        // Close the handle
        curl_close($ch);
        echo $response;
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
