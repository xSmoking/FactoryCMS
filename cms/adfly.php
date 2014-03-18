<?php 

function generarPassword($longitud)
{
 $pass_width = $longitud;
 $pass_chars = '1234567890';
 $pass_new = '';
 for ( $i = 0 ; $i < $pass_width ; $i++ ){
  $pass_ctrl = rand(0,strlen($pass_chars) - 1);
  $pass_new .= $pass_chars[$pass_ctrl];
 }
 return $pass_new;
}

if($_SERVER['HTTP_REFERER'] != "http://adf.ly/IF2So"){
  $gen = generarPassword(devil);
  $_SESSION['pin'] = $gen;
  $connect->query("UPDATE users SET pin = '".$gen."' WHERE id = '$my_id'");
  Header("Location: http://adf.ly/IF2So");
  die();
}

if($_SESSION['pin'] == $myrow['pin']){
 $_SESSION['pin'] = "";
 $connect->query("UPDATE users SET pin = '' id = '$my_id'");
}
else
{
  $gen = generarPassword(devil);
  $_SESSION['pin'] = $gen;
  $connect->query("UPDATE users SET pin = '".$gen."' WHERE id = '$my_id'");
  Header("Location: http://adf.ly/IF2So");
  die();
}

?>