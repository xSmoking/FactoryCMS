<?php
$pagename = "Adicionar Banimento";
include_once("./template/header.php");

if (isset($_POST['addban'])) {
    $value = FilterText($_POST['value']);
    $reason = FilterText($_POST['reason']);
    $expire = FilterText($_POST['expire']);
    $expire_full = time() + $expire;
    $bantype = FilterText($_POST['bantype']);

    $ban_exist = $connect->query("SELECT * FROM bans WHERE value='" . $value . "'") or die($connect->error());
    if ((!$value) || (!$reason) || (!$expire) || (!$bantype)) {
        echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
    } elseif ($ban_exist->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Erro: este usuário já está banido.');</script>";
    } else {
        $connect->query("INSERT INTO bans(bantype, value, reason, expire, added_by, added_date) VALUES('" . $bantype . "', '" . $value . "', '" . $reason . "', '" . $expire_full . "', '" . $myrow['username'] . "', '" . $date_full . "')") or die($connect->error());
        echo "<script type='text/javascript'>alert('Banimento adicionado!');</script>";
        sendMusCommand($server_ip, 'reloadbans');
    }
}
?>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Banir Usuário</div>
                <form action="bans_add.php" method="post">
                    <div class="form-group">
                        Tipo de Banimento
                        <select id="bantype" class="form-control" name="bantype">
                            <option value="user">user</option>
                            <option value="ip">ip</option>
                        </select>
                    </div>
                    <div class="form-group">
                        Usuário / IP
                        <input class="form-control" type="text" name="value" id="value" size="30" />
                    </div>
                    <div class="form-group">
                        Motivo
                        <input class="form-control" type="text" name="reason" id="reason" size="50" />
                    </div>
                    <div class="form-group">
                    Expira em
                    <select class="form-control" name="expire">
                        <option value="7200">2 horas</option>
                        <option value="14400">4 horas</option>
                        <option value="86400">1 dia</option>
                        <option value="172800">2 dias</option>
                        <option value="604800">7 dias</option>
                        <option value="1296000">15 dias</option>
                        <option value="2629743">1 mês</option>
                        <option value="7889231">3 meses</option>
                        <option value="15778463">6 meses</option>
                        <option value="31556926">1 ano</option>
                        <option value="315569260">10 anos</option>
                    </select>
                    </div>
                    <button type="submit" name="addban" class="btn btn-primary">Banir</button>
                    <a class="btn btn-danger" style="color:#fff; float:right;" href="javascript:history.back(1);">Cancelar</a>
                </form>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
</body>
</html>