<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Message;
use Jenssegers\Date\Date;
use Stripe\Refund;
use Stripe\Stripe;
use App\Events\SentMail;


/**
 * App\Order
 *
 * @property integer                                                        $id
 * @property integer                                                        $customer_id
 * @property string                                                         $reference
 * @property string                                                         $payment_token
 * @property string                                                         $payment_method
 * @property string                                                         $state
 * @property string                                                         $shipping_zipcode
 * @property string                                                         $shipping_company
 * @property string                                                         $shipping_country
 * @property string                                                         $shipping_city
 * @property string                                                         $shipping_street
 * @property string                                                         $shipping_name
 * @property integer                                                        $total
 * @property integer                                                        $sub_total
 * @property integer                                                        $total_shipping
 * @property integer                                                        $total_taxes
 * @property \Carbon\Carbon                                                 $created_at
 * @property \Carbon\Carbon                                                 $updated_at
 * @property string                                                         $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderLine[] $lines
 * @property-read \App\Customer                                             $customer
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCustomerId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereReference( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePaymentToken( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePaymentMethod( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereState( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingZipcode( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingCompany( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingCountry( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingCity( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingStreet( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereShippingName( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTotal( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereSubTotal( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTotalShipping( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTotalTaxes( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDeletedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Order today()
 * @mixin \Eloquent
 */
class Order extends Model
{

	use SoftDeletes;

	/**
	 * The database table for the model
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'customer_id',
		'reference',
		'state',
		'currency',
		'payment_method',
		'payment_token',
		'total',
		'sub_total',
		'total_shipping',
		'total_taxes',
		'shipping_name',
		'shipping_street',
		'shipping_city',
		'shipping_country',
		'shipping_zipcode',
		'shipping_company',
		'is_shippable',
		'barcode',
		'labellesskode',
		'labelTekst1',
		'labelTekst2',
		'labelTekst3',
		'coupon',
		'vitamins',
		'repeat'

	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function lines()
	{
		return $this->hasMany( 'App\OrderLine', 'order_id', 'id' );
	}

	public function customer()
	{
		return $this->hasOne( 'App\Customer', 'id', 'customer_id' );
	}

	/**
	 * @return Customer
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

    public function user()
    {
        return $this->hasOne( 'App\User', 'id', 'customer_id' );
    }




    public function getPaddedId()
	{
		return str_pad( $this->id, 11, 0, STR_PAD_LEFT );
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function getCoupon()
	{
		if(!is_null($this->coupon)){

			return $this->coupon;

		} else{

			return "No coupone";
		}
	}

	public function getVitamins(){

		$vitamins = json_decode( $this->vitamins );

		if ( is_null( $vitamins ) )
		{
			return false;
		}
		return $vitamins;
	}

	public function getSubTotal()
	{
		return $this->sub_total;
	}


	public function getTotalShipping()
	{
		return $this->total_shipping;
	}

	public function getSubTotalShipping()
	{
		return $this->sub_total_shipping;
	}

	public function isShippable()
	{
		return $this->is_shippable == 1;
	}

	public function getTotalTaxes()
	{
		return $this->total_taxes;
	}

	public function scopeToday( $query )
	{
		return $query->whereBetween( 'created_at', [ Date::today()->setTime( 0, 0, 0 ), Date::today()->setTime( 23, 59, 59 ) ] );
	}



	public function markPrint()
	{


		$this->state = 'printed';
		$this->save();


		if ( $this->customer )
		{


            $locale = \App::getLocale();

            //\Event::fire(new SentMail($this, 'print'));

			\App::setLocale($locale);

		}


		return true;
	}





	public function markSent()
	{


		$this->state = 'sent';
		$this->save();

		if ( $this->customer )
		{
			//Rebill on click Sent
			$this->customer->plan->rebilled();

			\Log::info('Customer '.$this->customer->id.' rebilled to '.\Date::now()->addDays( 28 ));

            $locale = \App::getLocale();


            //\Event::fire(new SentMail($this, 'sent'));

            \App::setLocale($locale);

			$this->customer->plan->setNullSnooze();
		}

		return true;
	}


	public function sendEmail($status){

        \Log::info('Start event '.$status);

	    $locale = $this->customer->getLocale();
        $receiverName  = $this->customer->getName();
        $receiverEmail = $this->customer->getEmail();

        \App::setLocale( $this->customer->getLocale() );

        if($locale == 'nl') {
            $fromEmail = 'info@takedaily.nl';
        } else{
            $fromEmail = 'info@takedaily.dk';
        }

        if($status == 'sent'){
            $trans =  trans( 'mails.order-sent.subject' );
            $template = 'emails.order-sent';
        } else{
            $trans = trans( 'mails.order-print.subject' );
            $template = 'emails.order-print';
        }

        try {
            \Mail::send( $template, [ 'locale' => $this->customer->getLocale(), 'name' => $this->customer->getFirstname() ], function ($message ) use ( $receiverName, $receiverEmail, $fromEmail, $trans, $status )

            {   \Log::info('Mail sent with status '.$status.' '.$trans. ' to '.$receiverEmail);
                $message->from( $fromEmail, 'TakeDaily' );
                $message->to( $receiverEmail, $receiverName );
                $message->subject( $trans );
            } );
        } catch (\Exception $exception) {
            \Log::error("Mail error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

        }

    }



	public function refund() // todo convert to paymentHandler
	{
		try
		{
			Stripe::setApiKey( env( 'STRIPE_API_SECRET_KEY', '' ) );

			Refund::create( [
				'charge' => $this->stripe_charge_token,
				'reason' => 'requested_by_customer'
			] );
		} catch ( \Stripe\Error\Card $e )
		{
			return false;
		} catch ( \Stripe\Error\RateLimit $e )
		{
			return false;
		} catch ( \Stripe\Error\InvalidRequest $e )
		{
			return false;
		} catch ( \Stripe\Error\Authentication $e )
		{
			return false;
		} catch ( \Stripe\Error\ApiConnection $e )
		{
			return false;
		} catch ( \Stripe\Error\Base $e )
		{
			return false;
		} catch ( Exception $e )
		{
			return false;
		}

		if ( $balanceLine = $this->lines()->where( 'description', 'balance' )->first() )
		{
			$this->customer->addBalance( $balanceLine->total_amount * - 1 );
		}

		$this->lines()->create( [
			'description'  => 'refund',
			'amount'       => $this->getSubTotal() * - 1,
			'tax_amount'   => 0,
			'total_amount' => $this->getTotal() * - 1
		] );

		$this->total          = 0;
		$this->sub_total      = 0;
		$this->total_taxes    = 0;
		$this->total_shipping = 0;
		$this->state          = 'cancelled';
		$this->save();
	}

	public function stateToColor()
	{
		switch ( $this->state )
		{
			case 'new':
				$color = 'warning';
				break;
			case 'sent':
				$color = 'info';
				break;
			case 'cancelled':
				$color = 'important';
				break;
			case 'paid':
				$color = 'success';
				break;
			case 'completed':
			default:
				$color = 'inverse';
				break;
		}

		return $color;
	}

	public function loadLabel()
	{
		return $this->getCustomer()->loadLabel($this);
	}

	public function loadSticker()
	{
		return $this->getCustomer()->loadSticker($this);
	}

	public function download()
	{
		return $this->getCustomer()->generateLabel()->download( 'order_' . $this->getPaddedId() . '_label.pdf' );
	}

	public function downloadSticker()
	{
		return $this->getCustomer()->generateSticker()->download( 'order_' . $this->getPaddedId() . '_sticker.pdf' );
	}

	public function scopeShippable( $query )
	{
		return $query->where( 'is_shippable', 1 );
	}

	public function scopePaid( $query )
	{
		return $query->where( 'state', 'paid' );
	}

	public function scopeSent( $query )
	{
		return $query->where( 'state', 'sent' );
	}

}