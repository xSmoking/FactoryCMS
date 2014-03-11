<style>
    #badgeButton2 {
        height: 32px;
        line-height: 32px;
        font-family: Arial !important;
        font-size: 12px;
        font-weight: bold;
        margin: 0px 0 0 0;
        background-position: center;
        color: #cbe1e8;
        border-radius: 2px;
        cursor: pointer;
        width: 80px;
        margin-right: -31px;
        text-shadow: .18em .18em 0 rgba(0,0,0,.1);
        box-shadow: inset 0 0 3px 3px rgba(0,0,0,.05);
        border: 2px solid #357e99;
        background: rgba(42,102,121,.5);
        margin-left: -25px;
    }
    #saveButton {
        height: 32px;
        line-height: 32px;
        font-family: Arial !important;
        font-size: 12px;
        font-weight: bold;
        margin: 0px 0 0 0;
        background-position: center;
        color: #cbe1e8;
        border-radius: 2px;
        cursor: pointer;
        width: 80px;
        margin-right: -31px;
        text-shadow: .18em .18em 0 rgba(0,0,0,.1);
        box-shadow: inset 0 0 3px 3px rgba(0,0,0,.05);
        background-color: #00753f;
        border: 2px solid #79c151;
        margin-left: -25px;
    }

    .error {
        padding: 7px;
        background-color: #fff4f2;
        border: 1px solid #a63c29;
        color: #E2001A;
        margin-top: 5px;
    }

    .error > h3 {
        font-weight: bold;
        margin: 0px;
        padding: 0px;
        font-size: 13px;
    }
    div.goodmsg {
        padding: 7px;
        background-color: #d8f3d8;
        border: 1px solid #4da04d;
        color: #205220;
        margin-top: 5px;
    }

    div.goodmsg > h3 {
        font-weight: bold;
        margin: 0px;
        padding: 0px;
        font-size: 13px;
    }
    div.display_none {
        display: none;
    }
</style>

<?php {
    if (isset($_GET['buy']) && isset($_GET['id'])) {
        $badgeId = FilterText($_GET['id']);
        $userquery = mysql_query("SELECT * FROM users WHERE username = '" . $name . "'") or die(mysql_error());
        $query = mysql_fetch_assoc($userquery);
        $idpricequery = mysql_query("SELECT * FROM badgeshop WHERE id = '" . $badgeId . "'") or die(mysql_error());
        $idprice = mysql_fetch_assoc($idpricequery);
        $hasBadge = mysql_query("SELECT * FROM user_badges WHERE user_id='" . $idutente . "' AND badge_id='" . $idprice['name'] . "'") or die(mysql_error());
        if (mysql_num_rows($idpricequery) > 0){
            if ($punti < $idprice['price']) {
                echo "<center><strong>Você não possui Conchas suficientes :/</strong></center>";
            } elseif (mysql_num_rows($hasBadge) > 0) {
                echo "<center><strong>Você já possui esse emblema!</strong></center>";
            } else {
                echo "<center><strong>Emblema comprado com sucesso!</strong></center>";
                $sql = mysql_fetch_array(mysql_query("SELECT * FROM badgeshop WHERE id = '{$badgeId}'"));
                $id = $query['id'];
                $names = $sql['name'];
                mysql_query("INSERT INTO user_badges (user_id, badge_id) VALUES ('" . $idutente . "', '{$names}')");
                mysql_query("UPDATE users SET vip_points = vip_points - '" . $idprice['price'] . "' WHERE id = '" . $idutente . "'");
                mysql_query("UPDATE badgeshop SET buy = buy + '1' WHERE id = '{$badgeId}'");
                mysql_query("INSERT INTO cms_transactions (userid,amount,date,descr) VALUES ('" . $idutente . "',-'" . $idprice['price'] . "','" . $date_full . "','Purchased badge.')");
            }
        }else{
            echo "<center><strong>Este emblema nao está a venda!</strong></center>";
        }
    }
    if (isset($_GET['add']) and $rank >= 7) {

        if ($_GET['id']) {
            $query = mysql_query("SELECT * FROM `badgeshop` WHERE id = '{$badgeId}'");
            $array = mysql_fetch_assoc($query);
        }

        if ($_POST['submit']) {
            $rare_name = $_POST['name'];
            $rare_imgurl = $_POST['rare_imgurl'];
            $rare_price = $_POST['rare_price'];

            if ($_GET['id']) {
                echo "<center><strong>Badge has been updated!</strong></center>";
                mysql_query("UPDATE `badgeshop` SET name = '{$rare_name}', image = '{$rare_imgurl}', price = '{$rare_price}' WHERE id = '{$badgeId}' ");
            } else {
                echo "<center><strong>Badge has been added!</strong></center>";
                mysql_query("INSERT INTO `badgeshop` ( name, image, price ) VALUES ( '{$rare_name}', '{$rare_imgurl}', '{$rare_price}' )");
            }

            echo "<meta http-equiv=\"refresh\" content=\"3;url=/badge\" />";
        } else {
            echo "<div>";
            echo "<form method=\"post\">";

            echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"5\">";
            echo "<tr>";
            echo "<td style=\"width: 25%; text-align: right;\"><label for=\"rare_imgurl\">Emblema</label></td>";
            echo "<td style=\"padding: 0 0 0 10px;\"><input type=\"text\" name=\"rare_imgurl\" size=\"50\" value=\"{$array['image']}\"></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td style=\"width: 25%; text-align: right;\"><label for=\"rare_name\">Código</label></td>";
            echo "<td style=\"padding: 0 0 0 10px;\"><input type=\"text\" name=\"rare_name\" size=\"50\" value=\"{$array['name']}\"></td>";
            echo "</tr>";
            echo "</tr>";
            echo "<tr>";
            echo "<td style=\"width: 25%; text-align: right;\"><label for=\"rare_price\">Preço</label></td>";
            echo "<td style=\"padding: 0 0 0 10px;\"><input type=\"text\" name=\"rare_price\" size=\"50\" value=\"{$array['price']}\"></td>";
            echo "</tr>";
            echo "</table>";

            echo "<div class=\"settings-buttons\">";
            echo "<input type=\"submit\" value=\"Submit\" name=\"submit\" class=\"submit\" style=\"float: right;\">";
            echo "</div>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        $query = mysql_query("SELECT * FROM `badgeshop`");
        $j = "a";

        echo "<table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"5\">";

        echo "<tr align=\"center\" style=\"font-weight: bold;\">";
        echo "<td>Emblema</td>";
        echo "<td>Código</td>";
        echo "<td>Preço</td>";
        if ($rank >= 7) {
            echo "<td>Opções</td>";
        }
        echo "</tr>";

        while ($array = mysql_fetch_assoc($query)) {
            $credits = $array['price'];
            if ($credits > 1) {
                $credits = $array['price'] . " Conchas";
            } else {
                $credits = $array['price'] . " Conchas";
            }
            echo "<tr align=\"center\" id=\"rare-{$array['id']}\" class=\"rare {$j}\">";
            echo "<td><img src=\"{$array['image']}\" /></td>";
            echo "<td>{$array['name']}</td>";
            echo "<td>";
            echo $credits;
            echo "<br />";
            echo "";
            echo "</td>";

            echo"<td>";
            $gg = mysql_fetch_assoc(mysql_query("SELECT * FROM `badgeshop` WHERE id = '{$array['id']}'"));
            $idk = mysql_num_rows(mysql_query("SELECT * FROM user_badges WHERE badge_id = '" . $gg['name'] . "' AND user_id = '" . $idutente . "'"));
            if ($idk > 0) {
//echo"<b>Badge Purchased</b>";
                echo"<div id=\"badgeButton2\">Comprar</div>";
            } else {
                echo"<a href=\"badge?buy&id={$array['id']}\" style=\"color:white;text-decoration:none;\"><div id=\"saveButton\">Comprar</div></a>";
            }
            echo"</td>";
            echo "</tr>";

            $j++;
            if ($j == "c") {
                $j = "a";
            }
        }

        echo "</table>";
    }
}