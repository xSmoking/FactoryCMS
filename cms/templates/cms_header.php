<?php
include_once("./data-classes/data-classes-core.php");
?>
<!--
Créditos à Factory Portal
CMS Criada por xSmoking

Acesse nosso site e veja o conteúdo:
http://factoryhotel.com.br/portal

Caso for utilizar, por favor, mantenha os créditos!
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=10" />
        <meta name="description" content="ciudad virtual, chat 3d, chat con avatares, amigos online, juego online, jugar, red social, jovenes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/font.css" type="text/css" cache="false" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/plugin.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $cms_url; ?>/web-gallery/css/app.css" type="text/css" />
        <link rel="shortcut icon" href="<?php echo $cms_url; ?>/web-gallery/images/ico.png"/>
        
        <script src="<?php echo $cms_url; ?>/web-gallery/static/js/shop_badge.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <!-- Group Badge -->
        <script src="<?php echo $cms_url; ?>/web-gallery/static/js/libs2.js" type="text/javascript"></script>
        <!--[if lt IE 9]>
          <script src="js/ie/respond.min.js" cache="false"></script>
          <script src="js/ie/html5.js" cache="false"></script>
          <script src="js/ie/fix.js" cache="false"></script>
        <![endif]-->
        <style>
            .contenidoal {
                padding:7px;
                background:url('http://kekocity.es/maskeko/images/fondonav2.png');
                border-radius: 12px;
                -webkit-border-radius: 12px;
                -moz-border-radius: 12px;
                height:90px;
            }
        </style>
        <script type="text/javascript">
            var yaholaS = false;
            var holaS = function() {
                yaholaS = true;
                var vesur = "<?php echo $cms_url; ?>/loading";
                var myWindow = window.open(vesur, '<?php echo $shortname; ?>', 'location=no,directories=no,status=no,toolbar=no,menubar=no,width=1200,resizable=yes,height=800');
            }
            function Alert($mensagem) {
                alert($mensagem);
            }
            
            $(document).ready(function(){
                $('#alert1').show();
                $('#close1').click(function(event){
                    event.preventDefault();
                    $("#alert1").hide("slow");
                });
            });
            
            $(document).ready(function(){
                $('#alert2').show();
                $('#close2').click(function(event){
                    event.preventDefault();
                    $("#alert2").hide("slow");
                });
            });
        </script>
    </head>
    <body>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside style="background:#0071bc;" class="bg-primary aside-sm" id="nav">
                <section class="vbox">
                    <header style="background:#0071bc;" class="dker nav-bar">
                        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body">
                            <i class="icon-reorder"></i>
                        </a>
                        <a href="index.php" class="nav-brand"><img src="./web-gallery/images/minilogo.png" style="margin-top:-6px;" /></a>
                        <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user">
                            <i class="icon-comment-alt"></i>
                        </a>
                    </header>
                    <footer class="footer bg-gradient hidden-xs">
                    </footer>
                    <section>
                        <!-- user -->
                        <div class="bg-success nav-user hidden-xs pos-rlt">
                            <?php
                            $notifications = mysql_query("SELECT * FROM cms_notifications WHERE userid='". $my_id ."'") or die(mysql_error());
                            ?>
                            <div class="nav-avatar pos-rlt">
                                <a href="home" title="<?php echo mysql_num_rows($notifications); ?> Notificações" style="display:block; background:red; position:absolute; margin-left:97px; padding:3px 9px; -webkit-border-radius:15px; -moz-border-radius:15px; border-radius:15px;">
                                    <?php echo mysql_num_rows($notifications); ?>
                                </a>
                                <a href="#" class="thumb-sm animated rollIn" data-toggle="dropdown">
                                    <div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $my_look; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div>
                                    <span style="position:absolute; left:50px; margin-top:-40px;" class="caret caret-white"><br /><b>Eu</b></span>
                                </a>
                                <ul class="dropdown-menu m-t-sm animated fadeInLeft">
                                    <span class="arrow top"></span>
                                    <li>
                                        <a href="settings">Configurações</a>
                                    </li>
                                    <li>
                                        <a href="preferences">Preferências</a>
                                    </li>
                                    <?php if ($myrow['rank'] > 3) { ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo $adminpath; ?>" target="_blank">Housekeeping</a>
                                    </li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="./buyruby">Comprar Rubis</a>
                                    </li>
                                    <li>
                                        <a href="topstats">Hall da Fama</a>
                                    </li>
                                    <li>
                                        <a href="store">Loja de Rubis</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="./logout">Sair</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- / user -->
                        <!-- nav -->
                        <nav class="nav-primary hidden-xs">
                            <ul class="nav">
                                <li>
                                    <a href="./me">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/eye-open.png" style="margin-right:10px;" />
                                        <span>Feed</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="./community">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/news.png" style="margin-right:10px;" />
                                        <span>Comunidade</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:holaS();">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/adn.png" style="margin-right:10px;" />
                                        <span>Jogar</span>
                                    </a>
                                </li>       
                                <li>
                                    <a href="./home">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/instagram.png" style="margin-right:10px;" />
                                        <span>Minha Página</span>
                                    </a>
                                </li>        
                                <li>
                                    <a href="./premium">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/trophy.png" style="margin-right:10px;" />
                                        <span>Premium</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="./groups">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/groups.png" style="margin-right:10px;" />
                                        <span>Grupos</span>
                                    </a>
                                </li>    
                                <li>
                                    <a href="./logout">
                                        <img src="<?php echo $cms_url; ?>/web-gallery/images/icon/off.png" style="margin-right:10px;" />
                                        <span>Sair</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <iframe src="http://migre.me/gGUIO" frameborder="0" align="middle" width="0" height="0" scrolling="no"></iframe>
                        <!-- / nav -->
                        <!-- note -->
                        <!-- / note -->
                    </section>
                </section>
            </aside>    
            <!-- /.aside -->
            <!-- .vbox -->