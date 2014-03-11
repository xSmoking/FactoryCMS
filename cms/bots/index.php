<?php
$pasta = "";
require_once('./templates/topo.php');

$default = "http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=hr-0.sh-0.ch-0.hd-0.lg-0.cc-0";
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

    $verificabot = mysql_query("SELECT * FROM bots WHERE room_id='" . $room_id . "'") or die(mysql_query());
    $verificaquarto = mysql_query("SELECT * FROM rooms WHERE id='" . $room_id . "'") or die(mysql_query());
    $quartoarray = mysql_fetch_array($verificaquarto);

    if ((!$name) || (!$motto) || (!$room_id) || (!$look)) {
        $msg_type = "danger";
        $mensagem = "Preencha todos os campos!";
    } elseif (strlen($name) > "12") {
        $msg_type = "danger";
        $mensagem = "O nome do BOT &eacute; muito comprido.";
    } elseif (strlen($motto) > "25") {
        $msg_type = "danger";
        $mensagem = "A miss&atilde;o do BOT &eacute; muito comprida.";
    } else {
        if ($myrow['vip_points'] < "1000" || $myrow['credits'] < "5000") {
            $msg_type = "danger";
            $mensagem = "Voc&ecirc; n&atilde;o possui moedas ou rubis suficientes para comprar um BOT.";
        } elseif (mysql_num_rows($verificabot) > 0) {
            $msg_type = "danger";
            $mensagem = "J&aacute; existe um BOT neste quarto.<br />Voc&ecirc; s&oacute; pode ter 1 BOT em cada quarto!";
        } elseif ($quartoarray['owner'] != $myrow['username']) {
            $msg_type = "danger";
            $mensagem = "Este quarto n&atilde;o &eacute; seu. Por favor selecione um quarto de sua propriedade!";
        } else {
            mysql_query("INSERT INTO bots(room_id, owner_id, ai_type, name, motto, look, x, y, z, rotation, walk_mode) VALUE('" . $room_id . "', '" . $my_id . "', 'generic', '" . $name . "', '" . $motto . "', '" . $look . "', '0', '0', '0', '4', 'freeroam')") or die(mysql_error());
            $botidsql = mysql_query("SELECT * FROM bots WHERE room_id='" . $room_id . "' LIMIT 1") or die(mysql_query());
            $botarray = mysql_fetch_array($botidsql);
            mysql_query("INSERT INTO bots_speech(bot_id, text, shout) VALUES
                ('" . $botarray['id'] . "', 'Seja bem-vindo, posso ajudar?', '0'),
                ('" . $botarray['id'] . "', 'Sou o BOT deste incrível quarto, quer beber alguma coisa?', '0'),
                ('" . $botarray['id'] . "', 'Quantas pessoas lindas em um só quarto *--*', '0')") or die(mysql_error());

            mysql_query("INSERT INTO bots_responses(bot_id, keywords, response_text, mode, serve_id) VALUES
                ('" . $botarray['id'] . "', 'cola;drink;bebida;refri', 'Aqui está um refrigerante geladinho para você se refrescar!', 'say', '19'),
                ('" . $botarray['id'] . "', 'champanhe;champagne', 'Uma Champagne geladinha para comerar esta incrível festa :P', 'say', '40'),
                ('" . $botarray['id'] . "', 'cerveja;breja', 'Uma cerveja geladinha para descer redondo!', 'say', '43'),
                ('" . $botarray['id'] . "', 'cenoura', 'Todo coelho gosta de uma cenoura... Elas fazem bem para os olhos, sabia?', 'say', '3'),
                ('" . $botarray['id'] . "', 'sorvete', 'Nada melhor que um sorvete neste calor, não é mesmo?!', 'say', '4'),
                ('" . $botarray['id'] . "', 'cafe;café', 'Saindo bem quentinho, cuidado para não se queimar!', 'say', '53'),
                ('" . $botarray['id'] . "', 'redbull;energeitco', 'Nestas festas sempre é um bom um energético para não dormir!!', 'say', '44')") or die(mysql_error());

            $ncoins = $myrow['credits'] - 5000;
            $npts = $myrow['vip_points'] - 1000;
            mysql_query("UPDATE users SET credits='" . $ncoins . "', vip_points='" . $npts . "' WHERE id='" . $my_id . "'") or die(mysql_error());

            sendMusCommand($server_ip, 'updatecredits', $my_id);
            sendMusCommand($server_ip, 'updatepoints', $my_id);
            sendMusCommand($server_ip, 'update_bots', '1');
            sendMusCommand($server_ip, 'unloadroom', $room_id);
            $msg_type = "success";
            $mensagem = "BOT aquirido com sucesso! Voc&ecirc; j&aacute; pode entrar no quarto.";
        }
    }
}

$mybotsql = mysql_query("SELECT * FROM bots WHERE owner_id='" . $my_id . "'") or die(mysql_error());
if (mysql_num_rows($mybotsql) > 0) {
    $meus_bots = mysql_num_rows($mybotsql);
} else {
    $meus_bots = "0";
}
?>
<div id="wrap-content">
    <div id="meio">
        <b>&raquo; Meus BOTs (<?php echo $meus_bots; ?>)</b><br /><br />
        <?php
        if (mysql_num_rows($mybotsql) > 0) {
            while ($mybots = mysql_fetch_array($mybotsql)) {
                echo $mybots['name'] . ' (<a href="edit.php?id=' . $mybots['id'] . '" class="a">editar</a>)<br />';
            }
        } else {
            echo "Voc&ecirc; n&atilde;o possui BOTs<br />";
        }
        ?>
        <br /><br />

        <b>&raquo; Comprar novo BOT</b><br /><br />

        <?php
        if (isset($mensagem)) {
            echo '<div class="alert alert-'. $msg_type .'">'. $mensagem .'</div>';
        }
        ?>
        
        <u>Informa&ccedil;&otilde;es:</u><br />
        Pre&ccedil;o: 1000 rubis + 5000 moedas<br />
        A qualquer momento voc&ecirc; poder&aacute; trocar o nome, miss&atilde;o, roupa e quarto do BOT.<br /><br />

        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="name">Qual ser&aacute; o nome do BOT?</label>
                <input type="text" class="form-control" name="name" id="name" maxlength="12" id="name" placeholder="Nome do BOT" />
            </div>
            <div class="form-group">
                <label for="motto">Qual vai ser a miss&atilde;o do BOT?</label>
                <input type="text" class="form-control" name="motto" id="motto" size="40" maxlength="25" placeholder="Missão do BOT" />
            </div>
            <div class="form-group">
                <label for="room_id">Em qual quarto o BOT ir&aacute; ficar?</label>
                <select name="room_id" class="form-control">
                    <?php
                    $quartosql = mysql_query("SELECT * FROM rooms WHERE owner='" . $myrow['username'] . "'") or die(mysql_error());
                    while ($quarto = mysql_fetch_array($quartosql)) {
                        echo '<option value="' . $quarto['id'] . '">' . utf8_decode($quarto['caption']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                Escolha um visual para o BOT:<br />
                <?php
                echo '<table><tr>';
                for ($i = 1; $i <= count($visual); $i++) {
                    echo '
                        <td><img style="margin-left:-15px;" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=' . $visual[$i] . '&direction=2&head_direction=2&gesture=sml&action=&size=n" alt="' . $i . '" /></td>
                    ';
                }
                echo '</tr>';
                echo '<tr>';
                for ($i = 1; $i <= count($visual); $i++) {
                    echo '<td><input style="margin-left:15px;" type="radio" name="look" value="' . $visual[$i] . '" /></td>';
                }
                echo '</tr></table>';
                ?>
            </div>
            <input type="hidden" name="action" value="submit" id="action" />
            <button type="submit" class="btn btn-success">Comprar</button>
        </form>
        <br />
    </div>
</div>
<?php
require_once('./templates/rodape.php');