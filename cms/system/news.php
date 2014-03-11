<?php
include_once("./template/header.php");
$pagename = "Notícias";

if (isset($_GET['delete'])) {
    if($myrow['rank'] < 6){
        echo "<script type='text/javascript'>alert('Erro: você não possui permissão para deletar uma notícia');</script>";
    }else{
        $id = FilterText($_GET['delete']);
        $busca = mysql_query("SELECT * FROM cms_news_slider WHERE id='" . $id . "'") or die(mysql_error());
        if (mysql_num_rows($busca) > 0) {
            mysql_query("DELETE FROM cms_news_slider WHERE id='" . $id . "'") or die(mysql_error());
            echo "<script type='text/javascript'>alert('Notícia apagada.');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Erro: esta notícia não existe.');</script>";
        }
    }
}
?>
<title><?php echo $sitename . " - " . $pagename; ?></title>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Notícias</div>
        <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3; min-height:50px;">
            <form action="" method="get">
                Buscar Notícia<br />
                <span style="font-size:11px;">Insira uma palavra/letra contida no título</span><br />
                <input style="margin-top:5px; padding:1px 2px; border:solid 1px #abadb3;" type="text" name="search" id="search" />
                <input type="submit" value="" style="background:url(./web-files/images/search.png) no-repeat; width:20px; height:24px; border:0; position:absolute; margin-top:5px; cursor:pointer;" />
            </form>
            <a href="news_add.php" style="float:right; margin:-45px 5px; color:#fff;" class="btn btn-danger">CRIAR NOTÍCIA</a>
        </div>
        <table class="table table-striped" style="width:100%; font-size:13px;">
            <thead style="font-size:15px;">
                <td>Título</td>
                <td style="text-align:center;">Autor</td>
                <td style="text-align:center;">Publicada</td>
                <td style="text-align:center;">Data</td>
            </thead>
            <tbody>
            <?php
            if (isset($_GET['search'])) {
                $search = FilterText($_GET['search']);
                $busca = mysql_query("SELECT * FROM cms_news_slider WHERE title LIKE '%" . $search . "%' ORDER BY id DESC LIMIT 30") or die(mysql_error());
                if (mysql_num_rows($busca) > 0) {
                    while ($new = mysql_fetch_assoc($busca)) {
                        $authorsql = mysql_query("SELECT * FROM users WHERE id='" . $new['author'] . "'") or die(msqyl_error());
                        $author = mysql_fetch_assoc($authorsql);
                        if ($new['published'] == 1) {
                            $publicada = "Sim";
                        } else {
                            $publicada = "Não";
                        }
                        ?>
                        <tr>
                            <td style="width:40%;"><?php echo $new['title']; ?></td>
                            <td style="text-align:center;"><?php echo $author['username']; ?></td>
                            <td style="text-align:center;"><?php echo $publicada; ?></td>
                            <td style="text-align:center;"><?php echo $new['date']; ?></td>
                            <td style="text-align:center;"><a href="?delete=<?php echo $new['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/delete.png" alt="del" title="Remover" /></a></td>
                            <td style="text-align:center;"><a href="news_edit.php?id=<?php echo $new['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/edit.png" alt="del" title="Editar" /></a></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td>Nenhum registro encontrado.</td></tr>";
                }
            } else {
                $news_sql = mysql_query("SELECT * FROM cms_news_slider ORDER BY id DESC LIMIT 30") or die(msqyl_error());
                while ($new = mysql_fetch_assoc($news_sql)) {
                    $authorsql = mysql_query("SELECT * FROM users WHERE id='" . $new['author'] . "'") or die(msqyl_error());
                    $author = mysql_fetch_assoc($authorsql);
                    if ($new['published'] == 1) {
                        $publicada = "Sim";
                    } else {
                        $publicada = "Não";
                    }
                    ?>
                    <tr>
                        <td style="width:40%;"><?php echo $new['title']; ?></td>
                        <td style="text-align:center;"><?php echo $author['username']; ?></td>
                        <td style="text-align:center;"><?php echo $publicada; ?></td>
                        <td style="text-align:center;"><?php echo $new['date']; ?></td>
                        <td style="text-align:center;"><a href="?delete=<?php echo $new['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/delete.png" alt="del" title="Remover" /></a></td>
                        <td style="text-align:center;"><a href="news_edit.php?id=<?php echo $new['id']; ?>"><img src="<?php echo $adminpath; ?>/web-files/images/edit.png" alt="del" title="Editar" /></a></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>