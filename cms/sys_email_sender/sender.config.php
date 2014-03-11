<?php

require_once('./sys_configs/sys_data_core.php');
require_once('./sys_email_sender/class.phpmailer.php');

$mail = new PHPMailer();
$mail->SetLanguage('br');
$body = '<html>
<head>
<style type="text/css">
a { color: #fc6204; }
</style>
</head>
<body style="background-color: #e3e3db; margin: 0; padding: 0; font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000;">
<div style="background-color: #bce0ee; padding: 14px; border-bottom: 3px solid #000;">	
<img src="http://foreverhotel.com.br/web-gallery/v2/images/habbologo_whiteR.gif" alt="Forever Hotel" />
</div>
<div style="padding: 14px 14px 50px 14px; background-color: #e3e3db;">	
<div style="background-color: #fff; padding: 14px; border: 1px solid #ccc">
<h1 style="font-size: 16px">Sua nova senha no Forever Hotel:</h1>

	<p>
	<br />
	Olá <b><?php echo $forgot_name; ?></b>, sua nova senha foi trocada para:<br /><b><?php echo $sql_row[\'\password\'\]; ?></b>
	<br />Altere-a ao fazer login no site, e anote também. 
	<br />Tenha um bom jogo!
	<br />
	<br />
	<br />Equipe Forever
	<br />
	<br /><h1 style="font-size: 10px">Caso não tenha feito um pedido para alteração de senha desconsidere essa mensagem ou entre em contato conosco clicando em <b>Contate-nos</b> na página principal.</h1>
	</p>	
	</div>	
	<div style="padding: 14px 0; text-align: center; font-size: 10px;"> <?php echo $row[\'\value\'\]; ?>
	</div>
	</div>
	</body>
	</html>
	'; 
	
$mail->IsSMTP(); // Configura o objeto para usar SMTP
$mail->SMTPDebug = 2; // Debug do SMTP (para teste)
$mail->SMTPAuth = true; // ativa a autenticação SMTP. O Gmail exige autenticação, precisamos disso
$mail->SMTPSecure = "ssl"; // Configura o tipo de criptografia do SMTP do Gmail, no caso, SSL
$mail->Host = "smtp.gmail.com"; // Configura servidor SMTP do Gmail
$mail->Port = 465; // Configura porta do servidor SMTP do Gmail
$mail->Username = "joaocovaes@gmail.com.br"; // Seu Usuário do Gmail
$mail->Password = "1Px52b5i!"; // Sua Senha do Gmail
$mail->SetFrom('noreply@factoryhotel.com.br', 'The Factory'); // e-mail do remetente e seu nome/apelido
$mail->AddReplyTo("noreply@factoryhotel.com.br","The Factory"); // e-mail de resposta do e-mail que enviaremos. Ou seja, quando alguém responder a este e-mail, responderá para o e-mail aqui configurado ....e o nome/apelido do mesmo
$mail->Subject = "Sua nova senha no Forever Hotel"; // Assunto do e-mail
$mail->AltBody = "Para visualizar a mensagem, por favor, use um cliente de e-mail compatível/configurado para ver mensagens HTML!"; // Mensagem alternativa caso o destinatário. Veja o e-mail em um aplicativo sem suporte ou não configurado para ver mensagens HTML
$mail->MsgHTML($body);
$endereco = "wallacecalvet@hotmail.com";
$mail->AddAddress($endereco, $endereco); // e-mail do destinatário e seu nome/apelido
#$mail->AddAttachment("images/anexo-1.gif"); // caso queira enviar um anexo no e-mail
if(!$mail->Send()) {
	echo "Erro: " . $mail->ErrorInfo;
}else {
	echo "Mensagem Enviada!";
}

?>