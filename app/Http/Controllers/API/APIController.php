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
        // $api_page = $api_page ?? 1;
        $search_url = 'http://food2fork.com/api/search?key=' . env('F2F_API_KEY') . '&page=' . $api_page;
        echo $search_url;
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

    /**
     * Update the specified recipe_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
