<?php
include_once("./templates/cms_header.php");

if($user_rank <= 2){
    echo '<META http-equiv="refresh" content="0;URL=me"> ';
    exit;
}

/*
 * define o preço para criar grupos
 * aviso: NÃO insira sinais, ex: 10.000
 */
$cost_credits = 10000;
$cost_rubys = 500;
$cost_pixels = 0;

// Processa a compra do grupo
if ($_POST['action'] == "group_add") {
    $name = FilterText($_POST['name']);
    $desc = FilterText($_POST['desc']);
    $roomid = FilterText($_POST['roomid']);
    $locked = FilterText($_POST['locked']);
    $badge = "b0601Xs16114";

    $namecheck = mysql_query("SELECT * FROM groups WHERE name='". $name ."'") or die(mysql_erro());
    $groupcheck = mysql_query("SELECT * FROM groups WHERE ownerid='" . $my_id . "'") or die(mysql_erro());
    $roomusingcheck = mysql_query("SELECT * FROM groups WHERE roomid='" . $roomid . "'") or die(mysql_erro());
    $roomcheck = mysql_query("SELECT * FROM rooms WHERE id='". $roomid ."'") or die(mysql_erro());
    $roominfo = mysql_fetch_array($roomcheck);

    if ((!$name) || (!$desc) || (!$locked) || (!$roomid)) {
        echo "<script type='text/javascript'>alert('Preencha todos os campos.');</script>";
    } else {
        if (strlen($name) > 20) {
            echo "<script type='text/javascript'>alert('Nome muito comprido.');</script>";
        } elseif (strlen($desc) > 250) {
            echo "<script type='text/javascript'>alert('Descrição muito comprida.');</script>";
        } elseif (mysql_num_rows($roomcheck) < 1) {
            echo "<script type='text/javascript'>alert('Este quarto não existe.');</script>";
        } elseif ($roominfo['owner'] != $myrow['username']) {
            echo "<script type='text/javascript'>alert('Este quarto não é seu.');</script>";
        } elseif (mysql_num_rows($roomusingcheck) > 0) {
            echo "<script type='text/javascript'>alert('Este quarto já está sendo usado.');</script>";
        } elseif (mysql_num_rows($groupcheck) > 0 AND $myrow['rank'] < 2) {
            echo "<script type='text/javascript'>alert('Você já tem um grupo.');</script>";
        } elseif (mysql_num_rows($namecheck) > 0) {
            echo "<script type='text/javascript'>alert('Já existe um grupo com este nome.');</script>";
        } elseif ($myrow['credits'] < $cost_credits OR $myrow['vip_points'] < $cost_rubys OR $myrow['activity_points'] < $cost_pixels){
            echo "<script type='text/javascript'>alert('Você não possui moedas/rubis suficientes.');</script>";
        } else {
            $newcoins = $myrow['credits']-$cost_credits;
            $newrubis = $myrow['vip_points']-$cost_rubys;
            $newpixels = $myrow['activity_points']-$cost_pixels;
            mysql_query("UPDATE users SET credits='". $newcoins ."', vip_points='". $newrubis ."', activity_points='". $newpixels ."' WHERE id='". $my_id ."'") or die(mysql_error());
            mysql_query("INSERT INTO `groups`(`name`, `desc`, `badge`, `ownerid`, `created`, `roomid`, `locked`) VALUES('" . $name . "', '" . $desc . "', '" . $badge . "', '" . $my_id . "', '" . $date_full . "', '" . $roomid . "', '" . $locked . "')") or die(mysql_error());
            $groupsql = mysql_query("SELECT * FROM groups WHERE ownerid='" . $my_id . "' AND roomid='" . $roomid . "'") or die(mysql_error());
            $groupinfo = mysql_fetch_assoc($groupsql);
            mysql_query("INSERT INTO group_memberships(groupid, userid, rank) VALUES('" . $groupinfo['id'] . "', '" . $my_id . "', '3')") or die(mysql_error());
            echo "<script type='text/javascript'>alert('Grupo criado com sucesso!');</script>";
        }
    }
}
?>
<title><?php echo $sitename; ?> - Criar Grupo</title>
<section>
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Maiores Grupos</div>
                                    </div>
                                    <?php
                                    // Mostra grupos com mais membros
                                    
                                    $mgroups = mysql_query("SELECT * FROM groups ORDER BY (SELECT COUNT(*) FROM group_memberships WHERE groupid = groups.id) DESC LIMIT 5") or die(mysql_error());
                                    if (mysql_num_rows($mgroups) > 0) {
                                        while ($row = mysql_fetch_array($mgroups)) {
                                            $members1 = mysql_evaluate("SELECT COUNT(*) FROM group_memberships WHERE groupid = '" . $row['id'] . "'") or die(mysql_error());
                                            ?>
                                            <table style="<?php if($row['id']%2 == 0){ echo 'background:#F8F8F8;'; }else{ echo 'background:#F4F4F4;'; } ?> width:100%;">
                                                <tr>
                                                    <td><img style="margin:10px 10px 10px 10px;" src="<?php echo $cms_url; ?>/habbo-imaging/badge.php?badge=<?php echo $row['badge']; ?>" align="left"></td>
                                                    <td width="450px"><a href="<?php echo $cms_url; ?>/groups-<?php echo $row['id']; ?>"><b><?php echo $row['name']; ?></b></a><br /><?php echo $members1; ?> Membros</td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                    } else {
                                        echo "Não temos grupos criados.";
                                    }
                                    ?>
                                </div>
                            </section>
                        </div> 

                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Últimos Grupos Criados</div>
                                    </div>
                                    <?php
                                    // Mostra útlimos grupos criados
                                    
                                    $groups = mysql_query("SELECT * FROM groups ORDER BY id DESC") or die(mysql_error());
                                    if (mysql_num_rows($groups) > 0) {
                                        while ($row = mysql_fetch_array($groups)) {
                                            $members2 = mysql_evaluate("SELECT COUNT(*) FROM group_memberships WHERE groupid = '" . $row['id'] . "'") or die(mysql_error());
                                            ?>
                                            <table style="<?php if($row['id']%2 == 0){ echo 'background:#F8F8F8;'; }else{ echo 'background:#F4F4F4;'; } ?> width:100%;">
                                                <tr>
                                                    <td><img style="margin:10px 10px 10px 10px;" src="<?php echo $cms_url; ?>/habbo-imaging/badge.php?badge=<?php echo $row['badge']; ?>" align="left"></td>
                                                    <td width="450px"><a href="<?php echo $cms_url; ?>/groups-<?php echo $row['id']; ?>"><b><?php echo $row['name']; ?></b></a><br /><?php echo $members2; ?> Membros</td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                    } else {
                                        echo "Não temos grupos criados.";
                                    }
                                    ?>
                                </div>
                            </section>
                        </div> 
                    </div>

                    <div id="row">
                        <section class="panel">                   
                            <div class="panel-body">
                                <div class="clearfix m-b">
                                    <div style="font-size:16px; font-weight:bold;">O que são Grupos?</div>
                                </div>
                                Grupo é uma pequena comunidade dentro do Hotel com pessoas de mesmo pensamento/objetivo, cada grupo possui o <b>líder</b>, onde o mesmo pode editar as informações do próprio grupo, como <u>descrição</u>, <u>emblemas</u>, <u>cargos</u>, etc.<br />
                                Cada grupo possui um fórum para discutir temas e assuntos importantes ou não.<br />
                                O fórum possui 3 tipos de cargo, sendo eles: administrador, moderador e membro.
                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <h4 class="font-thin padder">
                            <?php
                            if (mysql_num_rows($groupsql) > 0) {
                                echo "Meus Grupos";
                            } else {
                                echo "Criar um Grupo";
                            }
                            ?>
                        </h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <?php
                                if (mysql_num_rows($groupsql) > 0) {
                                    $mygroups = mysql_query("SELECT * FROM groups WHERE ownerid='". $my_id ."' ORDER BY name") or die(mysql_error());
                                    while ($mygroup = mysql_fetch_assoc($mygroups)) {
                                        $members3 = mysql_evaluate("SELECT COUNT(*) FROM group_memberships WHERE groupid = '" . $mygroup['id'] . "'") or die(mysql_error());
                                        $requests = mysql_query("SELECT * FROM group_requests WHERE groupid='". $mygroup['id'] ."'") or die(mysql_error());
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
                                    if($myrow['rank'] > 1){
                                ?>
                                <div id="box-criarGrupo" style="margin-top:10px;">
                                    <div class="formGrupo">
                                        Preço: <?php echo $cost_credits." moedas + ".$cost_pixels." pixels + ".$cost_rubys." rubis"; ?><br /><br />
                                        <form action="" method="post">
                                            Nome<br />
                                            <input name="name" type="text" id="name" size="25" maxlength="50" /><br />
                                            Descrição<br />
                                            <textarea name="desc" rows="4" cols="60"></textarea><br />
                                            Quarto Principal<br />
                                            <select name="roomid">
                                                <?php
                                                $roomsql = mysql_query("SELECT * FROM rooms WHERE owner = '" . $myrow['username'] . "'") or die(mysql_error());
                                                while ($myroom = mysql_fetch_assoc($roomsql)) {
                                                    echo '<option value="' . $myroom['id'] . '">' . utf8_decode($myroom['caption']) . '</option>';
                                                }
                                                ?>
                                            </select><br />
                                            Privacidade<br />
                                            <label style="font-weight:normal;"><input type="radio" name="locked" value="open" checked="true" /> <b>Aberto</b> - Todos podem entrar</label><br />
                                            <label style="font-weight:normal;"><input type="radio" name="locked" value="locked" /> <b>Trancado</b> - Usuário devem pedir permissão</label><br />
                                            <label style="font-weight:normal;"><input type="radio" name="locked" value="closed" /> <b>Fechado</b> - Ninguém pode entrar</label><br />
                                            <input type="hidden" name="action" value="group_add" />
                                            <input type="submit" value="Criar Grupo" />
                                        </form>
                                    </div>
                                </div>
                                <?php
                                    }
                                } else {
                                    ?>
                                    Preço: 10000 Moedas + 500 Rubis<br /><br />
                                    <form action="" method="post">
                                        Nome<br />
                                        <input name="name" type="text" id="name" size="25" maxlength="50" /><br />
                                        Descrição<br />
                                        <textarea name="desc" rows="4" cols="60"></textarea><br />
                                        Quarto Principal<br />
                                        <select name="roomid">
                                            <?php
                                            $roomsql = mysql_query("SELECT * FROM rooms WHERE owner = '" . $myrow['username'] . "'") or die(mysql_error());
                                            while ($myroom = mysql_fetch_assoc($roomsql)) {
                                                echo '<option value="' . $myroom['id'] . '">' . $myroom['caption'] . '</option>';
                                            }
                                            ?>
                                        </select><br />
                                        Privacidade<br />
                                        <label style="font-weight:normal;"><input type="radio" name="locked" value="open" checked="true" /> <b>Aberto</b> - Todos podem entrar</label><br />
                                        <label style="font-weight:normal;"><input type="radio" name="locked" value="locked" /> <b>Trancado</b> - Usuário devem pedir permissão</label><br />
                                        <label style="font-weight:normal;"><input type="radio" name="locked" value="closed" /> <b>Fechado</b> - Ninguém pode entrar</label><br />
                                        <input type="hidden" name="action" value="group_add" />
                                        <input type="submit" value="Criar Grupo" />
                                    </form>
                                    <?php
                                }
                                ?>
                            </li>
                        </ul>
                    </section>

                    <section class="panel">
                        <h4 class="font-thin padder">Patrocinadores</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                            <center>
                                <script type="text/javascript"><!--
                                google_ad_client = "ca-pub-6896402047330257";
                                    /* Factory Index */
                                    google_ad_slot = "9934381233";
                                    google_ad_width = 468;
                                    google_ad_height = 60;
//-->
                                </script>
                                <script type="text/javascript"
                                        src="//pagead2.googlesyndication.com/pagead/show_ads.js">
                                </script>
                            </center>
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
<script src="./web-gallery/js/app.js"></script>
<script src="./web-gallery/js/app.plugin.js"></script>
<script src="./web-gallery/js/app.data.js"></script>  
<script src="./web-gallery/js/jquery.slimscroll.min.js"></script>  
<script src="./web-gallery/js/easypiechart/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="./web-gallery/js/socket.io.js"></script>
<script type="text/javascript">
    jQuery.fn.toggleText = function(a,b) {
        return   this.html(this.html().replace(new RegExp("("+a+"|"+b+")"),function(x){return(x==a)?b:a;}));
    }

    $(document).ready(function(){
        $('.formGrupo').before('<span style="cursor:pointer;">&raquo; Criar novo grupo</span>');
        $('.formGrupo').css('display', 'none')
        $('span', '#box-criarGrupo').click(function() {
            $(this).next().slideToggle('slow')
            .siblings('.formGrupo:visible').slideToggle('fast');
            // aqui começa o funcionamento do plugin
            $(this).toggleText('Criar novo grupo','Cancelar')
            .siblings('span').next('.formGrupo:visible').prev()
            .toggleText('Revelar','Esconder')
        });
    })
</script>

<script>
    function verma(qdi) {
        if ($('#' + qdi).css('display') == 'none') {
            $('#' + qdi).slideDown('slow');
            $('#l' + qdi).html('<i class="icon-sort-up"></i> Ver menos');
        } else {
            $('#' + qdi).slideUp('slow');
            $('#l' + qdi).html('<i class="icon-sort-down"></i> Ver mais');
        }
    }

    var mirocheckprofitimeou = null;
    var uspaprofcomurl = new Array();

    var pakie = '<?php echo $myrow['username']; ?>';
    var kekyooos = '<?php echo $myrow['username']; ?>';
</script>

<script src="./web-gallery/js/katrixweb.js"></script>
<script>
    function entrarya(kvez) {
        kvez++;
        if (document.getElementById('btnentrarya').className == "btn btn-info btn-block") {
            document.getElementById('btnentrarya').className = "btn btn-danger btn-block";
            document.getElementById('btnentraryad').className = "panel bg-danger lter no-borders";
            setTimeout("entrarya(" + kvez + ");", 500);
        } else {
            document.getElementById('btnentrarya').className = "btn btn-info btn-block";
            document.getElementById('btnentraryad').className = "panel bg-info lter no-borders";

            if (yahola == false) {
                setTimeout("entrarya(" + kvez + ");", 500);
            }
        }
    }

    function vesnex(kvez) {
        var nadaaa = 'na';
    }
</script>
</body>
</html>