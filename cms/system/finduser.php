<?php
include_once("./template/header.php");
$user = FilterText($_GET['user']);
$pagename = "Buscar Usuário - " . $user;

if($_POST['action'] != "updaterank"){
    echo '<style type="text/css">#box-rankchanged{display:none;}</style>';
}
?>
        <title><?php echo $sitename . " - " . $pagename; ?></title>
        <div id="wrap-main">
            <div id="big-box">
                <ul class="nav nav-pills" style="float:right; margin:-5px 10px 0 0;">
                    <li><a data-toggle="tooltip" title="Gerar nova senha" href="finduser.php?user=<?php echo $user; ?>&ac=changepass"><img src="./web-files/images/pass.png" /></a></li>
                    <li><a data-toggle="tooltip" title="Alterar Cargo" id="open-box-changerank" href="#"><img src="./web-files/images/rank.png" /></a></li>
                </ul> <!-- /pills -->
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">
                    Buscar Usuário - <?php echo $user; ?>
                </div>
                
                <div id="box-rankchanged">
                    <center>
                        <div class="form-group">
                        <?php
                        if($_POST['action'] == "updaterank"){
                            $rankId = FilterText($_POST['rankid']);
                            $rankVerify = mysql_query("SELECT * FROM ranks WHERE id='". $rankId ."'") or die(mysql_error());
                            $userQuery = mysql_query("SELECT * FROM users WHERE username='". $user ."'") or die(mysql_error());
                            $userInfo = mysql_fetch_assoc($userQuery);
                            if(mysql_num_rows($rankVerify) > 0){
                                if((!$rankId)){
                                    echo "Por favor, selecione um cargo";
                                }elseif($myrow['rank'] < 7){
                                    echo "Você não possui permissão para alterar cargos";
                                }elseif($my_id == $userInfo['id']){
                                    echo "Você não pode alterar seu próprio cargo";
                                }else{
                                    mysql_query("UPDATE users SET rank='". $rankId ."' WHERE id='". $userInfo['id'] ."'") or die(mysql_error());
                                    echo "Cargo de ". $user ." atualizado com sucesso!";
                                }
                            }else{
                                echo "O ID deste cargo não existe!<br />Por favor, selecione um existente";
                            }
                        }
                        ?>
                        </div>
                        <button id="close-box-rankchanged" class="btn btn-danger">Fechar</button>
                    </center>
                </div>
                
                <?php
                $usercheck = mysql_query("SELECT * FROM users WHERE username='" . $user . "' LIMIT 1") or die(mysql_error());
                if (mysql_num_rows($usercheck) > 0) {
                    $userinfo = mysql_fetch_assoc($usercheck);
                    if ($userinfo['rank'] >= $myrow['rank']) {
                        $ip_last = "IP não pode ser exibido";
                    } else {
                        $ip_last = $userinfo['ip_last'];
                    }
                    if ($userinfo['rank'] >= $myrow['rank']) {
                        $ip_reg = "IP não pode ser exibido";
                    } else {
                        $ip_reg = $userinfo['ip_reg'];
                    }
                    ?>
                    
                    <div id="box-changerank">
                        <center>
                        <form action="?user=<?php echo $user; ?>" method="post">
                            <div class="form-group">
                                <label for="rank">Selecione um Cargo</label>
                                <select id="rank" name="rankid" class="form-control">
                                    <option value="" disabled selected>Selecione um cargo</option>
                                    <?php
                                    $ranks = mysql_query("SELECT * FROM ranks ORDER BY id") or die(mysql_error());
                                    while($rank = mysql_fetch_assoc($ranks)){
                                        echo '<option value="'. $rank['id'] .'">'. $rank['name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="action" value="updaterank" />
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button id="close-box-changerank" class="btn btn-danger">Cancelar</button>
                        </form>
                        </center>
                    </div>
                
                    <?php
                    if($_GET['ac'] == "changepass"){
                        $novaSenha = geraSenha();
                        $user = FilterText($_GET['user']);
                        $senhaCripto = HoloHashMD5($novaSenha);

                        echo '
                            <div id="box-changepass">
                                <center>
                                <div class="form-group">
                        ';
                                if($myrow['rank'] < 7){
                                    echo 'Você não possui permissão para alterar senhas';
                                }else{
                                    mysql_query("UPDATE users SET password='". $senhaCripto ."' WHERE username='". $user ."'") or die(mysql_error());
                                    echo '<b>Nova Senha</b><br />'. $novaSenha .'<br />';
                                }
                        echo '
                                </div>
                                <button id="close-box-changepass" class="btn btn-danger">Fechar</button>
                                </center>
                            </div>
                        ';
                    }
                    ?>

                    <table class="table table-responsive table-striped" style="width:100%; font-size:13px;">
                        <tr>
                            <td width="50%">Usuário</td>
                            <td width="50%"><?php echo $userinfo['username']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">E-mail</td>
                            <td width="50%"><?php echo $userinfo['mail']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Senha</td>
                            <td width="50%">**********</td>
                        </tr>
                        <tr>
                            <td width="50%">Aniversário</td>
                            <td width="50%"><?php echo $userinfo['birthday']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Sexo</td>
                            <td width="50%">
                                <?php
                                if ($userinfo['gender'] == "M") {
                                    echo "Masculino";
                                } else {
                                    echo "Feminino";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Missão</td>
                            <td width="50%"><?php echo $userinfo['motto']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Cargo</td>
                            <td width="50%"><?php echo $userinfo['rank']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Moedas</td>
                            <td width="50%"><?php echo $userinfo['credits']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Pixels</td>
                            <td width="50%"><?php echo $userinfo['activity_points']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Rubis</td>
                            <td width="50%"><?php echo $userinfo['vip_points']; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Online</td>
                            <td width="50%">
                                <?php
                                if ($userinfo['online'] == "1") {
                                    echo "Sim";
                                } else {
                                    echo "Não";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Último IP</td>
                            <td width="50%"><?php echo $ip_last ?></td>
                        </tr>
                        <tr>
                            <td width="50%">IP de Registro</td>
                            <td width="50%"><?php echo $ip_reg; ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Último Login</td>
                            <td width="50%"><?php echo date("d/m/Y H:i:s", $userinfo['last_online']); ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Registrado em</td>
                            <td width="50%"><?php echo date("d/m/Y H:i:s", $userinfo['account_created']); ?></td>
                        </tr>
                        <tr>
                            <td width="50%">Usuário VIP</td>
                            <td width="50%">
                                <?php
                                if ($userinfo['vip'] == "1") {
                                    echo "Sim";
                                } else {
                                    echo "Não";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">Visual</td>
                            <td width="50%"><?php echo $userinfo['look'] ?></td>
                        </tr>
                    </table>
                    <div style="margin-top:10px; font-size:18px;">Emblemas</div>
                    <span style="font-size:11px;">(passa o mouse para ver o código)</span><br /><br />
                    <?php
                    $badges = mysql_query("SELECT * FROM user_badges WHERE user_id='" . $userinfo['id'] . "'") or die(mysql_error());
                    while ($badge = mysql_fetch_assoc($badges)) {
                        ?>
                    <a data-toggle="tooltip" title="<?php echo $badge['badge_id']; ?>"><img style="margin-right:10px;" src="<?php echo $swf_patch; ?>/c_images/album1584/<?php echo $badge['badge_id']; ?>.gif" alt="<?php echo $badge['badge_id']; ?>" /> </a>
                <?php
            }
        } else {
            echo "<script type='text/javascript'>alert('Este usuário não existe.');</script>";
            header("Location: " . $adminpath);
        }
        ?>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
        
        <script type="text/javascript">
        $(document).ready(function(){
            $('#box-changerank').hide();
            $('#open-box-changerank').click(function(event){
                event.preventDefault();
                $("#box-changerank").show("slow");
            });
            $('#close-box-changerank').click(function(event){
                event.preventDefault();
                $("#box-changerank").hide("slow");
            });
            
            $('#box-changepass').show();
            $('#close-box-changepass').click(function(event){
                event.preventDefault();
                $("#box-changepass").hide("slow");
            });
            
            $('#close-box-rankchanged').click(function(event){
                event.preventDefault();
                $("#box-rankchanged").hide("slow");
            });
        });
        </script>
</body>
</html>