<?php
$pasta = "../";
require_once('./templates/topo.php');

$bot_id = FilterText($_GET['id']);

$visual['1'] = "hr-125-32.sh-300-64.ch-3001-62-81.hd-180-3.lg-285-64.cc-260-62.ea-3168-74";
$visual['2'] = "hd-3092-1.lg-275-104.he-3070-92.hr-828-42.ch-215-110";
$visual['3'] = "hr-155-1342.wa-2001-62.sh-290-62.ch-220-66.hd-180-10.lg-270-92";
$visual['4'] = "ch-3059-110.hd-180-7.lg-3023-92.hr-3163-31.sh-3016-110";
$visual['5'] = "hr-893-61.sh-290-102.ch-215-96.hd-180-10.lg-275-1321";
$visual['6'] = "ca-3085-92.he-3070-92.hr-3163-1342.sh-290-96.ch-3030-107.hd-206-28.lg-275-92";
$visual['7'] = "fa-1203-62.ch-3234-1321.hd-209-30.lg-3235-93.ea-1401-62.ha-1012-93.he-3227-96";
$visual['8'] = "hr-3162-1344.sh-3016-110.ch-875-92-110.hd-180-7.lg-285-110";
$visual['9'] = "he-1608-96.hr-3012-45.wa-2001-62.ch-824-92.hd-600-28.lg-3018-1341.sh-730-96";
$visual['10'] = "ha-3054-1329-109.hr-170-1356.sh-3016-100.ch-3059-100.hd-206-10.lg-281-100";
$visual['11'] = "ca-3217-100-92.ch-3005-1327-106.hd-600-1.lg-3018-98.hr-9534-1347";
$visual['12'] = "hr-834-37.wa-2001-62.hd-600-28.lg-3192-92.sh-730-99.ch-3013-110.he-1610-92";
$visual['13'] = "he-3070-110.hr-3012-45.wa-2001-62.ch-817-92.hd-600-28.lg-3018-1341.sh-735-110";
$visual['14'] = "ch-3013-92.he-1610-93.lg-3006-1337-92.hr-9534-1342.hd-610-28.wa-2003-78";
$visual['15'] = "ch-815-92-110.hd-600-1.lg-695-110.hr-3012-1344.sh-3016-110";
$visual['16'] = "cp-3207-96-96.he-3082-96.hr-3040-36.ca-3187-62.ch-3005-98-62.hd-3099-1.lg-3174-98-62";

if ($_POST['action'] == "submit") {
    $name = FilterText($_POST['name']);
    $motto = FilterText($_POST['motto']);
    $room_id = FilterText($_POST['room_id']);
    $look = FilterText($_POST['look']);

    $botinfosql = mysql_query("SELECT * FROM bots WHERE id='" . $bot_id . "'") or die(mysql_error());
    $botinfo = mysql_fetch_array($botinfosql);
    $verificabot = mysql_query("SELECT * FROM bots WHERE room_id='" . $room_id . "' AND id <> '" . $bot_id . "'") or die(mysql_error());
    $verificaquarto = mysql_query("SELECT * FROM rooms WHERE id='" . $room_id . "'") or die(mysql_error());
    $quartoarray = mysql_fetch_array($verificaquarto);

    if ((!$name) || (!$motto) || (!$room_id) || (!$look)) {
        $mensagem = "Preencha todos os campos!";
    } elseif (strlen($name) > "12") {
        $mensagem = "O nome do BOT &eacute; muito comprido.";
    } elseif (strlen($motto) > "25") {
        $mensagem = "A miss&atilde;o do BOT &eacute; muito comprida.";
    } else {
        if (mysql_num_rows($verificabot) > 0) {
            $mensagem = "J&aacute; existe um BOT neste quarto.<br />Voc&ecirc; s&oacute; pode ter 1 BOT em cada quarto!";
        } elseif ($quartoarray['owner'] != $myrow['username']) {
            $mensagem = "Este quarto n&atilde;o &eacute; seu. Por favor selecione um quarto de sua propriedade!";
        } else {
            mysql_query("UPDATE bots SET room_id='" . $room_id . "', name='" . $name . "', motto='" . $motto . "', look='" . $look . "' WHERE id='" . $bot_id . "'") or die(mysql_error());
            sendMusCommand($server_ip, 'update_bots', '1');
            sendMusCommand($server_ip, 'unloadroom', $botinfo['room_id']);
            sendMusCommand($server_ip, 'unloadroom', $room_id);
            $mensagem = "BOT atualizado com sucesso! Voc&ecurc; j&aacute; pode entrar no quarto.";
        }
    }
}

$mybotsql = mysql_query("SELECT * FROM bots WHERE id='" . $bot_id . "' AND owner_id='" . $my_id . "'") or die(mysql_error());
?>
<div id="wrap-content">
    <div id="meio">
        <?php
        if (mysql_num_rows($mybotsql) > 0) {
            $botarray = mysql_fetch_array($mybotsql);
            ?>
            <b>&raquo; Editar meu BOT</b><br /><br />
            <form action="" method="post">
                Qual ser&aacute; o nome do BOT?<br />
                <input type="text" name="name" id="name" maxlength="12" value="<?php echo $botarray['name']; ?>" /><br /><br />

                Qual vai ser a miss&atilde;o do BOT?<br />
                <input type="text" name="motto" id="motto" size="40" maxlength="25" value="<?php echo $botarray['motto']; ?>" /><br /><br />

                Em qual quarto o BOT ir&aacute; ficar?<br />
                <select name="room_id">
                    <?php
                    $quartosql = mysql_query("SELECT * FROM rooms WHERE owner='" . $myrow['username'] . "'") or die(mysql_error());
                    while ($quarto = mysql_fetch_array($quartosql)) {
                        ?>
                        <option value="<?php echo $quarto['id']; ?>" <?php
                        if ($botarray['room_id'] == $quarto['id']) {
                            echo 'selected';
                        }
                        ?>><?php echo utf8_decode($quarto['caption']); ?></option>
                                <?php
                            }
                            ?>
                </select><br /><br />

                Escolha um visual para o BOT<br />
                <?php
                echo '<table><tr>';
                for ($i = 1; $i <= count($visual); $i++) {
                    echo '
                    <td><img style="margin-left:-15px;" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=' . $visual[$i] . '&direction=2&head_direction=2&gesture=sml&action=&size=l" alt="' . $i . '" /></td>
                ';
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 1; $i <= count($visual); $i++) {
                    ?>
                    <td><input style="margin-left:15px;" type="radio" name="look" value="<?php echo $visual[$i]; ?>" <?php
                        if ($botarray['look'] == $visual[$i]) {
                            echo 'checked';
                        }
                        ?> /></td>
        <?php
    }
    echo '</tr></table>';
    ?>
                <br /><br />
                <input type="hidden" name="action" value="submit" id="action" />
                <input type="submit" value="Editar BOT" id="submit" />
                <a href="http://server.factoryhotel.com.br/bots/" id="cancel">Cancelar</a>
            </form>
            <br />
            <?php
            if (isset($mensagem)) {
                echo $mensagem . "<br />";
            }
            ?>
            <br />
    <?php
} else {
    echo 'Voc&ecirc; n&atilde;o &eacute; dono deste BOT, por favor selecione um BOT de sua propriedade.';
}
?>
    </div>
</div>
<?php
require_once('./templates/rodape.php');
?>