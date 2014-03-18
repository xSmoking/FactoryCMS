<?php
$pagename = "Início";
include_once("./template/header.php");
?>
        <div id="wrap-main">
            <div id="big-box">
                <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Equipe do Hotel</div>
                <table class="table table-striped table-hover" style="width:100%; font-size:13px;">
                    <thead style="font-size:15px;">
                        <td>Usuário</td>
                        <td style="text-align:center;">Cargo</td>
                        <td style="text-align:center;">Moedas</td>
                        <td style="text-align:center;">Píxels</td>
                        <td style="text-align:center;">Online</td>
                    </thead>
                    <?php 
                    $staff_sql = $connect->query("SELECT * FROM users WHERE rank > 3 ORDER BY rank DESC") or die($connect->error());
                    while($staff = $staff_sql->fetch_assoc()){
                    $rank_sql = $connect->query("SELECT * FROM ranks WHERE id='". $staff['rank'] ."'") or die($connect->error());
                    $rank = $rank_sql->fetch_assoc();
                    ?>
                    <tr>
                        <td><?php echo $staff['username']; ?></td>
                        <td style="text-align:center;"><?php echo $rank['name']; ?></td>
                        <td style="text-align:center;"><?php echo $staff['credits']; ?></td>
                        <td style="text-align:center;"><?php echo $staff['activity_points']; ?></td>
                        <td style="text-align:center;">
                            <?php
                            if($staff['online'] == 1){
                                echo '<img src="./web-files/images/online.gif" />';
                            }else{
                                echo '<img src="./web-files/images/offline.gif" />';
                            }
                            ?>
                        </td>
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