<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Error\Warning;
use App\Helpers\XMLParser;

class ATrucks extends Model
{
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    //
    public static function all($columns = ['*']) {
        $xml = self::sendRequest('get_orders');
    }

    public static function find(string $uuid) {
        return self::sendRequest('get_orders', [
            'order_id' => $uuid
        ]);
    }

    private static function formatData($array) {
        dump($array);
        $root = $array['atrucks:root'];

        $companies = [];
        foreach ($root['atrucks:companies'] as $company) {
            $id = $company['company_id'];
            $companies[$id] = $company;
        }

        $orders = [];
        foreach ($root['atrucks:orders'] as $order) {
            // dump($order);
            $id = $order['order_id'];
            $orders[$id] = $order;
            $orders[$id]['cargos'] = [];
            $orders[$id]['auctions'] = [];
        }

        foreach ($root['atrucks:cargoes'] as $cargo) {
            $id = $cargo['cargo_id'];
            $company_id = $cargo['company_id'];
            dd([
                'orders' => $orders,
                'cargo' => $cargo,
            ]);
            // dump([
            //     'id' => $id,
            //     'company' => $company_id,
            //     'cargo' => $cargo,
            // ]);
            $cargo['company'] = $companies[$company_id];
            array_push($orders[$id]['cargos'], $cargo);
        }

        foreach ($root['atrucks:auction_results'] as $auction) {
            $id = $auction['order_id'];
            array_push($order[$id]['auctions'], $auction);
        }

        // $order['']
        // $weight = $order['order_id']
        // array_push($result, [
        //     'id' => 'atrucks_' . $order['order_id'],
        //     'load_points' => $order['comment'],
        //     'unload_points' => $order['comment'],
        //     'price' => (int) $order['price'] * 0.88,
        //     // 'distance' => $order['comment'],
        //     'loading_time' => $order['comment'],
        //     'unloading_time' => $order['comment'],
        //     'loading_comment' => $order['comment'],
        //     'unloading_comment' => $order['comment'],
        //     'cargo_type' => $order['comment'],
        //     'comment' => $order['comment'],
        //     'weight' => $order['comment'],
        //     'length' => $order['comment'],
        // ]);
        return $orders;
    }

    private static function sendRequest(string $api_method, array $params = []) {
        $api = config()->get('api.atrucks');
        $params = array_merge($params, array('auth_key' => $api['token']));
        // dd(array_merge($params, array('auth_key' => $api['token'])));
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $api['url'] . '/' . $api_method,
            CURLOPT_HTTPHEADER     => array('Content-Type: multipart/form-data'),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        // $fh = fopen('curl_std_err.out', 'w+');
        // curl_setopt($ch, CURLOPT_STDERR, $fh);

        $xml = curl_exec($ch);
        // dd([
        //     'url' => $api['url'] . '/' . $api_method,
        //     'body' => http_build_query($params),
        //     'response' => $xml,
        // ]);
        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            throw new Warning($xml, 0, __FILE__, __LINE__);
            return false;
        }
        curl_close($ch);
        dd($xml);

        $XMLParser = new XMLParser($xml);
        $orders = $XMLParser->getOutput();
        return self::formatData($orders);
    }
}
