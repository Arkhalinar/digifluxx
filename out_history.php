<?php
	include "header.php"; 
?>

		<!-- <div class="content">
			<h2>&#8212; Бонус Пул финансовая история &#8212;</h2>
			<div class="row over">
				<h1 class="developing">В РАЗРАБОТКЕ</h1>
				<img class="tools" src="../img/tools.png">
			</div>
		</div> -->
		
		<?php
			if(true) {
		?>
		<div class="content">
			<h2>&#8212; Бонус Пул финансовая история &#8212;</h2>
			<div class="row over">
				<?php
					if(!isset($_GET['p']) || !is_numeric($_GET['p']) || $_GET['p'] < 0) {
						$_GET['p'] = 1;
					}

					$start = 5*($_GET['p']-1);

					$res = $DBdes->query("SELECT ID FROM fin_table_pool WHERE Login='".$_SESSION['usName']."'");
					$allCount = $res->rowCount();

					$res = $DBdes->query("SELECT * FROM fin_table_pool WHERE Login='".$_SESSION['usName']."' ORDER BY ID DESC LIMIT ".$start.", 5");
					if($res->rowCount() > 0) {
				?>
				<table id="fin_table">
					<tr>
						<th>Дата</th>
						<th>Сумма</th>
						<th>Действие</th>
					</tr>
					<?php
				  		$arr = $res->fetchAll(PDO::FETCH_ASSOC);
						for($i = 0; $i < count($arr); $i++) {
				  	?>
							<tr>
								<td><?php echo $arr[$i]['Date']; ?></td>
								<td style="<?php if($arr[$i]['ChBal'][0] == '+') { ?>color:green;<?php }else{ ?>color:red;<?php } ?>"><?php echo $arr[$i]['ChBal']; ?> $</td>
								<td><?php echo $arr[$i]['Event']; ?></td>
							</tr>
					<?php
				  		}
				  	?>
				</table>
				<?php
					if($allCount > 5) {
				?>
						<div class="pagination">


							<?php
								if($_GET['p'] == 1 && $allCount > 5) {
							?>
								<a class="active-pag" href="#">1</a>
								<a href="?p=2#fin_table">2</a>
							<?php
								}elseif($_GET['p']*3 >= $allCount) {
							?>
								<a href="?p=<?php echo $_GET['p']-1;?>#fin_table"><?php echo $_GET['p']-1;?></a>
								<a class="active-pag"><?php echo $_GET['p'];?></a>
							<?php
								}else {
							?>
								<a href="?p=<?php echo $_GET['p']-1;?>#fin_table"><?php echo $_GET['p']-1;?></a>
								<a class="active-pag" href="#"><?php echo $_GET['p'];?></a>
								<a href="?p=<?php echo $_GET['p']+1;?>#fin_table"><?php echo $_GET['p']+1;?></a>
							<?php
								}
							?>
						</div>
				<?php
						}
			  		}else {
			  	?>
			  		<br><br>
			  		<h2 style="text-align: center;">У вас еще небыло записей в истории.</h2>
			  	<?php
					}
			  	?>
			</div>
		</div>
		<?php
			}
		?>

<?php
	include "footer.php"; 
?>