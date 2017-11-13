<?php

namespace App\Http\Controllers\Dashboard;

use App\Apricot\Repositories\NutritionistRepository;
use App\Http\Controllers\Controller;
use App\Nutritionist;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use Input;
use Image;

class NutritionistController extends Controller
{

    private $repo;

    function __construct(NutritionistRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    function index()
    {
        $nutritionists = $this->repo->all();
        //$nutritionists->load('user');

        return view('admin.nutritionists.home', [
            'nutritionists' => $nutritionists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.nutritionists.create');
    }

    /**
     * Store a new resource.
     */

    public function store(Request $request)
    {
        $nutritionist = new Nutritionist;

        $data = $request->all();

        if (Input::hasFile('image')){

            $file = Input::file('image');

            $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
            $data['image'] = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path().'/images/nutritionist/', $data['image']);
            $path = public_path().'/images/nutritionist/'.'thumb_'.$data['image'];
            $imagePath = public_path() . '/images/nutritionist/' . $data['image'];
            $image = Image::make($imagePath);

            $image->resize(175, 175, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($path);
        }

        $nutritionist->create($data);

        return redirect('dashboard/nutritionist')->with('success', 'Nutritionist created');
    }

    function edit($id)
    {

        $nutritionist = Nutritionist::find($id);

        if( ! $nutritionist )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        return view('admin.nutritionists.edit', [
            'nutritionist' => $nutritionist
        ]);
    }


    public function update(Request $request, $id)
    {

        $nutritionist = Nutritionist::find($id);
        $data = $request->all();
//        dd($data);
        $file = Image::make(file_get_contents($data['imagebase64']));

        if (Input::hasFile('image')){
//
//        $file = Input::file('image');

        $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
        $data['image'] = $timestamp. '-' .$file->getClientOriginalName();
        $file->move(public_path().'/images/nutritionist/', $data['image']);
        $path = public_path().'/images/nutritionist/'.'thumb_'.$data['image'];
        $imagePath = public_path() . '/images/nutritionist/' . $data['image'];
        $image = Image::make($imagePath);

        $image->resize(175, 175, function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($path);
        }

        $nutritionist->update($data);

        return redirect('dashboard/nutritionist')->with('success', 'Nutritionist updated');

    }

    function show($id)
    {

        $nutritionist = Nutritionist::find($id);

        if( ! $nutritionist )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        return view('admin.nutritionists.show', [
            'nutritionist' => $nutritionist
        ]);
    }

    function destroy($id)
    {

        $nutritionist = Nutritionist::find($id);

        if( ! $nutritionist )
        {
            return \Redirect::back()->withErrors("Kunden (#{$id}) kunne ikke findes!");
        }

        $nutritionist->delete();


        return \Redirect::action('Dashboard\NutritionistController@index')->with('success', 'Nutritionist deleted.');

    }

}