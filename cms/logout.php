<?php
include_once("./data-classes/data-classes-core.php");
session_destroy();
sendMusCommand($server_ip, 'signout', $my_id);
header("Location: ". $cms_url);
?>
