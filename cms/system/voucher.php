<?php
$pagename = "Códigos (Voucher)";
include_once("./template/header.php");
?>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Códigos de Prêmios (Voucher)</div>
                <div style="margin-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
                    <a href="voucher_add.php" class="btn btn-danger" style="float:left; color:#fff; padding:10px 15px;">CRIAR VOUCHER</a>
                </div>
                <table class="table table-striped" style="width:100%; font-size:13px;">
                    <thead style="font-size:15px;">
                        <td>Código</td>
                        <td style="text-align:center;">Moedas</td>
                        <td style="text-align:center;">Píxels</td>
                        <td style="text-align:center;">Rubis</td>
                    </thead>
                    <?php 
                    $vouchers = $connect->query("SELECT * FROM vouchers ORDER BY code") or die($connect->error());
                    while($voucher = $vouchers->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $voucher['code']; ?></td>
                        <td style="text-align:center;"><?php echo $voucher['credits']; ?></td>
                        <td style="text-align:center;"><?php echo $voucher['pixels']; ?></td>
                        <td style="text-align:center;"><?php echo $voucher['vip_points']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php include_once("./template/box-right.php"); ?>
    </body>
</html>