<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use DateTime;
use App\ATrucks;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(ATrucks::all());
        $orders = Order::all();
        // foreach ($orders as $order) {
            // $order->load_points();
        // }
        return view('orders.index', compact('orders'));
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
        $data['load_points'] = array_filter($data['load_points']);
        $data['unload_points'] = array_filter($data['unload_points']);
        $data['loading_time'] = DateTime::createFromFormat('d.m.Y H:i', $data['loading_time']);
        if (array_key_exists('unloading_time', $data)) {
            $data['unloading_time'] = DateTime::createFromFormat('d.m.Y H:i', $data['unloading_time']);
        }

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
        // dd(['db' => $db, 'id' => $id]);

        switch ($db) {
            case 'pts':
                $order = Order::findOrFail($id);
                break;
            case 'atrucks':
                $order = ATrucks::find($id);
                break;
            case 'other':
                $order = [];
                break;
            default:
                return abort(404);
                break;
        }
        return view('orders.show', compact('order'));
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
    public function destroy($id, $db = 'pts')
    {
        switch($db) {
            case 'pts':
                Order::findOrFail($id)->delete();
                break;
            case 'atrucks':
                // $order = ATrucks::find($id);
                break;
            default:
                redirect('/');
                break;
        }
        return redirect("/");
    }
}
