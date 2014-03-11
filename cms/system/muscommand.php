<?php
include_once("./template/header.php");
$pagename = "MUS Command";

$action = FilterText($_GET['ac']);

if($action == "shutdown"){
    if($myrow['rank'] < 7){
        echo "<script type='text/javascript'>alert('Você não possui permissão para desligar o servidor');</script>";
    }else{
        sendMusCommand($server_ip, 'shutdown');
        echo "<script type='text/javascript'>alert('O servidor será desligado!');</script>";
    }
}elseif($action == "userdc"){
    $username = FilterText($_GET['value']);
    if($myrow['rank'] < 5){
        echo "<script type='text/javascript'>alert('Você não possui permissão para desconectar algum usuário');</script>";
    }else{
        $usersql = mysql_query("SELECT * FROM users WHERE username='". $username ."'") or die(mysql_error());
        if(mysql_num_rows($usersql) > 0){
            $userinfo = mysql_fetch_assoc($usersql);
            if($userinfo['rank'] > 3){
                echo "<script type='text/javascript'>alert('Este usuário não pode ser desconectado');</script>";
            }elseif($userinfo['online'] == "0"){
                echo "<script type='text/javascript'>alert('Impossível desconectar usuário!\nO mesmo se encontra offline.');</script>";
            }else{
                sendMusCommand($server_ip, 'signout', $userinfo['id']);
                echo "<script type='text/javascript'>alert('O usuário '".$userinfo['username']."' foi desconectado');</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Este usuário não existe');</script>";
        }
    }
}elseif($action == "ha"){
    $value = $_GET['value'];
    if($myrow['rank'] < 5){
        echo "<script type='text/javascript'>alert('Você não possui permissão para alertar o hotel');</script>";
    }else{
        sendMusCommand($server_ip, 'ha', $value);
        echo "<script type='text/javascript'>alert('Alerta enviado com sucesso!');</script>";
    }
}elseif($action == "update_filter"){
    sendMusCommand($server_ip, 'update_filter');
    echo "<script type='text/javascript'>alert('Filtro de conversa atualizado!');</script>";
}elseif($action == "reloadbans"){
    sendMusCommand($server_ip, 'reloadbans');
    echo "<script type='text/javascript'>alert('Banimentos atualizados!');</script>";
}elseif($action == "update_bots"){
    sendMusCommand($server_ip, 'update_bots');
    echo "<script type='text/javascript'>alert('BOTs atualizados!');</script>";
}elseif($action == "roomalert"){
    $room_id = FilterText($_GET['id']);
    $value = $_GET['value'];
    if($myrow['rank'] < 4){
        echo "<script type='text/javascript'>alert('Você não possui permissão para alertar algum quarto');</script>";
    }else{
        sendMusCommand($server_ip, 'roomalert', $room_id." ".$value);
        echo "<script type='text/javascript'>alert('Alerta enviado com sucesso!');</script>";
    }
}elseif($action == "update_items"){
    sendMusCommand($server_ip, 'update_items');
    echo "<script type='text/javascript'>alert('Items atualizados com sucesso!');</script>";
}elseif($action == "update_catalogue"){
    sendMusCommand($server_ip, 'update_catalogue');
    echo "<script type='text/javascript'>alert('Catálogo atualizado com sucesso!');</script>";
}
?>
        <title><?php echo $sitename. " - ". $pagename; ?></title>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Comandos para o Emulador</div>
                <table style="width:100%; border-bottom:dashed 1px #afafaf;">
                    <tr>
                        <td width="33%"><a href="#" class="btn btn-success" onclick="UserDisconnect()" id="button" style="margin:10px 20px;">Desconectar Usuário</a></td>
                        <td width="33%"><a href="#" class="btn btn-primary" onclick="HotelAlert()" id="button" style="margin:10px 20px;">Alertar Hotel</a></td>
                        <td width="33%"><a href="#" class="btn btn-success" onclick="RoomAlert()" id="button" style="margin:10px 20px;">Alertar Quarto</a></td>
                    </tr>
                </table>
                
                <table style="width:100%; border-bottom:dashed 1px #afafaf;">
                    <tr>
                        <td width="33%"><a href="?ac=update_filter" class="btn btn-primary" id="button" style="margin:10px 20px;">Atualizar Filtro de Conversa</a></td>
                        <td width="33%"><a href="?ac=reloadbans" class="btn btn-success" id="button" style="margin:10px 20px;">Atualizar Banimentos</a></td>
                        <td width="33%"><a href="?ac=update_bots" class="btn btn-primary" id="button" style="margin:10px 20px;">Atualizar BOTs</a></td>
                    </tr>
                </table>
                
                <table style="width:100%; margin-bottom:10px; border-bottom:dashed 1px #afafaf;">
                    <tr>
                        <td width="33%"><a href="?ac=update_items" class="btn btn-success" id="button" style="margin:10px 20px;">Atualizar Items</a></td>
                        <td width="33%"><a href="?ac=update_catalogue" class="btn btn-primary" id="button" style="margin:10px 20px;">Atualizar Catálogo</a></td>
                        <td width="33%"></td>
                    </tr>
                </table>
                <a href="#" onclick="ShutdownConfirm()" class="btn btn-danger" style="margin-top:10px;" id="button">Desligar Servidor</a>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
        <script language="JavaScript">
        function ShutdownConfirm(){
            if (confirm("Certeza de que deseja desligar o servidor?")) {
                location.href="?ac=shutdown";
            }
        }
        
        function UserDisconnect(){
            var nome;
            do{nome = prompt("Insira o nome do usuário");}
            while(nome == null || nome == "");
            if (confirm("Certeza de que deseja desconectar o usuário:\n"+nome)) {
                location.href="?ac=userdc&value="+nome;
            }
        }
        
        function HotelAlert(){
            var alerta;
            do{alerta = prompt("Insira o alerta");}
            while(alerta == null || alerta == "");
            if (confirm("Certeza de que deseja enviar o alerta?")) {
                location.href="?ac=ha&value="+alerta;
            }
        }
        
        function RoomAlert(){
            var alerta;
            var id;
            do{id = prompt("Insira o ID do quarto");}
            while(id == null || id == "");
            do{alerta = prompt("Insira o que deseja alertar");}
            while(alerta == null || alerta == "");
            if (confirm("Certeza de que deseja enviar o alerta?")) {
                location.href="?ac=roomalert&id="+id+"&value="+alerta;
            }
        }
        </script>
    </body>
</html>