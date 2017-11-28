<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Giftcard
 *
 * @property integer        $id
 * @property string         $token
 * @property integer        $worth
 * @property boolean        $is_used
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class MailStat extends Model
{

    /**
     * The database table for the model
     *
     * @var string
     */
    protected $table = 'mail_stat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mail_cat'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];



    public function setMail ($id){

        $this->mail_cat = $id;
        $this->save();
    }

}
