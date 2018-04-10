<?php

/**
 * Model for Recipes pulled from the Food2Fork API
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class apiRecipe extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'api_raw_api_recipes';

    /**
    * The primary key associated with the model.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = true;


    /**
    * The model attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'api_f2f_id',
        'api_recipe_title',
        'api_recipe_image_url',
        'api_recipe_source_url',
        'api_recipe_f2f_url',
        'api_recipe_publisher',
        'api_recipe_publisher_url',
        'api_recipe_social_rank',
        'api_recipe_page',
        'api_recipe_data_pulled',
        'assigned_recipe_id',
        'date_assigned'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
    * Validation rules for the model attributes.
    *
    * @var array
    */
    public static $rules = [
        'api_recipe_title'         => 'alpha_num|max:191',
        'api_f2f_id'               => 'max:10',
        'api_recipe_title'         => 'max:191',
        'api_recipe_image_url'     => 'max:191',
        'api_recipe_source_url'    => 'max:191',
        'api_recipe_f2f_url'       => 'max:191',
        'api_recipe_publisher'     => 'max:191',
        'api_recipe_publisher_url' => 'max:191',
        'api_recipe_social_rank'   => 'numeric',
        'api_recipe_page'          => 'numeric'
    ];

    /**
     * The apiRecipeData models that belong to this apiRecipe.
     */
    public function apiRecipeData()
    {
        return $this->hasMany('App\Models\API\apiRecipeData', 'api_id');
    }

    /**
    * Scopes a query to only include apiRecipes that have not had their data pulled.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeDataNotLoaded($query)
    {
        return $query->where('api_recipe_data_loaded', false);
    }

    /**
     * Scopes a query to only include apiRecipes that have errors.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoErrors($query)
    {
        return $query->where('api_recipe_has_errors', false);
    }

    /**
     * Marks the current apiRecipe as "loaded" indicating that its apiRecipeData model(s)
     * have been pulled from the F2F API and successfully loaded.
     *
     * @return bool
     */
    public function markRecipeDataLoaded()
    {
        return $this->api_recipe_data_loaded = true;
    }

    /**
     * Marks the current apiRecipe as riddled with errors. Womp womp.
     *
     * @return bool
     */
    public function markRecipeHasErrors()
    {
        return $this->api_recipe_has_errors = true;
    }
}
