<?php
include_once("./templates/cms_header.php");

$group_id = FilterText($_GET['id']);

if (isset($_GET['id']) AND isset($_GET['request']) AND isset($_GET['userid'])) {
    $group = FilterText($_GET['id']);
    $type = FilterText($_GET['request']);
    $userid = FilterText($_GET['userid']);

    if ($type == "accept") {
        mysql_query("INSERT INTO group_memberships(groupid, userid, rank) VALUES('" . $group . "', '" . $userid . "', '1')") or die(mysql_error());
        mysql_query("DELETE FROM group_requests WHERE groupid='" . $group . "' AND userid='" . $userid . "'") or die(mysql_error());
    } elseif ($type == "recuse") {
        mysql_query("DELETE FROM group_requests WHERE groupid='" . $group . "' AND userid='" . $userid . "'") or die(mysql_error());
    }
}

if ($_POST['action'] == "group_edit") {
    $desc = FilterText($_POST['desc']);
    $roomid = FilterText($_POST['roomid']);
    $locked = FilterText($_POST['locked']);

    $groupcheck = mysql_query("SELECT * FROM groups WHERE id='" . $group_id . "' AND ownerid='" . $my_id . "'") or die(mysql_erro());
    $roomcheck = mysql_query("SELECT * FROM rooms WHERE id='" . $roomid . "'") or die(mysql_erro());
    $roominfo = mysql_fetch_array($roomcheck);

    if ((!$desc) || (!$locked) || (!$roomid)) {
        $msg_echo = "Erro: preencha todos os campos.";
    } else {
        if (strlen($desc) > 250) {
            echo "<script type='text/javascript'>alert('Descrição muito comprida.');</script>";
        } elseif (mysql_num_rows($roomcheck) < 1) {
            echo "<script type='text/javascript'>alert('Este quarto n&atilde;o existe.');</script>";
        } elseif ($roominfo['owner'] != $myrow['username']) {
            echo "<script type='text/javascript'>alert('Este quarto não é seu.');</script>";
        } elseif (mysql_num_rows($groupcheck) < 1) {
            echo "<script type='text/javascript'>alert('Você não tem permissão para editar este grupo.');</script>";
        } else {
            mysql_query("UPDATE groups SET `desc`='" . $desc . "', `roomid`='" . $roomid . "', `locked`='" . $locked . "' WHERE id='" . $group_id . "'") or die(mysql_error());
            sendMusCommand($server_ip, 'updategroup', $groupid);
        }
    }
}

$group_check = mysql_query("SELECT * FROM groups WHERE id='" . $group_id . "' AND ownerid='". $my_id ."'") or die(mysql_error());
?>
<title><?php echo $sitename; ?> - Editar Grupo</title>
<section>
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <?php
                if (mysql_num_rows($group_check) > 0) {
                    $mygroup = mysql_fetch_assoc($group_check);
                    if ($_GET['request'] == "acceptall") {
                        $requests_select = mysql_query("SELECT * FROM group_requests WHERE groupid='" . $group_id . "'") or die(mysql_error());
                        while ($rinfo = mysql_fetch_assoc($requests_select)) {
                            mysql_query("INSERT INTO group_memberships(groupid, userid, rank) VALUES('" . $group_id . "', '" . $rinfo['userid'] . "', '1')") or die(mysql_error());
                            mysql_query("DELETE FROM group_requests WHERE groupid='" . $group_id . "' AND userid='" . $rinfo['userid'] . "'") or die(mysql_error());
                        }
                    } elseif ($_GET['request'] == "recuseall") {
                        mysql_query("DELETE FROM group_requests WHERE groupid='" . $group_id . "'") or die(mysql_error());
                    }
                    ?>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 boxkatrix">
                                <section class="panel">                   
                                    <div class="panel-body">
                                        <div class="clearfix m-b">
                                            <div id="group-favorite">
                                                <img data-group="<?php echo $group_id; ?>" src="./web-gallery/images/icon/<?php if($mystat['groupid'] == $group_id){ echo "favorite_active"; }else{ echo "favorite_desactive"; } ?>.png" id="group-badge" alt="Favorito" title="Marcar como favorito" />
                                            </div>
                                            <div style="font-size:16px; font-weight:bold;">Editar Grupo: <?php echo $mygroup['name']; ?></div>
                                        </div>
                                        <form action="" method="post">
                                            Nome<br />
                                            <input name="name" type="text" class="form-control" id="name" size="25" maxlength="50" value="<?php echo $mygroup['name']; ?>" disabled /><br />
                                            Descrição<br />
                                            <textarea name="desc" rows="4" class="form-control" cols="50"><?php echo $mygroup['desc']; ?></textarea><br />
                                            Quarto Principal<br />
                                            <select name="roomid" class="form-control">
                                                <?php
                                                $roomsql = mysql_query("SELECT * FROM rooms WHERE owner = '" . $myrow['username'] . "'") or die(mysql_error());
                                                while ($myroom = mysql_fetch_assoc($roomsql)) {
                                                    ?>
                                                    <option value="<?php echo $myroom['id']; ?>" <?php if ($myroom['id'] == $mygroup['roomid']) {
                                                echo 'selected="selected"';
                                            } ?>><?php echo $myroom['caption']; ?></option>';
                                                    <?php
                                                }
                                                ?>
                                            </select><br />
                                            Privacidade<br />
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="locked" value="open" <?php if ($mygroup['locked'] == "open") { echo 'checked="true"';} ?> />
                                                    <b>Aberto</b> - Todos podem entrar
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="locked" value="locked" <?php if ($mygroup['locked'] == "locked") { echo 'checked="true"';} ?> />
                                                    <b>Trancado</b> - Usu&aacute;rios devem pedir permiss&atilde;o
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="locked" value="closed" <?php if ($mygroup['locked'] == "closed") { echo 'checked="true"';} ?> />
                                                    <b>Fechado</b> - Ningu&eacute;m pode entrar
                                                </label>
                                            </div>
                                            <input type="hidden" name="action" value="group_edit" />
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                            <a href="javascript:history.back(1)" style="float:right;" class="btn btn-danger">Cancelar</a>
                                        </form>
                                    </div>
                                </section>
                            </div> 


                            <div class="col-lg-6 col-sm-6 boxkatrix">
                                <section class="panel">                   
                                    <div class="panel-body">
                                        <div class="clearfix m-b">
                                            <!--
                                            <div id="group-reload-badge">
                                                <img data-group="<?php echo $group_id; ?>" src="https://cdn4.iconfinder.com/data/icons/wirecons-free-vector-icons/32/refresh-16.png" id="group-reload-badge-btn" alt="Recarregar" title="Recarregar Emblema" />
                                            </div>
                                            -->
                                            <div style="font-size:16px; font-weight:bold;">Editar Emblema</div>
                                        </div>
                                        <center>
                                            <div id="badge-update">
                                                <img id="badge" src="<?php echo $cms_url; ?>/habbo-imaging/badge.php?badge=<?php echo $mygroup['badge']; ?>">
                                            </div>
                                        </center>
                                        <a href="#" onclick="badgeWindowOpen()" id="group-badge-edit-btn">EDITAR EMBLEMA</a><br />
                                    </div>
                                </section>
                            </div> 

                                <?php
                                if ($mygroup['locked'] == "locked") {
                                ?>
                                <div class="col-lg-6 col-sm-6 boxkatrix">
                                    <section class="panel">                   
                                        <div class="panel-body">
                                            <div class="clearfix m-b">
                                                <div style="font-size:16px; font-weight:bold;">Solicita&ccedil;&otilde;es</div>
                                                <a href="<?php echo $cms_url; ?>/groups_edit.php?id=<?php echo $group_id; ?>&request=acceptall">Aceitar Todas</a> | <a href="<?php echo $cms_url; ?>/groups_edit.php?id=<?php echo $group_id; ?>&request=recuseall">Recusar Todas</a>
                                            </div>
                                            <?php
                                            $request_sql = mysql_query("SELECT * FROM group_requests WHERE groupid='" . $mygroup['id'] . "' LIMIT 10") or die(mysql_query());
                                            if (mysql_num_rows($request_sql) > 0) {
                                                while ($request = mysql_fetch_array($request_sql)) {
                                                    $user_search = mysql_query("SELECT * FROM users WHERE id='" . $request['userid'] . "'") or die(mysql_error());
                                                    $user_asked = mysql_fetch_assoc($user_search);
                                                    ?>
                                                    <div id="group-request">
                                                        <a href="home.php?user=<?php echo $user_asked['username']; ?>"><b><?php echo $user_asked['username']; ?></b></a> pediu para entrar no grupo
                                                        <a href="<?php echo $cms_url; ?>/groups_edit.php?id=<?php echo $group_id; ?>&request=accept&userid=<?php echo $request['userid']; ?>" id="accept" title="Aceitar">V</a>
                                                        <a href="<?php echo $cms_url; ?>/groups_edit.php?id=<?php echo $group_id; ?>&request=recuse&userid=<?php echo $request['userid']; ?>" id="recuse" title="Recusar">X</a>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                echo "Este grupo n&atilde;o possui solicita&ccedil;&otilde;es";
                                            }
                                            ?>
                                        </div>
                                    </section>
                                </div>
                        <?php
                    }
                    ?>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '
                    <div class="col-lg-8">
                        <div id="row">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Erro!</div>
                                    </div>
                                    Este grupo n&atilde;o existe ou n&atilde;o pertence &agrave; voc&ecirc;.<br /><br />
                                    <a href="javascript:history.back(1)">&laquo; Voltar &agrave; p&aacute;gina anterior</a>
                                </div>
                            </section>
                        </div>
                    </div>
                    ';
                }
                ?>
                <div class="col-lg-4">
                    <section class="panel">
                        <h4 class="font-thin padder">Meus Grupos</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                            <?php
                            if (mysql_num_rows($groupsql) > 0) {
                                $mygroups = mysql_query("SELECT * FROM groups ORDER BY name") or die(mysql_error());
                                while ($mygroup = mysql_fetch_assoc($mygroups)) {
                                    $members3 = mysql_evaluate("SELECT COUNT(*) FROM group_memberships WHERE groupid = '" . $mygroup['id'] . "'") or die(mysql_error());
                                    $requests = mysql_query("SELECT * FROM group_requests WHERE groupid='" . $mygroup['id'] . "'") or die(mysql_error());
                            ?>
                                        <table style="<?php if($mygroup['id']%2 == 0){ echo 'background:#F8F8F8;'; }else{ echo 'background:#F4F4F4;'; } ?> width:100%;">
                                            <tr>
                                                <td><img style="margin:10px 10px 10px 10px;" src="<?php echo $cms_url; ?>/habbo-imaging/badge.php?badge=<?php echo $mygroup['badge']; ?>" align="left"></td>
                                                <td width="350px"><a href="<?php echo $cms_url; ?>/groups-<?php echo $mygroup['id']; ?>"><b><?php echo $mygroup['name']; ?></b></a><br /><?php echo $members3; ?> Membros - <?php echo mysql_num_rows($requests); ?> Solicita&ccedil;&otilde;es</td>
                                                <td><a href="<?php echo $cms_url; ?>/groupedit-<?php echo $mygroup['id']; ?>" id="groupedit">EDITAR</a></td>
                                            </tr>
                                        </table>
                            <?php
                                }
                            }else{ echo "Você não possui um grupo."; }
                            ?>
                            </li>
                        </ul>
                    </section>

                    <section class="panel text-center bg-inverse dker">
                        <div class="panel-body">
                            <h4 class="text-uc">JUNTE-SE SOCIALMENTE</h4>
                            <p>Quer ficar ligado das novidades do <?php echo $shortname; ?>?</p>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">redes sociais</small>
                            <p class="m-t-sm">
                                <a href="<?php echo $facebook; ?>" target="_blank" class="btn btn-rounded btn-facebook btn-icon" style="width: 120px;"><img src="./web-gallery/images/icon/facebook.png" style="margin-right:5px; padding-bottom:3px;" /> FACEBOOK</a>
                                <a href="<?php echo $twitter; ?>" target="_blank" class="btn btn-rounded btn-twitter btn-icon" style="width: 120px;"><img src="./web-gallery/images/icon/twitter.png" style="margin-right:5px;" /> TWITTER</a>
                            </p>
                        </div>
                    </section>
                </div>
            </div>          
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a>
</section>
<!-- /.vbox -->
</section>
<script src="./web-gallery/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./web-gallery/js/bootstrap.js"></script>
<!-- Sparkline Chart -->
<script src="./web-gallery/js/jquery.sparkline.min.js"></script>
<!-- App -->
<script type="text/javascript" src="./web-gallery/js/app.js"></script>
<script type="text/javascript" src="./web-gallery/js/app.plugin.js"></script>
<script type="text/javascript" src="./web-gallery/js/app.data.js"></script>  
<script type="text/javascript" src="./web-gallery/js/jquery.slimscroll.min.js"></script>  
<script type="text/javascript" src="./web-gallery/js/socket.io.js"></script>
<script type="text/javascript" src="./web-gallery/js/katrixweb.js"></script>

<script>
    function badgeWindowOpen() {
        BadgeWindow = window.open("<?php echo $cms_url; ?>/ajax/groups_badge_editor.php?id=<?php echo $group_id; ?>", "_blank", "width=310,height=400");
    }
    
    jQuery("#group-badge").on("click", function(){
        var $this = jQuery(this);
        $.ajax({
            url:"./ajax/groups_set_favorite.php?id="+ $this.data("group"),
            type:'GET',
            success:function(setfavorite){
                $("#group-favorite").html(setfavorite);
            }
        });
    });
    
    /*
    jQuery("#group-reload-badge-btn").on("click", function(){
        var $this = jQuery(this);
        $.ajax({
            url:"./ajax/groups_badge_reload.php?id="+ $this.data("group"),
            type:'GET';
            success:function(response){
                $("#badge-update").html(response);
            }
        });
    });
    */
</script>
</body>
</html>