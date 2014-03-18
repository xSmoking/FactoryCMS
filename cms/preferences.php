<?php
include_once("./templates/cms_header.php");
if (isset($_POST['save_settings'])) {
    //$visibility = FilterText($_POST['visibility']);
    $block_newfriends = FilterText($_POST['block_newfriends']);
    $hide_online = FilterText($_POST['hide_online']);
    $hide_inroom = FilterText($_POST['hide_inroom']);
    $accept_trading = FilterText($_POST['accept_trading']);
    $radio_autoplay = FilterText($_POST['radio_autoplay']);

    if ($block_newfriends == "true") {
        $block_newfriends = "0";
    } else {
        $block_newfriends = "1";
    }
    if ($hide_online == "true") {
        $hide_online = "0";
    } else {
        $hide_online = "1";
    }
    if ($hide_inroom == "true") {
        $hide_inroom = "0";
    } else {
        $hide_inroom = "1";
    }
    if ($accept_trading == "true") {
        $accept_trading = "1";
    } else {
        $accept_trading = "0";
    }
    if ($radio_autoplay == "true") {
        $radio_autoplay = "1";
    } else {
        $radio_autoplay = "0";
    }

    $connect->query("UPDATE users SET block_newfriends = '" . $block_newfriends . "', hide_online = '" . $hide_online . "', hide_inroom = '" . $hide_inroom . "', accept_trading = '" . $accept_trading . "', radio_autoplay = '" . $radio_autoplay . "' WHERE id = '" . $my_id . "'") or die($connect->error());
    $msg = "Preferências salvas com sucesso!";
}
$usersql = $connect->query("SELECT * FROM users WHERE username = '" . $myrow['username'] . "' LIMIT 1") or die($connect->error());
$myrow = $usersql->fetch_assoc();
?>
<title><?php echo $sitename; ?> - Preferências</title>
<style>
    div.tagsinput { border:1px solid #CCC; background: #FFF; padding:5px; width:300px; height:100px; overflow-y: auto;}
    div.tagsinput span.tag { border: 1px solid #a5d24a; -moz-border-radius:2px; -webkit-border-radius:2px; display: block; float: left; padding: 5px; text-decoration:none; background: #cde69c; color: #638421; margin-right: 5px; margin-bottom:5px;font-family: helvetica;  font-size:13px;}
    div.tagsinput span.tag a { font-weight: bold; color: #82ad2b; text-decoration:none; font-size: 11px;  } 
    div.tagsinput input { width:70px; height: 40px;margin:0px; font-family: helvetica; font-size: 13px; border:1px solid transparent; padding:5px; background: transparent; color: #000; outline:0px;  margin-right:5px; margin-bottom:5px; }
    div.tagsinput div { display:block; float: left; } 
    .tags_clear { clear: both; width: 100%; height: 0px; }
    .not_valid {background: #FBD8DB !important; color: #90111A !important;}
</style>
<form class="form-horizontal well" action="preferences.php" method="post">
    <legend>Editar preferências de <?php echo $myrow['username']; ?></legend>
    <div class="control-group">
        <!--
         <label class="control-label">Seu Perfil</label><br />
         Quem poderá ver seu perfil?
         <div class="controls">
             <label style="font-weight:normal;"><input name="visibility" type="radio" id="visibility" value="1" <?php if ($myrow['visibility'] == '1') {
    echo 'checked="checked"';
} ?> /> Amigos</label>
             <label style="font-weight:normal;"><input name="visibility" type="radio" id="visibility" value="2" <?php if ($myrow['visibility'] == '2') {
    echo 'checked="checked"';
} ?> style="margin-left:10px;" /> Todos</label>
             <label style="font-weight:normal;"><input name="visibility" type="radio" id="visibility" value="0" <?php if ($myrow['visibility'] == '0') {
    echo 'checked="checked"';
} ?> style="margin-left:10px;" /> Ninguém</label>
         </div>
        -->
    </div>
    <div class="control-group">
        <label class="control-label">Pedidos de amigo</label>
        <div class="radio">
            <label>
                <input name="block_newfriends" type="checkbox" id="block_newfriends" value="true" <?php if ($myrow['block_newfriends'] == '0') { echo 'checked="checked"'; } ?> />
                Permitir que me enviem solicitação de amizade
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Estado de Conexão</label>
        <div class="radio">
            <label>
                <input name="hide_online" type="checkbox" id="hide_online" value="true" <?php if ($myrow['hide_online'] == '0') { echo 'checked="checked"'; } ?> />
                Permitir que me vejam online
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Siga-me</label>
        <div class="radio">
            <label>
                <input name="hide_inroom" type="checkbox" id="hide_inroom" value="true" <?php if ($myrow['hide_inroom'] == '0') { echo 'checked="checked"'; } ?> />
                Permitir que me sigam no quarto em que eu estiver
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Negociar</label>
        <div class="radio">
            <label>
                <input name="accept_trading" type="checkbox" id="accept_trading" value="true" <?php if ($myrow['accept_trading'] == '0') { echo 'checked="checked"'; } ?> />
                Permitir que negoceiem comigo
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Rádio</label>
        <div class="radio">
            <label>
                <input name="radio_autoplay" type="checkbox" id="radio_autoplay" value="true" <?php if ($myrow['radio_autoplay'] == '0') { echo 'checked="checked"'; } ?> />
                Permitir que negoceiem comigo
            </label>
        </div>
    </div>
    <div class="control-group">
        <div class="controls" style="margin-top:20px;">
            <button type="submit" name="save_settings" class="btn btn-primary">Salvar Configurações</button>
            <a href="javascript:history.back(1)" style="margin-left:100px;" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
<?php
if (isset($msg)) {
    echo '<div style="margin-top:20px; background:#0086ed; padding:10px 20px; color:#fff;">' . $msg . '</div>';
}
?>
</form>
<script type="text/javascript" src="web-gallery/js/docs/jquery-1.8.0.js"></script>
<script src="web-gallery/js/bootstrap.js"></script></body>
</html>