<?php
include_once("./template/header.php");
$pagename = "Criar Códigos (Voucher)";

if($_POST['action'] == "voucher_add"){
    $code = FilterText($_POST['code']);
    $credits = FilterText($_POST['credits']);
    $pixels = FilterText($_POST['pixels']);
    $vip_points = FilterText($_POST['vip_points']);

    if($code == "" OR $credits == "" OR $pixels == "" OR $vip_points == ""){
        echo "<script type='text/javascript'>alert('Erro: preencha todos os campos.');</script>";
    }else{
        if($code < 0 OR $credits < 0 OR $pixels < 0 OR $vip_points < 0){
            echo "<script type='text/javascript'>alert('Erro: insira números inteiros e positivos');</script>";
        }elseif($myrow['rank'] < 6 AND $vip_points > 0){
            echo "<script type='text/javascript'>alert('Erro: você não possui permissão para criar vouchers com Rubis');</script>";
        }else{
            mysql_query("INSERT INTO vouchers(code, credits, pixels, vip_points) VALUES('". $code ."', '". $credits ."', '". $pixels ."', '". $vip_points ."')") or die(mysql_error());
            echo "<script type='text/javascript'>alert('Código criado com sucesso!');</script>";
        }
    }
}
?>
<title><?php echo $sitename . " - " . $pagename; ?></title>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Criar Notícia</div>
        <?php
        if($myrow['rank'] < 5){
            echo "Você não tem permissão para criar uma notícia.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        }else{
        ?>
        <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">
            <span style="color:red;"><b>Aviso:</b> cargos abaixo de administrador não poderá criar voucher com Rubis</span>
        </div>
        <form action="" method="post">
            <div class="form-group">
                Código
                <input class="form-control" type="text" name="code" id="code" size="30" value="<?php echo geraSenha(); ?>" style="margin-bottom:10px;" />
            </div>
            <div class="form-group">
                Moedas
                <input class="form-control" type="number" name="credits" id="credits" size="5" value="0" style="margin-bottom:10px;" />
            </div>
            <div class="form-group">
                Píxels
                <input class="form-control" type="number" name="pixels" id="pixels" size="5" value="0" style="margin-bottom:10px;" />
            </div>
            <div class="form-group">
                Rubis
                <input class="form-control" type="number" name="vip_points" id="vip_points" size="5" value="0" style="margin-bottom:10px;" />
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Criar Voucher</button>
            <input type="hidden" id="hidden" name="action" value="voucher_add" />
            <a class="btn btn-danger" style="color:#fff; float:right" href="javascript:history.back(1);">Cancelar</a>
        </form>
        <?php
        }
        ?>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>