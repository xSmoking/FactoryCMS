<?php
include_once("./templates/cms_header.php");
?>
<title><?php echo $sitename; ?> - Comprar Pontos</title>
<section id="content">
    <section class="vbox">
        <header class="header bg-white b-b">       
            <p><a href="javascript:void(0);" onclick="hola2();" id="btnentrarya" class="btn btn-info btn-block" style="margin-top: -6px;">ENTRAR NO <?php echo strtoupper($shortname); ?></a></p>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php
                        if($_GET['ac'] == "success"){
                        ?>
                        <div class="col-lg-8">
                            <div id="alert2" style="background:#007f0c; color:#fff; padding:10px; margin-bottom:10px;">
                                <div style="float:right;" id="close2">X</div>
                                <span style="font-size:16px;">Obrigado pela compra!</span><br />
                                Sua compra foi processada e seus pontos serão creditados em breve!
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div style="float:right;"><img src="./web-gallery/images/logo_pp.png" /></div>
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Pontos via PayPal</div>(Cartão de Crédito)
                                    </div>
                                    <div style="float:left;">
                                        <span style="font-size:14px;">Opção 1</span><br />
                                        2.000 Pontos<br />
                                        R$ 10,00<br />
                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="hosted_button_id" value="RXQT9LTDMRABL">
                                        <button type="submit" class="btn btn-primary" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 2</span><br />
                                        5.000 Pontos<br />
                                        R$ 20,00<br />
                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="hosted_button_id" value="SVH262M4F4KSE">
                                        <button type="submit" class="btn btn-primary" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                    <div style="position:absolute; margin-left:200px;">
                                        <span style="font-size:14px;">Opção 3</span><br />
                                        12.000 Pontos<br />
                                        R$ 40,00<br />
                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                        <input type="hidden" name="cmd" value="_s-xclick">
                                        <input type="hidden" name="hosted_button_id" value="TXQPGVK6FNW8A">
                                        <button type="submit" class="btn btn-primary" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 4</span><br />
                                        16.000 Pontos<br />
                                        R$ 60,00<br />
                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                        <input type="hidden" name="cmd" value="_s-xclick"/>
                                        <input type="hidden" name="hosted_button_id" value="A9A6Z6CEVVG5G"/>
                                        <button type="submit" class="btn btn-primary" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                </div>
                            </section>
                        </div> 
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div style="float:right;"><img src="./web-gallery/images/logo_moip.png" /></div>
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Pontos via MoIP</div>(Boleto Bancário)
                                    </div>
                                    <div style="float:left;">
                                        <span style="font-size:14px;">Opção 1</span><br />
                                        2.000 Pontos<br />
                                        R$ 10,00<br />
                                        <form method='post' action='https://www.moip.com.br/Process.do' target='_blank'>
                                        <input type='hidden' name='method' value='digitalsale'/>
                                        <input type='hidden' name='eproduct_id' value='55860'/>
                                        <input type='hidden' name='type' value='1'/>
                                        <button type="submit" class="btn btn-warning" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 2</span><br />
                                        5.000 Pontos<br />
                                        R$ 20,00<br />
                                        <form method='post' action='https://www.moip.com.br/Process.do' target='_blank'>
                                        <input type='hidden' name='method' value='digitalsale'/>
                                        <input type='hidden' name='eproduct_id' value='65720'/>
                                        <input type='hidden' name='type' value='1'/>
                                        <button type="submit" class="btn btn-warning" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                    <div style="position:absolute; margin-left:200px;">
                                        <span style="font-size:14px;">Opção 3</span><br />
                                        12.000 Pontos<br />
                                        R$ 40,00<br />
                                        <form method='post' action='https://www.moip.com.br/Process.do' target='_blank'>
                                        <input type='hidden' name='method' value='digitalsale'/>
                                        <input type='hidden' name='eproduct_id' value='65721'/>
                                        <input type='hidden' name='type' value='1'/>
                                        <button type="submit" class="btn btn-warning" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 4</span><br />
                                        16.000 Pontos<br />
                                        R$ 60,00<br />
                                        <form method='post' action='https://www.moip.com.br/Process.do' target='_blank'>
                                        <input type='hidden' name='method' value='digitalsale'/>
                                        <input type='hidden' name='eproduct_id' value='65722'/>
                                        <input type='hidden' name='type' value='1'/>
                                        <button type="submit" class="btn btn-warning" name="submit" id="submit" alt='Comprar' style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div style="float:right;"><img src="./web-gallery/images/logo_ps.png" /></div>
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Pontos via PagSeguro</div>
                                    </div>
                                    <div style="float:left;">
                                        <span style="font-size:14px;">Opção 1</span><br />
                                        2.000 Pontos<br />
                                        R$ 10,00<br />
                                        
                                        <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" target="_blank">
                                        <input type="hidden" name="code" value="188B201C99993DDEE4B42FA57D2A9B72" />
                                        <button type="submit" class="btn btn-success" name="submit" alt="Comprar" style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 2</span><br />
                                        5.000 Pontos<br />
                                        R$ 20,00<br />
                                        <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" target="_blank">
                                        <input type="hidden" name="code" value="C9E8898C21214B1AA469BFBE03540B84" />
                                        <button type="submit" class="btn btn-success" name="submit" alt="Comprar" style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                    <div style="position:absolute; margin-left:200px;">
                                        <span style="font-size:14px;">Opção 3</span><br />
                                        12.000 Pontos<br />
                                        R$ 40,00<br />
                                        <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" target="_blank">
                                        <input type="hidden" name="code" value="C96DD154B9B935EBB47B7F8CC1621E83" />
                                        <button type="submit" class="btn btn-success" name="submit" alt="Comprar" style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />

                                        <span style="font-size:14px;">Opção 4</span><br />
                                        16.000 Pontos<br />
                                        R$ 60,00<br />
                                        <form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" target="_blank">
                                        <input type="hidden" name="code" value="208372572323BEE9947B3F83DB37A1D2" />
                                        <button type="submit" class="btn btn-success" name="submit" alt="Comprar" style="margin-top:10px;">Comprar</button>
                                        </form><br /><br />
                                    </div>
                                </div>
                            </section>
                        </div>
                        
                        <div class="col-lg-6 col-sm-6 boxkatrix">
                            <section class="panel">                   
                                <div class="panel-body">
                                    <div style="float:right;"><img src="./web-gallery/images/logo_pg.png" /></div>
                                    <div class="clearfix m-b">
                                        <div style="font-size:16px; font-weight:bold;">Pontos via SMS</div>(celular)
                                    </div>
                                    <div style="float:left;">
                                        <span style="font-size:14px;">Opção 1</span><br />
                                        500 Pontos<br />
                                        R$ 7,00 + impostos<br />
                                        <button onclick="alert('Compra por SMS em manutenção');" class="btn btn-danger" style="margin-top:10px;">Comprar</button>
                                                                                <!-- PayGol Form using Post method -->'
                                        <!--<form name="pg_frm" method="post" action="http://www.paygol.com/micropayment/paynow" target="_blank">
                                            <input type="hidden" name="pg_serviceid" value="48980">
                                            <input type="hidden" name="pg_currency" value="BRL">
                                            <input type="hidden" name="pg_name" value="<?php echo $shortname; ?> Rubis - 500">
                                            <input type="hidden" name="pg_custom" value="<?php echo $my_id; ?>">
                                            <input type="hidden" name="pg_price" value="7.00">
                                            <input type="hidden" name="pg_return_url" value="http://server.factoryhotel.com.br/buyruby?ac=success">
                                            <input type="hidden" name="pg_cancel_url" value="http://server.factoryhotel.com.br/buyruby">
                                            <button type="submit" class="btn btn-danger" name="pg_button" id="submit" style="margin-top:10px;">Comprar</button>
                                        </form>-->
                                    </div>
                                </div>
                            </section>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-4">
                    <section class="panel">
                        <div class="panel-body" onclick="hola()" style="cursor:pointer; border-radius: 4px 4px 0 0; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; background: url('<?php echo $cms_url; ?>/web-gallery/images/ima1.png');">
                            <div class="clearfix text-center m-t">
                                <div class="inline">
                                    <div class="easypiechart" data-percent="10" data-line-width="5" data-loop="false" data-bar-color="#92cf5c" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="150">
                                        <div class="thumb-lg">
                                            <img style="background:#a3a3a3; padding-bottom:7px; border:solid 2px #fff; -webkit-border-radius: 200px; -moz-border-radius: 200px; border-radius: 200px;" src="http://www.habbo.co.uk/habbo-imaging/avatarimage?figure=<?php echo $myrow['look']; ?>&size=b&direction=2&head_direction=2&action=wlk&gesture=n&size=n" />
                                        </div>
                                    </div>
                                    <div class="h4 m-t m-b-xs" style=" color:#fff; text-shadow:1px 1px #000;"><?php echo $myrow['username']; ?></div>


                                </div>                      
                            </div>
                        </div>
                        <footer class="panel-footer bg-dark lter text-center">
                            <div class="row pull-out" style="color:#fff;">
                                <div class="col-xs-4" style="background:#ceb900;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['credits']; ?></span>
                                        <small>Moedas</small>
                                    </div>
                                </div>
                                <div class="col-xs-4" style="background:#0064c9;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['activity_points']; ?></span>
                                        <small>Píxels</small>
                                    </div>
                                </div>
                                <div class="col-xs-4" style="background:#9d00bc;">
                                    <div class="padder-v">
                                        <span class="m-b-xs h4 block"><?php echo $myrow['vip_points']; ?></span>
                                        <small>Pontos VIP</small>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </section>

                    <section class="panel">
                        <h4 class="font-thin padder">Sobre os Pontos</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                Pontos de catálogo são parecidos com as moedas utilizadas no hotel, porém estes pontos são utilizados para adquirir super raros e emblemas exclusivos, onde estes jamais entrarão no catálogo normal!<br /><br />

                                A venda destes pontos, é realizada através de SMS (celular), boleto bancário ou cartão de crédito.<br />
                                Com os pontos você irá acessar nosso catálogo e por lá irá comprar raros e emblemas.<br /><br />

                                Confira os planos ao lado e adquira já seus pontos e desfrute de nossa incrível loja!
                            </li>
                        </ul>
                    </section>

                    <section class="panel text-center bg-inverse dker">
                        <div class="panel-body">
                            <h4 class="text-uc">JUNTE-SE SOCIALMENTE</h4>
                            <p>Quer ficar ligado das novidades do <?php echo $shortname; ?>?</p>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">redes sociais</small>
                            <p class="m-t-sm">
                                <a href="<?php echo $facebook; ?>" target="_blank" class="btn btn-rounded btn-facebook btn-icon" style="width: 120px;"><img src="./web-gallery/images/icon/facebook.png" style="margin-right:5px; padding-bottom:3px;" /> FACEBOOK</a>
                                <a href="<?php echo $twitter; ?>" target="_blank" class="btn btn-rounded btn-twitter btn-icon" style="width: 120px;"><img src="./web-gallery/images/icon/twitter.png" style="margin-right:5px;" /> TWITTER</a>
                            </p>
                        </div>
                    </section>
                </div>
            </div>          
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a>
</section>
<!-- /.vbox -->
</section>
<script src="./web-gallery/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./web-gallery/js/bootstrap.js"></script>
<!-- Sparkline Chart -->
<script src="./web-gallery/js/jquery.sparkline.min.js"></script>
<!-- App -->
<script src="./web-gallery/js/app.js"></script>
<script src="./web-gallery/js/app.plugin.js"></script>
<script src="./web-gallery/js/app.data.js"></script>  
<script src="./web-gallery/js/jquery.slimscroll.min.js"></script>  
<script src="./web-gallery/js/easypiechart/jquery.easy-pie-chart.js"></script>
<script type="text/javascript" src="./web-gallery/js/socket.io.js"></script>
<script src="./web-gallery/js/katrixweb.js"></script>
</body>
</html>