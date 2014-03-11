<?php
require_once('data-classes/data-classes-core-index.php');
include_once("./sys_email_sender/class.phpmailer.php");

$pagename = "Esqueci a Senha";

if (isset($_POST['actionForgot'])) {
    $username = FilterText($_POST['forgottenpw-username']);
    $email = FilterText($_POST['forgottenpw-email']);
    $captcha = FilterText($_POST['forgottenpw-captcha']);

    $sql = mysql_query("SELECT * FROM users WHERE username = '" . $username . "' AND mail = '" . $email . "'") or die(mysql_error());
    $row = mysql_num_rows($sql);
    $row2 = mysql_fetch_assoc($sql);
    if ((!$username) || (!$email) || (!$captcha) || $_SESSION['register-captcha-bubble'] !== strtolower($_POST['forgottenpw-captcha']) || empty($_SESSION['register-captcha-bubble'])) {
        $result = "Preencha todos os campos corretamente.";
    } elseif ($row > 0) {
        unset($_SESSION['register-captcha-bubble']);
        $remail = $row2['mail'];
        $caracters = 'abcdxywzABCDZYWZ0123456789';
        $max = strlen($caracters) - 1;
        for ($i = 0; $i < 18; $i++) {
            $code .= $caracters{mt_rand(0, $max)};
        }
        mysql_query("INSERT INTO password_recovery(username,mail,code,timestamp) VALUES('$username','$remail','$code', '$date_normal')") or die(mysql_error());
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
            <h1 style='font-size: 16px'>Sua nova senha no Forever Hotel:</h1>
            <p>
            <br />
            Ol&aacute; <b>" . $username . "</b>, para redefinir sua senha, acesse o link abaixo:<br />
            <a href='" . $path . "/forgot/verify/" . $code . "'>" . $path . "/forgot/verify/" . $code . "</a>
            <br />
            <br />Ap&oacute;s redefini-la, altere-a em nosso site ao fazer login, e anote-a tamb&eacute;m. 
            <br />Tenha um bom jogo!
            <br />
            <br />
            <br /><b>Equipe Forever</b>
            <br />
            <br /><h1 style='font-size: 10px'>Caso n&atilde;o tenha feito um pedido para altera&ccedil;&atilde;o de senha desconsidere essa mensagem ou entre em contato conosco clicando em <b>Contate-nos</b> na p&aacute;gina principal.</h1>
            </p>	
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
        $mail->Username = "mailings@foreverhotel.com.br";
        $mail->Password = "bo4387fg34if837f4b3yyud";
        $mail->SetFrom('mailings@foreverhotel.com.br', 'Forever Hotel'); // e-mail do remetente e seu nome/apelido
        $mail->AddReplyTo("mailings@foreverhotel.com.br", "Forever Hotel"); // e-mail de resposta do e-mail que enviaremos. Ou seja, quando algu�m responder a este e-mail, responder� para o e-mail aqui configurado ....e o nome/apelido do mesmo
        $mail->Subject = "Sua nova senha no Forever Hotel"; // Assunto do e-mail
        $mail->AltBody = "Para visualizar a mensagem, por favor, use um cliente de e-mail compat�vel/configurado para ver mensagens HTML!"; // Mensagem alternativa caso o destinat�rio. Veja o e-mail em um aplicativo sem suporte ou n�o configurado para ver mensagens HTML
        $mail->MsgHTML($body);
        $endereco = $remail;
        $mail->AddAddress($endereco, $endereco);
        if (!$mail->Send()) {
            $result = "Houve um erro, tente novamente mais tarde!";
        } else {
            $result = "Um link de redefini&ccedil;&atilde;o de senha foi enviado para seu e-mail.";
        }
    } else {
        $result = "Seu nome de usu&aacute;rio n&atilde;o coincide com o e-mail.";
    }
}
?>
<?php
require_once('../sys_templates/tpl_login_subheader.php');
?>
<style type="text/css"> 
    div.left-column { float: left; width: 48% }
    div.right-column { float: right; width: 47% }
    label { display: block }
    input { width: 98% }
    input.process-button { width: auto; float: right }
    div.box-content { padding: 15px 8px; }
    div.right-column p { color: gray; }
    div.right-column .habbo-id-logo { background: transparent url(<?php echo $path; ?>/web-gallery/v2/images/registration/Habbo_ID_logo_white.png) no-repeat; padding-top: 2px; height: 35px; width: 124px; float:right; }
    div.divider {background: transparent url(<?php echo $path; ?>/web-gallery/v2/images/shared_icons/line_gray.png) repeat-y; width: 1px; height: 130px; float:left; margin: 1px 15px 20px;}
</style> 

</head>
<body id="" class="process-template secure-page">

    <div id="overlay"></div>

    <div id="container">
        <div class="cbb process-template-box clearfix">

            <div id="content">
                <div id="header" class="clearfix">
                    <h1><a href="<?php echo $path; ?>"></a></h1>

                </div>
                <div id="process-content">

<?php if (!empty($result)) { ?>
                        <div class="cbb clearfix white">
                            <div class="box-content">

                                <p><?php echo "<div align='center'><b>" . $result . "</b></div>"; ?></p>

                            </div>
                        </div>
<?php } ?>
                    <div class="cbb clearfix"> 
                        <h2 class="title">Esqueceu a senha da sua conta Forever?</h2> 
                        <div class="box-content"> 
                            <div class="left-column"> 

                                <p>N�o entre em p�nico! Enviaremos um email contendo um link para que voc� podessa trocar sua senha.</p> 

                                <div class="clear"></div> 

                                <form method="post" action="forgot" id="forgottenpw-form"> 
                                    <p> 
                                        <label for="forgottenpw-username">Nome Forever:</label> 
                                        <input type="text" name="forgottenpw-username" id="forgottenpw-username"  value="<?php echo Filtertext($_POST['forgottenpw-username']); ?>"/> 
                                    </p> 

                                    <p> 
                                        <label for="forgottenpw-email">Endere�o de Email:</label> 
                                        <input type="text" name="forgottenpw-email" id="forgottenpw-email" value="<?php echo Filtertext($_POST['forgottenpw-email']); ?>"/> 
                                    </p> 

                                    <p>
                                        <img src="<?php echo $path; ?>/captcha" /><br>
                                        <label for="forgottenpw-captcha">Por favor, digite o c�digo de seguran�a:</label> 
                                        <input type="text" name="forgottenpw-captcha" size="10" maxlength="10" value="<?php echo FilterText($_POST['forgottenpw-captcha']); ?>" />
                                    </p> 

                                    <p> 
                                        <input type="submit" value="Solicitar uma nova senha" name="actionForgot" class="submit process-button" id="forgottenpw-submit" /> 
                                    </p> 
                                    <input type="hidden" value="default" name="origin" /> 
                                </form> 
                            </div> 
                            <div class="divider"></div> 
                            <div class="right-column"> 
                                <p><b>Senha Segura!</b></p> 
                                <p>A escolha de uma senha segura � inteligente. Com uma senha segura, voc� est� previnido de v�rios problemas, como: roubo, hackers, spam etc.<br>Para criar uma senha segura, misture letras e n�meros, e nunca use informa��es pessoais. Lembre-se, senha � intransfer�vel, guarde-a e n�o passe a ningu�m.</p> 
                            </div> 
                        </div> 
                    </div> 


                    <p><a href="<?php echo $path; ?>/">Voltar ao Site &raquo;</a></p> 
                    <div class="clear"></div> 

<?php
require('../sys_templates/tpl_login_footer.php');
?>
