<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    private static $response;
    private static $responseAssoc;
    //
    public static function sendMessage($chat_id, $message, $params = null) {
        $params = self::getAllowedParams($params, ['chat_id', 'text', 'parse_mode', 'disable_web_page_preview', 'disable_notification', 'reply_to_message_id', 'reply_markup']);
        $params = array_merge($params, [
            'chat_id'    => $chat_id,
            'text'       => $message,
        ]);
        self::sendRequest('sendMessage', $params);
        return self::isOk();
    }

    public static function isOk() {
        if (!is_null(self::$responseAssoc)) {
            return self::$responseAssoc->ok;
        } else if (gettype(self::$response) == 'string') {
            self::$responseAssoc = json_decode(self::$response);
            return self::$responseAssoc->ok;
        }
        return false;
    }

    public static function getResponse() {
        return self::$responseAssoc ?: self::$response;
    }

    private static function getAllowedParams($params, $allowed_params) {
        return array_filter($params,
            function ($key) use ($allowed_params) {
                return in_array($key, $allowed_params);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    private static function sendRequest($api_method, $params) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://api.telegram.org/bot812247319:AAFb0SlTlaZLhGwKaZe-xsGo1rIDnY8cHpk/' . $api_method,
            CURLOPT_HTTPHEADER     => ['Content-Type: multipart/form-data'],
            CURLOPT_POST           => true,
            CURLOPT_HEADER         => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        dd($ch);
        dd(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        self::$response = $response;
        self::$responseAssoc = null;
    }
}
