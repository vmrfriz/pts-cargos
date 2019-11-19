<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Error\Warning;
use App\Helpers\XMLParser;
use DateTime;

class ATrucks extends Model
{
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    //
    public static function all($columns = ['*']) {
        $imported_array = self::sendRequest('get_orders');
        return self::ordersFormat($imported_array);
    }

    public static function find(string $uuid) {
        $imported_array = self::sendRequest('get_orders', [
            'order_id' => $uuid
        ]);
        return self::ordersFormat($imported_array)[0];
    }

    private static function ordersFormat($imported_array) {
        $data = [];
        $root = $imported_array['atrucks:root'];
        // $banned_uuid = array_filter($root['atrucks:companies'], function ($val, $key) {
        //     return $val['name'] == 'Стекловолокно';
        // })[0];
        foreach ($root['atrucks:orders'] as $order) {
            $load_points = self::getLoadPointsFromRoute($order['atrucks:route']);
            $load_addr = $load_points['addr'];
            $load_coords = $load_points['coord'];
            array_push($data, array(
                'id' => 'atrucks_' . $order['order_id'],
                'load_points' => $load_addr,
                'load_coords' => $load_coords,
                'unload_points' => self::getUnloadPointsFromRoute($order['atrucks:route'])['addr'],
                'price' => round((float) $order['price'] * 0.88, -3, PHP_ROUND_HALF_DOWN),
                'distance' => (float) self::getDistanceFromRoute($order['atrucks:route']),
                'loading_time' => self::getEventDatetimeFromRoute('loading', $order['atrucks:route']),
                'unloading_time' => self::getEventDatetimeFromRoute('unloading', $order['atrucks:route']),
                'loading_comment' => self::getRouteComments($order['atrucks:route'], ['loading']),
                'unloading_comment' => self::getRouteComments($order['atrucks:route'], ['unloading']),
                'comment' => $order['comment'],
                'cargo_type' => (string) self::getCargoTypesFromOrder($order, $root['atrucks:cargoes']),
                'weight' => (float) self::getOrderCargosWeight($order, $root['atrucks:cargoes']),
                'length' => null,
            ));
        }
        return $data;
    }

    private static function getRouteComments($route, array $filter = ['loading', 'unloading']): string {
        $comments = [];
        foreach ($route as $point) {
            if (!in_array($point['waypoint_type'], $filter))
                continue;
            if ($point['comment'])
                array_push($comments, $point['comment']);
        }
        return implode("\n", $comments);
    }

    private static function getEventDatetimeFromRoute($event, $route) {
        $datetimes = [];
        foreach ($route as $point) {
            $date = null;
            if ($point['arrival_date']) {
                $time = ($point['arrival_time'] ?: '00:00:00');
                $time .= strlen($time) == 5 ? ':00' : '';
                $date = $point['arrival_date'].' '.$time;
            } else {
                $date = date('Y-m-d h:i:s', strtotime('tomorrow'));
            }
            array_push($datetimes, $date);
        }
        sort($datetimes);
        if ($event == 'loading') {
            $result = $datetimes[0];
        } else {
            $result = end($datetimes);
        }
        // dump($result);
        return $result;
    }

    private static function getCargoTypesFromOrder($order, $cargos): string {
        $cargo_types = [];
        $order_cargos = $order['cargo_ids'];
        foreach ($cargos as $cargo) {
            $cargo_id = $cargo['cargo_id'];
            if (!in_array($cargo_id, $order_cargos))
                continue;
            $cargo_type =
                $cargo['pack_types']
                ? implode(', ', $cargo['pack_types'])
                : '';
            array_push($cargo_types, $cargo_type);
        }
        return implode(', ', $cargo_types);
    }

    private static function getOrderCargosWeight($order, $cargos): float {
        $weight = 0;
        $order_cargos = $order['cargo_ids'];
        foreach ($cargos as $cargo) {
            $cargo_id = $cargo['cargo_id'];
            if (!in_array($cargo_id, $order_cargos))
                continue;
            $weight += (double) $cargo['weight'];
        }
        return $weight;
    }

    private static function getLoadPointsFromRoute($route): array {
        return self::getPointsFromRoute('loading', $route);
    }

    private static function getUnloadPointsFromRoute($route): array {
        return self::getPointsFromRoute('unloading', $route);
    }

    private static function getPointsFromRoute($waypoint_type, $route): array {
        $loads_addr = [];
        $loads_points = [];
        foreach ($route as $point) {
            if ($point['waypoint_type'] != $waypoint_type)
                continue;
            $first_key = array_key_first($point['address']);
            $address = $point['address'][$first_key]; //['free_form'];
            // $city = self::getCityByAddress($address);
            $geoinfo = self::getGeoInfoByAddress($address);
            $city = $geoinfo['city'];
            $coord = $geoinfo['coords'];
            array_push($loads_addr, $city);
            array_push($loads_points, $coord);
        }
        return [
            'addr' => $loads_addr,
            'coord' => $loads_points,
        ];
    }

    private static function getGeoInfoByAddress(string $address): array {
        $response_json = self::getCachedGeocoderResponse($address);
        $response_data = (
            $response_json
            ? json_decode($response_json)
            : json_decode(self::getYandexGeocoderResponse($address))
        );

        $GeoObjectInfo = $response_data->response->GeoObjectCollection->featureMember;
        if ($GeoObjectInfo) {
            $address_components = $GeoObjectInfo[0]->GeoObject->metaDataProperty->GeocoderMetaData->Address->Components;
            $area = '';
            $city = '';

            if ($address_components)
            foreach ($address_components as $a) {
                if ($a->kind == 'locality') {
                    $city = $a->name;
                    break;
                }
                if ($a->kind == 'area' && !$area)
                    $area = $a->name;
            }
            $cityName = $city ?: $area ?: $address;
            $cityCoordsObj = $GeoObjectInfo[0]->GeoObject->Point->pos; // ->boundedBy->Envelope;
            // $cityCoordsLower = explode(' ', $cityCoordsObj->lowerCorner);
            // $cityCoordsUpper = explode(' ', $cityCoordsObj->upperCorner);
            $cityCoordsCenter = explode(' ', $cityCoordsObj); //[
                // ($cityCoordsUpper[0] - $cityCoordsLower[0]) / 2 + $cityCoordsLower[0],
                // ($cityCoordsUpper[1] - $cityCoordsLower[1]) / 2 + $cityCoordsLower[1],
            // ];
            $result = [
                'city'   => preg_replace(['/посёлок городского типа/', '/посёлок/', '/село/'], ['пгт.', 'пос.', 'с.'], $cityName),
                'coords' => [$cityCoordsCenter[1], $cityCoordsCenter[0]],
            ];
        } else {
            $result = [
                'city'   => $address,
                'coords' => null,
            ];
        }
        return $result;
    }

    private static function getCityByAddress(string $address): string {
        $response_json = self::getCachedGeocoderResponse($address);
        $response_data = (
            $response_json
            ? json_decode($response_json)
            : json_decode(self::getYandexGeocoderResponse($address))
        );

        $address_components = $response_data->response->GeoObjectCollection->featureMember;
        if ($address_components) {
            $address_components = $address_components[0]->GeoObject->metaDataProperty->GeocoderMetaData->Address->Components;
        }
        $area = '';
        $city = '';

        if ($address_components)
        foreach ($address_components as $a) {
            if ($a->kind == 'locality') {
                $city = $a->name;
                break;
            }
            if ($a->kind == 'area' && !$area)
                $area = $a->name;
        }

        $result = $city ?: $area ?: $address;
        return preg_replace(['/посёлок городского типа/', '/посёлок/', '/село/'], ['пгт.', 'пос.', 'с.'], $result);
    }

    private static function getCachedGeocoderResponse($address) {
        $data = YandexGeocoder::where('address', $address)->first();
        return $data ? $data->response : false;
    }

    private static function getYandexGeocoderResponse($address) {
        $ch = curl_init();
        $ymaps_token = config()->get('api.yandexmaps.token');
        $request_data = array(
            'format'  => 'json',
            'apikey'  => $ymaps_token,
            'geocode' => $address,
        );
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://geocode-maps.yandex.ru/1.x/?'.http_build_query($request_data),
            CURLOPT_RETURNTRANSFER => true
        ]);
        $response_json = curl_exec($ch);
        YandexGeocoder::create([
            'address' => $address,
            'response' => $response_json,
        ]);
        return $response_json;
    }

    private static function getDistanceFromRoute($route): float {
        return 0;
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

        $XMLParser = new XMLParser($xml);
        $orders = $XMLParser->getOutput();
        return $orders;
    }
}
