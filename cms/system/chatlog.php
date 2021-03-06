<?php
$pagename = "Chatlog";
include_once("./template/header.php");
?>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Buscar Registro de Conversa</div>
        <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
            <form action="" method="post">
                <table class="table table-condensed" style="font-size:13px;">
                    <tr>
                        <td>Tipo</td>
                        <td>
                            <select class="form-control" name="type">
                                <option value="user">Usuário</option>
                                <option value="room">Quarto</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Usuário ou ID do Quarto</td>
                        <td><input class="form-control" type="text" name="value" size="20" /></td>
                    </tr>
                    <tr>
                        <td>N° de Linhas</td>
                        <td><input class="form-control" type="text" name="rows" size="10" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="font-size:11px;">n° máximo: 1000</td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="chatlog" class="btn btn-primary">Procurar</button></td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
        if (isset($_POST['chatlog'])) {
            $tipo = FilterText($_POST['type']);
            $value = FilterText($_POST['value']);
            $rows = FilterText($_POST['rows']);

            if ((!$tipo) || (!$value) || (!$rows)) {
                echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
            } else {
                echo '
                          <table class="table table-striped" style="width:100%; font-size:13px;">
                            <thead>
                                <td style="text-align:center;">Quarto</td>
                                <td style="text-align:center;">Usuário</td>
                                <td style="text-align:center;">Data</td>
                                <td style="text-align:center;">Hora</td>
                                <td style="text-align:center;">Fala</td>
                            </thead>  
                        ';
                if ($tipo == "user") {
                    $verify_user = $connect->query("SELECT * FROM users WHERE username='" . $value . "'") or die($connect->error());
                    if ($verify_user->num_rows > 0) {
                        $user_info = $verify_user->fetch_assoc();
                        $chatlogs = $connect->query("SELECT * FROM chatlogs WHERE user_id='" . $user_info['id'] . "' ORDER BY timestamp DESC LIMIT " . $rows . "") or die($connect->error());
                        while ($chatlog = $chatlogs->fetch_assoc()) {
                            if ($chatlog['room_id'] == 0) {
                                $room_id = "Console";
                            } else {
                                $room_id = $chatlog['room_id'];
                            }
                            echo '
                                      <tr>
                                        <td style="text-align:center;">' . $room_id . '</td>
                                        <td style="text-align:center;">' . $chatlog['user_name'] . '</td>
                                        <td style="text-align:center;">' . $chatlog['full_date'] . '</td>
                                        <td style="text-align:center;">' . $chatlog['hour'] . ':' . $chatlog['minute'] . '</td>
                                        <td style="text-align:center;">' . FilterText(utf8_decode($chatlog['message'])) . '</td>
                                      </tr>
                                    ';
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Erro: este usuário não existe.');</script>";
                    }
                } elseif ($tipo == "room") {
                    $verify_quarto = $connect->query("SELECT * FROM rooms WHERE id='" . $value . "'") or die($connect->error());
                    if ($verify_quarto->num_rows > 0) {
                        $chatlogs = $connect->query("SELECT * FROM chatlogs WHERE room_id='" . $value . "' ORDER BY timestamp DESC LIMIT " . $rows . "") or die($connect->error());
                        while ($chatlog = $chatlogs->fetch_assoc()) {
                            echo '
                                      <tr>
                                        <td style="text-align:center;">' . $chatlog['room_id'] . '</td>
                                        <td style="text-align:center;">' . $chatlog['user_name'] . '</td>
                                        <td style="text-align:center;">' . $chatlog['full_date'] . '</td>
                                        <td style="text-align:center;">' . $chatlog['hour'] . ':' . $chatlog['minute'] . '</td>
                                        <td style="text-align:center;">' . FilterText(utf8_decode($chatlog['message'])) . '</td>
                                      </tr>
                                    ';
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Erro: este quarto não existe.');</script>";
                    }
                }
                echo '</table>';
            }
        }
        ?>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>