<?php

/**
 * Main Recipe Model
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models;

use App\Models\BaseModel;

class Recipe extends BaseModel
{
    /**
     * The table associated with the recipe model.
     *
     * @var string
     */
    protected $table = 'recipes';

    /**
     * The primary key associated with the recipe model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
    * Indicates if the recipe model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = true;

    /**
    * The recipe attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'image_url',
        'publisher',
        'source_url'
    ];

    /**
    * Validation rules for the recipe attributes.
    * TODO: tighten up these rules - think DB safety, as well as application stuff, like string display lengths / etc.
    *
    * @var array
    */
    protected $rules = [
        'name'       => 'max:191',
        'image_url'  => 'max:191',
        'publisher'  => 'max:191',
        'source_url' => 'max:191'
    ];

    /**
     * Gets the ingredients for this recipe.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function ingredients()
    {
        return $this->hasMany('App\Models\Ingredient');
    }
}
