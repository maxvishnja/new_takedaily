<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function isAdmin()
	{
		return $this->type == 'admin';
	}

	public function isUser()
	{
		return $this->type == 'user';
	}
}
