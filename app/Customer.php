<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Charge;
use Stripe\Error;
use Stripe\Stripe;

/**
 * Class Customer
 * @package App
 *
 * @property integer id
 * @property integer user_id
 * @property integer plan_id
 * @property string  name
 * @property mixed   birthday
 * @property string  gender
 * @property integer order_count
 * @property mixed   created_at
 * @property mixed   updated_at
 * @property mixed   deleted_at
 */
class Customer extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'customers';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $fillable = [ 'user_id', 'plan_id' ];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function plan()
	{
		return $this->hasOne('App\Plan', 'id', 'plan_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders()
	{
		return $this->hasMany('App\Order', 'customer_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function attributes()
	{
		return $this->hasMany('App\CustomerAttribute', 'customer_id', 'id');
	}

	/**
	 * @return Plan
	 */
	public function getPlan()
	{
		return $this->plan()->first();
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user()->first();
	}

	/**
	 * @return User
	 */
	public function getOrders()
	{
		return $this->orders()->get();
	}

	public function isSubscribed()
	{
		return $this->getPlan()->isActive();
	}

	public function getAttribute($name)
	{
		return $this->attributes()->where('identifier', $name)->first();
	}

	public function getName()
	{
		return $this->name;
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function getGender()
	{
		return $this->gender;
	}

	public function getOrderCount()
	{
		return $this->order_count;
	}

	public function rebill()
	{
		if ( !$this->isSubscribed() )
		{
			return false;

		}

		try
		{
			Stripe::setApiKey(env('STRIPE_API_SECRET_KEY'));

			Charge::create([
				'amount'               => 400,
				'currency'             => 'dkk',
				'source'               => $this->getAttribute('stripe_token'),
				'description'          => 'Betaling for ordre #' . str_pad(1, 11, 0, STR_PAD_LEFT),
				'statement_descriptor' => substr('Takedaily #' . str_pad(1, 11, 0, STR_PAD_LEFT), 0, 22),
				// todo: get order id
				'shipping'             => [
					'address'         => [
						'city'        => $this->getAttribute('address_city'),  // todo: add to customer
						'country'     => $this->getAttribute('address_country'),  // todo: add to customer
						'line1'       => $this->getAttribute('address_line1'),  // todo: add to customer
						'line2'       => $this->getAttribute('address_line2'),  // todo: add to customer
						'postal_code' => $this->getAttribute('address_postal'),  // todo: add to customer
						'state'       => $this->getAttribute('address_state') // todo: add to customer
					],
					'name'            => $this->getName(),
					'phone'           => $this->getAttribute('phone'), // todo: add to customer
					'carrier'         => '', // todo: add carrier to order
					'tracking_number' => '' // todo: add tracking number to order
				]
			]);

		} catch( Error\Card $e )
		{
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			print('Status is:' . $e->getHttpStatus() . "\n");
			print('Type is:' . $err['type'] . "\n");
			print('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			print('Param is:' . $err['param'] . "\n");
			print('Message is:' . $err['message'] . "\n");
		} catch( Error\RateLimit $e )
		{
			// Too many requests made to the API too quickly
		} catch( Error\InvalidRequest $e )
		{
			// Invalid parameters were supplied to Stripe's API
		} catch( Error\Authentication $e )
		{
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
		} catch( Error\ApiConnection $e )
		{
			// Network communication with Stripe failed
		} catch( Error\Base $e )
		{
			// Display a very generic error to the user, and maybe send
			// yourself an email
		} catch( Exception $e )
		{
			// Something else happened, completely unrelated to Stripe
		}
	}

}