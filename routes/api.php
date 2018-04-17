<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO: implement auth
// Route::middleware('auth:api')->get('/get/newRecipes', 'API\apiController@getNewRecipes');

Route::get('/get/pageInfo', 'API\apiController@getPageInfo');
Route::get('/get/unloadedApiRecipe', 'API\apiController@getUnloadedApiRecipe');
Route::get('/get/apiHealthData', 'API\apiController@getApiHealthData');

Route::post('/post/apiRecipeData', 'API\apiController@postApiRecipeData');
Route::post('/post/apiRecipes', 'API\apiController@postApiRecipes');
