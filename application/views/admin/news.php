<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $this->lang->line('admin_news_1');?> </h3>
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
						<a href="/index.php/adminpanel/add_news" class="btn btn-success btn-block" role="button"><?php echo $this->lang->line('admin_news_2');?></a> 
						<?php if(isset($_SESSION['news_added'])): ?>
							<p class="success"><?php echo $this->lang->line('admin_news_3');?></p>
						<?php endif; ?>
						<?php if(isset($news)): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th><?php echo $this->lang->line('admin_news_4');?></th>
								  <th><?php echo $this->lang->line('admin_news_5');?></th>
								  <th><?php echo $this->lang->line('admin_news_6');?></th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($news as $n):?>
									<tr>
									  <td><?php echo $n['title_russian'];?></td>
									  <?php
										$content = preg_replace("/<img[^>]+\>/i", "(image) ", $n['body_text_russian']);
										?>
									  <td>
										<a href="/index.php/adminpanel/news_view/<?php echo $n['id'];?>"><?php echo strlen($content) > 700 ? substr($content, 0, 700) . '...' : $content;?> </a>
									  </td>
									  <td>
										<a href="/index.php/adminpanel/news_edit/<?php echo $n['id'];?>"><i class="fa fa-edit" style="font-size:25px;"></i> </a>
									  </td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="pagination pagination-split">
							<?php					
								echo $this->pagination->create_links();					
							?>
                        </ul>
                      </div>
							</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('no_news');?></p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->