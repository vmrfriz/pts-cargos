<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
// use App\Helpers\ATrucks as ATrucks;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ATrucks::all();
        $orders = Order::all();
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'load_points'       => 'required|array',
            'unload_points'     => 'required|array',
            'price'             => 'required|integer',
            'loading_time'      => 'required|date_format:d.m.Y H:i',
            'unloading_time'    => 'nullable|date_format:d.m.Y H:i',
            'loading_comment'   => 'nullable|string',
            'unloading_comment' => 'nullable|string',
            'cargo_type'        => 'required|string',
            'weight'            => 'required|numeric',
            'length'            => 'nullable|numeric',
        ]);

        $data = array_filter($validatedData);
        $data['load_points'] = json_encode(array_filter($data['load_points']));
        $data['unload_points'] = json_encode(array_filter($data['unload_points']));
        $data['loading_time'] = Carbon::parse($data['loading_time'])->format('d.m.Y H:i');
        $data['unloading_time'] = Carbon::parse($data['unloading_time'])->format('d.m.Y H:i');

        // echo gettype($data) . '<br>';
        // var_dump($data);
        // exit;

        $order = Order::create($data);
        return redirect("/id{$order->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(string $id, string $db = 'pts')
    {
        dd(['db' => $db, 'id' => $id]);

        // switch ($site) {
        //     case 'atrucks':
        //         $order = ATrucks::getOrder($id);
        //         break;
        //     case 'other':
        //         $order = [];
        //         break;
        //     default:
        //         return abort(404);
        //         break;
        // }
        return view('orders.show', compact(null));
    }

    public function reserve(string $id, string $db = 'pts') {
        return redirect('/reserved')->with(['db' => $db, 'id' => $id]);
    }

    public function reserved(string $id, string $db = 'pts') {

        return view('orders.reserved', ['id' => $id, 'db' => $db]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update(request()->all());
        return redirect('orders.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Order::destroy($order->id);
        return redirect("/");
    }
}
