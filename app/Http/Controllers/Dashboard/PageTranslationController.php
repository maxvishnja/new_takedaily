<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Page;
use App\PageTranslation;
use Illuminate\Http\Request;

class PageTranslationController extends Controller
{

	function edit($id)
	{
		$translation = PageTranslation::find($id);

		if (!$translation) {
			return \Redirect::back()->withErrors("Oversættelsen (#{$id}) kunne ikke findes!");
		}

		return view('admin.cms_translations.manage', [
			'translation' => $translation
		]);
	}

	function update(Request $request, $id)
	{
		$translation = PageTranslation::find($id);

		if (!$translation) {
			return \Redirect::back()->withErrors("Oversættelsen (#{$id}) kunne ikke findes!");
		}

		$translation->locale           = $request->get('locale');
		$translation->title            = $request->get('title');
		$translation->sub_title        = $request->get('sub_title');
		$translation->body             = $request->get('body');
		$translation->meta_title       = $request->get('meta_title');
		$translation->meta_description = substr($request->get('meta_description'), 0, 200);

		if ($img = $request->file('meta_image')) {
			$imgPath = public_path('uploads/cms/meta/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while (!$fileIsUnique) {
				if (\File::exists("$imgPath/$imgName")) {
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				} else {
					$fileIsUnique = true;
				}
			}

			$img->move($imgPath, $imgName);

			$translation->meta_image = "/uploads/cms/meta/$imgName";
		}

		$translation->save();

		return \Redirect::action('Dashboard\PageController@edit', ['id' => $translation->page_id])->with('success', 'Oversættelsen blev gemt!');
	}

	function create(Request $request)
	{
		$pageId = $request->get('page');

		if (!$pageId) {
			return \Redirect::back()->withErrors("Ingen side valgt!");
		}

		$page = Page::find($pageId);

		if (!$page) {
			return \Redirect::back()->withErrors("Siden (#{$pageId}) kunne ikke findes!");
		}

		return view('admin.cms_translations.manage', [
			'page' => $page
		]);
	}

	function store(Request $request)
	{
		$translation                   = new PageTranslation();
		$translation->locale           = $request->get('locale');
		$translation->page_id           = $request->get('page_id');
		$translation->title            = $request->get('title');
		$translation->sub_title        = $request->get('sub_title');
		$translation->body             = $request->get('body');
		$translation->meta_title       = $request->get('meta_title');
		$translation->meta_description = substr($request->get('meta_description'), 0, 200);

		if ($img = $request->file('meta_image')) {
			$imgPath = public_path('uploads/cms/meta/');
			$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();

			$fileIsUnique = false;
			while (!$fileIsUnique) {
				if (\File::exists("$imgPath/$imgName")) {
					$imgName = str_random(40) . '.' . $img->getClientOriginalExtension();
				} else {
					$fileIsUnique = true;
				}
			}

			$request->file('meta_image')->move($imgPath, $imgName);

			$translation->meta_image = "/uploads/cms/meta/$imgName";
		}

		$translation->save();

		return \Redirect::action('Dashboard\PageController@edit', ['id' => $translation->page_id])->with('success', 'Oversættelsen blev gemt!');
	}

	function delete($id)
	{
		$translation = PageTranslation::find($id);

		if (!$translation) {
			return \Redirect::back()->withErrors("Oversættelsen (#{$id}) kunne ikke findes!");
		}

		$pageId = $translation->page_id;

		$translation->delete();

		return \Redirect::action('Dashboard\PageController@edit', ['id' => $pageId])->with('success', 'Oversættelsen blev slettet!');
	}

}
