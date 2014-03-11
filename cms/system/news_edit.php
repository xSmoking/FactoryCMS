<?php
include_once("./template/header.php");
$pagename = "Editar Notícia";
echo '<title>'. $sitename .' - '. $pagename .'</title>';

$new_id = FilterText($_GET['id']);

if($_POST['action'] == "edit_news"){
    $title = FilterText($_POST['title']);
    $content = $_POST['content'];
    $published = FilterText($_POST['published']);
    
    if((!$title) || (!$content)){
        echo "<script type='text/javascript'>alert('Preencha todos os campos.');</script>";
    }else{
        mysql_query("UPDATE cms_news_slider SET title='". $title ."', longstory='". $content ."', published='". $published ."' WHERE id='". $new_id ."'") or die(mysql_error());
        echo "<script type='text/javascript'>alert('Notícia alterada com sucesso!');</script>";
    }
}

$newVerify = mysql_query("SELECT * FROM cms_news_slider WHERE id='". $new_id ."'") or die(mysql_error());
?>
<div id="wrap-main">
    <div id="big-box">
        <div style="font-size:18px; margin-bottom:10px; padding-bottom:10px; border-bottom:solid 1px #a3a3a3;">Editar Notícia</div>
        <?php
        if($myrow['rank'] < 5){
            echo "Você não tem permissão para criar uma notícia.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        }elseif(mysql_num_rows($newVerify) == 0){
            echo "Esta notícia não exsite.<br /><br />";
            echo "<a href='javascript:history.back(1);'>&laquo; Voltar</a>";
        }else{
            $newInfo = mysql_fetch_assoc($newVerify);
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
                            <option value="1" <?php if($newInfo['published'] == 1){ echo 'selected'; } ?>>Sim</option>
                            <option value="0" <?php if($newInfo['published'] == 0){ echo 'selected'; } ?>>Não</option>
                        </select>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <button class="btn btn-primary" type="submit" id="submit">Editar Notícia</button>
                        <input type="hidden" id="hidden" name="action" value="edit_news" />
                    </td>
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