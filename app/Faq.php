<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
	protected $fillable = [
		'identifier',
		'question',
		'answer'
	];

	public function translations()
	{
		return $this->hasMany( FaqTranslation::class );
	}
}
