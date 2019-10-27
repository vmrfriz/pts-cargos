<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ATrucks
    |--------------------------------------------------------------------------
    |
    | https://atrucks.su
    |
    */

    'atrucks' => [
        'url' => env('ATRUCKS_URL', 'https://training.atrucks.su/api/v3/carrier'),
        'token' => env('ATRUCKS_TOKEN', 'G8mUwHOwiV4gcR99ms3FRfCvii0v0veL303p0bqn5BTPesGQ'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Yandex Maps
    |--------------------------------------------------------------------------
    |
    | Yandex maps geocoder API
    |
    */

    'yandexmaps' => [
        'token' => env('YMAPS_TOKEN'),
    ]

];
