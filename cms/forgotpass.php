<?php
include_once("./data-classes/data-classes-core-index.php");
include_once("./phpmailer/class.phpmailer.php");

if(isset($_SESSION['username'])){
    header("Location:". $cms_url . "/me");
    exit;
}

if ($_POST['action'] == "pass_send") {
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();

    // Define os dados do servidor e tipo de conexão
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    //$mail->Host = "localhost"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
    $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
    $mail->Username = 'joaocovaes@gmail.com'; // Usuário do servidor SMTP (endereço de email)
    $mail->Password = '1Px52b5i!'; // Senha do servidor SMTP (senha do email usado)

    // Define o remetente
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->From = "joaocovaes@gmail.com"; // Seu e-mail
    $mail->Sender = "joaocovaes@gmail.com"; // Seu e-mail
    $mail->FromName = "The Factory"; // Seu nome

    // Define os destinatário(s)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->AddAddress('joaocovaes@gmail.com', 'Teste Locaweb');
    $mail->AddAddress('joaocovaes@gmail.com');

    // Define os dados técnicos da Mensagem
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

    // Define a mensagem (Texto e Assunto)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->Subject  = "Retrive Password"; // Assunto da mensagem
    $mail->Body = 'Este é o corpo da mensagem de teste, em HTML! 
     <IMG src="http://seudomínio.com.br/imagem.jpg" alt=":)"   class="wp-smiley"> ';
    $mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
    <IMG src="http://seudomínio.com.br/imagem.jpg" alt=":)"  class="wp-smiley"> ';

    // Envia o e-mail
    $enviado = $mail->Send();

    // Limpa os destinatários e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    // Exibe uma mensagem de resultado
    if ($enviado) {
    echo "E-mail enviado com sucesso!";
    } else {
    echo "Não foi possível enviar o e-mail.

    ";
    echo "Informações do erro: 
    " . $mail->ErrorInfo;
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