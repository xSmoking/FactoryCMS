<?php
include_once("../data-classes/data-classes-core.php");

$groupid = FilterText($_POST['groupId']);
$badge = FilterText($_POST['code']);
$appkey = FilterText($_POST['__app_key']);

$badge = str_replace("NaN", "", $badge);

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
        $connect->query("UPDATE groups SET badge = '" . FilterText($badge) . "' WHERE id = '" . $groupid . "' LIMIT 1");
        exit;
    }
}
$connect->query("UPDATE groups SET badge = '" . FilterText($badge) . "' WHERE id = '" . $groupid . "' LIMIT 1");
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
