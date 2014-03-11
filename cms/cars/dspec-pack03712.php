<?php
$pasta = "";
require_once('./templates/topo.php');

$car_id = FilterText($_GET['car_id']);
if (isset($_GET['car_id'])) {
    $sqlc = mysql_query("SELECT * FROM catalog_cars WHERE id='" . $car_id . "'") or die(mysql_error());
    if (mysql_num_rows($sqlc) > 0) {
        $mark = mysql_fetch_array($sqlc);
        if ($mark['activated'] == 0) {
            echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce nao pode comprar este carro.")</SCRIPT>';
        } else {
            $itemsql = mysql_query("SELECT * FROM furniture WHERE sprite_id='" . $mark['sprite_id'] . "'") or die(mysql_error());
            $item = mysql_fetch_array($itemsql);
            $pagesql = mysql_query("SELECT * FROM catalog_items WHERE item_ids='" . $item['id'] . "'") or die(mysql_error());
            $page = mysql_fetch_array($pagesql);
            $newpoints = $myrow['vip_points'] - $mark['cost_points'];
            $newcoins = $myrow['credits'] - $mark['cost_credits'];
            $newpixel = $myrow['activity_points'] - $mark['cost_pixels'];
            if ($newpoints < 0) {
                echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce nao possui rubis suficientes para comprar o carro")</SCRIPT>';
            } else {
                mysql_query("UPDATE users SET credits='$newcoins', vip_points='$newpoints', activity_points='$newpixel' WHERE id='$myrow[id]'") or die(mysql_error());
                //mysql_query("INSERT INTO items(user_id, room_id, base_item) VALUES('$myrow[id]', '0', '$item[id]')") or die(mysql_error());
                sendMusCommand($server_ip, 'updatecredits', $my_id);
                sendMusCommand($server_ip, 'updatepixels', $my_id);
                sendMusCommand($server_ip, 'updatepoints', $my_id);
                sendMusCommand($server_ip, 'giveitem', '' . $my_id . ' ' . $item['id'] . ' ' . $page['page_id'] . ' Aqui está seu carro 0km, divirta-se!');
                echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce recebeu um presente da nossa Loja, confira seu inventario!")</SCRIPT>';
            }
        }
    }
}

if (isset($_GET['buy'])) {
    $newpoints = $myrow['vip_points'] - 5000;
    if ($newpoints < 0) {
        echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce nao possui rubis suficientes para comprar o carro")</SCRIPT>';
    } else {
        $car1 = "50234";
        $car2 = "50235";
        $car3 = "50236";
        $car4 = "50237";
        $car5 = "50238";
        $car6 = "50239";
        $cars_page = "10018";
        mysql_query("UPDATE users SET vip_points='" . $newpoints . "' WHERE id='" . $my_id . "'") or die(mysql_error());
        sendMusCommand('127.0.0.1', 'updatepoints', $my_id);
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car1 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car2 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car3 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car4 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car5 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        sendMusCommand('127.0.0.1', 'giveitem', '' . $my_id . ' ' . $car6 . ' ' . $cars_page . ' Aqui está seu carro 0km, divirta-se!');
        echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce recebeu um presente da nossa Loja, confira seu inventario!")</SCRIPT>';
    }
}

$my_rowsql = mysql_query("SELECT * FROM users WHERE id='" . $myrow['id'] . "'") or die(mysql_error());
$my_row = mysql_fetch_array($my_rowsql);
?>
<div id="wrap-content">
    <div id="meio">
        <div style="float:left; width:200px;">
            <?php
            require_once('./templates/menu.php');
            ?>
        </div>
        <div style="margin-left:210px; width:670px; min-height:300px; margin-top:10px;">
            <?php
            $classe = FilterText($_GET['class']);
            $consulta = mysql_query("SELECT * FROM catalog_cars WHERE class='" . $classe . "' AND activated='1'") or die(mysql_error());
            if (mysql_num_rows($consulta) > 0) {
                while ($array = mysql_fetch_array($consulta)) {
                    echo "<table style='margin-left:0px; margin-bottom:30px;'>";
                    //echo "<tr>";
                    //echo "<td colspan='2' style='text-align:center; font-size:16px; padding-bottom:10px;'><b>" . $array['name'] . "</b></td>";
                    //echo "</tr>";
                    echo "<tr>";
                    echo "<td style='padding-right:20px;'>" . $array['cost_points'] . " Rubis<br /><br />";
                    echo "<a href='index.php?class=" . $classe . "&car_id=" . $array['id'] . "'>Comprar</a></td>";
                    echo "<td colspan='1'><img src='" . $array['img_url'] . "' alt='' /></td>";
                    echo "</tr>";
                    echo "</table>";
                }
                echo "<br />";
            } else {
                echo "Escolha uma classe existente.";
            }
            ?>
            <center>
                <span style="font-size:18px; font-weight:bold;">Comprar Pacote Completo</span><br /><br />
                Pacote com todos os carros D-Spec e um exclusivo GTR Stock car de presente<br /><br />
                <b>Pre&ccedil;o:</b> 5000 rubis<br /><br />
                <a href="dspec-pack.php?class=p&buy=pack"><img src="http://www.factoryhotel.com.br/web-gallery/cars/dspec-pack.png" alt="" /></a>
            </center>
        </div>
    </div>
</div>
<?php
require_once('./templates/rodape.php');
?>