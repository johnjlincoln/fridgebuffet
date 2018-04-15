<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
    * User Type Constants
    *
    * @var string
    */
    const ADMIN_TYPE = 'admin';
    const REGISTERED_TYPE = 'registered';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Returns whether the user is an admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    /**
     * Returns whether the user is registered
     *
     * @return boolean
     */
    public function isRegistered()
    {
        return $this->type === self::REGISTERED_TYPE;
    }

    /**
     * Gets the user type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
