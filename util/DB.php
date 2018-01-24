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
    private $db = 'maqnunes';
    private $host = 'localhost';
    private $port = 3306;
    private $con = null;

    function getLink(){
        return $this->con;
    }

    function __construct()
    {
        $link = new mysqli("$this->host:$this->port", $this->user, $this->password, $this->db);
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