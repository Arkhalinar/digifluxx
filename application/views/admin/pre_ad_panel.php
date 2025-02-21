<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Preview advertise view </h3>
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
						<button onclick="document.location.href='/index.php/adminpanel/pre_ad_create'">Add new block</button> 
						<?php if(isset($_SESSION['news_added'])): ?>
							<p class="success"><?php echo $this->lang->line('admin_news_3');?></p>
						<?php endif; ?>
						<?php if(isset($blocks)): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>№</th>
								  <th>Left</th>
								  <th>Middle</th>
								  <th>Right</th>
								  <th>State</th>
								  <th>Action</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($blocks as $n):?>
									<tr>
										<td>
											<?php
												echo $n['id'];
											?>
										</td>
										<td>
											<?php
												if(is_null($n['block_1']))
												{
													echo '- |empty| -';
												}
												else 
												{
													$info = json_decode($n['block_1'], true);
													switch ($info['type']) {
														case 'text':
															echo '<p>'.$info['content'].'</p>';
															break;
														case 'img':
															echo '<img src="'.$info['content'].'">';
															break;
														case 'vid':
															echo '<iframe src="https://www.youtube.com/embed/'.$info['content'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
															break;
													}
												}
											?>
										</td>
										<td>
											<?php
												if(is_null($n['block_2']))
												{
													echo '- |empty| -';
												}
												else 
												{
													$info = json_decode($n['block_2'], true);
													switch ($info['type']) {
														case 'text':
															echo '<p>'.$info['content'].'</p>';
															break;
														case 'img':
															echo '<img src="'.$info['content'].'">';
															break;
														case 'vid':
															echo '<iframe src="https://www.youtube.com/embed/'.$info['content'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
															break;
													}
												}
											?>
										</td>
										<td>
											<?php
												if(is_null($n['block_3']))
												{
													echo '- |empty| -';
												}
												else 
												{
													$info = json_decode($n['block_3'], true);
													switch ($info['type']) {
														case 'text':
															echo '<p>'.$info['content'].'</p>';
															break;
														case 'img':
															echo '<img src="'.$info['content'].'">';
															break;
														case 'vid':
															echo '<iframe src="https://www.youtube.com/embed/'.$info['content'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
															break;
													}
												}
											?>
										</td>
										<td>
											<?php
												echo 'Lang: <span style="font-weight:bold; font-size:120%;">'.$n['lang'].'</span>';
											?>
											<br><br>
											<?php
												echo 'State: ';
												if($n['status'] == 1)
												{
													echo '<span style="color:green;font-weight:bold; font-size:120%;">on</span>';
												}
												else
												{
													echo '<span style="color:red;font-weight:bold; font-size:120%;">off</span>';
												}
											?>
											<br><br>
											<?php
												echo $n['date'];
											?>
										</td>
										<td>
											<button onclick='document.location.href="/index.php/adminpanel/pre_ad_edit/<?php echo $n['id'];?>"'>EDIT</button> 
											<hr>
											<button onclick='document.location.href="/index.php/adminpanel/pre_ad_del/<?php echo $n['id'];?>"'>DELETE</button> 
										</td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      		</div>
						</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i>There are no block's now</p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->