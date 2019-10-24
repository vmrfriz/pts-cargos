<?php

/**
 * Temperarity file for example
 *
 */

class ATrucksSDK
{
    private $api_url;
    private $auth_key;
    private $is_main_server;

    public function __construct($api_token, $main_server = true)
    {
        $this->auth_key = $api_token;
        if ($main_server) {
            // 'sEoFnBjF8MYny8zjn2IKRLTXmiXeaBGgyvHZx9CtEf3LrnDS'
            $this->api_url = 'https://www.atrucks.su/api/v3/carrier/';
            $this->is_main_server = true;
        } else {
            $this->api_url = 'https://training.atrucks.su/api/v3/carrier/';
            // 'G8mUwHOwiV4gcR99ms3FRfCvii0v0veL303p0bqn5BTPesGQ'
            $this->is_main_server = false;
        }
    }

    // get_order by uuid
    public function get_order($uuid) {
        $params = array('order_id' => $uuid);
        return $this->get_array('get_orders', $params);
    }

    public function get_order_xml($uuid) {
        $params = array('order_id' => $uuid);
        return $this->api_request('get_orders', $params);
    }

    // get_orders
    public function get_orders() {
        $old_data = $this->get_array('get_orders');
        $struct = [
            'companies'       => 'company_id',
            'cargoes'         => 'cargo_id',
            'orders'          => 'order_id',
            'auction_results' => 'order_id',
        ];
        $middle_data = [];
        if ($struct)
        foreach ($struct as $new_section => $id_key) {
            $old_section = 'atrucks:' . $new_section;
            $middle_data[$new_section] = [];

            if ($old_data['atrucks:root'][$old_section])
            foreach ($old_data['atrucks:root'][$old_section] as $k => $v) {
                $id = $v[$id_key];
                $middle_data[$new_section][$id] = $v;
            }
        }

        $new_data = [];
        foreach ($middle_data['orders'] as $order) {
            $order_id = $order['order_id'];
            $cargo_id = $order['cargo_ids'];

            if (gettype($order['cargo_ids']) != 'array') {
                $order['cargo_ids'] = array($order['cargo_ids']);
            }

            foreach ($order['cargo_ids'] as $cargo_id) {
                $cargo = $middle_data['cargoes'][$cargo_id];
                $company_id = $cargo['company_id'];
                $company = $middle_data['companies'][$company_id];
                $order['cargoes'][] = array_merge($cargo, ['company' => $company]);
            }

            $order['auction'] = $middle_data['auction_results']['order_id'];

            $new_data[$order_id] = $order;
        }

        return $new_data;
    }

    public function get_orders_xml() {
        return $this->api_request('get_orders');
    }

    // get_available_orders
    public function get_available_orders() {
        $params = array('type' => 'available');
        return $this->get_array('get_orders', $params);
    }

    public function get_available_orders_xml() {
        $params = array('type' => 'available');
        return $this->api_request('get_orders', $params);
    }

    // get_obtained_orders [by date]
    public function get_obtained_orders($date = null) {
        $params = array('type' => 'obtained');
        if ($date) $params['date'] = $date;
        return $this->get_array('get_orders', $params);
    }

    public function get_obtained_orders_xml($date = null) {
        $params = array('type' => 'obtained');
        if ($date) $params['date'] = $date;
        return $this->api_request('get_orders', $params);
    }

    // ============= PRIVATE =============

    private function get_array($api_method, $params_array = array()) {
        $api_response = $this->api_request($api_method, $params_array);
        $xml_response = new XMLParser($api_response);
        return $xml_response->getOutput();
    }

    private function api_request($api_method, $params_array = array()) {
        $params_array['auth_key'] = $this->auth_key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . $api_method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_array);
        // curl_setopt($ch, CURLOPT_FAILONERROR, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $api_response = curl_exec($ch);
        curl_close($ch);

        return $api_response;
    }
}

