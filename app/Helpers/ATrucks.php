<?php

namespace App\Helpers;

class ATrucks {
    public static $api_url;
    private static $token;

    /**
     * Установить токен для запросов
     * 
     * @var    token Токен API
     * @return void
     */
    public static function setup($token): void {
        self::$token = $token;
    }

    /**
     * Получить все рейсы из ATrucks
     * 
     * @return JSON json
     */
    public static function all(): string {
        $params = array('type' => 'available');
        $result = self::request('get_orders', $params);
        return json_encode($result);
    }

    /**
     * Получить всю информацию по рейсу
     * 
     * @var    uuid  Идентификатор рейса в формате UUID
     * @return JSON  json
     */
    public static function id(string $uuid): string {
        $params = array('order_id' => $uuid);
        $result = self::request('get_order', $params);
        return json_encode($result);
    }

    /**
     * cUrl запрос к API ATrucks
     * 
     * @var    api_method    Метод API из документации ATrucks. Например, get_orders
     * @var    params_array  Параметры запроса
     * @return XML           Ответ сервера в формате XML
     */
    private static function request(string $api_method, array $params_array = array()): string {
        $params_array['auth_key'] = self::$token;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => self::$api_url . $api_method,
            CURLOPT_HTTPHEADER     => array('Content-Type: multipart/form-data'),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $params_array,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $api_response = curl_exec($ch);
        curl_close($ch);

        return $api_response;
    }
}
