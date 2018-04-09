<?php

/**
 * Endpoints for handling data pulls from the Food2Fork API.
 * This is a very opinionated and verbose controller. In this case it's
 * mainly serving as couple of programatic buttons for a cron job to push.
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\API\apiRecipe;
use App\Models\API\apiRecipeData;
use Validator;

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
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            return response()->json([
                'error' => "cURL error ({$errno}):\n {$error_message}"
                ]);
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);

        // Save new models
        foreach ($response->recipes as $recipe) {
            $new_api_recipe = [
                'api_f2f_id'               => $recipe->recipe_id,
                'api_recipe_title'         => $recipe->title,
                'api_recipe_image_url'     => $recipe->image_url,
                'api_recipe_source_url'    => $recipe->source_url,
                'api_recipe_f2f_url'       => $recipe->f2f_url,
                'api_recipe_publisher'     => $recipe->publisher,
                'api_recipe_publisher_url' => $recipe->publisher_url,
                'api_recipe_social_rank'   => $recipe->social_rank,
                'api_recipe_page'          => (int)$api_page
            ];
            $validator = Validator::make($new_api_recipe, apiRecipe::$rules);
            if ($validator->fails()) {
                Log::error('Get new recipe failed. Validation failed.', [
                    'rId'         => $recipe->recipe_id,
                    'page_failed' => $api_page,
                    'errors'      => $validator->errors()
                ]);
                return response()->json([
                    'rId'         => $recipe->recipe_id,
                    'success'     => 'false',
                    'page_failed' => $api_page,
                    'errors'      => $validator->errors()
                ]);
            }
            $api_recipe_model =  new apiRecipe();
            $api_recipe_model->fill($new_api_recipe);
            $success = $api_recipe_model->save();
            if (!$success) {
                Log::error('Get new recipe failed. Save failed post validation.', [
                    'rId'    => $recipe->api_f2f_id,
                    'api_id' => $recipe->id,
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'rId'     => $recipe->recipe_id,
                    'success' => 'false',
                    'errors'  => $validator->errors()
                ]);
            }
        }
        Log::info('New page of recipes pulled.', [
            'page_retrieved' => $api_page
        ]);
        return response()->json([
            'success'        => 'true',
            'page_retrieved' => $api_page
        ]);
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
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            return response()->json([
                'error' => "cURL error ({$errno}):\n {$error_message}"
                ]);
        }

        // Close the handle and load the response
        curl_close($ch);
        $response = json_decode($response);

        // Save new models
        foreach ($response->recipe->ingredients as $ingredient) {
            $new_api_recipe_data = [
                'api_id'              => $recipe->id,
                'api_f2f_id'          => $recipe->api_f2f_id,
                'api_ingredient_data' => isset($ingredient) ? $ingredient : 'not found'
            ];
            $validator = Validator::make($new_api_recipe_data, apiRecipeData::$rules);
            if ($validator->fails()) {
                Log::error('Pull failed for rId. Validation failed.', [
                    'rId'    => $recipe->api_f2f_id,
                    'api_id' => $recipe->id,
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'rId'     => $recipe->api_f2f_id,
                    'success' => 'false',
                    'errors'  => $validator->errors()
                ]);
            }
            $api_recipe_data_model = new apiRecipeData();
            $api_recipe_data_model->fill($new_api_recipe_data);
            $success = $api_recipe_data_model->save();
            if (!$success) {
                Log::error('Pull failed for rId. Save failed post validation.', [
                    'rId'    => $recipe->api_f2f_id,
                    'api_id' => $recipe->id,
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'rId'     => $recipe->api_f2f_id,
                    'success' => 'false',
                    'errors'  => $validator->errors()
                ]);
            }
        }

        // Mark the apiRecipe as having its data pulled
        $recipe->markRecipeDataPulled();
        $success = $recipe->save();
        Log::info('Recipe pulled.', [
            'rId' => $recipe->api_f2f_id
        ]);

        return response()->json([
            'success' => $success,
            'string'  => $success ? 'Recipe ' . $recipe->api_f2f_id . ' pulled!' : 'Pull failed on recipe ' . $recipe->api_f2f_id
            ]);
    }
}
