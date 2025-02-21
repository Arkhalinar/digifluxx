<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Packets </h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row" style="overflow-x:auto;">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
					  <div class="x_content">

						<!-- start project list -->
						<a href="/index.php/adminpanel/add_packet" class="btn btn-success btn-block" role="button">Create</a> 
						<?php if(isset($_SESSION['news_added'])): ?>
							<p class="success"><?php echo $this->lang->line('admin_news_3');?></p>
						<?php endif; ?>
						<?php if(isset($packets)): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>Name of packets</th>
								  <th>Product</th>
								  <th>Price</th>
								  <th>Date</th>
								  <th>Action</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($packets as $n):?>
									<tr>
									  <td>
									  	<?php
									  		$ArrayOfPacketsName = json_decode($n['name_of_packet'], true);
									  		echo $ArrayOfPacketsName['ENG'].'(EN)<hr>'.$ArrayOfPacketsName['RUS'].'(RUS)<hr>'.$ArrayOfPacketsName['GER'].'(GER) ';
									  	?>
									  </td>
									  <td>
										<?php
									  		$ArrayOfPacketsProduct = json_decode($n['product'], true);
									  		$start = true;
									  		for ($i=1; $i <= 4; $i++) { 
									  			if(empty($ArrayOfPacketsProduct[$i])) {
									  				continue;
									  			}
									  			if(!$start) {
									  				echo '<hr>';
									  			}
									  			echo 'BONUS PR-M: '.$i.'<br>SCALE AT LEVEL: '.$ArrayOfPacketsProduct[$i]['lvl'].'<br>STARTING VALUE: '.$ArrayOfPacketsProduct[$i]['insta_balance'].' Credits';
									  			if($start) {
									  				$start = false;
									  			}

									  		}
									  	?>
									  </td>
									  <td>
									  	<?php
									  		echo $n['price'].' Credits';
									  	?>
									  </td>
									  <td>
									  	<?php
									  		echo $n['date'];
									  	?>
									  </td>
									  <td>
										<a href="/index.php/adminpanel/packet_edit/<?php echo $n['id'];?>"><i class="fa fa-edit" style="font-size:25px;"></i> </a>
										<hr>
										<a href="/index.php/adminpanel/packet_del/<?php echo $n['id'];?>"><i class="fa fa-window-close" style="font-size:25px;"></i> </a>
									  </td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      		</div>
						</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i>There are no packets now</p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->