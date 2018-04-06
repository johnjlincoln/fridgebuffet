<?php

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
        'ingredient_data',
        'assigned_recipe_id',
        'date_assigned'
    ];

    /**
    * Get the apiRecipeData that owns the data.
    */
    public function apiRecipe()
    {
        return $this->belongsTo('App\Models\API\apiRecipe');
    }
}
