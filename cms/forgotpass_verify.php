<?php

require_once('../sys_configs/sys_data_core.php');
include_once("../sys_email_sender/class.phpmailer.php");

if($logged_in){
	header("Location: ".$path."/me");
	exit;
}
	
$pagename = "Esqueci a Senha";
$pageid = "13";

    $code = FilterText($_GET['code']);
    $sql = mysql_query("SELECT * FROM password_recovery WHERE code = '".$code."'");
    $row = mysql_num_rows($sql);
    $row2 = mysql_fetch_assoc($sql);
    $array = mysql_fetch_array($sql);
    $password = FilterText($_POST['forgottenpw-password']);
    $retypedPassword = FilterText($_POST['forgottenpw-retypedpassword']);
    $sds = explode("/", $row2['timestamp']);

    $vday = $sds[0];
    $vmonth = $sds[1];

    if($row > 0 && $vday == $d && $vmonth == $m){
        $form_ok = "1";
    }else{
	    $form_ok = "0";
    }
	if($form_ok == "1"){
	        $result = "       <form method=\"post\" action=\"$code\" id=\"forgottenpw-form\"> 
            <p> 
            <label for=\"forgottenpw-password\">Nova Senha:</label> 
            <input type=\"password\" name=\"forgottenpw-password\" id=\"forgottenpw-password\"  value=\"\"/> 
            </p> 
 
            <p> 
            <label for=\"forgottenpw-retypedpassword\">Repita a Senha:</label> 
            <input type=\"password\" name=\"forgottenpw-retypedpassword\" id=\"forgottenpw-retypedpassword\" value=\"\"/> 
            </p> 
 
            <p> 
            <input type=\"submit\" value=\"Alterar Senha\" name=\"actionForgot\" class=\"submit process-button\" id=\"forgottenpw-submit\" /> 
            </p> 
            <input type=\"hidden\" value=\"default\" name=\"origin\" /> 
        </form> 
        ";
	}else{
        mysql_query("DELETE FROM password_recovery WHERE code='".$code."'") or die(mysql_error());
	$result = "<b>Este c&oacute;digo j&aacute; foi utilizado / n&atilde;o existe / não é mais válido em nosso sistema.</b>";
	}
	
if(isset($_POST['actionForgot'])){
	
	if((!$password) || (!$retypedPassword)){
     $return2 =  "<b>Preencha os campos.</b>";
    }
    elseif($password != $retypedPassword){
        $return2 = "<b>As senhas inseridas n&atilde;o conhecidem, digite-as novamente.</b>";
    }else{
		if($form_ok == "1"){
			mysql_query("UPDATE users SET password = '".ForeverHash($password)."' WHERE username = '".$array['username']."'") or die(mysql_error());
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
            <img src='".$webgallery."/v2/images/habbologo_whiteR.gif' alt='Forever Hotel' />
            </div>
            <div style='padding: 14px 14px 50px 14px; background-color: #e3e3db;'>	
            <div style='background-color: #fff; padding: 14px; border: 1px solid #ccc'>
            <h1 style='font-size: 16px'>Sua senha foi alterada no Forever Hotel:</h1>
            <p>
            <br />
            Ol&aacute; <b>".$array['username']."</b>, sua senha foi redefinida com sucesso!<br />
            <br />
            <br />Ap&oacute;s redefini-la, altere-a em nosso site ao fazer login, e anote-a tamb&eacute;m. 
            <br />Tenha um bom jogo!
            <br />
            <br />
            <br /><b>Equipe Forever</b>
            <br />
            <br /><h1 style='font-size: 10px'>Caso n&atilde;o tenha trocado sua senha entre em contato conosco urgentemente clicando em <b>Contate-nos</b> na p&aacute;gina principal.</h1>
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
        $mail->Username = "phpsender@foreverhotel.com.br";
        $mail->Password = "bo4387fg34if837f4b3yyud";
        $mail->SetFrom('mailings@foreverhotel.com.br', 'Forever Hotel'); // e-mail do remetente e seu nome/apelido
        $mail->AddReplyTo("mailings@foreverhotel.com.br","Forever Hotel"); // e-mail de resposta do e-mail que enviaremos. Ou seja, quando alguém responder a este e-mail, responderá para o e-mail aqui configurado ....e o nome/apelido do mesmo
        $mail->Subject = "Sua senha foi alterada no Forever Hotel"; // Assunto do e-mail
        $mail->AltBody = "Para visualizar a mensagem, por favor, use um cliente de e-mail compatível/configurado para ver mensagens HTML!"; // Mensagem alternativa caso o destinatário. Veja o e-mail em um aplicativo sem suporte ou não configurado para ver mensagens HTML
        $mail->MsgHTML($body);
        $endereco = $array['mail'];
        $mail->AddAddress($endereco, $endereco);
        if(!$mail->Send()) {
                $return2 =  "<b>Sua senha foi alterada com sucesso!</b>";
        }else {
                $return2 =  "<b>Sua senha foi alterada com sucesso!</b>";
        }
			$return2 =  "<b>Sua senha foi alterada com sucesso!</b>";
			mysql_query("DELETE FROM password_recovery WHERE code='".$code."'") or die(mysql_error());
		}else{
			$return2 = "<b>Sua senha já foi alterada!</b>";
		}
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
        div.right-column .habbo-id-logo { background: transparent url(<?php echo $webgallery; ?>/v2/images/registration/Habbo_ID_logo_white.png) no-repeat; padding-top: 2px; height: 35px; width: 124px; float:right; }
        div.divider {background: transparent url(<?php echo $webgallery; ?>/v2/images/shared_icons/line_gray.png) repeat-y; width: 1px; height: 130px; float:left; margin: 1px 15px 20px;}
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

<div class="cbb clearfix"> 
    <h2 class="title">Redefina sua Senha Forever</h2> 
    <div class="box-content"> 
      <div class="left-column"> 
 
        <div class="clear"></div>
 <?php if(!empty($result)){ ?>


<?php echo $result ."<br /><br />". $return2; ?>

<?php } ?>

      </div> 
      <div class="divider"></div> 
      <div class="right-column"> 
          <p><b>Senha Segura!</b></p> 
          <p>A escolha de uma senha segura é inteligente. Com uma senha segura, você está previnido de vários problemas, como: roubo, hackers, spam etc.<br>Para criar uma senha segura, misture letras e números, e nunca use informações pessoais. Lembre-se, senha é intransferível, guarde-a e não passe a ninguém.</p> 
      </div> 
    </div> 
</div> 
 
 
  <p><a href="<?php echo $path; ?>/">Voltar ao Site &raquo;</a></p> 
  <div class="clear"></div> 

<?php
require('../sys_templates/tpl_login_footer.php');
?>
