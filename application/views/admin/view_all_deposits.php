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
					<form method="post" id="usearch" action="https://tradeprofit.net/index.php/adminpanel/view_all_deposits">
						 <!--  -->
						<select name="type">
							<option value="login"><?php echo $this->lang->line('admin_view_all_deposits_1');?></option>
							<option value="iddepo_plan"><?php echo $this->lang->line('admin_view_all_deposits_2');?></option>
							<option value="start_date"><?php echo $this->lang->line('admin_view_all_deposits_3');?></option>
							<option value="end_date"><?php echo $this->lang->line('admin_view_all_deposits_4');?></option>
							<option value="deposit_sum"><?php echo $this->lang->line('admin_view_all_deposits_5');?></option>
						</select>
						<div class="input-group" id="for_inputs">
							<input type="text" name="val" class="form-control" placeholder="value...">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="$('#usearch').submit();" type="button">Search</button>
							</span>
						</div>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'deposit_sum' ) {
								$('#for_inputs').html('<input type="text" name="val" class="form-control" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'iddepo_plan') {
								$('#for_inputs').html('<br><select name="val"><option value="1">CLASSIC</option><option value="2">PREMIUM</option><option value="3">EXCLUSIVE</option></select><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'start_date' || val == 'end_date') {
								$('#for_inputs').html('<input type="date" name="val" class="form-control" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}
						})
					</script>
                </div>
              </div>
        <br />
		  
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $this->lang->line('admin_view_all_deposits_6');?> </h2>
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
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_7');?></th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_8');?></th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_9');?></th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_10');?></th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_11');?></th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_all_deposits_12');?></th>
								</th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($transactions as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td class=" "><?php echo $trans['login'];?></td>
										<td class=" "><?php if($trans['iddepo_plan'] == 1){echo 'CLASSIC';}elseif($trans['iddepo_plan'] == 2){echo 'PREMIUM';}elseif($trans['iddepo_plan'] == 3){echo 'EXCLUSIVE';}?> </td>
										<td class=" "><?php echo $trans['start_date'];?></td>
										<td class=" "><?php echo $trans['end_date'];?></td>
										<td class=" "><?php echo $trans['deposit_sum'];?></td>
										<td class=" "><?php echo $trans['income'];?></td>
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
