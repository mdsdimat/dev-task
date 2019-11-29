<?php

namespace App\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiRequest {

    public static function get(string $url): object {

        if (env('APP_PROXY')) {
            $proxy = str_replace( ['tcp://', 'https://'] , 'http://', env('APP_PROXY'));
            $client = new Client(['proxy' => $proxy]);
        } else {
            $client = new Client();
        }
        try {
            $response = $client->request('GET', $url, ['connect_timeout' => 10]);
        } catch (RequestException $e) {
            return (object) array('status' => 'error', 'message' => 'error courses');
        }

        $result = (string)$response->getBody();

        return json_decode($result);
    }
}