<?php
require_once("../data-classes/data-classes-core.php");

$group_id = FilterText($_GET['id']);
$group_check = mysql_query("SELECT * FROM groups WHERE id='" . $group_id . "' AND ownerid='". $my_id ."'") or die(mysql_error());

if (mysql_num_rows($group_check) > 0) {
    $mygroup = mysql_fetch_assoc($group_check);
    echo '<img id="badge" src="'. $cms_url .'/habbo-imaging/badge.php?badge='. $mygroup['badge'] .'">';
}
?>