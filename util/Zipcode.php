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

    function __construct()
    {
    }

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

    function getFreight($postalCode, $weight){
        $query = "SELECT d.price, d.time 
                FROM corelab_freight AS d 
               WHERE (d.cep_initial <= '".intval($postalCode)."' AND d.cep_final >= '".intval($postalCode)."') 
                 AND (d.weight_initial <= '".doubleval($weight)."' AND d.weight_final >= '".doubleval($weight)."')
            ORDER BY d.time ASC, d.price ASC
               LIMIT 0,1
            ";

        $con = new DB();
        //echo $query;
        if ($weight > 0 & $query != "") {
            if ($result = $con->getLink()->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    $result->close();
                    return ($row);
                }

            }
        }
    }
}