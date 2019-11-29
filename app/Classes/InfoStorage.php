<?php

namespace App\Classes;


class InfoStorage {
    public function getRatesInfo() {
        //using cache
        return ApiRequest::get(env('API_URL'));
    }
}