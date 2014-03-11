<?php
include_once("../data-classes/data-classes-core.php");

$groupid = FilterText($_POST['groupId']);
$badge = FilterText($_POST['code']);
$appkey = FilterText($_POST['__app_key']);

$badge = str_replace("NaN", "", $badge);

$check_user = mysql_query("SELECT * FROM group_memberships WHERE userid = '" . $myrow['id'] . "' AND groupid = '" . $groupid . "' AND rank=3") or die(mysql_error());
if (mysql_num_rows($check_user) > 0) {
    $my_membership = mysql_fetch_assoc($check_user);
    $rank = $my_membership['rank'];
    if ($rank < 3) {
        exit;
    }
} else {
    exit;
}

$checksql = mysql_query("SELECT * FROM groups WHERE id = '" . $groupid . "'") or die(mysql_error());
if (mysql_num_rows($checksql) > 0) {
    $groupdata = mysql_fetch_assoc($checksql);
} else {
    echo '
        <html>
            <head>
                <title>Alterar Emblema - Acesso Negado!</title>
            </head>
            <body onunload="window.opener.location.reload()" onload="window.close()">
                Ocorreu algum erro, <a href="#" onclick="window.close()">Clique aqui</a> para fechar.
            </body>
        </html>
    ';
}

if ($badge != $groupdata['badge']) {
    if ($groupdata['badge'] != b0503Xs09114s05013s05015) {
        $image = $cms_url . "/habbo-imaging/badge-fill/".$groupdata['badge'].".gif";
        if (file_exists($image)) {
            unlink($image);
        }
    } else {
        mysql_query("UPDATE groups SET badge = '" . FilterText($badge) . "' WHERE id = '" . $groupid . "' LIMIT 1");
        exit;
    }
}
mysql_query("UPDATE groups SET badge = '" . FilterText($badge) . "' WHERE id = '" . $groupid . "' LIMIT 1");
sendMusCommand($server_ip, 'updategroup', $groupid);
?> 
<html>
    <head>
        <title>Alterar Emblema - Sucesso!</title>
    </head>
    <body onunload="window.opener.location.reload()" onload="window.close()">
        <a href="#" onclick="window.close()">Clique aqui</a> para fechar.
    </body>
</html>
