<?php

/**
 * Created by PhpStorm.
 * User: thiagozampieri
 * Date: 23/01/18
 * Time: 21:32
 */
class Bling
{

    private $apiKey = "4b5e20dc60fdd147a72e9a2af70a77c242d28ee7043e7c38696a08bdea9e0e5d5a850572"; //IntegracaoCorelab
    private $outputType = "json";
    private $host = "https://bling.com.br/Api/v2/";


    private function transfer($url){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, str_replace(" ", "%20", $url));
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($curl_handle, CURLOPT_HEADER, true);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER,
            array('Content-Type:application/json')
        );
        $response = curl_exec($curl_handle);
        $response = json_decode($response);
        //print_r($response);
        //curl_close($curl_handle);
        return $response;
    }

    public function executeGetProduct($code){
        if ($code != ""){
            $url = $this->host.'produto/' . $code . '/' . $this->outputType.'?estoque=S&apikey=' . $this->apiKey;
            //echo $url;
            $response = $this->transfer($url);
            $response = $response->retorno->produtos[0]->produto;

            //print_r($response);
            return $response;
        }
}

}