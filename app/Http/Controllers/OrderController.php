<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use DateTime;
use App\ATrucks;
use App\Telegram;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atrucks_orders = ATrucks::all();
        $local_orders = Order::all()->toArray();
        $orders = array_merge($local_orders, $atrucks_orders);
        // dd($orders);
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
    public function show($id, $db = 'pts')
    {
        if ($db != 'pts') {
            $order_id = $id;
            $id = $db;
            $db = $order_id;
        }

        switch ($db) {
            case 'pts':
                $order = Order::findOrFail($id);
                break;
            case 'atrucks':
                $order = ATrucks::find($id)->toArray();
                break;
            case 'other':
                $order = [];
                break;
            default:
                return abort(404);
                break;
        }
        return view('orders.show', compact('order', 'db', 'id'));
    }

    public function reserve() {
        $post = request()->all();

        switch ($post['db']) {
            case 'pts':
                $order = Order::findOrFail($post['id']);
                break;
            case 'atrucks':
                $order = ATrucks::find($post['id'])->toArray();
                break;
            case 'other':
                $order = [];
                break;
            default:
                return abort(404);
                break;
        }

        $msg = [
            'ИНН'     => $post['company_inn'],
            'Телефон' => $post['phone'],
        ];

        if (!is_null($post['new-price'])) {
            $msg = array_merge($msg, array(
                'Готовы забрать за' => number_format($post['new-price'], 0, '.', ' ') . ' ₽',
            ));
        }

        $msg = array_merge($msg, [
            ''               => '---------- Рейс ----------',
            'Погрузка'       => $order['load_points'],
            'Выгрузка'       => $order['unload_points'],
            'Бюджет'         => $order['price'],
            'Время погрузки' => $order['loading_time'],
            'Время выгрузки' => $order['unlodaing_time'],
            'Типы груза'     => $order['cargo_type'],
            'Вес'            => $order['weight'] ? $order['weight'] . ' т' : null,
            'Длина'          => $order['length'] ? $order['length'] . ' м' : null,
        ]);

        $to = 'tldr@promtrans.pro';
        $subject = 'Резервирование рейса через сайт';
        $headers = "Content-Type: text/html\nFrom: Promtrans <no-reply@promtrans.pro>";

        $e_msg = '';
        foreach ($msg as $param => $val) {
            if (!$val) continue;
            $e_msg .= '<b>'.$param.':</b> ';
            if (gettype($val) == 'array') {
                $e_msg .= PHP_EOL . '<ul>' . PHP_EOL;
                foreach ($val as $item) {
                    if (!$item) continue;
                    $e_msg .= "\t<li>".$item.'</li>' . PHP_EOL;
                }
                $e_msg .= '</ul>';
            } else {
                $e_msg .= $val;
            }
            $e_msg .= PHP_EOL;
        }
        $e_msg = trim($e_msg);

        $tg_msg = '';
        foreach ($msg as $param => $val) {
            if (!$val) continue;
            $tg_msg .= '*' . $param . ':* ';
            if (gettype($val) == 'array') {
                $tg_msg .= PHP_EOL;
                foreach ($val as $item) {
                    if (!$item) continue;
                    $tg_msg .= '- '.$item;
                }
            } else {
                $tg_msg .= $val;
            }
            $tg_msg .= PHP_EOL;
        }
        $tg_msg = trim($tg_msg);

        // mail($to, $subject, $e_msg, $headers);
        // dump($e_msg);
        Telegram::sendMessage('-1001479907659', $tg_msg, ['parse_mode' => 'Markdown']);
        dump(Telegram::getResponse());

        // return redirect('/reserved')->with('db', $post['db'])->with('id', $post['id']);
    }

    public function reserved() {

        dd([
            'page' => 'reserved',
            'db' => session('db'),
            'id' => session('id'),
        ]);

        switch ($db) {
            case 'pts':
                $order = Order::findOrFail($id);
                break;
            case 'atrucks':
                $order = ATrucks::find($id)->toArray();
                break;
            case 'other':
                $order = [];
                break;
            default:
                return abort(404);
                break;
        }
        return view('orders.reserved', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $db = 'pts')
    {
        if ($db != 'pts') {
            $order_id = $id;
            $id = $db;
            $db = $order_id;
        }

        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, $id, $db = 'pts')
    {
        $order->update(request()->all());
        return redirect('id'.$id);
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
