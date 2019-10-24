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
        $XMLParser = new XMLParser($xml);
        // $obj = $XMLParser->XMLParser($xml);
        return $XMLParser->getOutput();
        // return $obj->getOutput();
    }

    public static function find(string $uuid) {
        return self::sendRequest('get_orders', [
            'order_id' => $uuid
        ]);
    }

    private static function formatArray($array) {
        return $array;
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
        return $xml;
    }
}
