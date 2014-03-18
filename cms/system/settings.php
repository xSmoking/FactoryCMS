<?php
$pagename = "Configurações do Hotel";
include_once("./template/header.php");
?>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Configurações do Hotel</div>
        <div style="margin-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
            <a href="settings_edit.php" class="btn btn-danger" style="float:left; color:#fff; padding:10px 15px;">EDITAR CONFIGURAÇÕES</a>
        </div>
        <table class="table table-striped table-hover" style="width:100%; font-size:13px;">
            <tr>
                <td>CMS URL</td>
                <td><?php echo $cms_url; ?></td>
            </tr>
            <tr>
                <td>Client IP</td>
                <td><?php echo $server_ip; ?></td>
            </tr>
            <tr>
                <td>Game Port</td>
                <td><?php echo $client_port; ?></td>
            </tr>
            <tr>
                <td>MUS Port</td>
                <td><?php echo $mus_port; ?></td>
            </tr>
            <tr>
                <td>SWF Patch</td>
                <td><?php echo $swf_patch; ?></td>
            </tr>
            <tr>
                <td>Maintenance</td>
                <td><?php echo $maintenance; ?></td>
            </tr>
            <tr>
                <td>Register Enable</td>
                <td><?php echo $register_enable; ?></td>
            </tr>
            <tr>
                <td>Site Name</td>
                <td><?php echo $sitename; ?></td>
            </tr>
            <tr>
                <td>Shortname</td>
                <td><?php echo $shortname; ?></td>
            </tr>
            <tr>
                <td>Facebook Page</td>
                <td><?php echo $facebook; ?></td>
            </tr>
            <tr>
                <td>Twitter Page</td>
                <td><?php echo $twitter; ?></td>
            </tr>
        </table>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>