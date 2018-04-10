<?php

/**
 * Model for Recipe Data retrieved from the Food2Fork API
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;

class apiRecipeData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api_raw_api_recipe_data';

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
        'api_id',
        'api_f2f_id',
        'api_ingredient_data',
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
        'api_f2f_id'          => 'max:10',
        'api_ingredient_data' => 'max:191'
    ];

    /**
    * Get the apiRecipeData that owns the data.
    */
    public function apiRecipe()
    {
        return $this->belongsTo('App\Models\API\apiRecipe', 'api_id');
    }
}
