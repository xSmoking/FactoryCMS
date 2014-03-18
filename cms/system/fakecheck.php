<?php
include_once("./template/header.php");
$pagename = "Checar Fake";
?>
<title><?php echo $sitename . " - " . $pagename; ?></title>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Checar Contas Falsas</div>
        <?php
        if (isset($_POST['check'])) {
            $type = FilterText($_POST['type']);
            $value = FilterText($_POST['value']);

            if ((!$type) || (!$value)) {
                echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
            } else {
                echo '<table style="width:100%; font-size:13px;">';
                echo '
                    <tr style="font-weight:bold;">
                        <td>Usuário</td>
                        <td>Último IP</td>
                        <td>IP de Registro</td>
                        <td>Moedas</td>
                        <td>Píxels</td>
                        <td>Online</td>
                    </tr>
                ';
                if ($type == "ip") {
                    $user_exist = $connect->query("SELECT * FROM users WHERE ip_last='" . $value . "' OR ip_reg='" . $value . "'") or die($connect->error());
                    if ($user_exist->num_rows > 0) {
                        while ($info = $user_exist->fetch_assoc()) {
                            if ($info['rank'] == 7) {
                                $ip_last = "IP não pode ser exibido";
                            } else {
                                $ip_last = $info['ip_last'];
                            }
                            if ($info['rank'] == 7) {
                                $ip_reg = "IP não pode ser exibido";
                            } else {
                                $ip_reg = $info['ip_reg'];
                            }
                            echo '
                                <tr>
                                    <td>' . $info['username'] . '</td>
                                    <td>' . $ip_last . '</td>
                                    <td>' . $ip_reg . '</td>
                                    <td>' . $info['credits'] . '</td>
                                    <td>' . $info['activity_points'] . '</td>
                                    <td>' . $info['online'] . '</td>
                                </tr>
                            ';
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Erro: não existe nenhum usuário com este IP.');</script>";
                    }
                } elseif ($type == "user") {
                    $user_exist = $connect->query("SELECT * FROM users WHERE username='" . $value . "'") or die($connect->error());
                    if ($user_exist->num_rows > 0) {
                        $user_info = $user_exist->fetch_assoc();
                        $ip_search = $connect->query("SELECT * FROM users WHERE ip_last='" . $user_info['ip_reg'] . "' OR ip_reg='" . $user_info['ip_reg'] . "'") or die($connect->error());
                        while ($info = $ip_search->fetch_assoc()) {
                            if ($info['rank'] == 7) {
                                $ip_last = "IP não pode ser exibido";
                            } else {
                                $ip_last = $info['ip_last'];
                            }
                            if ($info['rank'] == 7) {
                                $ip_reg = "IP não pode ser exibido";
                            } else {
                                $ip_reg = $info['ip_reg'];
                            }
                            echo '
                                <tr>
                                    <td>' . $info['username'] . '</td>
                                    <td>' . $ip_last . '</td>
                                    <td>' . $ip_reg . '</td>
                                    <td>' . $info['credits'] . '</td>
                                    <td>' . $info['activity_points'] . '</td>
                                    <td>' . $info['online'] . '</td>
                                </tr>
                            ';
                        }
                    }
                }
                echo '</table>';
            }
        } else {
            ?>
            <form action="" method="post">
                <div class="form-group">
                    Buscar
                    <select class="form-control" name="type">
                        <option value="user">Usuário</option>
                        <option value="ip">IP</option>
                    </select>
                </div>
                <div class="form-group">
                    Usuário / IP
                    <input class="form-control" type="text" name="value" size="30" />
                </div>
                <button type="submit" name="check" class="btn btn-primary">Buscar</button>
                <a class="btn btn-danger" style="color:#fff; float:right;" href="javascript:history.back(1);">Cancelar</a>
            </form>
    <?php
}
?>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>