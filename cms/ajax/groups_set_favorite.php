<?php
require_once("../data-classes/data-classes-core.php");

$group_id = FilterText($_GET['id']);

$connect->query("UPDATE user_stats SET groupid='". $group_id ."' WHERE id='". $my_id ."'") or die($connect->error());

echo '<img src="./web-gallery/images/icon/favorite_active.png" alt="Favorito" title="Este grupo é seu favorito" />';
?>