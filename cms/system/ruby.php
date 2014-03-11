<?php
include_once("./template/header.php");
$pagename = "Início";
?>
        <title><?php echo $sitename. " - ". $pagename; ?></title>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Equipe do Hotel</div>
                <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
                    <div id="Aba_1" onClick="AlternarAbas(Aba_1, divAba_1)">Primeira Aba</div>
                    <div id="Aba_2" onClick="AlternarAbas(Aba_2, divAba_2)">Segunda Aba</div>
                    <div id="divAba_1" style="display:none">Conteúdo da primeira aba</div>
                    <div id="divAba_2" style="display:none">Conteúdo da segunda aba</div>
                </div>
                <table style="width:100%; font-size:13px;">
                    <tr style="font-size:15px;">
                        <td>Usuário</td>
                        <td style="text-align:center;">Cargo</td>
                        <td style="text-align:center;">Moedas</td>
                        <td style="text-align:center;">Píxels</td>
                    </tr>
                    <?php 
                    $staff_sql = mysql_query("SELECT * FROM users WHERE rank > 3 ORDER BY rank DESC") or die(msqyl_error());
                    while($staff = mysql_fetch_assoc($staff_sql)){
                    $rank_sql = mysql_query("SELECT * FROM ranks WHERE id='". $staff['rank'] ."'") or die(msqyl_error());
                    $rank = mysql_fetch_assoc($rank_sql);
                    ?>
                    <tr>
                        <td><?php echo $staff['username']; ?></td>
                        <td style="text-align:center;"><?php echo $rank['name']; ?></td>
                        <td style="text-align:center;"><?php echo $staff['credits']; ?></td>
                        <td style="text-align:center;"><?php echo $staff['activity_points']; ?></td>
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