<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AtiLoads extends Model
{
    protected $url = 'https://api.ati.su/';
    protected $api_token = config()->get('api.ati.api_token');

    public function get($id) {

    }

    public function getAll($contactId) {

    }

    public function new() {
        $this->request('POST', 'loads', '');
    }

    public function edit() {

    }

    public function remove($uuid) {
        $response = $this->request('DELETE', "loads/{$uuid}");
        return $response;
    }

    private function request(string $method, string $request_url, $data = []) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->url . $request_url,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Authorization: Bearer ' . $this->api_token,
                'Content-Type: application/json',
            ],
            CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        return curl_exec($ch);
    }
}
