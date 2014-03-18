<?php
$pagename = "Criar Notícia";
include_once("./template/header.php");

if (isset($_POST['create_news'])) {
    $title = FilterText($_POST['title']);
    $content = $_POST['content'];
    $published = FilterText($_POST['published']);
    $author = $my_id;

    if ((!$title) || (!$content)) {
        echo "<script type='text/javascript'>alert('Preencha todos os campos.');</script>";
    } else {
        $connect->query("INSERT INTO cms_news_slider(title, longstory, author, published, date, hour) VALUES('" . $title . "', '" . $content . "', '" . $author . "', '" . $published . "', '" . $date_normal . "', '" . date("H:i") . "')") or die($connect->error());
        sendMusCommand($server_ip, 'ha', 'Nova notícia publicada, confira nossa página "Comunidade"');
        echo "<script type='text/javascript'>alert('Notícia publicada com sucesso!');</script>";
    }
}
?>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Criar Notícia</div>
        <?php
        if ($myrow['rank'] < 5) {
            echo "Você não tem permissão para criar uma notícia.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        } else {
            ?>
            <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">
                <span style="color:red;"><b>Aviso:</b> ao publicar uma notícia, o hotel será alertado automaticamente!</span>
            </div>
            <form action="" method="post">
                <table width="100%">
                    <tr>
                        <td valign="top">Título</td>
                        <td><input class="form-control" type="text" name="title" id="title" size="50px;" style="margin-bottom:10px;" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Conteúdo</td>
                        <td><textarea style="width:100%;" rows="20" id="eml1" name="content"></textarea></td>
                    </tr>
                    <tr>
                        <td valign="bottom">Ativada</td>
                        <td>
                            <select class="form-control" style="margin-top:10px;" name="published">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td><button type="submit" name="create_news" id="submit" class="btn btn-primary">Criar Notícia</button></td>
                        <td align="right"><a class="btn btn-danger" style="color:#fff;" href="javascript:history.back(1);">Cancelar</a></td>
                    </tr>
                </table>
            </form>
            <?php
        }
        ?>
    </div>
</div>
<?php include_once("./template/box-right.php"); ?>
</body>
</html>