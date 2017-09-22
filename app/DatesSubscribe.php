<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class DatesSubscribe extends Model
{

    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'date_subscription';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'customer_id', 'subscription_started_at', 'subscription_canceled_at' ];

    public function customer()
    {
        return $this->belongsTo( 'App\Customer', 'id', 'customer_id' );
    }

}