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

	/**
	 * @return bool|\Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function customer()
	{
		return $this->belongsTo('App\Customer', 'id', 'user_id');
	}

	/**
	 * @return bool|\Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function getCustomer()
	{
		if( !$this->isUser() )
		{
			return false;
		}

		return $this->customer()->first();
	}
}
