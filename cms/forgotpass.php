<?php
include_once("./data-classes/data-classes-core-index.php");
include_once("./sys_email_sender/class.phpmailer.php");

if(isset($_SESSION['username'])){
    header("Location:". $cms_url . "/me");
    exit;
}

if ($_POST['action'] == "pass_send") {
    $username = FilterText($_POST['username']);
    $email = FilterText($_POST['mail']);

    $sql = mysql_query("SELECT * FROM users WHERE username = '" . $username . "' AND mail = '" . $email . "'") or die(mysql_error());
    if ((!$username) || (!$email)) {
        $msg_type = "danger";
        $msg_echo = "Preencha todos os campos.";
    } elseif (mysql_num_rows($sql) > 0) {
        $row2 = mysql_fetch_assoc($sql);
        $caracters = 'abcdxywzABCDZYWZ0123456789';
        $code = geraSenha();
        $timestampend = time()+86400;
        mysql_query("INSERT INTO password_recovery(username, mail, code, timestampend) VALUES('". $username ."','". $email ."','". $code ."', '". $timestampend ."')") or die(mysql_error());
        
        $mail = new PHPMailer();
        $mail->SetLanguage('br');
        $body = "
            <html>
            <head>
            <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
            <style type='text/css'>
            a { color: #fc6204; }
            </style>
            </head>
            <body style='background-color: #e3e3db; margin: 0; padding: 0; font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000;'>
            <div style='background-color: #bce0ee; padding: 14px; border-bottom: 3px solid #000;'>	
            <img src='" . $webgallery . "/v2/images/habbologo_whiteR.gif' alt='Forever Hotel' />
            </div>
            <div style='padding: 14px 14px 50px 14px; background-color: #e3e3db;'>	
            <div style='background-color: #fff; padding: 14px; border: 1px solid #ccc'>
            <h1 style='font-size: 16px'>Redefina sua senha no The Factory!</h1>
            <br />
            Ol&aacute; <b>" . $username . "</b>, recebemos uma solicitação de redefinição de senha vinda do IP <b>". $_SERVER['REMOTE_ADDR'] ."</b><br />
            <br />Para redefinir sua senha, acesse o link abaixo:<br />
            <a href='" . $cms_url . "/forgotpass_verify_" . $code . "'>" . $cms_url . "/forgotpass_verify_" . $code . "</a>
            <br />
            <br />Este é um e-mail de resposta automática, não o responda! 
            <br />Caso tenha dúvida mande um e-mail para <b>contato@factoryhotel.com.br</b>
            <br />
            <br />
            <br /><b>Equipe Factory</b>
            <br />
            <br /><h1 style='font-size: 10px'>Caso n&atilde;o tenha feito um pedido para altera&ccedil;&atilde;o de senha desconsidere essa mensagem ou entre em contato conosco.</h1>	
            </div>	
            </div>
            </body>
            </html>
        ";
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "joaocovaes@gmail.com";
        $mail->Password = "1Px52b5i!";
        $mail->SetFrom('joaocovaes@gmail.com', 'The Factory'); // e-mail do remetente e seu nome/apelido
        $mail->AddReplyTo("joaocovaes@gmail.com", "The Factory"); // e-mail de resposta do e-mail que enviaremos. Ou seja, quando alguém responder a este e-mail, responderá para o e-mail aqui configurado ....e o nome/apelido do mesmo
        $mail->Subject = "Redefinição de senha para The Factory"; // Assunto do e-mail
        $mail->AltBody = "Para visualizar a mensagem, por favor, use um cliente de e-mail compatível/configurado para ver mensagens HTML!"; // Mensagem alternativa caso o destinat�rio. Veja o e-mail em um aplicativo sem suporte ou n�o configurado para ver mensagens HTML
        $mail->MsgHTML($body);
        $endereco = $email;
        $mail->AddAddress($endereco, $endereco);
        if (!$mail->Send()) {
            $msg_type = "danger";
            $msg_echo = "Houve um erro, tente novamente mais tarde.";
        } else {
            $msg_type = "success";
            $msg_echo = "Foi enviado um link de redefinição de senha para seu e-mail.";
        }
    } else {
        $msg_type = "danger";
        $msg_echo = "Seu nome de usuário não conhecide com o e-mail.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $sitename; ?> - Esqueci a Senha</title>
        <meta http-equiv="X-UA-Compatible" content="IE=10" />
        <meta name="description" content="ciudad virtual, chat 3d, chat con avatares, amigos online, juego online, jugar, red social, jovenes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="web-gallery/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font.css" type="text/css" cache="false" />
        <link rel="stylesheet" href="web-gallery/css/plugin.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/app.css" type="text/css" />
        <link rel="shortcut icon" href="web-gallery/images/logobig.ico"/>
        <!--[if lt IE 9]>
          <script src="js/ie/respond.min.js" cache="false"></script>
          <script src="js/ie/html5.js" cache="false"></script>
          <script src="js/ie/fix.js" cache="false"></script>
        <![endif]-->
    </head>
    <style type="text/css">
        body {
            background-color: #078ce5;
            background-image: url(./web-gallery/images/background-blue.png);
        }
        #fotam a{
            color:#fff;
        }
    </style>
    <body>
        <section id="content" class="m-t-lg wrapper-md animated fadeInDown">
            <a class="nav-brand"><img src="./web-gallery/images/logo.png"/></a>
            <div class="row m-n">
                <div class="col-md-4 col-md-offset-4 m-t-lg" style="width: 700px;min-width: 700px;max-width: 700px;">
                    <section class="panel">
                        <header style="background:#006fc4;" class="panel-heading bg bg-primary text-center">
                            Redefina sua senha para o <?php echo $sitename; ?>
                        </header>
                        <form method="post" action="" class="panel-body">
                            <?php if(isset($msg_type)){ ?>
                            <div class="alert alert-<?php echo $msg_type; ?>">
                                <?php echo $msg_echo; ?>
                            </div>
                            <?php } ?>
                            <div class="form-group" id="regkekonomgroup">
                                <label class="control-label">Nome de usuário do <?php echo $shortname; ?></label>
                                <input type="text" name="username" placeholder="Escreva o nome que você utiliza dentro do <?php echo $shortname; ?>" class="form-control">
                            </div>
                            <div class="form-group" id="regusernamegroup">
                                <label class="control-label">Seu e-mail</label>
                                <input type="email" name="mail" placeholder="Insira seu e-mail atual aqui" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-info">Enviar redinição de senha</button>
                            <a href="javascript:history.back(1)" class="btn btn-danger" style="float:right;">Cancelar</a>
                            <input type="hidden" id="hidden" name="action" value="pass_send" />
                        </form>
                    </section>
                </div>
            </div>
        </section>
        <!-- footer -->
        <!-- / footer -->
        <script src="web-gallery/js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="web-gallery/js/bootstrap.js"></script>
        <!-- app -->
        <script src="web-gallery/js/app.js"></script>
        <script src="web-gallery/js/app.plugin.js"></script>
        <script src="web-gallery/js/app.data.js"></script>
        <div id="etrack"></div>
    </body>
</html>