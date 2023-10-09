<?php

namespace Modules\Orders\Http\Controllers;

use DirectoryIterator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderData;
use Modules\Orders\Entities\OrderLogs;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Orders = Order::whereNot('status', 100)->orderBy('order')->get();

        return view('orders::index', compact('Orders'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if( isset($_GET['type']) )
        {
            return view('orders::' . $_GET['type']);
        }

        return view('orders::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $Order = new Order;

        $Order->name = $request->name;
        $Order->auftraggeber = $request->auftraggeber;
        $Order->status = 0;
        $Order->user_id = auth()->user()->id;
        $Order->link = md5(rand(0, 10000000000000) + time());
        $Order->order = 1000000000;

        $Order->save();

        if($files=$request->file('images')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('image' . '/' . $Order->link, $name);
            }
        }

        $propertyInputs = $request->get('files');
        unset($propertyInputs['image']);

        foreach ($request->except('images[]') as $key => $value) {
            if( !empty($value) ) {
                if( !is_array($value) ) {
                    $save = new OrderData;
                    $save->key = $key;
                    $save->value = $value;
                    $save->order_id = $Order->id;
                    $save->save();
                }
            }
        }

        $OrderLog = new OrderLogs;
        $OrderLog->user_id = auth()->user()->id;
        $OrderLog->order_id = $Order->id;
        $OrderLog->value = 'Auftrag wurde Angelegt!';

        $OrderLog->save();

        return redirect()->route('orders.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $Order = Order::where('link', $id)->first();
        $OrderDatas = OrderData::where('order_id', $Order->id)->whereNot('key', '_token')->get()->pluck('value', 'key');
        $files = [];
        if ( File::isDirectory(public_path() . '\image\\' . $Order->link) ) {
            $path = public_path() . '\image\\' . $Order->link;
            $files = File::allFiles($path);
        }
//        dd(File::isDirectory(public_path() . '\image\\' . $id));

        return view('orders::show', compact('Order', 'OrderDatas', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Order = Order::where('link', $id)->first();
        $OrderDatas = OrderData::where('order_id', $Order->id)->whereNot('key', '_token')->get()->pluck('value', 'key');

        $edit = true;

        return view('orders::create', compact('Order', 'OrderDatas', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $Order = Order::where('link', $id)->first();

        $Order->name = $request->name;
        $Order->auftraggeber = $request->auftraggeber;

        $Order->save();

        if($files=$request->file('images')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('image' . '/' . $Order->link, $name);
            }
        }

        OrderData::where('order_id', $Order->id)->delete();

        $propertyInputs = $request->get('files');
        unset($propertyInputs['image']);

        foreach ($request->except('images[]') as $key => $value) {
            if( !empty($value) ) {
                if( !is_array($value) ) {
                    $save = new OrderData;
                    $save->key = $key;
                    $save->value = $value;
                    $save->order_id = $Order->id;
                    $save->save();
                }
            }
        }

        $OrderLog = new OrderLogs;
        $OrderLog->user_id = auth()->user()->id;
        $OrderLog->order_id = $Order->id;
        $OrderLog->value = 'Auftrag wurde Bearbeitet';

        $OrderLog->save();

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
