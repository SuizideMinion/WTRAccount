<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Orders\Entities\Order;

class APIOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Order = Order::select('auftraggeber', 'name', 'status', 'created_at')->get();

        return json_decode($Order);

        return view('orders::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('orders::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('orders::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('orders::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function update(Request $request, int $id = 0)
    {
        /*
         * UPDATE `orders` SET `order` = `order` + 1 WHERE `order` >= 1;
         * UPDATE `orders` SET `order` = '1' WHERE `orders`.`id` = 26;
         */
        $tasks = Order::all();

        foreach ($tasks as $task) {
            $task->timestamps = false; // To disable update_at field updation
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
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
