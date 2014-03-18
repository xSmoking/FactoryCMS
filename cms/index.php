<?php
include_once("./data-classes/data-classes-core-index.php");

if(isset($_SESSION['username'])){
    header("Location:". $cms_url . "/me");
    exit;
}

if(isset($_POST['submit'])){
    $username = FilterText($_POST['username']);
    $password = HoloHashMD5($_POST['password']);
    if((!$username) || (!$password)){
        $msg_type = "error";
        $msg_echo = "Preencha os campos para realizar o login";
    }else{
        $user_verify = $connect->query("SELECT * FROM users WHERE username = '". $username ."' AND password = '". $password ."' OR mail = '". $username ."' AND password = '". $password ."'") or die($connect->error());
        if($user_verify->num_rows > 0){
            $ban_verify = $connect->query("SELECT * FROM bans WHERE value = '". $username ."' AND bantype = 'user' OR value = '". $remote_ip ."' AND bantype = 'ip'") or die($connect->error());
            if($ban_verify->num_rows > 0){
                $ban_array = $ban_verify->fetch_assoc();
                $timestamp = time();
                if($ban_array['expire'] <= $timestamp){
                    $connect->query("DELETE FROM bans WHERE value = '". $username ."'") or die($connect->error());
                    $connect->query("UPDATE users SET ip_last = '" . $remote_ip . "', WHERE username = '" . $username . "'") or die($connect->error());
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    header("location: $cms_url/me");
                }else{
                    $msg_type = "error";
                    $msg_echo = "Você está banido até <b>". date('d/m/Y H:i', $ban_array['expire']) ."</b><br /><b>Motivo:</b> ". $ban_array['reason'];
                }
            }else{
                $connect->query("UPDATE users SET ip_last = '" . $remote_ip . "' WHERE username = '" . $username . "'") or die($connect->error());
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                header("location: $cms_url/me");
            }
        }else{
            $msg_type = "error";
            $msg_echo = "Nome de usuário/e-mail ou senha está incorreto";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $sitename; ?> - Página Principal</title>
        <meta http-equiv="X-UA-Compatible" content="IE=10" />
        <meta name="description" content="ciudad virtual, chat 3d, chat con avatares, amigos online, juego online, jugar, red social, jovenes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="web-gallery/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/fuelux.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font.css" type="text/css" cache="false" />
        <link rel="stylesheet" href="web-gallery/css/plugin.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/app.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/idangerous.chopslider-3.4.css">
        <link rel="shortcut icon" href="web-gallery/images/ico.png"/>
        <script src="web-gallery/js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="web-gallery/js/bootstrap.js"></script>
        <!-- app -->
        <script src="web-gallery/js/app.js"></script>
        <script src="web-gallery/js/app.plugin.js"></script>
        <script src="web-gallery/js/app.data.js"></script>
        <script src="web-gallery/js/jcookie.js"></script>
        <script src="web-gallery/js/idangerous.chopslider-3.4.min.js"></script>
        <!--[if lt IE 9]>
          <script src="js/ie/respond.min.js" cache="false"></script>
          <script src="js/ie/html5.js" cache="false"></script>
          <script src="js/ie/fix.js" cache="false"></script>
        <![endif]-->
        <style type="text/css">
            body {
                background-color: #078ce5;
                background-image: url(./web-gallery/images/background-blue.png);
            }
            #fotam a{
                color:#fff;
            }
        </style>
        <script>
            function Alert($mensagem){ alert($mensagem); }
        </script>
    </head>
    <body>
        <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
            <div class="row m-n">
                <div class="col-md-4 col-md-offset-4 m-t-lg" style="width: 700px;min-width: 700px;max-width: 700px;">
                    <section class="panel">
                        <header class="panel-heading text-center">
                            <!-- slider inicio-->
                            <div class="cs3-wrap cs3-skin-5" style="position: absolute;margin-left:-16px;margin-top:-30px;">
                                <div class="cs3" style="border-radius:4px 4px 0 0;-webkit-border-radius:4px 4px 0 0;-moz-border-radius:4px 4px 0 0;height: 267px;max-height:267px;overflow:hidden;">
                                    <div class="cs3-slide"><img src="web-gallery/images/sandrowow.png"></div>
                                    <div class="cs3-slide"><img src="web-gallery/images/pic7.png"></div>
                                    <div class="cs3-slide"><img src="web-gallery/images/ima8.png"></div>
                                    <div class="cs3-slide-prev"></div>
                                    <div class="cs3-slide-next" id="nextya"></div>
                                    <div class="cs3-pagination-wrap">
                                    <div class="cs3-pagination"></div>
                                    </div>

                                    <div class="cs3-captions cs3-caption-multi cs3-caption-multi-black ">
                                        <div class="cs3-caption">
                                            <div class="cs3-caption-title">Participe de Festas!</div>
                                            <div class="cs3-caption-text">Organize seus eventos e crie suas próprias festas</div>
                                            <div class="cs3-caption-text" style="background: none;height:20px;"><br /></div>
                                        </div>
                                        <div class="cs3-caption">
                                            <div class="cs3-caption-title">Espaços Públicos</div>
                                            <div class="cs3-caption-text">Aproveite de nossos incríveis espaços públicos</div>
                                            <div class="cs3-caption-text" style="background: none;height:20px;"><br /></div>
                                        </div>
                                        <div class="cs3-caption">
                                            <div class="cs3-caption-title">Distrito <?php echo $shortname; ?></div>
                                            <div class="cs3-caption-text">Explore esta cidade que é a maior construção já feita em qualquer game do genero!</div>
                                            <div class="cs3-caption-text" style="background: none;height:20px;"><br /></div>
                                        </div>
                                    </div>

                                </div>
                            </div>          
                            <div style="height:260px;min-height:260px;max-height:260px;"></div>
                            <img src="web-gallery/images/logo.png" style="float: left;margin-top:-20px;"/> Bem-vindo ao <?php echo $sitename; ?>, uma cidade virtual onde você pode criar sua própria casa, fazer novos amigos, ter mascotes, bots para te servirem, personalizar sua roupa, compartilhar informações e muito mais!
                            <br /><br />
                        </header>
                        <form class="panel-body" method="post" action="index.php">
                            <div id="loginerrorplusmas" class="alert alert-info alert-block hide">
                                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                                <h4><i class="icon-bell-alt"></i> Recuperar contraseña</h4>
                                <p>Hemos enviado un email a tu correo con la contraseña de tu cuenta</p>
                            </div>
                            <?php
                            if(isset($msg_type)){
                            ?>
                            <div class="alert alert-error" id="loginerror">
                                <span><?php echo $msg_echo; ?></span>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="form-group">
                                <label class="control-label">E-mail ou nome de usuário</label>
                                <input type="text" id="username" name="username" placeholder="Escreva aqui seu e-mail ou nome de usuário do <?php echo $shortname; ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Senha</label>
                                <input type="password" id="password" name="password" placeholder="Escreva aqui sua senha" class="form-control">
                            </div>

<!--                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="checkbox-custom">
                                        <input type="checkbox" name="remember_me" />
                                        Lembrar-me na próxima sessão
                                    </label>
                                </div>
                            </div>-->

                            <a href="./forgotpass.php" onclick="Alert('Opção desativada no momento. Em breve estará disponível!')" class="pull-right m-t-xs"><small>Esqueceu a Senha?</small></a>
                            <button type="submit" name="submit" id="submit" class="btn btn-info">Entrar</button>
                            <div class="line line-dashed"></div>
                            <p class="text-muted text-center"><small>Ainda não possui uma conta?</small></p>
                            <a href="register" class="btn btn-primary btn-block">Cadastre-se no <?php echo $sitename; ?> agora mesmo!</a>
                        </form>
                    </section>
                    <div style="color: #FFF;" id="fotam">
                        <footer id="footer">
                            <div class="text-center padder clearfix">
                                <p>
                                    <small><a href="http://factoryhotel.com.br/portal">Factory Portal</a> | <a href="http://www.factoryhotel.com.br/contrato_de_licensa_de_uso.docx" target="_blank">Termos e condições</a>
                                    <br><?php echo $shortname; ?> não tem vínculos com o Habbo ou com a Sulake</small>
                                </p>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </section>
		<div style="position:absolute; left:50%; margin-left:-340px;">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-6896402047330257";
		/* Factory Head */
		google_ad_slot = "2517144037";
		google_ad_width = 728;
		google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
        <!-- footer -->
        <!-- / footer -->

        <script>
            function addva(min, max) {
                var res = Math.floor(Math.random() * (max - min + 1)) + min;
                return res.toString();
            }
            function addvacaa(min, max) {
                var res = Math.floor(Math.random() * (max - min + 1)) + min;
                return res.toString();
            }

            $(document).ready(function() {
                $('a#goface').click(function() {
                    var caracteristicas = "height=300,width=450,scrollTo,resizable=1,scrollbars=0,location=0";
                    window.open('./?face=1', 'logiface', caracteristicas);
                    return false;
                });
                var cs3 = $('.cs3').cs3({
                    pagination: {
                        container: '.cs3 .cs3-pagination'
                    },
                    navigation: {
                        next: '.cs3 .cs3-slide-next',
                        prev: '.cs3 .cs3-slide-prev'
                    },
                    captions: {
                        enabled: true,
                        duration: 100,
                        type: 'horizontal',
                        multi: false,
                        multiDelay: 100
                    }
                });
                setTimeout("vesnex('0');", 9500);
            });

            function vesnex(kvez) {
                kvez++;
                document.getElementById('nextya').click();
                if (kvez < 10) {
                    setTimeout("vesnex(" + kvez + ");", 9500);
                }
            }
        </script>
        <script src="web-gallery/js/fuelux.js"></script>
    </body>
</html>