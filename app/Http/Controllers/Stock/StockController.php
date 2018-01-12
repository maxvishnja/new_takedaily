<?php

namespace App\Http\Controllers\Stock;

use Auth;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if(Auth::user()->isAdmin())
        {
            return view('admin.stock.new');
        }
        elseif(Auth::user()->isPacker())
        {
            return view('packer.stock.new');
        }
    }

    public function insert(Request $request)
    {
        $data = [
            'name'   => $request->input('item-name'),
            'number' => $request->input('item-number'),
            'type'   => $request->input('item-type'),
            'reqQty' => $request->input('item-reqQty'),
            'qty'    => $request->input('item-qty'),
            'alert'  => $request->input('item-alarm'),
            'price'  => $request->input('item-price')
        ];

        $item = $this->repo->create($data);

        if(!$item) {
            return redirect()->back()->with('message-fail', $this->respondInternalError());
        }

        if(Auth::user()->isAdmin()) {
            return redirect('/dashboard/stock')->with('message-success', 'Inventory item created.');
        }
        elseif(Auth::user()->isPacker()) {
            return redirect('/packaging/stock')->with('message-success', 'Inventory item created.');
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = $this->repo->getItem($id);

        if(Auth::user()->isAdmin()) {
            return view('admin.stock.edit', compact('item', 'qty'));
        }
        elseif(Auth::user()->isPacker()) {
            return view('packer.stock.edit', compact('item', 'qty'));
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // get item
        $item = $this->repo->getItem($request->input('item-id'));

        // prepare
        $data = [
            'name'   => $request->input('item-name'),
            'number' => $request->input('item-number'),
            'type'   => $request->input('item-type'),
            'reqQty' => $request->input('item-reqQty'),
//            'qty'    => $request->input('item-qty'),
            'alert'  => $request->input('item-alarm'),
            'price'  => $request->input('item-price'),
            'email'  => $request->input('item-alarm-email')
        ];

//        dd($data);

        if($item->type == 'vitamin') {
            $data['qty'] = $this->repo->calcOrdersVitaminsQty($request->input('item-reqQty'), $item->id);
            $data['status'] = ($data['alert'] * 28 >= $data['qty']) ? 1 : 0;
        } elseif($item->type == 'material') {
            $data['qty'] = $request->input('item-reqQty') - $this->repo->getCountPendingOrders();
            $data['status'] = ($data['qty'] <= $data['alert']) ? 1 : 0;
        }

        // update item
        $item = $this->repo->update($item->id, $data);

        if($item->email != '' && $item->status == 1)
        {
            $emails = explode(',', $item->email);

            try {
                for($i=0; $i<count($emails); $i++) {
                    \Mail::send('emails.stock-alert', ['item' => $item], function ($m) use ($item, $emails, $i) {
                        $m->from('admin@takedaily.com');
                        $m->to($emails[$i]);
                    });
                }
            } catch (\Exception $exception) {
                \Log::error("Mail error: " . $exception->getMessage() . ' in line ' . $exception->getLine() . " file " . $exception->getFile());

            }
        }

        if(!$item) {
            return redirect()->back()->with('message-fail', $this->respondInternalError());
        }

        if(Auth::user()->isAdmin()) {
            return redirect('/dashboard/stock')->with('message-success', 'Item updated.');
        }
        elseif(Auth::user()->isPacker()) {
            return redirect('/packaging/stock')->with('message-success', 'Item updated.');
        }


    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $item = $this->repo->remove($id);

        if(!$item) {
            return redirect()->back()->with('message-fail', $this->respondInternalError());
        }

        if(Auth::user()->isAdmin()) {
            return redirect('/dashboard/stock')->with('message-success', 'Item removed.');
        }
        elseif(Auth::user()->isPacker()) {
            return redirect('/packaging/stock')->with('message-success', 'Item removed.');
        }

    }
}