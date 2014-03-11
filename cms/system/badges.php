<?php
include_once("./template/header.php");
$pagename = "Emblemas";

if($_GET['ac'] == "give"){
    $user = FilterText($_POST['username']);
    $badge = FilterText($_POST['badge']);
    
    if((!$user) || (!$badge)){
        echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
    }else{
        $user_sql = mysql_query("SELECT * FROM users WHERE username='". $user ."'") or die(mysql_error());
        if(mysql_num_rows($user_sql) > 0){
            $userinfo = mysql_fetch_assoc($user_sql);
            $verify = mysql_query("SELECT * FROM user_badges WHERE badge_id='". $badge ."' AND user_id='". $userinfo['id'] ."'") or die(mysql_error());
            if(mysql_num_rows($verify) > 0){
                echo "<script type='text/javascript'>alert('Erro: este usuário já possui este emblema.');</script>";
            }else{
                mysql_query("INSERT INTO user_badges(user_id, badge_id) VALUES('". $userinfo['id'] ."', '". $badge ."')") or die(mysql_error());
                echo "<script type='text/javascript'>alert('Emblema entregue com sucesso!');</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Erro: este usuário não existe.');</script>";
        }
    }
}elseif($_GET['ac'] == "take"){
    $user = FilterText($_POST['username']);
    $badge = FilterText($_POST['badge']);
    
    if((!$user) || (!$badge)){
        echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
    }else{
        $user_sql = mysql_query("SELECT * FROM users WHERE username='". $user ."'") or die(mysql_error());
        if(mysql_num_rows($user_sql) > 0){
            $userinfo = mysql_fetch_assoc($user_sql);
            $verify = mysql_query("SELECT * FROM user_badges WHERE badge_id='". $badge ."' AND user_id='". $userinfo['id'] ."'") or die(mysql_error());
            if(mysql_num_rows($verify) > 0){
                mysql_query("DELETE FROM user_badges WHERE user_id='". $userinfo['id'] ."' AND badge_id='". $badge ."'") or die(mysql_error());
                echo "<script type='text/javascript'>alert('Emblema removido com sucesso!');</script>";
            }else{
                echo "<script type='text/javascript'>alert('Erro: este usuário não possui este emblema.');</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Erro: este usuário não existe.');</script>";
        }
    }
}
?>
        <title><?php echo $sitename. " - ". $pagename; ?></title>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Dar Emblema</div>
                <form action="?ac=give" method="post">
                    <div class="form-group">
                        Usuário
                        <input class="form-control" type="text" name="username" id="username" size="30" />
                        <span style="font-size:12px;">Insira o nome do usuário à entregar o emblema</span>
                    </div>
                    <div class="form-group">
                        Emblema
                        <input class="form-control" type="text" name="badge" id="badge" size="30" />
                        <span style="font-size:12px;">Insira código do emblema. Ex: FAC05</span>
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Dar Emblema</button>
                </form>
                <div style="margin-bottom:30px; border-bottom:solid 1px #a3a3a3;">&nbsp;</div>
                
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Remover Emblema</div>
                <form action="?ac=take" method="post">
                    <div class="form-group">
                        Usuário
                        <input class="form-control" type="text" name="username" id="username" size="30" />
                        <span style="font-size:12px;">Insira o nome do usuário à remover o emblema</span>
                    </div>
                    <div class="form-group">
                        Emblema
                        <input class="form-control" type="text" name="badge" id="badge" size="30" />
                        <span style="font-size:12px;">Insira código do emblema. Ex: FAC05</span>
                    </div>
                    <button type="submit" id="submit" class="btn btn-warning">Remover Emblema</button>
                </form>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
    </body>
</html>