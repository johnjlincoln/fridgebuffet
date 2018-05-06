<?php

/**
 * Main Ingredient Model
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models;

use App\Models\BaseModel;
use Validator;

class Ingredient extends BaseModel
{
    /**
     * The table associated with the ingredient model.
     *
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * The primary key associated with the ingredient model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
    * Indicates if the ingredient model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = true;

    /**
    * The ingredient attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'recipe_id',
        'name',
        'description',
        'tag'
    ];

    /**
    * Validation rules for the ingredient attributes.
    * TODO: tighten up these rules - think DB safety, as well as application stuff, like string display lengths / etc.
    *
    * @var array
    */
    protected $rules = [
        'recipe_id'   => 'max:191',
        'name'        => 'max:191',
        'description' => 'max:191',
        'tag'         => 'max:191'
    ];

    /**
     * Gets the recipe for this ingredient.
     *
     * @return App\Models\Recipe
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
}
