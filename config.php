<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "virtuagym";

// Creating the connection
$conn = mysqli_connect($host,$username,$password,$db) or die("Could not connect to database, please make sure ");
$GLOBALS['conn'] = $conn;

error_reporting(E_ALL & ~E_NOTICE);

function safe($data){
    return trim(mysqli_real_escape_string($GLOBALS['conn'],$data));
}

