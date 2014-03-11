<?php
require_once('../data-classes/data-classes-core.php');
if(!isset($_SESSION['username'])){
	header("Location: http://factoryhotel.com.br");
}
?>
<html>
<head>
    <title>Factory Hotel - Quartos</title>
    <link rel="stylesheet" href="<?php echo $pasta; ?>web-files/css/estrutura.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $pasta; ?>web-files/css/estilo.css" type="text/css" />
</head>
<body>
    <div id="wrap-site">
        <div id="wrap-topo">
            <div id="topo">Comprar Quarto</div>
        </div>
        