<?php
require_once("../data-classes/data-classes-core.php");

$group_id = FilterText($_GET['id']);

mysql_query("UPDATE user_stats SET groupid='". $group_id ."' WHERE id='". $my_id ."'") or die(mysql_error());

echo '<img src="./web-gallery/images/icon/favorite_active.png" alt="Favorito" title="Este grupo é seu favorito" />';
?>