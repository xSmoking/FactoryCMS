<?php
$pagename = "Editar Notícia";
include_once("./template/header.php");

$new_id = FilterText($_GET['id']);

if (isset($_POST['edit_news'])) {
    $title = FilterText($_POST['title']);
    $content = $_POST['content'];
    $published = FilterText($_POST['published']);

    if ((!$title) || (!$content)) {
        echo "<script type='text/javascript'>alert('Preencha todos os campos.');</script>";
    } else {
        $connect->query("UPDATE cms_news_slider SET title='" . $title . "', longstory='" . $content . "', published='" . $published . "' WHERE id='" . $new_id . "'") or die($connect->error());
        echo "<script type='text/javascript'>alert('Notícia alterada com sucesso!');</script>";
    }
}

$newVerify = $connect->query("SELECT * FROM cms_news_slider WHERE id='" . $new_id . "'") or die($connect->error());
?>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Editar Notícia</div>
        <?php
        if ($myrow['rank'] < 5) {
            echo "Você não tem permissão para criar uma notícia.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        } elseif ($newVerify->num_rows == 0) {
            echo "Esta notícia não exsite.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        } else {
            $newInfo = $newVerify->fetch_assoc();
            ?>
            <form action="?id=<?php echo $new_id; ?>" method="post">
                <table width="100%">
                    <tr>
                        <td valign="top">Título</td>
                        <td><input class="form-control" type="text" name="title" id="title" size="50px;" style="margin-bottom:10px;" value="<?php echo $newInfo['title']; ?>" /></td>
                    </tr>
                    <tr>
                        <td valign="top">Conteúdo</td>
                        <td><textarea class="form-control" style="width:100%;" rows="20" id="eml1" name="content"><?php echo $newInfo['longstory']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="bottom">Ativada</td>
                        <td>
                            <select class="form-control" style="margin-top:10px;" name="published">
                                <option value="1" <?php if ($newInfo['published'] == 1) {
            echo 'selected';
        } ?>>Sim</option>
                                <option value="0" <?php if ($newInfo['published'] == 0) {
            echo 'selected';
        } ?>>Não</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td><button class="btn btn-primary" type="submit" name="edit_news" id="submit">Editar Notícia</button></td>
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