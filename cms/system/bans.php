<?php
include_once("./template/header.php");
$pagename = "Banidos";

if(isset($_GET['delete'])){
    $id = FilterText($_GET['delete']);
    $busca = $connect->query("SELECT * FROM bans WHERE id='". $id ."'") or die($connect->error());
    if($busca->num_rows > 0){
        $connect->query("DELETE FROM bans WHERE id='". $id ."'") or die($connect->error());
        sendMusCommand($server_ip, 'reloadbans');
        echo "<script type='text/javascript'>alert('Banimento removido.');</script>";
    }else{
        echo "<script type='text/javascript'>alert('Erro: este usuário não está banido.');</script>";
    }
}
?>
        <title><?php echo $sitename. " - ". $pagename; ?></title>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Usuário Banidos</div>
                <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
                    <form action="" method="get">
                        Buscar Usuário / IP<br />
                        <input style="margin-top:5px; padding:1px 2px; border:solid 1px #abadb3;" type="text" name="search" id="search" />
                        <input type="submit" value="" style="background:url(./web-files/images/search.png) no-repeat; width:20px; height:24px; border:0; position:absolute; margin-top:5px; cursor:pointer;" />
                    </form>
                    
                    <a href="bans_add.php" style="float:right; margin:-40px 5px; color:#fff;" class="btn btn-danger">ADICIONAR BANIMENTO</a>
                </div>
                <table class="table table-striped" style="width:100%; font-size:13px;">
                    <thead style="font-size:15px;">
                        <td>Usuário</td>
                        <td style="text-align:center;">Tipo</td>
                        <td style="text-align:center;">Motivo</td>
                        <td style="text-align:center;">Expiração</td>
                        <td style="text-align:center;">Responsável</td>
                    </thead>
                    <?php
                    if(isset($_GET['search'])){
                        $search = FilterText($_GET['search']);
                        $busca = $connect->query("SELECT * FROM bans WHERE value='". $search ."'") or die($connect->error());
                        if($busca->num_rows > 0){
                        while($ban = $busca->fetch_assoc()){
                    ?>
                            <tr>
                                <td><?php echo $ban['value']; ?></td>
                                <td style="text-align:center;"><?php echo $ban['bantype']; ?></td>
                                <td style="text-align:center;"><?php echo $ban['reason']; ?></td>
                                <td style="text-align:center;"><?php echo date("d/m/Y H:i:s", $ban['expire']); ?></td>
                                <td style="text-align:center;"><?php echo $ban['added_by']; ?></td>
                                <td style="text-align:center;"><a href="?delete=<?php echo $ban['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/delete.png" alt="del" title="Remover Banimento" /></a></td>
                            </tr>
                    <?php
                        }
                        }else{
                            echo "<tr><td>Nenhum registro encontrado.</td></tr>";
                        }
                    }else{
                        $bans_sql = $connect->query("SELECT * FROM bans LIMIT 30") or die($connect->error());
                        while($ban = $bans_sql->fetch_assoc()){
                    ?>
                        <tr>
                            <td><?php echo $ban['value']; ?></td>
                            <td style="text-align:center;"><?php echo $ban['bantype']; ?></td>
                            <td style="text-align:center;"><?php echo $ban['reason']; ?></td>
                            <td style="text-align:center;"><?php echo date("d/m/Y H:i:s", $ban['expire']); ?></td>
                            <td style="text-align:center;"><?php echo $ban['added_by']; ?></td>
                            <td style="text-align:center;"><a href="?delete=<?php echo $ban['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/delete.png" alt="del" title="Remover Banimento" /></a></td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
    </body>
</html>