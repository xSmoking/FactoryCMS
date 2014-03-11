<?php
include_once("./data-classes/data-classes-core.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=10" />
        <meta name="description" content="ciudad virtual, chat 3d, chat con avatares, amigos online, juego online, jugar, red social, jovenes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="web-gallery/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/font.css" type="text/css" cache="false" />
        <link rel="stylesheet" href="web-gallery/css/plugin.css" type="text/css" />
        <link rel="stylesheet" href="web-gallery/css/app.css" type="text/css" />
        <link rel="shortcut icon" href="web-gallery/images/ico.png"/>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <!--[if lt IE 9]>
          <script src="js/ie/respond.min.js" cache="false"></script>
          <script src="js/ie/html5.js" cache="false"></script>
          <script src="js/ie/fix.js" cache="false"></script>
        <![endif]-->
        <style>
            .contenidoal {
                padding:7px;
                background:url('http://kekocity.es/maskeko/images/fondonav2.png');
                border-radius: 12px;
                -webkit-border-radius: 12px;
                -moz-border-radius: 12px;
                height:90px;
            }
        </style>
        <script type="text/javascript">
            var yaholaS = false;
            var holaS = function() {
                yaholaS = true;
                var vesur = "http://server.factoryhotel.com.br/loading";
                var myWindow = window.open(vesur, 'Factory', 'location=no,directories=no,status=no,toolbar=no,menubar=no,width=1200,resizable=yes,height=800');
            }

            function Alert($mensagem) {
                alert($mensagem);
            }
            
            $(document).ready(function(){
                $('#alert1').show();
                $('#close1').click(function(event){
                    event.preventDefault();
                    $("#alert1").hide("slow");
                });
            });
            
            $(document).ready(function(){
                $('#alert2').show();
                $('#close2').click(function(event){
                    event.preventDefault();
                    $("#alert2").hide("slow");
                });
            });
        </script>
    </head>
    <body>
        <section class="hbox stretch">
            <!-- .vbox -->