<?php
require_once("../data-classes/data-classes-core.php");

$group_id = FilterText($_GET['id']);
$group_check = $connect->query("SELECT * FROM groups WHERE id='" . $group_id . "' AND ownerid='". $my_id ."'") or die($connect->error());

if ($group_check->num_rows > 0) {
    $mygroup = $group_check->fetch_assoc();
    echo '<img id="badge" src="'. $cms_url .'/habbo-imaging/badge.php?badge='. $mygroup['badge'] .'">';
}
?>