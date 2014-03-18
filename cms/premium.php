<?php
include_once("./templates/cms_header.php");
?>
<title><?php echo $sitename; ?> - Comprar Pontos</title>
<section id="content">
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Benefício da Conta Premium</div>
                                    </div>
                                    <div style="float:left;">
                                        <span style="font-size:14px;">Comandos Extras</span><br />
                                        :push x (empurra o usuário que quiser)<br />
                                        :pull x (traz para você o usuário que você deseja)<br />
                                        :moonwalk (anda para trás)<br />
                                        :follow x (seguir um determinado usuário) <br />
                                        :mimic x (copia o visual do usuário)<br />
                                        :flagme (altera o nome de usuário)<br />
                                        :enable ID (colocar efeitos, ex. :enable 10)<br />
                                        <br />
                                        <span style="font-size:14px;">Outros Benefícios</span><br />
                                        Emblema Premium, para que todos saibam que você é Premium<br />
                                        Catálogo Premium, com mobis e raros especiais<br />
                                        Entrar em quartos lotados<br />
                                        500 Pontos de conquista<br />
                                        Loja de emblemas<br />
                                        Tempo mudo por flood: 10 segundos<br />
                                        Acesso VIP em shows/eventos da gerência<br />
                                    </div>
                                </div>
                            </section>
                        </div> 

                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Adquir Conta Premium</div>
                                    </div>
                                    Ao adquirir o Premium, o mesmo não haverá prazo de término.<br />
                                    Todos os benefícios citados ao lado serão incluídos em sua conta.
                                    <div style="margin-top:10px;">Preço: 1000 Rubis</div>
                                    <?php
                                    if ($myrow['online'] == 1) {
                                        echo '<div style="float:left; margin-top:20px;" class="btn btn-danger" disabled="disabled">Fique offline para adquirir</div>';
                                    } elseif ($myrow['vip'] == 1) {
                                        echo '<div style="float:left; margin-top:20px;" class="btn btn-primary" disabled="disabled">Você já é Premium</div>';
                                    } else {
                                        echo '<a href="?buy=premium" style="float:left; display:block; margin-top:20px;" class="btn btn-warning">Comprar Premium</a>';
                                    }
                                    ?>
                                    <a href="buyruby" style="display:block; float:right; margin-top:20px;" class="btn btn-success">Comprar Rubis</a>
                                    <div style="float:left; margin-top:70px;">
                                        <?php
                                        echo '<div style="margin-top:10px;">';

                                        if (isset($_GET['buy'])) {
                                            if ($_GET['buy'] == "premium") {
                                                if ($myrow['vip_points'] < 1000) {
                                                    echo "Você não possui rubis suficientes.";
                                                } elseif ($myrow['vip'] == 1) {
                                                    echo "Você já é Premium.";
                                                } elseif ($myrow['online'] == 1) {
                                                    echo "Fique offline para adquirir.";
                                                } else {
                                                    $newAchi = $mystat['AchievementScore'] + 200;
                                                    $newPts = $myrow['vip_points'] - 1000;
                                                    $connect->query("UPDATE users SET rank='2', vip='1', vip_points='" . $newPts . "' WHERE id='" . $my_id . "'") or die($connect->error());
                                                    $connect->query("UPDATE user_stats SET AchievementScore='" . $newAchi . "' WHERE id='" . $my_id . "'") or die($connect->error());
                                                    echo "Compra realizada, agora você é Premium.";
                                                }
                                            }
                                        }
                                        echo '</div>';
                                        ?>
                                    </div>
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
                                            <img style="background:#a3a3a3; padding-bottom:7px; border:solid 2px #fff; -webkit-border-radius: 200px; -moz-border-radius: 200px; border-radius: 200px;" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $myrow['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n" />
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

                    <section class="panel">
                        <h4 class="font-thin padder">Sobre os Rubis</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                Rubis de catálogo são parecidos com as moedas utilizadas no hotel, porém estes rubis são utilizados para adquirir super raros e emblemas exclusivos, onde estes jamais entrarão no catálogo normal!<br /><br />

                                A venda destes rubis, é realizada através de SMS (celular), boleto bancário ou cartão de crédito.<br />
                                Com os rubis você irá acessar nosso catálogo e por lá irá comprar raros e emblemas.<br /><br />

                                Confira os planos ao lado e adquira já seus rubis e desfrute de nossa incrível loja!
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
<script src="./web-gallery/js/katrixweb.js"></script>
</body>
</html>