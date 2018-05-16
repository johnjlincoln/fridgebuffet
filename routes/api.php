<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Temporary routes for the F2F jobs -- once complete these will be removed and replaced with an application API for users to consume
Route::get('/get/pageInfo', 'API\apiController@getPageInfo');
Route::get('/get/unloadedApiRecipe', 'API\apiController@getUnloadedApiRecipe');
Route::get('/get/apiHealthData', 'API\apiController@getApiHealthData');
Route::post('/post/apiRecipeData', 'API\apiController@postApiRecipeData');
Route::post('/post/apiRecipes', 'API\apiController@postApiRecipes');
