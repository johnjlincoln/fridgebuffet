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
    * Get the apiRecipe that owns the data.
    */
    public function apiRecipeData()
    {
        return $this->hasMany('App\Models\API\apiRecipeData');
    }

    /**
    * Scope a query to only include recipes that have not had their data pulled.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeDataNotPulled($query)
    {
        return $query->where('api_recipe_data_pulled', false);
    }

    /**
     * VALIDATION
     */

    /**
     * [protected description]
     * @var [type]
     */
    protected $rules = [
        'api_recipe_title' => 'alpha_num|max:191',
        'api_f2f_id' =? 'max:10',
        'api_recipe_title' => 'max:191',
        'api_recipe_image_url' => 'max:191',
        'api_recipe_source_url' => 'max:191',
        'api_recipe_f2f_url' => 'max:191',
        'api_recipe_publisher' => 'max:191',
        'api_recipe_publisher_url' => 'max:191',
        'api_recipe_social_rank' => 'alpha_num',
        'api_recipe_page' => 'numeric'
    ];

    /**
     * [protected description]
     * @var [type]
     */
    protected $errors;

    /**
     * [validate description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function validate($data)
    {
        $v = Validator::make($data, $this->rules);

        if ($v->fails()) {
            $this->errors = $v->errors;
            return false;
        }

        return true;
    }

    /**
     * [errors description]
     * @return [type] [description]
     */
    public function errors()
    {
        return $this->errors;
    }
}
