<?php
include_once("./data-classes/data-classes-core-index.php");

if(isset($_SESSION['username'])){
    header("Location:". $cms_url . "/me");
    exit;
}

if($register_enable == false){
    header("Location:". $cms_url . "/index");
    exit;
}

$randomico = rand(1000000, 9999999);

if (isset($_POST['reg_submit'])) {
    $username = FilterText($_POST['username']);
    $password = HoloHashMD5($_POST['password']);
    $mail     = FilterText($_POST['mail']);
    $regdia   = FilterText($_POST['regdia']);
    $regmes   = FilterText($_POST['regmes']);
    $regano   = FilterText($_POST['regano']);
    $gender   = FilterText($_POST['gender']);
    $n_rand   = FilterText($_POST['n_rand']);
    $s_rand   = FilterText($_POST['s_rand']);
    $filter   = preg_match("/^([a-zA-Z0-9]+)$/", $username);
    
    $verificafake = mysql_query("SELECT * FROM users WHERE ip_last='". $remote_ip ."' OR ip_reg='". $remote_ip ."'") or die(mysql_error());
    $verificauser = mysql_query("SELECT * FROM users WHERE username='". $username ."'") or die(mysql_error());
    $verificamail = mysql_query("SELECT * FROM users WHERE mail='". $mail ."'") or die(mysql_error());

    if ($n_rand != $s_rand) {
        $msg_type = "error";
        $msg_echo = "Código inválido, por favor escreva corretamente o código exibido";
    } elseif($filter != true){
        $msg_type = "error";
        $msg_echo = "Seu nome de usuário possui caracteres inválidos";
    } elseif((!$username) || (!$password) || (!$mail) || (!$regdia) || (!$regmes) || (!$regano) || (!$n_rand)){
        $msg_type = "error";
        $msg_echo = "Preencha todos os campos para realizar o cadastro";
    } elseif (mysql_num_rows($verificafake) > 1) {
        $msg_type = "error";
        $msg_echo = "Você já possui duas contas neste IP, por isso não poderá criar outra";
    } elseif (mysql_num_rows($verificamail) > 0){
        $msg_type = "error";
        $msg_echo = "Este e-mail já esta sendo utilizado";
    } elseif (mysql_num_rows($verificauser) > 0){
        $msg_type = "error";
        $msg_echo = "Este nome de usuário já está sendo utilizado";
    } else {
        $birthday = $regdia."/".$regmes."/".$regano;
        mysql_query("INSERT INTO `users`(username,birthday,password,auth_ticket,motto,mail,rank,look,gender,account_created,last_online,online,ip_last,ip_reg) VALUES ('". $username ."', '". $birthday ."', '". $password ."', '-/-', 'Bem-vindo ao ". $sitename ."', '". $mail ."', '1', 'ch-215-62.hd-180-7.lg-270-64.sh-300-62.hr-100-1354', '". $gender ."', '". $date_full ."','" . date('d/m/Y - H:i:s') . "', '1', '" . $remote_ip . "','" . $remote_ip . "')") or die(mysql_error());
        $userdata2 = mysql_query("SELECT * FROM users WHERE username = '". $username ."'");
        $userdata = mysql_fetch_assoc($userdata2);

        mysql_query("INSERT INTO `user_info` (user_id,reg_timestamp) VALUES ('". $userdata['id'] ."','". time() ."')");
        mysql_query("INSERT INTO `user_stats` (id) VALUES ('". $userdata['id'] ."')");

        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        header("Location: ". $cms_url ."/me");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $sitename; ?> - Crie sua conta</title>
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
                            Cadastre-se no <?php echo $sitename; ?>
                        </header>
                        <form method="post" action="" class="panel-body">
                            <?php if(isset($msg_type)){ ?>
                            <div class="alert alert-error" id="regerrors">
                                <span><?php echo $msg_echo; ?></span>
                            </div>
                            <?php } ?>
                            <div class="form-group" id="regkekonomgroup">
                                <label class="control-label">Nome de usuário do <?php echo $shortname; ?></label>
                                <input type="text" name="username" placeholder="Escreva o nome que você utilizará dentro do <?php echo $shortname; ?>" class="form-control">
                            </div>
                            <div class="form-group" id="regusernamegroup">
                                <label class="control-label">Seu e-mail</label>
                                <input type="email" name="mail" placeholder="Insira seu e-mail atual aqui" class="form-control">
                            </div>
                            <div class="form-group" id="regpasswordgroup">
                                <label class="control-label">Sua senha</label>
                                <input type="password" name="password" placeholder="Escolha uma senha para seu <?php echo $shortname; ?>" class="form-control">
                            </div>

                            <div class="control-group" id="regfechagroup">
                                <label class="control-label">Data de Nascimento:</label>
                                <div class="controls">
                                    <div class="input-icon left" style="width: 90px; float: left;">
                                        <select name="regdia" id="regdia" class="form-control" style="width: 90px;"><option value="-1" selected>Dia:</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> 
                                    </div>

                                    <div class="input-icon" style="width: 90px; float: left; margin-left:2px;">
                                        <select name="regmes" id="regmes" class="form-control" style="width: 90px;"><option value="-1" selected>Mês:</option>
                                            <option value="1">Janeiro</option>
                                            <option value="2">Fevereiro</option>
                                            <option value="3">Março</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Maio</option>
                                            <option value="6">Junho</option>
                                            <option value="7">Julho</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option></select>
                                    </div>  <div class="input-icon" style="width: 90px;float: left; margin-left:2px;">
                                        <select name="regano" id="regano" class="form-control" style="width: 90px;"><option value="-1" selected>Ano:</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option></select>
                                    </div>
                                </div>
                            </div><br /><br />
                            <div class="control-group">
                                <label class="control-label" class="control-label visible-ie8 visible-ie9"></label>
                                <div class="controls">
                                    <div class="btn-group" data-toggle="buttons" style="margin-top:10px;">
                                        <label class="btn btn-danger">
                                            <input type="radio" name="gender" value="F" id="option1"> Mulher
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" name="gender" value="M" id="option2"> Homem
                                        </label>
                                    </div>
                                </div>
                            </div><br />
                            <div style="border:solid 1px #717171; width:170px; height:50px; font-size:30px; padding:2px; text-align:center;"><?php echo $randomico; ?></div><br />
                            <div class="form-group" id="regusernamegroup">
                                <label class="control-label">Insira o texto exibido à cima</label>
                                <input type="text" name="n_rand" placeholder="Insira aqui o texto mostrado à cima" class="form-control" />
                                <input type="hidden" name="s_rand" value="<?php echo $randomico; ?>" />
                            </div>
                            <div class="control-group" id="regtermsgroup">
                                Ao criar sua conta, você estará aceitando o <a target="_blank" href="http://www.factoryhotel.com.br/contrato_de_licensa_de_uso.docx" target="_blank"><b>termos e condições de uso</b></a>.
                            </div>
                            <br />
                            <button type="submit" name="reg_submit" class="btn btn-info">Concluir Cadastro</button>
                            <div class="line line-dashed"></div>
                            <p class="text-muted text-center"><small>Já possui uma conta?</small></p>
                            <a href="./" class="btn btn-white btn-block">Clique aqui e faça o login</a>
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