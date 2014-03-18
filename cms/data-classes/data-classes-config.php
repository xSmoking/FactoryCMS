<?php
header('Content-Type: text/html; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "2296agosto";
$dbname = "phoenix_db";

$connect = mysqli_connect($host, $username, $password, $dbname);

$connect->set_charset("utf8");

if(mysqli_connect_errno()){
    printf("Connection falied: %s\n", mysqli_connect_error());
    exit();
}
?>