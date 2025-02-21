<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $this->lang->line('admin_pending_payments_1');?></h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row" style="overflow-x:auto;">
              <div class="col-md-12 col-sm-12 col-xs-12">
				
				<?php if(isset($_SESSION['payment_error'])):?>
				<p class="no_reflink"><?php echo $this->lang->line('admin_pending_payments_2');?> <?php if(isset($_SESSION['desc'])) echo ' - ' . $_SESSION['desc'];?></p>
				<?php endif;?>
				
			  <?php if(isset($_SESSION['withdraw_error'])):?>
				<p class="no_reflink"><?php echo $this->lang->line('payment_error');?>: <?php echo $_SESSION['withdraw_error'];?></p>
			  <?php elseif(isset($_SESSION['low_funds'])):?>
				<p class="no_reflink"><?php echo $this->lang->line('error_wallet_low_funds');?></p>
				<?php elseif(isset($_SESSION['transferred'])):?>
					<p class="success"><?php echo $this->lang->line('transactions_done');?></p>
				<?php endif;?>
			  
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
					  <div class="x_content">
						
						<!-- start project list -->
						<?php if(isset($transactions) && count($transactions) > 0):?>

            <?php
            $sum_all_out = 0;
            foreach($transactions as $trans):
              $sum_all_out = bcadd($sum_all_out, $trans['amount'], 4);
            endforeach;
            ?>
              <p style="text-align: right;"><?php echo $this->lang->line('admin_pending_payments_3');?> <?php echo $sum_all_out;?> $</p>
							<form method="post" action="<?php echo base_url();?>index.php/adminpanel/process_payments">
							<div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                    			<!-- <th class="column-title">#<?php //echo $this->lang->line('order_num');?> </th> -->
          								<th class="column-title"><?php echo $this->lang->line('order_date');?> </th>
          								<th class="column-title"><?php echo $this->lang->line('order_sender');?> </th>
          								<!-- <th class="column-title"><?php //echo $this->lang->line('status');?> </th> -->
                          <th class="column-title"><?php echo $this->lang->line('admin_pending_payments_4');?> </th>
                          <th class="column-title"><?php echo $this->lang->line('admin_pending_payments_5');?> </th>
                          <th class="column-title"><?php echo $this->lang->line('admin_pending_payments_6');?> </th>
                          <th class="column-title"><?php echo $this->lang->line('admin_pending_payments_7');?> </th>
          								<th class="column-title no-link last"><span class="nobr"><?php echo $this->lang->line('sum');?></span>

                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;"><?php echo $this->lang->line('bulk_actions');?> ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
							<?php $counter = 0;
								foreach($transactions as $trans):?>
								<?php if($counter % 2 == 0) $class = "odd";
								else $class = "even";?>
                          <tr class="<?php echo $class;?> pointer">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records[]" value="<?php echo $trans['id'];?>">
                            </td>
                            <!-- <td class=" "><?php //echo $trans['id'];?></td> -->
                            <td class=" "><?php echo $trans['actiondate'];?> </td>
                            <td class=" "><a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $trans['sendername'];?>" target="_blank"><?php echo $trans['sendername'];?></a></td>
                            <!-- <td class=" "><?php //echo $this->lang->line('payment_pending');?></td> -->
                            <td class=" "><?php echo $trans['btc_address'];?></td>
                            <td class=" "><?php echo $trans['currency'];?></td>
                            <td class=" "><?php echo $trans['userlang'];?></td>
                            <td class=" "><textarea name="riason_<?php echo $trans['id'];?>"></textarea></td>
                            <td class="a-right a-right "><?php echo $trans['amount'];?> </td>
                            </td>
                          </tr>
						  <?php endforeach; ?>
                        </tbody>
                      </table>
					  
					  <div class="col-md-3 col-sm-3 col-xs-3">
						<label><?php echo $this->lang->line('transactions_marked');?></label>
                          <select name="act" class="form-control">
							<option value="1"><?php echo $this->lang->line('admin_pending_payments_8');?></option>
							<option value="2"><?php echo $this->lang->line('admin_pending_payments_9');?></option>
                          </select>
					  <input type="submit" />
                        </div>
					  </form>
                    </div>
					<?php else: ?>
						<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('admin_pending_payments_10');?></p>
					<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->