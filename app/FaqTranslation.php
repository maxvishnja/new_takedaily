<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
	protected $fillable = [
		'identifier',
		'locale',
		'question',
		'answer',
	    'faq_id'
	];
}
