<?php

/**
 * Controller for handling raw API payloads retrieved from Food2Fork.
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
     * Gets the current page in api_raw_api_recipes along with the next page that.
     * needs to be loaded.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageInfo()
    {
        $recipe = apiRecipe::orderBy('api_recipe_page', 'desc')->first();
        $current_page = isset($recipe) ? $recipe->api_recipe_page : 1;
        $next_page = isset($recipe) ? $recipe->api_recipe_page + 1 : 1;

        return response()->json([
            'current_page' => $current_page,
            'next_page'    => $next_page
        ]);
    }

    /**
     * Gets the apiRecipe ID and corresponding Food2Fork ID for an apiRecipe that has not been loaded.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUnloadedApiRecipe()
    {
        $recipe = apiRecipe::dataNotLoaded()->noErrors()->first();

        return response()->json([
            'api_f2f_id' => $recipe->api_f2f_id,
            'api_id'     => $recipe->id
        ]);
    }

    /**
     * Gets some general data regarding the health of the api.
     * TODO: document this better and build it out
     *
     * @return \Illuminate\Http\Response
     */
    public function getApiHealthData()
    {
        $api_recipes_loaded = apiRecipe::where('api_recipe_data_loaded', 1)->count();
        $api_recipes_not_loaded = apiRecipe::where('api_recipe_data_loaded', 0)->count();
        $last_api_recipe_loaded = apiRecipe::where('api_recipe_data_loaded', 1)->latest()->first();
        $next_api_recipe_to_load = apiRecipe::where('api_recipe_data_loaded', 0)->oldest()->first();

        return response()->json([
            'apiRecipesLoaded'    => $api_recipes_loaded,
            'apiRecipesNotLoaded' => $api_recipes_not_loaded,
            'lastApiRecipeLoaded' => $last_api_recipe_loaded->api_recipe_title,
            'nextApiRecipeToLoad' => $next_api_recipe_to_load->api_recipe_title
        ]);
    }

    /**
     * Adds a new apiRecipe model for every recipe in the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postApiRecipes(Request $request)
    {
        foreach ($request->new_recipes as $recipe) {
            $new_api_recipe = [
                'api_f2f_id'               => $recipe['recipe_id'],
                'api_recipe_title'         => $recipe['title'],
                'api_recipe_image_url'     => $recipe['image_url'],
                'api_recipe_source_url'    => $recipe['source_url'],
                'api_recipe_f2f_url'       => $recipe['f2f_url'],
                'api_recipe_publisher'     => $recipe['publisher'],
                'api_recipe_publisher_url' => $recipe['publisher_url'],
                'api_recipe_social_rank'   => $recipe['social_rank'],
                'api_recipe_page'          => (int)$request->page
            ];
            $validator = Validator::make($new_api_recipe, apiRecipe::$rules);
            if ($validator->fails()) {
                Log::error('Load new recipes failed. Recipe failed validation.', [
                    'rId'         => $recipe['recipe_id'],
                    'page_failed' => (int)$request->page,
                    'errors'      => $validator->errors()
                ]);
                return response()->json([
                    'rId'         => $recipe['recipe_id'],
                    'success'     => 'false',
                    'page_failed' => (int)$request->page,
                    'errors'      => $validator->errors()
                ]);
            }
            $api_recipe_model =  new apiRecipe();
            $api_recipe_model->fill($new_api_recipe);
            $success = $api_recipe_model->save();
            if (!$success) {
                Log::error('Load new recipes failed. Save failed post validation.', [
                    'rId'    => $recipe['recipe_id'],
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'rId'     => $recipe['recipe_id'],
                    'success' => 'false',
                    'errors'  => $validator->errors()
                ]);
            }
        }
        Log::info('New page of recipes loaded.', [
            'page_retrieved' => (int)$request->page
        ]);

        return response()->json([
            'success'        => 'true',
            'page_retrieved' => (int)$request->page
        ]);
    }

    /**
     * Adds new apiRecipeData models for an apiRecipe.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postApiRecipeData(Request $request)
    {
        $recipe = apiRecipe::find($request->api_id);
        foreach ($request->ingredients as $ingredient) {
            $new_api_recipe_data = [
                'api_id'              => $request->api_id,
                'api_f2f_id'          => $recipe->api_f2f_id,
                'api_ingredient_data' => isset($ingredient) ? $ingredient : 'not found'
            ];
            $validator = Validator::make($new_api_recipe_data, apiRecipeData::$rules);
            if ($validator->fails()) {
                Log::error('Load failed for rId. Validation failed.', [
                    'rId'    => $recipe->api_f2f_id,
                    'api_id' => $recipe->id,
                    'errors' => $validator->errors()
                ]);
                $recipe->markRecipeHasErrors();
                $recipe->save();
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
                Log::error('Load failed for rId. Save failed post validation.', [
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
        $recipe->markRecipeDataLoaded();
        $success = $recipe->save();
        Log::info('Recipe loaded.', [
            'rId' => $recipe->api_f2f_id
        ]);

        return response()->json([
            'success' => $success,
            'string'  => $success ? 'Recipe ' . $recipe->api_f2f_id . ' loaded!' : 'Load failed on recipe ' . $recipe->api_f2f_id
            ]);
    }
}
