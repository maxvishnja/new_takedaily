<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Coupon
 *
 * @property integer        $id
 * @property string         $description
 * @property string         $code
 * @property string         $discount_type
 * @property integer        $discount
 * @property string         $applies_to
 * @property integer        $uses_left
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string         $valid_from
 * @property string         $valid_to
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereDescription( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereCode( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereDiscountType( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereDiscount( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereAppliesTo( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereUsesLeft( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereValidFrom( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereValidTo( $value )
 * @mixin \Eloquent
 */
class Coupon extends Model
{

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'coupons';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'description',
		'code',
		'discount',
		'applies_to',
		'discount_type',
		'currency',
		'for_second',
		'length',
		'automatic',
		'automatic_id',
		'uses_left',
		'valid_from',
		'valid_to'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	function usage()
	{
		return strtolower( trans( "usage.{$this->applies_to}" ) );
	}

	function isAmount()
	{
		return $this->discount_type == 'amount';
	}

	function isPercentage()
	{
		return $this->discount_type == 'percentage';
	}

	function isFreeShipping()
	{
		return $this->discount_type == 'free_shipping';
	}

	function reduceUsagesLeft()
	{
		if ( $this->uses_left > 0 )
		{
			$this->uses_left --;
			$this->save();
		}
	}

    function reduceLength()
    {
        if ( $this->length > 0 )
        {
            $this->length --;
            $this->save();
        }
    }

	public static function newUpsellCoupon($code)
	{
		return self::create( [
			'description'   => 'Upsell discount',
			'code'          => $code,
			'currency'      => trans( 'general.currency' ),
			'discount'      => 50,
			'applies_to'    => 'order',
			'discount_type' => 'percentage',
			'uses_left'     => 1,
			'valid_from'    => \Jenssegers\Date\Date::now(),
			'valid_to'      => \Jenssegers\Date\Date::now()->addDay()
		] );
	}



}