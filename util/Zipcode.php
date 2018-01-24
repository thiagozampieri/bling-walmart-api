<?php

/**
 * Created by PhpStorm.
 * User: thiagozampieri
 * Date: 23/01/18
 * Time: 22:42
 */
class Zipcode
{
    private $host = "https://viacep.com.br/ws/{zipcode}/json";

    function getAddress($zipcode){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, str_replace("{zipcode}", $zipcode, $this->host));
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($curl_handle, CURLOPT_HEADER, true);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER,
            array('Content-Type:application/json')
        );
        $response = curl_exec($curl_handle);
        $response = json_decode($response);
        return $response;
    }
}