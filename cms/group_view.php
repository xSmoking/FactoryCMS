<?php
include_once("./templates/cms_header.php");

$group_id = FilterText($_GET['groupid']);

$group_find = mysql_query("SELECT * FROM groups WHERE id='". $group_id ."'") or die(mysql_error());
?>
<title><?php echo $sitename; ?> - Ver Grupo</title>
<section>
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <?php
                if(mysql_num_rows($group_find) > 0){
                    $group = mysql_fetch_assoc($group_find);
                    $groupOwnerSQL = mysql_query("SELECT * FROM users WHERE id='". $group['ownerid'] ."'") or die(mysql_error());
                    $groupOwnerInfo = mysql_fetch_assoc($groupOwnerSQL);
                    
                    if($_GET['ac'] == "getin"){
                        $checkMember = mysql_query("SELECT * FROM group_memberships WHERE groupid='". $group_id ."' AND userid='". $my_id ."'") or die(mysql_error());
                        if(mysql_num_rows($checkMember) > 0){
                            echo "<script type='text/javascript'>alert('Você já é membro deste grupo.');</script>";
                        }else{
                            mysql_query("INSERT INTO group_memberships(groupid, userid) VALUE('". $group_id ."', '". $my_id ."')") or die(mysql_error());
                            echo "<script type='text/javascript'>alert('Pronto! Agora você é membro deste grupo');</script>";
                        }
                    }elseif($_GET['ac'] == "favorite"){
                        $checkMember = mysql_query("SELECT * FROM group_memberships WHERE groupid='". $group_id ."' AND userid='". $my_id ."'") or die(mysql_error());
                        if(mysql_num_rows($checkMember) > 0){
                            if($mystat['groupid'] == $group_id){
                                echo "<script type='text/javascript'>alert('Este grupo já está marcado como favorito.');</script>";
                            }else{
                                mysql_query("UPDATE user_stats SET groupid='". $group_id ."' WHERE id='". $my_id ."'") or die(mysql_error());
                                echo "<script type='text/javascript'>alert('Pronto! Este grupo foi marcado como seu favorito.');</script>";
                            }
                        }else{
                            echo "<script type='text/javascript'>alert('Você precisa entrar no grupo para marca-lo como favorito.');</script>";
                        }
                    }

                    $user_stats_sql = mysql_query("SELECT * FROM user_stats WHERE id='". $myrow['id'] ."'") or die(mysql_error());
                    $mystat = mysql_fetch_assoc($user_stats_sql);
                    $checkUserMember = mysql_query("SELECT * FROM group_memberships WHERE groupid='". $group_id ."' AND userid='". $my_id ."'") or die(mysql_error());
                ?>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">
                                <div class="panel-body">
                                    <img src="<?php echo $cms_url; ?>/habbo-imaging/badge-fill/<?php echo $group['badge']; ?>.gif" style="float:right;" />
                                    <div class="font-thin" style="font-size:20px; margin-bottom:10px;"><?php echo $group['name']; ?></div>
                                    <?php
                                    $groups = mysql_query("SELECT * FROM groups WHERE id='". $group_id ."'") or die(mysql_error());
                                    while ($row = mysql_fetch_array($groups)) {
                                        $members2 = mysql_evaluate("SELECT COUNT(*) FROM group_memberships WHERE groupid = '" . $row['id'] . "'") or die(mysql_error());
                                    ?>
                                        <b>Proprietário:</b> <?php echo $groupOwnerInfo['username']; ?><br />
                                        <b>Criado em:</b> <?php echo $group['created']; ?><br />
                                        <b><?php echo $members2; ?></b> Membro(s)<br /><br />
                                        <?php echo $group['desc']; ?>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="font-thin" style="font-size:20px; margin-bottom:10px;">Membros</div>
                                    <?php
                                    $groupMembers = mysql_query("SELECT * FROM group_memberships WHERE groupid='". $group_id ."'") or die(mysql_error());
                                    while ($row = mysql_fetch_array($groupMembers)) {
                                        $membersInfo = mysql_query("SELECT * FROM users WHERE id='". $row['userid'] ."'") or die(mysql_error());
                                        $memberInfo = mysql_fetch_assoc($membersInfo);
                                    ?>
                                    <a href="<?php echo $cms_url; ?>/home-<?php echo $memberInfo['username']; ?>" data-toggle="tooltip" title="<?php echo $memberInfo['username']; ?>" class="thumb-sm pull-left m-r">
                                        <div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $memberInfo['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -10px -14px; width:40px; height:45px;"></div>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </section>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <h4 class="font-thin padder">Ações</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <table style="width:100%; font-size:14px;" class="table-hover" cellpadding="10">
                                    <tr>
                                        <td><a href="group_view.php?groupid=<?php echo $group_id; ?>&ac=getin">Entrar no Grupo</a></td>
                                        <td><img style="float:right;" src="./web-gallery/images/group_enter<?php if(mysql_num_rows($checkUserMember) > 0){ echo "_hover"; } ?>.png" /></td>
                                    </tr>
                                    <tr>
                                        <td><a href="group_view.php?groupid=<?php echo $group_id; ?>&ac=favorite">Marcar grupo como favorito</a></td>
                                        <td><img style="float:right;" src="./web-gallery/images/group_favorite<?php if($mystat['groupid'] == $group_id){ echo "_hover"; } ?>.png" /></td>
                                    </tr>
                                </table>
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
                <?php
                }else{
                    echo ' 
                    <div class="col-lg-8">
                        <section class="panel">  
                            <h4 class="font-thin padder" style="margin-bottom:0px;">Grupo não encontrado</h4>
                            <div class="panel-body">
                                O grupo que você está procurando não foi localizado em nosso banco de dados.
                            </div>
                        </section>
                    </div> 
                    ';
                }
                ?>
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