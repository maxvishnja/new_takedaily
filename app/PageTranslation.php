<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PageTranslation
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $locale
 * @property string $title
 * @property string $sub_title
 * @property string $body
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Page $page
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereLocale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereSubTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereMetaImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageTranslation extends Model
{

	public function page()
	{
		return $this->belongsTo(Page::class);
	}
}
