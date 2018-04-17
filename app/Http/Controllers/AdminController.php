<?php

/**
 * Admin Controller
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API\apiRecipe;

class AdminController extends Controller
{
    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the Admin home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $api_recipes_loaded = apiRecipe::where('api_recipe_data_loaded', 1)->count();
        $api_recipes_not_loaded = apiRecipe::where('api_recipe_data_loaded', 0)->count();
        $last_api_recipe_loaded = apiRecipe::where('api_recipe_data_loaded', 1)->latest()->first();
        $next_api_recipe_to_load = apiRecipe::where('api_recipe_data_loaded', 0)->oldest()->first();
        return view('admin/admin', [
            'api_recipes_loaded'      => $api_recipes_loaded,
            'api_recipes_not_loaded'  => $api_recipes_not_loaded,
            'last_api_recipe_loaded'  => $last_api_recipe_loaded->api_recipe_title,
            'next_api_recipe_to_load' => $next_api_recipe_to_load->api_recipe_title
        ]);
    }
}
