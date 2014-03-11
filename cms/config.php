<?php
include_once("./templates/cms_header.php");
if ($_POST['action'] == "acc_config") {
    $mail = FilterText($_POST['mail']);
    $motto = FilterText($_POST['motto']);
    $pass1 = $_POST['password'];
    $pass1h = HoloHashMD5($_POST['password']);
    $pass2 = $_POST['newpass'];
    $pass2h = HoloHashMD5($_POST['newpass']);
    $valide = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $mail);

    if ((!$mail) || (!$motto) || (!$pass1)) {
        $msg_type = "danger";
        $msg = "Preencha os campos obrigatórias para salavar as configurações.";
    } else {
        if (strlen($motto) > 40 OR strlen($mail) > 50) {
            $msg_type = "danger";
            $msg = "Sua missão ou e-mail possui muitos caracteres.";
        } elseif ($pass1h != $myrow['password']) {
            $msg_type = "danger";
            $msg = "Sua senha atual está incorreta.";
        } elseif ($valide != true) {
            $msg_type = "danger";
            $msg = "Insira um e-mail válido.";
        } elseif (!empty($pass2)) {
            mysql_query("UPDATE users SET mail='" . $mail . "', motto='" . $motto . "', password='" . $pass2h . "' WHERE id='" . $my_id . "'") or die(mysql_error());
            $_SESSION['password'] = $pass2h;
            $msg_type = "success";
            $msg = "Configurações salvas com sucesso.";
        } else {
            mysql_query("UPDATE users SET mail='" . $mail . "', motto='" . $motto . "' WHERE id='" . $my_id . "'") or die(mysql_error());
            $msg_type = "success";
            $msg = "Configurações salvas com sucesso.";
        }
    }
}
$usersql = mysql_query("SELECT * FROM users WHERE username = '" . $myrow['username'] . "' LIMIT 1") or die(mysql_error());
$myrow = mysql_fetch_assoc($usersql);
?>
<title><?php echo $sitename; ?> - Configuração</title>
<style>
    div.tagsinput { border:1px solid #CCC; background: #FFF; padding:5px; width:300px; height:100px; overflow-y: auto;}
    div.tagsinput span.tag { border: 1px solid #a5d24a; -moz-border-radius:2px; -webkit-border-radius:2px; display: block; float: left; padding: 5px; text-decoration:none; background: #cde69c; color: #638421; margin-right: 5px; margin-bottom:5px;font-family: helvetica;  font-size:13px;}
    div.tagsinput span.tag a { font-weight: bold; color: #82ad2b; text-decoration:none; font-size: 11px;  } 
    div.tagsinput input { width:70px; height: 40px;margin:0px; font-family: helvetica; font-size: 13px; border:1px solid transparent; padding:5px; background: transparent; color: #000; outline:0px;  margin-right:5px; margin-bottom:5px; }
    div.tagsinput div { display:block; float: left; } 
    .tags_clear { clear: both; width: 100%; height: 0px; }
    .not_valid {background: #FBD8DB !important; color: #90111A !important;}
</style>
<form class="form-horizontal well" action="settings" method="post">
    <legend>Editar perfil de <?php echo $myrow['username']; ?></legend>
    <div class="control-group">
        <label class="control-label">* Email</label>
        <div class="controls">
            <input name="mail" class="form-control" type="mail" id="mail" size="40" value="<?php echo $myrow['mail']; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">* Missão</label>
        <div class="controls">
            <input name="motto" class="form-control" type="text" id="motto" size="40" maxlength="40" value="<?php echo $myrow['motto']; ?>" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">* Senha Atual</label>
        <div class="controls">
            <input name="password" class="form-control" type="password" id="password" />
        </div>
        <div style="border-bottom:solid 1px #ccc; margin:10px 0px;"></div>
    </div>
    <div class="control-group">
        <span style="color:red;">* não preencha caso não deseje alterar</span><br />
        <label class="control-label">Nova Senha</label>
        <div class="controls">
            <input name="newpass" class="form-control" type="password" id="newpass" /><br />
        </div>
    </div>
    <div class="control-group">
        <div class="controls" style="margin-top:20px;">
            <input type="hidden" name="action" value="acc_config" />
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="javascript:history.back(1)" style="float:right;" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
    <?php
    if(isset($msg)){
        echo '<div style="margin-top:20px;" class="alert alert-dismissable alert-'. $msg_type .'">'. $msg .'</div>';
    }
    ?>
</form>
<script type="text/javascript" src="web-gallery/js/docs/jquery-1.8.0.js"></script>
<script src="web-gallery/js/bootstrap.js"></script></body>
</html>