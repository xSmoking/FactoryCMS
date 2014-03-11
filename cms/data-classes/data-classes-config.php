<?php
header('Content-Type: text/html; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "2296agosto";
$dbname = "phoenix_db";

$connect = mysql_connect($host, $username, $password) or die("Could not connect to server, error: ".mysql_error());
$db = mysql_select_db($dbname, $connect) or die("Could not connect to database, error: ".mysql_error());
mysql_set_charset('utf8');

//mysql_query("SET NAMES 'utf8'");
//mysql_query('SET character_set_connection=utf8');
//mysql_query('SET character_set_client=utf8');
//mysql_query('SET character_set_results=utf8');
?>