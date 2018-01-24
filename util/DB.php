<?php

/**
 * Created by PhpStorm.
 * User: thiagozampieri
 * Date: 23/01/18
 * Time: 22:07
 */
class DB
{
    private $user = 'root';
    private $password = 'root';
    private $db = 'walmart_freight';
    private $host = 'localhost';
    private $port = 3306;
    private $con = null;

    function __construct()
    {
        $link = new mysqli("$host:$port", $user, $password, $db);
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $this->con = $link;
    }

    function close(){
        $this->con->close();
    }

}