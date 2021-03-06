<?php
include_once("./templates/cms_header_share.php");
?>
<title><?php echo $sitename; ?> - Perfil</title>
<section id="content">
    <section class="vbox">
        <section class="scrollable">
            <section class="hbox stretch">
                <aside class="aside-lg bg-light lter b-r">
                    <section class="vbox">
                        <section class="scrollable">
                            <div class="wrapper">
                                <div class="clearfix m-b">
                                    <a href="#" class="pull-left thumb m-r">
                                        <div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $myrow['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -8px -10px; width:50px; height:50px;"></div>
                                    </a>
                                    <div class="clear">
                                        <div class="h4 m-t-xs m-b-xs"><?php echo $myrow['username']; ?></div>
                                        <small class="text-muted">
                                            <?php
                                            if($myrow['online'] == 1){
                                                echo "<img src='./web-gallery/images/icon/online.png' style='padding:0 5px 4px 0' alt='' />";
                                                echo "Conectado";
                                            }else{
                                                echo "<img src='./web-gallery/images/icon/offline.png' style='padding:0 5px 4px 0' alt='' />";
                                                echo "Desconectado"; 
                                            }
                                            ?>
                                        </small>
                                    </div>                
                                </div>
                                <div class="panel wrapper">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <a>
                                                <span class="m-b-xs h4 block">
                                                <?php
                                                $ffsql = $connect->query("SELECT * FROM messenger_friendships WHERE user_one_id='". $myrow['id'] ."'") or die($connect->error());
                                                echo $ffsql->num_rows;
                                                ?>
                                                </span>
                                                <small class="text-muted">Amigos</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>                    
                                <div>
                                    <small class="text-uc text-xs text-muted">emblemas</small>
                                    <p>
                                    <?php
                                    $badges_active = $connect->query("SELECT * FROM user_badges WHERE user_id='". $myrow['id'] ."' AND badge_slot != '0'") or die($connect->error());
                                    while($badge = $badges_active->fetch_assoc()){
                                        echo '<img src="'. $swf_patch .'/c_images/album1584/'. $badge['badge_id'] .'.gif" alt="" />';
                                    }
                                    ?>
                                    </p>
                                    <small class="text-uc text-xs text-muted">missão</small>
                                    <p><?php echo $myrow['motto']; ?></p>
                                </div>
                            </div>
                        </section>
                    </section>
                </aside>
                <aside class="bg-white">
                    <section class="vbox">
                        <section class="scrollable">
                            <div class="wrapper">
                            <?php
                            if($my_id == $myrow['id']){
                                echo '
                                    <section class="panel">
                                        <form method="POST" action="">
                                            <textarea class="form-control no-border" rows="5" id="compartilhar" name="compartilhar" placeholder="Compartilhe algo com seus amigos"></textarea>
                                        <footer class="panel-footer bg-light lter">
                                            <input type="submit" class="btn btn-info pull-right btn-sm" value="Publicar" />
                                            <input type="hidden" name="action" value="compartilhar" />
                                            <ul class="nav nav-pills nav-sm">
                                                <li> </li>
                                                <li> </li>
                                            </ul>
                                        </footer>
                                        </form>
                                    </section>
                                ';
                            }
                            echo '</div>';
                            
                            if(isset($_GET['ac'])){
                                if($_GET['ac'] == "delete" && isset($_GET['id'])){
                                    $feed_id = FilterText($_GET['id']);
                                    $verify_sql = $connect->query("SELECT * FROM cms_feed_news WHERE id='". $feed_id ."'") or die($connect->error());
                                    $verify_row = $verify_sql->fetch_assoc();
                                    if($verify_row['user_id'] != $my_id){
                                        echo "<script type='text/javascript'>alert('Você não tem permissão para deletar este status.');</script>";
                                    }else{
                                        $connect->query("DELETE FROM cms_feed_news WHERE id='". $feed_id ."'") or die($connect->error());
                                        $connect->query("DELETE FROM cms_feed_news_comments WHERE feed_id='". $feed_id ."'") or die($connect->error());
                                        echo "<script type='text/javascript'>alert('Postagem apagada com sucesso!');</script>";
                                        echo '<meta http-equiv="refresh" content="0; url=home.php">';
                                        exit;
                                    }
                                }
                            }
                            
                            if(isset($_POST['action'])){
                                if($_POST['action'] == "compartilhar"){
                                    $texto = FilterText($_POST['compartilhar']);
                                    if((!$texto)){
                                        echo "<script type='text/javascript'>alert('Ocorreu algum erro ao postar seus status.');</script>";
                                    }else{
                                        $connect->query("INSERT INTO cms_feed_news(user_id, publication, date, hour) VALUES('". $my_id ."', '". $texto ."', '". date("d/m") ."', '". date("H:i") ."')") or die($connect->error());
                                        echo "<script type='text/javascript'>alert('Status compartilhado com sucesso!');</script>";
                                    }
                                }elseif($_POST['action'] == "comment"){
                                    $feed_id = FilterText($_POST['feedid']);
                                    $comment = FilterText($_POST['comment']);
                                    if((!$comment)){
                                        echo "<script type='text/javascript'>alert('Ocorreu algum erro ao postar o comentário.');</script>";
                                    }else{
                                        $connect->query("INSERT INTO cms_feed_news_comments(feed_id, user_id, comment) VALUE('". $feed_id ."', '". $my_id ."', '". $comment ."')") or die($connect->query());
                                        echo "<script type='text/javascript'>alert('Comentário inserido!');</script>";
                                        echo '<meta http-equiv="refresh" content="0; url=home.php">';
                                        exit;
                                    }
                                }
                            }
                            
                            $home_feed_sql  = $connect->query("SELECT * FROM cms_feed_news WHERE user_id='". $myrow['id'] ."' ORDER BY id DESC LIMIT 6") or die($connect->error()); 
                            while ($home_feed = $home_feed_sql->fetch_assoc()) {
                            $authorsql = $connect->query("SELECT * FROM users WHERE id='" . $home_feed['user_id'] . "'") or die($connect->error());
                            $author = $authorsql->fetch_assoc();
                            $comments = $connect->query("SELECT * FROM cms_feed_news_comments WHERE feed_id='" . $home_feed['id'] . "'") or die($connect->error());
                            ?>
                            <div class="col-lg-6 col-sm-6 boxkatrix">
                              <section class="panel">                   
                                <div class="panel-body">
                                  <div class="clearfix m-b">
                                    <small class="text-muted pull-right" id="cuando1444"><?php echo $home_feed['date']; ?><br /><?php echo $home_feed['hour']; ?></small>
                                    <a href="<?php echo $cms_url; ?>/home.php?user=<?php echo $author['username']; ?>" class="thumb-sm pull-left m-r">
                                      <div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $author['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n) -10px -14px; width:40px; height:45px;"></div>
                                    </a>
                                    <div class="clear">
                                        <a href="<?php echo $cms_url; ?>/home.php?user=<?php echo $author['username']; ?>"><strong><?php echo $author['username']; ?></strong></a> publicou um artigo
                                        <?php if($myrow['id'] == $my_id OR $myrow['rank'] > 3){ ?><small class="block text-muted"><a href="?ac=delete&id=<?php echo $home_feed['id']; ?>" style="color:red;">Deletar</a></small><?php } ?>
                                    </div></div>
                                    <p><?php echo $home_feed['publication']; ?></p>
                                    <vercommentfeed<?php echo $home_feed['id']; ?>>Comentários (<?php echo $comments->num_rows; ?>)</vercommentfeed<?php echo $home_feed['id']; ?>><br />
                                    <hiddenfeed<?php echo $home_feed['id']; ?> style="display:none;">
                                        <?php
                                        if ($comments->fetch_assoc() > 0) {
                                            while ($comment = $comments->fetch_assoc()) {
                                                $user_comment2 = $connect->query("SELECT * FROM users WHERE id='" . $comment['user_id'] . "'") or die($connect->error());
                                                $user_comment = $user_comment2->fetch_assoc();
                                                ?>
                                                <div style='margin:10px;'>
                                                    <table>
                                                        <tr>
                                                            <td rowspan="3"><div style="background:url(http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $user_comment['look']; ?>&size=n&direction=3&head_direction=3&action=wlk&gesture=n&size=n) -10px -18px; width:40px; height:40px; margin-right:10px;"></div></td>
                                                            <td><b><a href="<?php echo $cms_url; ?>/home.php?user=<?php echo $user_comment['username']; ?>"><?php echo $user_comment['username']; ?></a></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $comment['comment']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo "Não há comentários.";
                                        }
                                        ?>
                                    </hiddenfeed<?php echo $home_feed['id']; ?>>
                                    <script>
                                    $("vercommentfeed<?php echo $home_feed['id']; ?>").click(function() {
                                        $("hiddenfeed<?php echo $home_feed['id']; ?>").slideToggle("slow");
                                    });
                                    </script>
                                  <div id="allconets1444" style="display: none; max-height:150px;"><div></div></div>
                                </div>
                                <footer class="panel-footer pos-rlt">
                                    <span class="arrow top"></span>
                                    <form class="pull-out" action="" method="post" autocomplete="off">
                                        <input type="text" name="comment" class="form-control no-border input-lg text-sm" placeholder="Escrever comentário..">
                                        <input type="hidden" name="action" value="comment" />
                                        <input type="hidden" name="feedid" value="<?php echo $home_feed['id']; ?>" />
                                    </form>
                                </footer>
                              </section>
                            </div>
                            <?php
                            }
                            ?>
                          <div id="akisoci"></div>
                        </section>
                    </section>
                </aside>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a>
</section>
<!-- /.vbox -->
</section>
<script src="./web-gallery/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./web-gallery/js/bootstrap.js"></script>
<!-- App -->
<script src="./web-gallery/js/app.js"></script>
<script src="./web-gallery/js/app.plugin.js"></script>
<script src="./web-gallery/js/app.data.js"></script>
<!-- fuelux -->
<script src="./web-gallery/js/fuelux.js"></script>
<script src="./web-gallery/js/underscore-min.js"></script>
<!-- datatables -->
<script src="./web-gallery/js/jquery.dataTables.min.js"></script>
<!-- Sparkline Chart -->
<script src="./web-gallery/js/jquery.sparkline.min.js"></script>
<!-- Easy Pie Chart -->
<script src="./web-gallery/js/jquery.easy-pie-chart.js"></script>
<script src="./web-gallery/js/jquery.slimscroll.min.js"></script>  

<script type="text/javascript" src="http://kekocity.es:8088/socket.io/socket.io.js"></script>
<script>
  function verma(qdi) {
      if ($('#' + qdi).css('display') == 'none') {
          $('#' + qdi).slideDown('slow');
          $('#l' + qdi).html('<i class="icon-sort-up"></i> Ver menos');
      } else {
          $('#' + qdi).slideUp('slow');
          $('#l' + qdi).html('<i class="icon-sort-down"></i> Ver más');
      }
  }

  var mirocheckprofitimeou = null;
  var uspaprofcomurl = new Array();
  var pakie = 'xSmoking';
  var kekyooos = 'xSmoking';
</script>
<script src="./web-gallery/js/katrixweb.js"></script></body>
</html>