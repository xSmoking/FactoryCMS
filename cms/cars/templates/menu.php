			<div style="font-size:16px; font-weight:bold; margin:10px 7px;">Menu</div>
			<ul style="margin-bottom:30px; margin-top:0px; padding:0px;">
				<li><a href="index.php?class=s">Carros classe S</a></li>
				<li><a href="index.php?class=a">Carros classe A</a></li>
				<li><a href="index.php?class=b">Carros classe B</a></li>
				<li><a href="index.php?class=c">Carros classe C</a></li>
			</ul>
			<div style="font-size:16px; font-weight:bold; margin:10px 7px;">Informa&ccedil;&otilde;es</div>
			Voc&ecirc; possui:
			<table>
				<tr>
					<td><b>Pontos:</b> <?php echo $my_row['vip_points']; ?></td>
				</tr>
				<tr>
                    <td><b>Moedas:</b> <?php echo $my_row['credits']; ?></td>
                </tr>
                <tr>
                    <td><b>P&iacute;xels:</b> <?php echo $my_row['activity_points']; ?></td>
                </tr>
			</table>