<?php
include_once("./templates/cms_header.php");

if ($myrow['vip'] == 1 && $date_normal2 !== $myrow['getmoney_date']) {
    mysql_query("UPDATE users SET getmoney_date = '" . $date_normal2 . "' WHERE id = '" . $my_id . "'") or die(mysql_error());
    mysql_query("UPDATE user_stats SET DailyRespectPoints = '5', DailyPetRespectPoints = '5' WHERE id = '" . $my_id . "'");
} elseif ($myrow['vip'] == 0 && $date_normal2 !== $myrow['getmoney_date']) {
    mysql_query("UPDATE users SET getmoney_date = '" . $date_normal2 . "' WHERE id = '" . $my_id . "'") or die(mysql_error());
    mysql_query("UPDATE user_stats SET DailyRespectPoints = '3', DailyPetRespectPoints = '3' WHERE id = '" . $my_id . "'") or die(mysql_error());
} elseif ($myrow['vip'] == 1 && $user_rank > 4 && $date_normal2 !== $myrow['getmoney_date']) {
    mysql_query("UPDATE users SET getmoney_date = '" . $date_normal2 . "' WHERE id = '" . $my_id . "'") or die(mysql_error());
    mysql_query("UPDATE user_stats SET DailyRespectPoints = '10', DailyPetRespectPoints = '10' WHERE id = '" . $my_id . "'") or die(mysql_error());
}
?>
<title><?php echo $sitename; ?> - <?php echo $myrow['username']; ?></title>
<section id="content">
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-8">

                    <div id="alert2" style="background:#aa0000; color:#fff; padding:10px; margin-bottom:10px;">
                        <div style="float:right;" id="close2">X</div>
                        <span style="font-size:16px;">Sua conta não entra?</span><br />
                        Estamos com problemas no console e estamos trabalhando para resolve-lo!<br />
                        Caso sua conta não entre, <a style="color:#ff5b5b;" href="accdebug.php">clique aqui</a> para resolver o problema.
                    </div>
                    
                    <div id="alert2" style="background:#007acc; color:#fff; padding:10px; margin-bottom:10px;">
                        <div style="float:right;" id="close2">X</div>
                        <span style="font-size:16px;">Você Sabia?</span><br />
                        No <?php echo $shortname; ?> você pode comprar novos modelos de quarto, BOTs para seu quarto e até carros!<br />
                        <a style="color:#a8dcff;" href="<?php echo $cms_url; ?>/store">Clique aqui</a> e confira nossa loja extra!
                    </div>

                    <div class="row">
                        <?php
                        if(isset($_GET['ac'])){
                            if ($_GET['ac'] == "delete" && isset($_GET['id'])) {
                                $feed_id = FilterText($_GET['id']);
                                $verify_sql = mysql_query("SELECT * FROM cms_feed_news WHERE id='" . $feed_id . "'") or die(mysql_error());
                                $verify_row = mysql_fetch_array($verify_sql);
                                if (mysql_num_rows($verify_sql) > 0) {
                                    if ($myrow['rank'] < 4) {
                                        echo "<script type='text/javascript'>alert('Você não tem permissão para deletar esta publicação.');</script>";
                                    } else {
                                        mysql_query("DELETE FROM cms_feed_news WHERE id='" . $feed_id . "'") or die(mysql_error());
                                        mysql_query("DELETE FROM cms_feed_news_comments WHERE feed_id='" . $feed_id . "'") or die(mysql_error());
                                        echo "<script type='text/javascript'>alert('Postagem apagada com sucesso!');</script>";
                                        echo '<meta http-equiv="refresh" content="0; url=me.php">';
                                        exit;
                                    }
                                } else {
                                    echo "<script type='text/javascript'>alert('Esta publicação não existe.');</script>";
                                }
                            }
                        }
                        
                        if(isset($_POST['action'])){
                            if ($_POST['action'] == "comment") {
                                $feed_id = FilterText($_POST['feedid']);
                                $comment = FilterText($_POST['comment']);
                                $verify_double = mysql_query("SELECT * FROM cms_feed_news_comments WHERE comment='" . $commnet . "' AND feed_id='" . $feed_id . "' AND user_id='" . $my_id . "'") or die(mysql_error());
                                if ((!$comment)) {
                                    echo "<script type='text/javascript'>alert('Ocorreu algum erro ao postar o comentário.');</script>";
                                } elseif (mysql_num_rows($verify_double) > 0) {
                                    echo "<script type='text/javascript'>alert('Ocorreu algum erro ao postar o comentário.\nAperte OK e espere a página te redirecionar!');</script>";
                                } else {
                                    $trace_user = mysql_query("SELECT * FROM cms_feed_news WHERE id='". $feed_id ."'") or die(mysql_error());
                                    $trace_usera = mysql_fetch_assoc($trace_user);
                                    mysql_query("INSERT INTO cms_notifications(userid) VALUES('". $trace_usera['user_id'] ."')") or die(mysql_error());
                                    mysql_query("INSERT INTO cms_feed_news_comments(feed_id, user_id, comment) VALUE('" . $feed_id . "', '" . $my_id . "', '" . $comment . "')") or die(mysql_query());
                                    echo "<script type='text/javascript'>alert('Comentário inserido!');</script>";
                                    echo '<meta http-equiv="refresh" content="0; url=me.php">';
                                    exit;
                                }
                            } elseif ($_POST['action'] == "updatebirth") {
                                $day = FilterText($_POST['day']);
                                $month = FilterText($_POST['month']);
                                $year = FilterText($_POST['year']);
                                if ((!$day) || (!$month) || (!$year)) {
                                    echo "<script type='text/javascript'>alert('Data de aniversário inválida');</script>";
                                } elseif (strlen($day) > 2 OR strlen($month) > 2 OR strlen($year) > 4) {
                                    echo "<script type='text/javascript'>alert('Data de aniversário inválida');</script>";
                                } else {
                                    $birthday = $day . "/" . $month . "/" . $year;
                                    mysql_query("UPDATE users SET birthday='" . $birthday . "' WHERE id='" . $my_id . "'") or die(mysql_error());
                                    echo "<script type='text/javascript'>alert('Data de aniversário confirmada, obrigado!');</script>";
                                    echo '<meta http-equiv="refresh" content="0; url=me.php">';
                                    exit;
                                }
                            }
                        }
                        
                        $selec_feed = mysql_query("SELECT * FROM cms_feed_news WHERE user_id IN (SELECT DISTINCT user_one_id FROM messenger_friendships WHERE user_two_id = '" . $my_id . "') ORDER BY id DESC LIMIT 24") or die(mysql_error());
                        while ($feed = mysql_fetch_assoc($selec_feed)) {
                            $comments = mysql_query("SELECT * FROM cms_feed_news_comments WHERE feed_id='" . $feed['id'] . "'") or die(mysql_error());
                            $user_sql = mysql_query("SELECT * FROM users WHERE id='" . $feed['user_id'] . "'") or die(mysql_error());
                            $user_row = mysql_fetch_array($user_sql);
                            ?>
                            <div class="col-lg-6 col-sm-6 boxkatrix">
                                <section class="panel">                   
                                    <div class="panel-body">
                                        <div class="clearfix m-b">
                                            <small class="text-muted pull-right"><?php echo $feed['date']; ?><br /><?php echo $feed['hour']; ?></small>
                                            <a href="<?php echo $cms_url; ?>/home-<?php echo $user_row['username']; ?>" class="thumb-sm pull-left m-r">
                                                <div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $user_row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -10px -14px; width:40px; height:45px;"></div>
                                            </a>
                                            <div class="clear">
                                                <a href="<?php echo $cms_url; ?>/home-<?php echo $user_row['username']; ?>"><strong><?php echo $user_row['username']; ?></strong></a> publicou um artigo
                                                <?php if ($myrow['rank'] > 3) { ?><small class="block text-muted"><a href="?ac=delete&id=<?php echo $feed['id']; ?>" style="color:red;">Deletar</a></small><?php } ?>
                                            </div>
                                        </div>
                                        <p><?php echo $feed['publication']; ?></p>
                                        <vercommentfeed<?php echo $feed['id']; ?> style="cursor:pointer; font-weight:bold;">Comentários (<?php echo mysql_num_rows($comments); ?>)</vercommentfeed<?php echo $feed['id']; ?>><br />
                                        <hiddenfeed<?php echo $feed['id']; ?> style="display:none;">
                                            <?php
                                            $comments = mysql_query("SELECT * FROM cms_feed_news_comments WHERE feed_id='" . $feed['id'] . "'") or die(mysql_error());
                                            if (mysql_num_rows($comments) > 0) {
                                                while ($comment = mysql_fetch_array($comments)) {
                                                    $user_comment = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='" . $comment['user_id'] . "'")) or die(mysql_error());
                                                    ?>   
                                                    <div style='margin:10px;'>
                                                        <table>
                                                            <tr>
                                                                <td rowspan="3"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $user_comment['look']; ?>&size=n&direction=3&head_direction=3&action=wlk&gesture=n&size=n) -10px -18px; width:40px; height:40px; margin-right:10px;"></div></td>
                                                                <td><b><a href="<?php echo $cms_url; ?>/home-<?php echo $user_comment['username']; ?>"><?php echo $user_comment['username']; ?></a></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo $comment['comment']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                echo "Não há comentários.";
                                            }
                                            ?>
                                        </hiddenfeed<?php echo $feed['id']; ?>>
                                        <script>
                                        $("vercommentfeed<?php echo $feed['id']; ?>").click(function() {
                                            $("hiddenfeed<?php echo $feed['id']; ?>").slideToggle("slow");
                                        });
                                        </script>
                                        <div id="allconets1369" style="display: none; max-height:150px;"><div></div></div>
                                    </div>
                                    <footer class="panel-footer pos-rlt">
                                        <span class="arrow top"></span>
                                        <form class="pull-out" action="" method="post" autocomplete="off">
                                            <input type="text" name="comment" class="form-control no-border input-lg text-sm" placeholder="Escrever comentário..">
                                            <input type="hidden" name="action" value="comment" />
                                            <input type="hidden" name="feedid" value="<?php echo $feed['id']; ?>" />
                                        </form>
                                    </footer>
                                </section>
                            </div> 
                            <?php
                        }
                        ?>	
                        <div id="akisoci"></div>
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

                    <?php
                    $minha_linha_sql = mysql_query("SELECT * FROM users WHERE id='" . $my_id . "'") or die(mysql_error());
                    $minhalinha = mysql_fetch_assoc($minha_linha_sql);
                    if ($minhalinha['birthday'] == NULL) {
                        ?>
                        <section class="panel">
                            <h4 class="font-thin padder">Confirmar data de Aniversário</h4>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <b>Por que?</b><br />
                                    Caso você esqueça ou perca sua senha, sua data de aniversário será nosso critério de segurança para que a mesma seja alterada.<br /><br />
                                    <font color="red"><b>Nota:</b> sua data de aniversário deve ser verdadeira</font><br /><br />
                                    Confirme sua data de aniversário abaixo:
                                    <form style="margin-top:10px;" action="" method="post" id="birthday">
                                        <select name="day" class="btn">
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <select name="month" class="btn">
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <select name="year" class="btn">
                                            <?php
                                            for ($i = 1970; $i <= 2013; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select><br />
                                        <input type="submit" value="Confirmar" class="btn btn-info" style="margin-top:20px;" />
                                        <input type="hidden" name="action" value="updatebirth" />
                                    </form>
                                </li>
                            </ul>
                        </section>
                    <?php } ?>

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
                    <section class="panel">
                        <h4 class="font-thin padder">Últimas Notícias</h4>
                        <ul class="list-group">
                            <?php
                            $last_news = mysql_query("SELECT * FROM cms_news_slider ORDER BY id DESC LIMIT 3") or die(mysql_error());
                            while ($newrow = mysql_fetch_array($last_news)) {
                                ?>
                                <li class="list-group-item">
                                    <p><?php echo $newrow['title']; ?></p>
                                    <small class="block text-muted"><img src="./web-gallery/images/icon/clock.png" alt="" style="padding:0 2px 3px 0;" /> <?php echo $newrow['date'] . " " . $newrow['hour']; ?> <a href="./news.php#view<?php echo $newrow['id']; ?>" style="margin-left:30px;">ver mais &raquo;</a></small>
                                </li>
                                <?php
                            }
                            ?>
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