<?php
$pasta = "";
require_once('./templates/topo.php');

if ($_POST['action'] == "submit") {
    $name = FilterText($_POST['name']);
    $modelo = FilterText($_POST['modelo']);
    $pagamento = FilterText($_POST['pagamento']);

    $verificaModelo = mysql_query("SELECT * FROM room_models WHERE id='" . $modelo . "'") or die(mysql_error());

    if ((!$name) || (!$modelo) || (!$pagamento)) {
        $mensagem = "Preencha todos os campos!";
    } elseif (strlen($name) > "20") {
        $mensagem = "O nome do Quarto &eacute; muito comprido.";
    } elseif (mysql_num_rows($verificaModelo) < 1) {
        $mensagem = "Este modelo n&atilde;o existe.";
    } else {
        $arrayModelo = mysql_fetch_array($verificaModelo);
        if ($arrayModelo['enable_room_store'] == 0) {
            $mensagem = "Voc&ecirc; n&atilde;o pode comprar este modelo.";
        } else {
            if ($pagamento == "coins") {
                if ($myrow['credits'] < 500 || $myrow['activity_points'] < 100) {
                    $mensagem = "Voc&ecirc; n&atilde;o possui moedas ou pixels suficiente.";
                } else {
                    $credit_balance = $myrow['credits'] - 500;
                    $activity_balance = $myrow['activity_points'] - 100;
                    mysql_query("UPDATE users SET credits='" . $credit_balance . "', activity_points='" . $activity_balance . "' WHERE id='" . $my_id . "'") or die(mysql_error());
                    mysql_query("INSERT INTO rooms(caption, owner, model_name) VALUE('" . $name . "', '" . $myrow['username'] . "', '" . $modelo . "')") or die(mysql_error());
                }
            } elseif ($pagamento == "points") {
                if ($myrow['vip_points'] < 5) {
                    $mensagem = "Voc&ecirc; n&atilde;o possui rubis suficiente.";
                } else {
                    $points_balance = $myrow['vip_points'] - 5;
                    mysql_query("UPDATE users SET vip_points='" . $points_balance . "' WHERE id='" . $my_id . "'") or die(mysql_error());
                    mysql_query("INSERT INTO rooms(caption, owner, model_name) VALUE('" . $name . "', '" . $myrow['username'] . "', '" . $modelo . "')") or die(mysql_error());
                }
            }
        }
        
        $mensagem = "Quarto adquirido com sucesso! Voc&ecirc; j&aacute; pode entrar no quarto.";
    }
}
?>
<div id="wrap-content">
    <div id="meio">
        <b>&raquo; Criar um Quarto</b><br /><br />

        <?php
        if($myrow['online'] == 1){
            echo "Você deve ficar offline para comprar um quarto!";
        }else{
        ?>
        <b>Pre&ccedil;os</b><br />
        Op&ccedil;&atilde;o 1: 500 moedas + 100 pixels<br />
        Op&ccedil;&atilde;o 2: 5 rubis<br /><br />
        Para alterar as informa&ccedil;&otilde;es do quarto entre no Hotel.<br /><br />

        <form action="" method="post">
            Nome do Quarto:<br />
            <input type="text" name="name" id="name" maxlength="20" size="30" /><br /><br />

            <ul id="modelos">
                <li>Modelo 1:<br /><br /><img src="http://www.factoryhotel.com.br/swf/c_images/modelos/model_novo_a.png" alt="" /><br /><br />183 quadrados</li>
                <li>Modelo 2:<br /><br /><img src="http://www.factoryhotel.com.br/swf/c_images/modelos/model_novo_b.png" alt="" /><br /><br />134 quadrados</li>
                <li>Modelo 3:<br /><br /><img src="http://www.factoryhotel.com.br/swf/c_images/modelos/model_novo_d.png" alt="" /><br /><br />1002 quadrados</li>
                <li>Modelo 4:<br /><br /><img src="http://www.factoryhotel.com.br/swf/c_images/modelos/model_novo_e.png" alt="" /><br /><br />570 quadrados</li>
                <li>Modelo 5:<br /><br /><img src="http://www.factoryhotel.com.br/swf/c_images/modelos/model_novo_f.png" alt="" /><br /><br />192 quadrados</li>
            </ul>
            <br /><br />

            Selecione o modelo:<br />
            <select name="modelo">
                <option value="model_novo_a">Modelo 1</option>
                <option value="model_novo_b">Modelo 2</option>
                <option value="model_novo_d">Modelo 3</option>
                <option value="model_novo_e">Modelo 4</option>
                <option value="model_novo_f">Modelo 5</option>
            </select><br /><br />

            <select name="pagamento">
                <option value="coins">Pagar com moedas + p&iacute;xels</option>
                <option value="points">Pagar com rubis</option>
            </select><br /><br />

            <input type="hidden" name="action" value="submit" id="action" />
            <input type="submit" value="Comprar Quarto" id="submit" />
        </form>
        <br />
        <?php
        if (isset($mensagem)) {
            echo $mensagem . "<br />";
        }
        }
        ?>
        <br />
    </div>
</div>
<?php
require_once('./templates/rodape.php');
?>