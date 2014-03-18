<?php
include_once("../data-classes/data-classes-core.php");
if($myrow['rank'] < 4){
    header("Location: ". $cms_url);
    exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $sitename. " - ". $pagename; ?></title>
        <!-- Carrega o CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo $adminpath; ?>/web-files/css/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $adminpath; ?>/web-files/css/bootstrap.css" />
        
        <!-- Carrega o JavaScript -->
        <script type="text/javascript" src="<?php echo $adminpath; ?>/web-files/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $adminpath; ?>/web-files/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $adminpath; ?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
        tinyMCE.init({
            // General options
            mode : "textareas",
            theme : "advanced",
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

            // Theme options
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,

            // Example content CSS (should be your site CSS)
            content_css : "css/content.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",

            // Style formats
            style_formats : [
                {title : 'Bold text', inline : 'b'},
                {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                {title : 'Example 1', inline : 'span', classes : 'example1'},
                {title : 'Example 2', inline : 'span', classes : 'example2'},
                {title : 'Table styles'},
                {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
            ],

            // Replace values for the template plugin
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        });
        
        $(function() {
            $('a').tooltip({placement: 'bottom'});
        });
        </script>
    </head>
    <body>
        <div id="bg_fundo"></div>
        <div id="wrap-menu">
            <div id="topo">MENÚ PRINCIPAL</div>
            <div id="content">
                <ul>
                    <li><a href="<?php echo $adminpath; ?>/index.php">&raquo; Início</a></li>
                    <li><a href="<?php echo $adminpath; ?>/bans.php">&raquo; Banidos</a></li>
                    <li><a href="<?php echo $adminpath; ?>/fakecheck.php">&raquo; Checar Fake</a></li>
                    <li><a href="<?php echo $adminpath; ?>/chatlog.php">&raquo; Chatlog</a></li>
                    <li><a href="<?php echo $adminpath; ?>/news.php">&raquo; Notícias</a></li>
                    <li><a href="<?php echo $adminpath; ?>/badges.php">&raquo; Emblemas</a></li>
                    <!--<li><a href="<?php echo $adminpath; ?>/ruby.php">&raquo; Loja de Rubis</a></li>-->
                    <li><a href="<?php echo $adminpath; ?>/voucher.php">&raquo; Códigos (Voucher)</a></li>
                    <li><a href="<?php echo $adminpath; ?>/settings.php">&raquo; Configurações</a></li>
                    <li><a href="<?php echo $adminpath; ?>/muscommand.php">&raquo; MUS Command</a></li>
                    <li>
                        <form action="finduser.php" method="get">
                        Buscar Usuário<br />
                        <input style="margin-top:5px; padding:1px 2px; border:solid 1px #abadb3;" type="text" name="user" id="user" />
                        <input type="submit" value="" style="background:url(./web-files/images/search.png); width:20px; height:24px; border:0; position:absolute; margin-top:5px; cursor:pointer;" />
                        </form>
                    </li>
                </ul>
                <div style="color:#666; margin-top:20px; text-align:center;">
                &copy; The Factory 2013<br />
                Todos os direitos reservados
                </div>
            </div>
        </div>