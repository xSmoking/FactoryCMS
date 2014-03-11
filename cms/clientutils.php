<?php
require_once('./data-classes/data-classes-core.php');
require_once('./data-classes/data-classes-session.php');

$pagename = "Error";
require_once('./templates/client_subheader.php');
?>

<body id="popup" class="process-template client_error">
    <div id="container">
        <div id="content">
            <div id="process-content" class="centered-client-error">

                <div id="column1" class="column">
                    <div class="habblet-container ">		
                        <div class="cbb clearfix blue">
                            <h2 class="title">Erro </h2>	
                            <div class="box-content">
                                <div class="retry-enter-hotel">
                                    <div class="hotel-open">
                                        <a id="enter-hotel-open-image" class="open" href="<?php echo $path; ?>/client" target="client" onclick="HabboClient.openOrFocus(this); return false;">
                                            <div class="hotel-open-image-splash"></div>
                                            <div class="hotel-image hotel-open-image"></div>
                                        </a>
                                        <div class="hotel-open-button-content">
                                            <a class="open" href="<?php echo $path; ?>/client">Client</a>
                                            <span class="open"></span>
                                        </div>
                                    </div>
                                </div>
                                <p style="margin-top:15px;">Opa, foi encontrado um problema técnico, mas não se preocupe. Este erro será investigado por nossa equipe de suporte.</p>
                                <p>Entre novamente no <a href="client">Hotel</a> para continuar. Desculpe-nos o incoveniente.</p>
                            </div>

                            <script type="text/javascript">
                                document.observe("dom:loaded", function() {
                                    var titles = $$("h2.title");
                                    if (titles.length > 0) {
                                        Element.insert(titles[0], "(#01087836) ");
                                    }
                                });
                            </script>

                        </div>
                        <script type="text/javascript">
                            document.observe("dom:loaded", function() {
                                ClientMessageHandler.googleEvent("client_error", "unknown");
                            });
                        </script>

                    </div>
                </div>
                <script type="text/javascript">
                    if (!$(document.body).hasClassName('process-template')) {
                        Rounder.init();
                    }
                </script>
            </div>
            <script type="text/javascript">
                HabboView.run();
            </script>
            <div id="column2" class="column">
            </div>
            <!--[if lt IE 7]>
            <script type="text/javascript">
            Pngfix.doPngImageFix();
            </script>
            <![endif]-->
        </div>
    </div>
</body>
</html>