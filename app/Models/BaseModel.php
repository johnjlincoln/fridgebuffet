<?php

/**
 * Base Model - Wrapper around Eloquent Model
 *
 * @author John J Lincoln <jlincoln88@gmail.com>
 * @copyright 2018 Arctic Pangolin
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class BaseModel extends Model
{
    /**
    * Validation rules for the model attributes.
    *
    * @var array
    */
    protected $rules = [];

    /**
     * Validate the model attributes
     * TODO: load the validation errors into a new model attribute?
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
     *
     * @param array $options Needed for compatibility with parent save - unsure of implementation
     * @return bool
     */
    public function save(array $options = [])
    {
        return $this->validate ? parent::save() : false;
    }
}
