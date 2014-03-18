<?php
require_once('./data-classes/data-classes-core.php');
require_once('./data-classes/data-classes-session.php');
require_once('./templates/client_subheader.php');
//require_once('./adfly.php');
$connect->query("UPDATE users SET auth_ticket = '" . GenerateTicket() . "', ip_last = '" . $remote_ip . "' WHERE id = '" . $my_id . "' and username = '" . $myrow['username'] . "'") or die($connect->error());
$ticketsql = $connect->query("SELECT * FROM users WHERE id = '" . $my_id . "' AND username = '" . $myrow['username'] . "'") or die($connect->error());
$ticketrow = $ticketsql->fetch_assoc();
?>

<script type="text/javascript">
    FlashExternalInterface.loginLogEnabled = true;

    FlashExternalInterface.logLoginStep("web.view.start");

    if (top == self) {
        FlashHabboClient.cacheCheck();
    }

    var flashvars = {
        "client.allow.cross.domain": "1",
        "client.notify.cross.domain": "1",
        "connection.info.host": "<?php echo $client_ip; ?>",
        "connection.info.port": "<?php echo $client_port; ?>",
        "site.url": "<?php echo $cms_url; ?>",
        "url.prefix": "<?php echo $cms_url; ?>",
        "client.reload.url": "<?php echo $cms_url; ?>/client",
        "client.fatal.error.url": "<?php echo $cms_url; ?>/clientutils",
        "client.connection.failed.url": "<?php echo $cms_url; ?>/clientutils",
        "external.variables.txt": "<?php echo $swf_patch; ?>/gamedata/external_variables.txt?<?php echo rand(0, 99999); ?>",
        "external.texts.txt": "<?php echo $swf_patch; ?>/gamedata/external_flash_texts.txt?<?php echo rand(0, 99999); ?>",
        "productdata.load.url": "<?php echo $swf_patch; ?>/gamedata/productdata.txt?<?php echo rand(0, 99999); ?>",
        "furnidata.load.url": "<?php echo $swf_patch; ?>/gamedata/furnidata.txt?<?php echo rand(0, 99999); ?>",
        "use.sso.ticket": "1",
        "sso.ticket": "<?php echo $ticketrow['auth_ticket']; ?>",
        "processlog.enabled": "1",
        "account_id": "<?php echo $my_id; ?>",
        "client.starting": "Aguarde, o <?php echo $shortname; ?> esta carregando",
        "flash.client.url": "<?php echo $swf_patch; ?>/gordon/RELEASE63-35255-35642/",
        "user.hash": "31385693ae558a03d28fc720be6b41cb1ccfec02",
        "has.identity": "0",
        "flash.client.origin": "popup",
        "token": "<?php echo $ticketrow['auth_ticket']; ?>"
    };
    var params = {
        "base": "<?php echo $swf_patch; ?>/gordon/RELEASE63-35255-35642/",
        "allowScriptAccess": "always",
        "menu": "false"
    };

    if (!(HabbletLoader.needsFlashKbWorkaround())) {
        params["wmode"] = "opaque";
    }

    FlashExternalInterface.signoutUrl = "<?php echo $cms_url; ?>/logout";

    var clientUrl = "<?php echo $swf_patch; ?>/gordon/RELEASE63-35255-35642/Factory.swf";

    swfobject.embedSWF(clientUrl, "flash-container", "100%", "100%", "10.0.0", "<?php echo $cms_url; ?>/web-gallery/flash/expressInstall.swf", flashvars, params);

    window.onbeforeunload = unloading;
    function unloading() {
        var clientObject;
        if (navigator.appName.indexOf("Microsoft") != -1) {
            clientObject = window["flash-container"];
        } else {
            clientObject = document["flash-container"];
        }
        try {
            clientObject.unloading();
        } catch (e) {
        }
    }
</script>



<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo $path; ?>/web-gallery/static/styles/ie6.css" type="text/css" />
<script src="<?php echo $path; ?>/web-gallery/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->

<meta name="build" content="63-BUILD406 - 09.05.2011 23:04 - de" />
<script>
    if (navigator.appName == "Opera") {
        document.write("Your browser is not supported.");
    }
</script>
</head>
<body id="client" class="flashclient">
    <div id="overlay"></div>
    <img src="<?php echo $path; ?>/web-gallery/v2/images/page_loader.gif" style="position:absolute; margin: -1500px;" />
    <div id="overlay"></div>
    <div id="client-ui" >
        <div id="flash-wrapper">
            <div id="flash-container">
                <div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
                    <div class="cbb clearfix">
                        <h2 class="title">Por favor, actualiza tu Flash Player a la última versión</h2>
                        <div class="box-content">
                            <p>Puedes instalar y descargar Adobe Flash Player aquí: <a href="http://get.adobe.com/flashplayer/">Instala Flash player</a>. Más instrucciones para su instalación aquí: <a href="http://www.adobe.com/products/flashplayer/productinfo/instructions/">Más información</a></p>
                            <p><a href="http://www.adobe.com/go/getflashplayer"><img src="<?php echo $path; ?>/web-gallery/v2/images/client/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                        </div>
                    </div>

                </div>
                <script type="text/javascript">
                    $('content').show();
                </script>
                <noscript>
                <div style="width: 400px; margin: 20px auto 0 auto; text-align: center">
                    <p>If you are not automatically redirected, please <a href="/client">click here</a></p>
                </div>
                </noscript>
            </div>
        </div>
</body>
</html>