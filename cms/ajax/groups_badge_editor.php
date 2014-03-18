<?php
include_once("../data-classes/data-classes-core.php");

$refer = $_SERVER['HTTP_REFERER'];
$groupid = FilterText($_GET['id']);

$check_user = $connect->query("SELECT * FROM group_memberships WHERE userid = '" . $myrow['id'] . "' AND groupid = '" . $groupid . "' AND rank=3") or die($connect->error());
if ($check_user->num_rows > 0) {
    $my_membership = $check_user->fetch_assoc();
    $rank = $my_membership['rank'];
    if ($rank < 3) {
        exit;
    }
} else {
    exit;
}

$checksql = $connect->query("SELECT * FROM groups WHERE id = '" . $groupid . "'") or die($connect->error());

if ($checksql->num_rows > 0) {
    $groupdata = $checksql->fetch_assoc();
} else {
    exit;
}
?>
<!--<style type="text/css">
    body{
        background:url(./web-gallery/images/bg_badge.png);
    }
</style>-->
<script src="<?php echo $cms_url; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
<div id="badge-editor-flash" align="center">
    <strong>Você deve ter Flash Player instalado em seu navegador</strong>
</div>
<script type="text/javascript" language="JavaScript">
    var swfobj = new SWFObject("<?php echo $cms_url; ?>/web-gallery/flash/BadgeEditor.swf", "badgeEditor", "280", "366", "8");
    swfobj.addParam("base", "<?php echo $cms_url; ?>/web-gallery/flash/");
    swfobj.addParam("bgcolor", "#FFFFFF");
    swfobj.addVariable("post_url", "<?php echo $cms_url; ?>/ajax/groups_badge_save.php");
    swfobj.addVariable("__app_key", "Factory");
    swfobj.addVariable("groupId", "<?php echo $groupid; ?>");
    swfobj.addVariable("badge_data", "<?php echo $groupdata['badge']; ?>");
    swfobj.addVariable("localization_url", "<?php echo $cms_url; ?>/web-gallery/flash/badge_editor.xml");
    swfobj.addVariable("xml_url", "<?php echo $cms_url; ?>/web-gallery/flash/badge_data.xml");
    swfobj.addParam("allowScriptAccess", "always");
    swfobj.write("badge-editor-flash");
</script>