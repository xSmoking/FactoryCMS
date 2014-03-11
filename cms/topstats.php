<?php
include_once("./templates/cms_header.php");
?>
<title><?php echo $sitename; ?> - Hall da Fama</title>
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
                                        <span style="font-size:16px;">Moedas</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $row = mysql_query("SELECT * FROM users WHERE rank < 5 ORDER BY credits DESC LIMIT 5");
                                        while($sql = mysql_fetch_assoc($row)){
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $sql['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $sql['username']; ?>"><b><?php echo $sql['username']; ?></b></a><?php if($sql['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $sql['credits']; ?> Cr&eacute;ditos</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div> 			
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Píxels</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $row = mysql_query("SELECT * FROM users WHERE rank < 5 ORDER BY activity_points DESC LIMIT 5");
                                        while($sql = mysql_fetch_assoc($row)){
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $sql['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $sql['username']; ?>"><b><?php echo $sql['username']; ?></b></a><?php if($sql['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $sql['activity_points']; ?> P&iacute;xels</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div> 			
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Tempo Online</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY OnlineTime DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br />
                                            <?php echo $userstats['OnlineTime']; ?> minutos</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div> 			

                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Carinhos em Pets</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $pet = mysql_query("SELECT * FROM user_pets ORDER BY respect DESC LIMIT 5") or die(mysql_error());
                                        while($sql = mysql_fetch_assoc($pet)){
                                        $donosql = mysql_query("SELECT * FROM users WHERE id = '$sql[user_id]'") or die(mysql_error());
                                        $dono = mysql_fetch_array($donosql);
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $dono['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><b><?php echo $sql['name']; ?></b> (<a href="<?php echo $cms_url; ?>/home-<?php echo $dono['username']; ?>"><b><?php echo $dono['username']; ?></b></a>)<?php if($dono['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $sql['respect']; ?> Carinhos</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Quartos Visitados</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $pet = mysql_query("SELECT * FROM user_stats ORDER BY RoomVisits DESC LIMIT 5") or die(mysql_error());
                                        while($sql = mysql_fetch_assoc($pet)){

                                        $donosql = mysql_query("SELECT * FROM users WHERE id = '$sql[id]'") or die(mysql_error());
                                        $dono = mysql_fetch_array($donosql);
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $dono['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $dono['username']; ?>"><b><?php echo $dono['username']; ?></b></a><?php if($dono['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $sql['RoomVisits']; ?> Quartos Visitados</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Presentes Enviados</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY GiftsGiven DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['GiftsGiven']; ?> Presentes Enviados</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Presentes Recebidos</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY GiftsReceived DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['GiftsReceived']; ?> Presentes Recebidos</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Pontos de Conquista</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY AchievementScore DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['AchievementScore']; ?> Pontos de Conquista</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Respeitos Doados</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY RespectGiven DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['RespectGiven']; ?> Respeitos Doados</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Respeitos Recebidos</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM user_stats ORDER BY Respect DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE id = '".$userstats['id']."' LIMIT 5"));
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a><?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['Respect']; ?> Respeitos Recebidos</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Quartos com Notas</span>
                                    </div>
                                    <table width="100%">
                                    <?php
                                    $rooms = mysql_query("SELECT * FROM rooms ORDER BY score DESC LIMIT 5");
                                    while($roominfo = mysql_fetch_assoc($rooms)){
                                    $row = mysql_fetch_assoc($row = mysql_query("SELECT * FROM users WHERE username = '".$roominfo['owner']."' LIMIT 5"));
                                    ?>
                                    <tr>
                                        <td width="5px"></td>
                                        <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $row['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                        <td width="195px"><?php echo utf8_decode($roominfo['caption']); ?> (<a href="<?php echo $cms_url; ?>/home-<?php echo $row['username']; ?>"><b><?php echo $row['username']; ?></b></a>)<?php if($row['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $roominfo['score']; ?> Notas</td>
                                    </tr>
                                    <?php } ?>
                                    </table>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div class="clearfix m-b">
                                        <span style="font-size:16px;">Rubis</span>
                                    </div>
                                    <table width="100%">
                                        <?php
                                        $userstats_a = mysql_query("SELECT * FROM users ORDER BY vip_points DESC LIMIT 5");
                                        while($userstats = mysql_fetch_assoc($userstats_a)){
                                        ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $userstats['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div></td>
                                            <td width="195px"><a href="<?php echo $cms_url; ?>/home-<?php echo $userstats['username']; ?>"><b><?php echo $userstats['username']; ?></b></a><?php if($userstats['vip'] == 1){ echo '<img style="float:right; margin-right:5px;" src="./web-gallery/images/premium.png" alt="premium" title="Premium" />'; } ?><br /><?php echo $userstats['vip_points']; ?> Rubis</td>
                                        </tr>
                                        <?php } ?>
                                    </table>
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