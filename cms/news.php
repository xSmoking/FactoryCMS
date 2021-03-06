<?php
include_once("./templates/cms_header.php");
?>
<title><?php echo $sitename; ?> - Comunidade</title>
<section>
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div id="akisociant"></div>
                        <?php
                        while ($news = $news_sql->fetch_assoc()) {
                        $authorsql = $connect->query("SELECT * FROM users WHERE id='" . $news['author'] . "'") or die(mysql_error());
                        $author = $authorsql->fetch_assoc();
                        $comments = $connect->query("SELECT * FROM cms_news_comments WHERE new_id='" . $news['id'] . "'") or die(mysql_error());
                        ?>
                        <div id="view<?php echo $news['id']; ?>" style="margin-left:15px;">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <small class="text-muted pull-right"><?php echo $news['date']; ?><br /><?php echo $news['hour']; ?></small><span class="thumb-sm pull-left m-r">
                                            <img src="<?php echo $cms_url; ?>/web-gallery/images/artwork.png" alt="" title="Equipe <?php echo $shortname; ?>" class="img-circle">
                                        </span>
                                        <div class="clear">
                                            <strong>Equipe <?php echo $shortname; ?></strong> publicou uma notícia<br />
                                            <strong><?php echo $news['title']; ?></strong>
                                        </div>
                                    </div>
                                    <p><?php echo $news['longstory']; ?></p>
									<br />
                                    <p>Postada por <b><a href="<?php echo $cms_url; ?>/home.php?user=<?php echo $author['username']; ?>"><?php echo $author['username']; ?></a></b></p>
                                    <div id="allconets1371" style="display: none; max-height:150px;"><div></div></div>
                                </div>
                            </section>
                        </div>
                        <?php
                        }
                        ?>
                        <div id="akisoci"></div>
                    </div>
                    <div class="text-center m-b" id="cargandowow" style="display: none;">
                        <i class="icon-spinner icon-spin"></i>
                    </div>
                    <div class="text-center m-b" id="cargandowowya" onclick="cargandowowyaj('home', '', '6', '');">
                        <button class="btn btn-sm btn-white" id="vermasbbut">
                            <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/plus.png" style="padding-bottom:3px; padding-right:4px;" alt="" />
                            <span class="text">Ver mais</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <h4 class="font-thin padder">Aniversariantes do Dia</h4>
                        <ul class="list-group">
                            <?php
                            $consulta = $connect->query("SELECT * FROM users WHERE birthday LIKE '%". $date_simple ."%'") or die(mysql_error());
                            
                            if($consulta->num_rows > 0){
                            while($niver = $consulta->fetch_assoc()){
                            ?>
                            <li class="list-group-item">
                                <p><?php echo $niver['username']; ?></p>
                            </li>
                            <?php
                            }
                            }else{
                                echo '<li class="list-group-item">';
                                echo 'Não possuimos aniversariantes do dia.';
                                echo '</li>';
                            }
                            ?>
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