<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Apricot\Repositories\ReviewRepository;

use App\Http\Requests;

class ReviewsController extends Controller
{
    /**
     * @var ReviewRepository
     */
    private $repo;

    public function __construct(ReviewRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = $this->repo->all();
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = $this->repo->getById($id);
        return $review ? view('admin.reviews.show', compact('review')) : \Redirect::back()->withErrors("Review (#{$id}) kunne ikke findes!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = $this->repo->getById($id);

        return $review ? view('admin.reviews.edit', compact('review')) : \Redirect::back()->withErrors("Review (#{$id}) kunne ikke findes!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = $this->repo->getById($id);

        if(!$review) {
            \Redirect::back()->withErrors("Review (#{$id}) kunne ikke findes!");
        }

        $review->name   = $request->input('rev_name');
        $review->age    = $request->input('rev_age');
        $review->review = $request->input('rev_review');

        return $review->save() ? \Redirect::to('/dashboard/reviews') : \Redirect::back()->withErrors("Something went wrong.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
