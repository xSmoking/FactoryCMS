<?php
include_once("./templates/cms_header.php");

/* PROCESSA A COMPRA DE EMBLEMAS */
if ($_POST['action'] == "badge") {
    $marksql = mysql_query("SELECT * FROM cms_marktplatz WHERE image='" . FilterText($_POST['badge_id']) . "'") or die(mysql_error());
    $mark = mysql_fetch_array($marksql);
    if (mysql_num_rows($marksql) > 0) {
        $userhasbadge = mysql_query("SELECT * FROM user_badges WHERE user_id='$myrow[id]' AND badge_id='$mark[image]'") or die(mysql_error());
        $newcoins = $myrow['credits'] - $mark['credits'];
        $newpoints = $myrow['vip_points'] - $mark['vip_points'];
        if (mysql_num_rows($userhasbadge) > 0) {
            echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce ja possui este emblema!")</SCRIPT>';
        } elseif ($newpoints < 0 OR $newcoins < 0) {
            echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Voce nao possui pontos ou moedas suficientes para comprar o emblema")</SCRIPT>';
        } else {
            $newcoins = $myrow['credits'] - $mark['credits'];
            $newpoints = $myrow['vip_points'] - $mark['vip_points'];
            mysql_query("UPDATE users SET credits='$newcoins', vip_points='$newpoints' WHERE id='$myrow[id]'") or die(mysql_error());
            mysql_query("INSERT INTO user_badges(user_id, badge_id, badge_slot) VALUES('$myrow[id]', '$mark[image]', '0')") or die(mysql_error());
            sendMusCommand('127.0.0.1', 'updatecredits', $my_id);
            sendMusCommand('127.0.0.1', 'updatepoints', $my_id);
            echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("Emblema adquirido com sucesso!\nCaso não tenha recebido, reentre no Hotel.")</SCRIPT>';
        }
    } else {
        echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert("O emblema selecionado não está a venda!")</SCRIPT>';
    }
}
$usersql = mysql_query("SELECT * FROM users WHERE id = '" . $my_id . "' LIMIT 1") or die(mysql_error());
$myrow = mysql_fetch_assoc($usersql);
?>
<title><?php echo $sitename; ?> - Loja de Rubis</title>
<section id="content">
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
                                        <span style="font-size:16px;">Venda de Emblemas</span>
                                    </div>
                                    <?php
                                    if ($myrow['online'] == 1) {
                                        echo '<font color="red">Voc&ecirc; deve ficar offline para comprar emblemas!</font>';
                                    } else {
                                        $badgesql = mysql_query("SELECT * FROM cms_marktplatz WHERE activated='1' AND type='badge' AND min_rank <= '$myrow[rank]' ORDER BY id DESC") or die(mysql_error());
                                        if (mysql_num_rows($badgesql) > 0) {
                                            while ($badge = mysql_fetch_array($badgesql)) {
                                                ?>
                                                <form action="" method="post">
                                                    <table style="width:80%; margin-bottom:20px;">
                                                        <tr>
                                                            <td rowspan="4"><img style="margin-right:10px; margin-top:-5px;" src="<?php echo $swf_patch; ?>/c_images/album1584/<?php echo $badge['image']; ?>.gif" alt="<?php echo $badge['name']; ?>" /></td>
                                                            <td colspan="2" style="font-size:14px;"><?php echo '<b>' . $badge['name'] . '</b><br />' . $badge['description'] . '<br />'; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Rubis:</b> <?php echo $badge['vip_points']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Moedas:</b> <?php echo $badge['credits']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php if ($myrow[vip_points] < $badge['vip_points'] OR $myrow['credits'] < $badge['credits']) { ?>
                                                                    <span style="font-weight:bold; color:red;">Voc&ecirc; n&atilde;o possui pontos ou moedas suficiente</span>
                                                                <?php } else { ?>
                                                                    <input type="submit" id="submit" style="height:25px; width:90px;" value="Comprar" />
                                                                <?php } ?>
                                                            </td>
                                                            <td><input type="hidden" id="action" name="action" value="badge" /></td>
                                                            <td><input type="hidden" id="badge_id" name="badge_id" value="<?php echo $badge['image']; ?>" /></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                                <?php
                                            }
                                        } else {
                                            echo '<b>N&atilde;o possuimos emblemas dispon&iacute;veis &agrave; venda.</b>';
                                        }
                                    }
                                    ?>
                                </div>
                            </section>
                        </div>
						
			<div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Outras Opções</span>
                                    </div>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="<?php echo $cms_url; ?>/rooms" target="_blank">Comprar <b>Quartos</b></a></li>
                                        <li><a href="<?php echo $cms_url; ?>/bots" target="_blank">Comprar <b>BOTs</b></a></li>
                                        <li><a href="<?php echo $cms_url; ?>/cars" target="_blank">Comprar <b>Carros</b></a></li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="panel-body" onclick="hola()" style="cursor:pointer; border-radius: 4px 4px 0 0; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; background: url('<?php echo $cms_url; ?>/web-gallery/images/ima1.png');">
                            <div class="clearfix text-center m-t">
                                <div class="inline">
                                    <div class="easypiechart" data-percent="10" data-line-width="5" data-loop="false" data-bar-color="#92cf5c" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="150">
                                        <div class="thumb-lg">
                                            <img style="background:#666; padding-bottom:7px; padding:10px 30px; -webkit-border-radius: 200px; -moz-border-radius: 200px; border-radius: 200px;" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $myrow['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n" />
                                        </div>
                                    </div>
                                    <div class="h4 m-t m-b-xs" style=" color:#fff; text-shadow:1px 1px #000;"><?php echo $myrow['username']; ?></div>
                                </div>                      
                            </div>
                        </div>
                        <footer class="panel-footer bg-dark lter text-center">
                            <div class="row pull-out" style="color:#fff;">
                                <div class="col-xs-4" style="background:#ceb900;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['credits']; ?></span>
                                        <small>Moedas</small>
                                    </div>
                                </div>
                                <div class="col-xs-4" style="background:#0064c9;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['activity_points']; ?></span>
                                        <small>Píxels</small>
                                    </div>
                                </div>
                                <div class="col-xs-4" style="background:#9d00bc;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['vip_points']; ?></span>
                                        <small>Rubis</small>
                                    </div>
                                </div>
                            </div>
                        </footer>
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

                    <section class="panel bg-info lter no-borders" id="btnentraryad" onclick="hola2()" style="cursor: pointer;">
                        <div class="panel-body">
                            <div class="text-center padder m-t">
                                <span class="h3">
                                    <img src="./web-gallery/images/icon/cloud.png" style="margin-right:7px; padding-bottom:3px;" />
                                    Entrar no <?php echo $shortname; ?></span>
                            </div>
                        </div>
                        <footer class="panel-footer lt">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="text-muted block">Data/Hora - BR/DF</small>
                                    <span><?php echo $date_full; ?></span>
                                </div>
                                <div class="col-xs-4">
                                    <small class="text-muted block">Quartos Ativos</small>
                                    <span><?php echo $system['rooms_loaded'] ?></span>
                                </div>
                                <div class="col-xs-4">
                                    <small class="text-muted block">Usuários Online</small>
                                    <span><?php echo $system['users_online']; ?></span>
                                </div>
                            </div>
                        </footer>
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
<script src="./web-gallery/js/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="./web-gallery/js/socket.io.js"></script>
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
</script></body>
</html>