<?php
 
if(empty($_SESSION['username']))
{ 

header("Location: $cms_url"); exit; 

} 

?>