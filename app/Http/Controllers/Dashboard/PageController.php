<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\PageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Page;
use App\UrlRewrite;
use Illuminate\Http\Request;

class PageController extends Controller
{
	/*
	 * @var \App\Apricot\Repositories\PageRepository
	 */
	private $repo;

	function __construct(PageRepository $repo)
	{
		$this->repo = $repo;
	}

	function index()
	{
		return view('admin.cms.home', [
			'pages' => $this->repo->all()
		]);
	}

	function edit($id)
	{
		$page = Page::find($id);

		if ( !$page )
		{
			return \Redirect::back()->withErrors("Siden (#{$id}) kunne ikke findes!");
		}

		return view('admin.cms.manage', [
			'page' => $page
		]);
	}

	function update(Request $request, $id)
	{
		$page = Page::find($id);

		if ( !$page )
		{
			return \Redirect::back()->withErrors("Siden (#{$id}) kunne ikke findes!");
		}

		$oldIdentifier = $page->url_identifier;

		$page->title = $request->get('title');
		if ( !$page->isLocked() )
		{
			$page->url_identifier = $page->generateIdentifier($request->get('title'));
		}
		$page->sub_title        = $request->get('sub_title');
		$page->body             = $request->get('body');
		$page->meta_title       = $request->get('meta_title');
		$page->meta_description = substr($request->get('meta_description'), 0, 200);

		if ( $img = $request->file('meta_image') )
		{
			$imgPath = public_path('uploads/cms/meta/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while( !$fileIsUnique )
			{
				if ( \File::exists("$imgPath/$imgName") )
				{
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				}
				else
				{
					$fileIsUnique = true;
				}
			}

			$request->file('meta_image')->move($imgPath, $imgName);

			$page->meta_image = "/uploads/cms/meta/$imgName";
		}

		$page->save();

		if( $oldIdentifier != $page->url_identifier )
		{
			UrlRewrite::create([
				'requested_path' => '/' . $oldIdentifier,
				'actual_path' => '/' . $page->url_identifier
			]);

			\Cache::tags('url_rewrites')->flush();
		}

		return \Redirect::action('Dashboard\PageController@index')->with('success', 'Siden blev gemt!');
	}

	function create()
	{
		return view('admin.cms.manage');
	}

	function store(Request $request)
	{
		// todo: validate (especially if exists already - slug.)

		$page                   = new Page();
		$page->title            = $request->get('title');
		$page->url_identifier   = $page->generateIdentifier($request->get('title'));
		$page->sub_title        = $request->get('sub_title');
		$page->body             = $request->get('body');
		$page->meta_title       = $request->get('meta_title');
		$page->meta_description = substr($request->get('meta_description'), 0, 200);

		if ( $img = $request->file('meta_image') )
		{
			$imgPath = public_path('uploads/cms/meta/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while( !$fileIsUnique )
			{
				if ( \File::exists("$imgPath/$imgName") )
				{
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				}
				else
				{
					$fileIsUnique = true;
				}
			}

			$request->file('meta_image')->move($imgPath, $imgName);

			$page->meta_image = "/uploads/cms/meta/$imgName";
		}

		$page->save();

		return \Redirect::action('Dashboard\PageController@index')->with('success', 'Siden blev oprettet!');
	}

	function destroy($id)
	{
		$page = Page::find($id);

		if ( !$page )
		{
			return \Redirect::back()->withErrors("Siden (#{$id}) kunne ikke findes!");
		}

		$page->delete();

		return \Redirect::action('Dashboard\PageController@index')->with('success', 'Siden blev slettet!');
	}

}
