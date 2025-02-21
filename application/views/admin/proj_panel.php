<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Categories</h3>
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
						<a href="/index.php/adminpanel/traf_proj_create" class="btn btn-success btn-block" role="button">Create</a> 
						<?php if(isset($packets) && count($packets) > 0): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>INFO</th>
								  <th>Image</th>
								  <th>Action</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($packets as $n):?>
									<tr>
									  <td>HEADER:<?php echo '<h3>'.$n['header'].'</h3><br><br>ABOUT:<p>'.$n['body']; ?></p><br>Link: <a href="<?php echo $n['url']; ?>"><?php echo $n['url']; ?></a><br><br>Ref Link: <a href="<?php echo $n['ref_url_for_check']; ?>"><?php echo $n['ref_url_for_check']; ?></a></td>
									  <td style="width: 45%;"><img style="width: 45%;" src="<?php if($n['type'] == 'link'){ echo $n['img'];}else{ echo '/'.$n['img'];} ?>"></td>
									  <td>
										<a href="/index.php/adminpanel/traf_proj_edit/<?php echo $n['id'];?>"><i class="fa fa-edit" style="font-size:25px;"></i> </a>
										<a href="/index.php/adminpanel/traf_proj_del/<?php echo $n['id'];?>"><i class="fa fa-trash" style="font-size:25px;"></i> </a>
									  </td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      		</div>
						</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i>There are no projects yet</p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->