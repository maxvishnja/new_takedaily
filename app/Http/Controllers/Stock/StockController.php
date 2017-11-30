<?php

namespace App\Http\Controllers\Stock;

use Auth;
use App\Http\Requests\Request;
use App\Http\Controllers\ApiController;
use App\Apricot\Repositories\StockRepository;

class StockController extends ApiController
{
    /**
     * @var StockRepository
     */
    private $repo;

    public function __construct(StockRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * 
     */
    public function index()
    {
        // get all stock items
        $items = $this->repo->getAll();

        if(Auth::user()->isAdmin())
        {
            return view('admin.stock.index', compact('items'));
        } 
        elseif(Auth::user()->isPacker()) 
        {
            return view('packer.stock.index', compact('items'));
        }
    }

    public function create()
    {
        return view('packer.stock.new');
    }

    public function insert(Request $request)
    {
        $data = [
            'name'   => $request->input('item-name'),
            'number' => $request->input('item-number'),
            'type'   => $request->input('item-type'),
            'reqQty' => $request->input('item-reqQty'),
            'qty'    => $request->input('item-qty'),
            'price'  => $request->input('item-price')
        ];

        $item = $this->repo->create($data);

        if(!$item) {
            return redirect()->back()->with('message', $this->respondInternalError());
        }
        return redirect()->back();
    }
}