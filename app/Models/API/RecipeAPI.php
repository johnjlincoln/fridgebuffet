<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class RecipeAPI extends Model
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
    * The attributes that are mass assignable.
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
        'api_recipe_social_rank'
        'assigned_recipe_id',
        'date_assigned'
    ];

    /**
    * Get the RecipeAPI that owns the data.
    */
    public function recipeDataAPI()
    {
        return $this->hasMany('App\Models\API\RecipeDataAPI');
    }
}
