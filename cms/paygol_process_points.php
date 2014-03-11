<?php
ini_set('display_errors', 1);
mysql_connect("localhost", "cms", "M5dF9012") or die("Erro");
mysql_select_db("factory_db") or die("Erro");

if(!in_array($_SERVER['REMOTE_ADDR'],
   array('109.70.3.48', '109.70.3.146', '109.70.3.58'))) {
   header("HTTP/1.0 403 Forbidden");
   die("Error: Unknown IP");
}

function sendMusCommand($server_ip, $command, $data=NULL, $port=30001){
    $data = $command . chr(1) . $data;
    $connection = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
    socket_connect($connection, $server_ip, $port);
    if(!is_resource($connection)){
        return false;
    }
    else{
        socket_send($connection, $data, strlen($data), MSG_DONTROUTE);
        return true;
    }
    socket_close($connection);
}

$custom = $_GET['custom'];

$ptsql = mysql_query("SELECT * FROM users WHERE id = '".$custom."' LIMIT 1") or mysql_error();
$user = mysql_fetch_assoc($ptsql);
$newpts = $user['vip_points'];
mysql_query("UPDATE users SET vip_points = '".$newpts."' + 500 WHERE id = '".$custom."'") or die(mysql_error());
sendMusCommand('69.162.82.226', 'updatepoints', $custom);
?>