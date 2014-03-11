<?php
include_once("data-classes-config.php");
session_start();

// #########################################################################
// Configurações da CMS
// #########################################################################

// Takes the data from database
$settings_cms_url = mysql_query("SELECT * FROM cms_settings WHERE variable = 'cms_url'") or die(mysql_error());
$settings_cms_url_array = mysql_fetch_array($settings_cms_url);
$settings_shortname = mysql_query("SELECT * FROM cms_settings WHERE variable = 'shortname'") or die(mysql_error());
$settings_shortname_array = mysql_fetch_array($settings_shortname);
$settings_site_name = mysql_query("SELECT * FROM cms_settings WHERE variable = 'site_name'") or die(mysql_error());
$settings_site_name_array = mysql_fetch_array($settings_site_name);
$settings_facebook = mysql_query("SELECT * FROM cms_settings WHERE variable = 'facebook'") or die(mysql_error());
$settings_facebook_array = mysql_fetch_array($settings_facebook);
$settings_twitter = mysql_query("SELECT * FROM cms_settings WHERE variable = 'twitter'") or die(mysql_error());
$settings_twitter_array = mysql_fetch_array($settings_twitter);
$settings_swfpatch = mysql_query("SELECT * FROM cms_settings WHERE variable = 'swf_patch'") or die(mysql_error());
$settings_swfpacth_array = mysql_fetch_array($settings_swfpatch);
$settings_cms_register = mysql_query("SELECT * FROM cms_settings WHERE variable = 'cms_register'") or die(mysql_error());
$settings_cms_register_array = mysql_fetch_array($settings_cms_register);

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
$register_enable = $settings_cms_register_array['value']; // criar contar - true ou false
$remote_ip = $_SERVER['REMOTE_ADDR'];
$date_normal = date("d/m/Y");
$date_simple = date("d/m");
$date_normal2 = date('d.m.Y', mktime($m, $d, $Y));
$date_full = date("d/m/Y H:i:s");

$system_sql = mysql_query("SELECT * FROM server_status LIMIT 1") or die(mysql_error());
$system = mysql_fetch_array($system_sql);

// #########################################################################
// Funções necessárias
// #########################################################################

function FilterText($str, $advanced = false) {
    if ($advanced == true) {
        return mysql_real_escape_string($str);
    }
    $str = mysql_real_escape_string(htmlspecialchars($str));
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

$settings_client_ip = mysql_query("SELECT * FROM cms_settings WHERE variable = 'client_ip'") or die(mysql_error());
$settings_client_ip_array = mysql_fetch_array($settings_client_ip);

$server_ip = $settings_client_ip_array['value'];

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
