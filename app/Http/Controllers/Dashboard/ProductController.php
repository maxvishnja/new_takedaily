<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Libraries\MoneyLibrary;
use App\Apricot\Libraries\SlugLibrary;
use App\Apricot\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	private $repo;

	function __construct(ProductRepository $repository)
	{
		$this->repo = $repository;
	}

	function index()
	{
		return view('admin.products.home', [
			'products' => $this->repo->all()
		]);
	}

	function edit($id)
	{
		$product = Product::find($id);

		if( ! $product )
		{
			return \Redirect::back()->withErrors("Produktet (#{$id}) kunne ikke findes!");
		}

		return view('admin.products.manage', [
			'product' => $product
		]);
	}

	function create()
	{
		return view('admin.products.manage');
	}

	function store(Request $request)
	{
		$product = new Product();

		$product->name = $request->get('name');
		$product->slug = SlugLibrary::generate($request->get('name'));
		$product->description = $request->get('description');
		$product->price_default = MoneyLibrary::toCents($request->get('price'));
		$product->price_special = MoneyLibrary::toCents($request->get('price_special'));

		if( $img = $request->file('picture'))
		{
			$imgPath = public_path('uploads/products/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while(!$fileIsUnique)
			{
				if( \File::exists("$imgPath/$imgName") )
				{
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				}
				else
				{
					$fileIsUnique = true;
				}
			}

			$img = $request->file('picture')->move($imgPath . 'full/', $imgName);
			\Image::make($img->getRealPath())->fit(300)->save("{$imgPath}thumbs/{$imgName}", 100);

			$product->image_url = "$imgName";
		}

		$product->save();

		return \Redirect::action('Dashboard\ProductController@index')->with('success', 'Produktet blev oprettet!');
	}

	function update($id, Request $request)
	{
		$product = Product::find($id);

		if( ! $product )
		{
			return \Redirect::back()->withErrors("Produktet (#{$id}) kunne ikke findes!");
		}

		$product->name = $request->get('name');
		$product->description = $request->get('description');
		$product->slug = SlugLibrary::generate($request->get('name'));
		$product->price_default = MoneyLibrary::toCents($request->get('price'));
		$product->price_special = MoneyLibrary::toCents($request->get('price_special'));

		if( $img = $request->file('picture'))
		{
			$imgPath = public_path('uploads/products/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while(!$fileIsUnique)
			{
				if( \File::exists("$imgPath/$imgName") )
				{
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				}
				else
				{
					$fileIsUnique = true;
				}
			}

			$img = $request->file('picture')->move($imgPath . 'full/', $imgName);
			\Image::make($img->getRealPath())->fit(300)->save("{$imgPath}thumbs/{$imgName}", 100);

			$product->image_url = "$imgName";
		}

		$product->save();

		return \Redirect::action('Dashboard\ProductController@index')->with('success', 'Produktet blev opdateret!');
	}

	function destroy($id)
	{
		$product = Product::find($id);

		if( ! $product )
		{
			return \Redirect::back()->withErrors("Produktet (#{$id}) kunne ikke findes!");
		}

		$product->delete();

		return \Redirect::action('Dashboard\ProductController@index')->with('success', 'Produktet blev slettet!');
	}
}
