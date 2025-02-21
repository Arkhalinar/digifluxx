<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Countries</h3>
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
						<a href="/index.php/adminpanel/country_create" class="btn btn-success btn-block" role="button">Create</a> 
						<?php if(isset($_SESSION['news_added'])): ?>
							<p class="success"><?php echo $this->lang->line('admin_news_3');?></p>
						<?php endif; ?>
						<?php if(isset($countries) && count($countries) > 0): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>Country</th>
								  <th>Category</th>
								  <th>Action</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($countries as $n):?>
									<tr>
									  <td>
									  	<?php
									  		echo $n['country'];
									  	?>
									  </td>
									  <td>
										<?php
									  		echo $n['category'];
									  	?>
									  </td>
									  <td>
										<a href="/index.php/adminpanel/country_edit/<?php echo $n['id'];?>"><i class="fa fa-edit" style="font-size:25px;"></i> </a>
										<a href="/index.php/adminpanel/country_del/<?php echo $n['id'];?>"><i class="fa fa-trash" style="font-size:25px;"></i> </a>
									  </td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      		</div>
						</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i>There are no countries</p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->