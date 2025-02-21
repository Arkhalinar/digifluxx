 <!-- page content -->
		<script>
			$(document).ready(function() {
				$('#usearch button').on('click', function(){
					$('#usearch').submit();
				});
			});
		</script>
		<div class="right_col" role="main">
		<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form method="post" id="usearch" style="display:none;">
                  <div class="input-group">
					<input type="text" name="username" class="form-control" placeholder="<?php echo $this->lang->line('search');?>">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><?php echo $this->lang->line('submit');?></button>
					</form>
                    </span>
                  </div>
                </div>
              </div>
         <br />
		  
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $this->lang->line('view_history');?> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#" class="toggle-view"><?php echo $this->lang->line('show_calendar');?></a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
						  <div class="col-md-12 view-calendar">
							<div id="calendar" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
							  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
							  <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
							</div>
						  </div>
					<div class="clearfix"></div>
				</div>

                  <div class="x_content">
                    
						<div class="table-responsive">
						<?php if(count($transactions)>0): ?>
						  <table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_1');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_2');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_3');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_4');?> </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_5');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_user_history_6');?> </th>
								<th class="column-title no-link last"><span class="nobr"><?php echo $this->lang->line('admin_view_all_user_history_7');?> </span>
								</th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($transactions as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td class=" "><?php echo $trans['id'];?></td>
										<td class=" "><?php echo $trans['actiondate'];?> </td>
										<td class=" "><?php if($trans['type'] == 1):?>
												<?php echo $this->lang->line('type_inner');?>
											<?php elseif($trans['type'] == 2): ?>
												<?php echo $this->lang->line('type_income');?>
											<?php elseif($trans['type'] == 4): ?>
												<?php echo $this->lang->line('type_byuplace');?>
											<?php elseif($trans['type'] == 5): ?>
												<?php echo $this->lang->line('type_struct_close_bonus');?>
											<?php elseif($trans['type'] == 6): ?>
												<?php echo $this->lang->line('type_ref_bonus');?>
											<?php elseif($trans['type'] == 7): ?>
												<?php echo $this->lang->line('admin_view_all_user_history_8');?>
											<?php elseif($trans['type'] == 8): ?>
												<?php echo $this->lang->line('admin_view_all_user_history_9');?>
											<?php elseif($trans['type'] == 9): ?>
												<?php echo $this->lang->line('admin_view_all_user_history_10');?>
											<?php else: ?>
												<?php echo $this->lang->line('type_withdraw');?>
											<?php endif ;?></td>
										<td class=" "><?php echo $trans['receivername'];?></td>
										<td class=" "><?php echo $trans['sendername'];?></td>
										<td class=" "><?php if($trans['status'] == 1):?>
												<?php echo $this->lang->line('payment_done');?>
											<?php elseif($trans['status'] == 2):?>
												<?php echo $this->lang->line('payment_pending');?>
											<?php else:?>
												<?php echo $this->lang->line('payment_cancelled');?>
											<?php endif;?></td>
										<td class="a-right a-right "><?php echo $trans['amount'];?></td>
										</td>
									  </tr>
								<?php endforeach; ?>

							</tbody>
						  </table>
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="pagination pagination-split">
							<?php					
								echo $this->pagination->create_links();					
							?>
                        </ul>
                      </div>
						  <?php else: ?>
								<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('nothing_found');?></p>
							<?php endif; ?>
						</div>
					

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
