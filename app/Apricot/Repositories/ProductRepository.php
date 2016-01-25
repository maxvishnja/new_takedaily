<?php namespace App\Apricot\Repositories;


use App\Product;

class ProductRepository
{
	public function all()
	{
		return Product::orderBy('created_at', 'DESC')->get();
	}
}