<?php
include_once("./data-classes/data-classes-core.php");
?>
<html>
<head>
<title><?php echo $sitename; ?> - Carregando</title>
<meta http-equiv="refresh" content="10; url=./client">
<script language="javascript">
<!-- begin
var sHors = "00"; 
var sMins = "00";
var sSecs = 6;
function getSecs(){
    sSecs--;
    if(sSecs<0)
        {sSecs=59;sMins--;if(sMins<=9)sMins="0"+sMins;}
    if(sMins=="0-1")
        {sMins=5;sHors--;if(sHors<=9)sHors="0"+sHors;}
    if(sSecs<=9)sSecs="0"+sSecs;
    if(sHors=="0-1")
        {sHors="00";sMins="00";sSecs="00";
        clock1.innerHTML=+sSecs;}
    else
    {
        clock1.innerHTML=+sSecs;
        setTimeout('getSecs()',1000);
    }
}
//-->
</script>
<style type="text/css">
    body,td,th {
        font-family: Verdana;
        margin:0 auto;
        background:#F0F0F0;
    }
    .ContentBox {
        background-color: #FFFFFF;
        border: 1px solid #D0D0D0;
        border-bottom: 4px solid #D0D0D0;
        border-radius: 4px;
        width: 750px;
        height: auto;
        padding: 4px;
        margin:0 auto;
        margin-bottom: 10px;
        margin-top:50px;
    }
    .ContentBox > .BoxHeader {
        font-size: 16px;
        font-weight: bold;
        color: #FFFFFF;
        width: 100%;
        text-align: center;
        height: 30px;
        line-height: 30px;
        border-radius: 4px;
    }

    .ContentBox > #grey     { background-color: #333333; }
    .ContentBox > #orange { background-color: #F66200; }
    .ContentBox > #blue     { background-color: #2767A7; }

    .Contentads {
        margin-top:20px;
    }
    .api{
        font: normal normal normal 11px/18px 'Helvetica Neue',Arial,sans-serif;
        position: relative;
        background-color: #F8F8F8;
        background-image: -webkit-gradient(linear,left top,left bottom,from(#fff),to(#dedede));
        background-image: -moz-linear-gradient(top,#fff,#dedede);
        background-image: -o-linear-gradient(top,#fff,#dedede);
        background-image: -ms-linear-gradient(top,#fff,#dedede);
        background-image: linear-gradient(top,#fff,#dedede);
        border: #CCC solid 1px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px; border-radius: 3px; color: #333;
        -webkit-user-select: none;
        -moz-user-select: none;
        -o-user-select: none;
        user-select: none;
        cursor: pointer;
        height: 18px;
        max-width: 98%;
        overflow: hidden;
        border-image: initial;color: #333;
        ursor: pointer;
        font-weight: bold;
        text-decoration: none;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
        padding:4px;
		top:-4px;
    }
	.Instagram, .Twitter, .Facebook{
	    position: absolute;
        top: 50%;
        left: 4px;
        margin-top: -7px;
        width: 16px;
        height: 16px;
        background-repeat-x: no-repeat;
        background-repeat-y: no-repeat;
        background-attachment: initial;
        background-position-x: 0px;
        background-position-y: 0px;
        background-origin: initial;
        background-clip: initial;
        background-color: transparent;
	}
    .Instagram{
        background: transparent url(http://widget.stagram.com/img/webstagram_followicon.png) 0 0 no-repeat;
        background-image: url(http://widget.stagram.com/img/webstagram_followicon.png);
    }
	.Twitter{
	margin-top: -8px;
        background: transparent url(http://cdn1.iconfinder.com/data/icons/cologne/16x16/twitter.png) 0 0 no-repeat;
        background-image: url(http://cdn1.iconfinder.com/data/icons/cologne/16x16/twitter.png);
    }
	.Facebook{
	margin-top: -8px;
        background: transparent url(http://cdn1.iconfinder.com/data/icons/WPZOOM_Social_Networking_Icon_Set/16/facebook.png) 0 0 no-repeat;
        background-image: url(http://cdn1.iconfinder.com/data/icons/WPZOOM_Social_Networking_Icon_Set/16/facebook.png);
    }
</style>
</head>
<body onload="startCountdown()">
    <div class="ContentBox">
        <div class="BoxHeader" id="blue"><?php echo $sitenam; ?> - Carregando</div>
        <div align="center"> 
            <br><b><?php echo $shortname; ?> &eacute; patrocinado por:</b></p>
            <p>
                <script type="text/javascript"><!--
                google_ad_client = "ca-pub-6896402047330257";
                /* Factory Head */
                google_ad_slot = "2517144037";
                google_ad_width = 728;
                google_ad_height = 90;
                //-->
                </script>
                <script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </p>	
                <a href="http://factoryhotel.com.br/portal" target="_blank"><img src="http://factoryhotel.com.br/portal/web-gallery/images/banner1.png" alt="FactoryPortal" /></a>
            </p>
        </div> 
        
        <div style="margin:20px 0px 15px 12px;">
            <a class="api" href="<?php echo $twitter; ?>" target="_blank"><span class="Twitter"></span><span class="label" style="padding: 0 3px 0 19px;"><span>Siga-nos no Twitter</span></span></a>
            <a class="api" href="<?php echo $facebook; ?>" target="_blank"><span class="Facebook"></span><span class="label" style="padding: 0 3px 0 19px;"><span>Curta-nos no Facebook</span></span></a>
        </div>
		
        <div style="margin:5px 0px 10px 0px; text-align:center; color:#2767A7; font-size:50px; font-family:arial;">
            <span id="clock1"></span>
            <script>setTimeout('getSecs()',400);</script>
        </div>
    </div>
</body>
</html>