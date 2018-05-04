<?php

/**
 * Main Recipe Model
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Recipe extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipes';

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
        'name',
        'image_url',
        'publisher',
        'source_url'
    ];

    /**
    * Validation rules for the model attributes.
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
     * Validate the model attributes
     * TODO: load the validation errors into a new model attribute?
     * TODO: this should go into a BaseModel, like the save() implementation
     *
     * @return bool
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, $this->rules);
        return $validator->passes();
    }

    /**
     * Saves the model
     * TODO: since we're just wrapping validation around Eloquent's save() - let's move this to a BaseModel
     *
     * @param array $options Needed for compatibility with parent save - unsure of implementation.
     * @return bool
     */
    public function save(array $options = [])
    {
        return $this->validate ? parent::save() : false;
    }
}
