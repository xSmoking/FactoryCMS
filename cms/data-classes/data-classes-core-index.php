<?php
include_once("data-classes-config.php");
session_start();

// #########################################################################
// Configurações da CMS
// #########################################################################

// Takes the data from database
$settings_cms_url = $connect->query("SELECT * FROM cms_settings WHERE variable = 'cms_url'") or die($connect->error());
$settings_cms_url_array = $settings_cms_url->fetch_assoc();
$settings_shortname = $connect->query("SELECT * FROM cms_settings WHERE variable = 'shortname'") or die($connect->error());
$settings_shortname_array = $settings_shortname->fetch_assoc();
$settings_site_name = $connect->query("SELECT * FROM cms_settings WHERE variable = 'site_name'") or die($connect->error());
$settings_site_name_array = $settings_site_name->fetch_assoc();
$settings_facebook = $connect->query("SELECT * FROM cms_settings WHERE variable = 'facebook'") or die($connect->error());
$settings_facebook_array = $settings_facebook->fetch_assoc();
$settings_twitter = $connect->query("SELECT * FROM cms_settings WHERE variable = 'twitter'") or die($connect->error());
$settings_twitter_array = $settings_twitter->fetch_assoc();
$settings_swfpatch = $connect->query("SELECT * FROM cms_settings WHERE variable = 'swf_patch'") or die($connect->error());
$settings_swfpacth_array = $settings_swfpatch->fetch_assoc();
$settings_client_ip = $connect->query("SELECT * FROM cms_settings WHERE variable = 'client_ip'") or die($connect->error());
$settings_client_ip_array = $settings_client_ip->fetch_assoc();
$settings_client_port = $connect->query("SELECT * FROM cms_settings WHERE variable = 'client_port'") or die($connect->error());
$settings_client_port_array = $settings_client_port->fetch_assoc();
$settings_mus_port = $connect->query("SELECT * FROM cms_settings WHERE variable = 'client_mus'") or die($connect->error());
$settings_mus_port_array = $settings_mus_port->fetch_assoc();
$settings_maintenance = $connect->query("SELECT * FROM cms_settings WHERE variable = 'maintenance'") or die($connect->error());
$settings_maintenance_array = $settings_maintenance->fetch_assoc();
$settings_cms_register = $connect->query("SELECT * FROM cms_settings WHERE variable = 'cms_register'") or die($connect->error());
$settings_cms_register_array = $settings_cms_register->fetch_assoc();

date_default_timezone_set('America/Sao_Paulo');

$H = date('H');
$i = date('i');
$s = date('s');
$m = date('m');
$d = date('d');
$Y = date('Y');
$j = date('j');
$n = date('n');
$sitename = $settings_site_name_array['value'];
$shortname = $settings_shortname_array['value'];
$cms_url = $settings_cms_url_array['value']; // site do hotel
$swf_patch = $settings_swfpacth_array['value']; // raiz da SWF
$adminpath = $settings_cms_url_array['value']."/system"; // site do hotel /system (acesso ou housekeeping)
$facebook = $settings_facebook_array['value']; // página do facebook
$twitter = $settings_twitter_array['value']; // página do twitter
$client_ip = $settings_client_ip_array['value']; // client ip
$client_port = $settings_client_port_array['value']; // client port
$mus_port = $settings_mus_port_array['value'];
$maintenance = $settings_maintenance_array['value'];
$register_enable = $settings_cms_register_array['value'];
$remote_ip = $_SERVER['REMOTE_ADDR'];
$date_normal = date("d/m/Y");
$date_simple = date("d/m");
$date_normal2 = date('d.m.Y', mktime($m, $d, $Y));
$date_full = date("d/m/Y H:i:s");

$system_sql = $connect->query("SELECT * FROM server_status LIMIT 1") or die($connect->error());
$system = $system_sql->fetch_assoc();

// #########################################################################
// Funções necessárias
// #########################################################################

function FilterText($str, $advanced = false) {
    global $connect;
    if ($advanced == true) {
        $str = $connect->real_escape_string($str);
        return $str;
    }
    $str = $connect->real_escape_string(htmlspecialchars($str));
    return $str;
}

function HoloHashMD5($password) {
    $hash_secret = "kasa%&(!kaskHAO)&!aksPL5645Sdsd54!&*(%";
    $string = md5($password . ($hash_secret));
    return $string;
}

function HoloText($str, $advanced = false, $bbcode = false) {
    if ($advanced == true) {
        return stripslashes($str);
    }
    $str = nl2br(htmlspecialchars($str));
    if ($bbcode == true) {
        $str = bbcode_format($str);
    }
    return $str;
}

function geraSenha($tamanho = 10, $maiusculas = true, $numeros = true, $simbolos = false){
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%&*-()';
    $retorno = '';
    $caracteres = '';

    $caracteres .= $lmin;
    if ($maiusculas) $caracteres .= $lmai;
    if ($numeros) $caracteres .= $num;
    if ($simbolos) $caracteres .= $simb;

    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++){
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
}

// #########################################################################
// F�R LOGIN_TICKET
// #########################################################################

function GenerateTicket() {
    $data = "ST-";
    for ($i = 1; $i <= 6; $i++) {
        $data = $data . rand(0, 9);
    }
    $data = $data . "-";
    for ($i = 1; $i <= 20; $i++) {
        $data = $data . rand(0, 9);
    }
    $data = $data . "-factory-";
    $data = $data . rand(0, 5);
    return $data;
}

// #########################################################################
// FUNCTION MUS COMMAND
// #########################################################################

function sendMusCommand($server_ip, $command, $data=NULL, $port=30001){
    $data = $command . chr(1) . $data;
    $connection = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
    socket_connect($connection, $server_ip, $port);
    if(!is_resource($connection)){
        return false;
    }
    else{
        socket_send($connection, $data, strlen($data), MSG_DONTROUTE);
        return true;
    }
    socket_close($connection);
}
?>
