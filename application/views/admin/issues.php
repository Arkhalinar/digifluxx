<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $this->lang->line('support_messages');?> </h3>
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
						<?php if(isset($_SESSION['issue_deleted'])):?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('record_deleted');?></p>
						<?php endif;?>
						<?php if(isset($issues)): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>№ <?php echo $this->lang->line('issue_no');?></th>
								  <th><?php echo $this->lang->line('msg_title');?></th>
								  <th><?php echo $this->lang->line('news_text');?></th>
								  <th><?php echo $this->lang->line('uid');?></th>
								  <th><?php echo $this->lang->line('ulogin');?></th>
								  <th><?php echo $this->lang->line('delete');?></th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($issues as $issue):?>
									<tr>
									  <td><?php echo $issue['id'];?></td>
									  <td><?php echo $issue['title'];?></td>
									  <td>
										<?php echo $issue['body_text'];?>
									  </td>
									  <td><?php echo $issue['iduser'];?></td>
									  <td><?php echo $issue['login'];?></td>
									  <td>
										<a href="/index.php/adminpanel/delete_issue/<?php echo $issue['id'];?>"><i class="fa fa-close delete"></i></a>
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
							<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('no_issues');?></p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->