<?php

namespace App\Http\Controllers\Stock;

use Auth;
use Illuminate\Routing\Controller;
use App\Apricot\Repositories\StockRepository;

class StockController extends Controller
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
            return view('admin.stock.index');
        } 
        elseif(Auth::user()->isPacker()) {
            return view('packer.stock.index');
        }
    }
}