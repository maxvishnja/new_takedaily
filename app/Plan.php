<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Plan
 * @package App
 *
 * @property integer id
 * @property string stripe_token
 * @property integer price
 * @property integer price_shipping
 * @property mixed subscription_started_at
 * @property mixed subscription_cancelled_at
 * @property mixed subscription_paused_at
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Plan extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'plans';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ ];
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [ ];

	public function isActive()
	{
		return !$this->isPaused() && !$this->isCancelled();
	}

	public function isCancelled()
	{
		return is_null($this->getSubscriptionCancelledAt());
	}

	public function isPaused()
	{
		return is_null($this->getSubscriptionPausedAt());
	}

	public function getSubscriptionPausedAt()
	{
		return $this->subscription_paused_at;
	}

	public function getSubscriptionCancelledAt()
	{
		return $this->subscription_cancelled_at;
	}

	public function getSubscriptionStartedAt()
	{
		return $this->subscription_started_at;
	}

}