         <div class="right_col" role="main">
		<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
					<form method="post" id="usearch" action="<?php echo base_url();?>index.php/adminpanel/view_user_history">
						 <!--  -->
						<select name="type">
							<option value="login"><?php echo $this->lang->line('admin_view_history_1');?></option>
							<option value="type"><?php echo $this->lang->line('admin_view_history_2');?></option>
							<option value="actiondate"><?php echo $this->lang->line('admin_view_history_3');?></option>
							<!-- <option value="amount">Сумма</option> -->
						</select>
						<div class="input-group" id="for_inputs">
							<input type="text" name="val" class="form-control" placeholder="Значение...">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="$('#usearch').submit();" type="button"><?php echo $this->lang->line('admin_view_history_4');?></button>
							</span>
						</div>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'amount' ) {
								$('#for_inputs').html('<input type="text" name="val" class="form-control" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'type') {
								$('#for_inputs').html('<br><select name="val"><option value="2">Пополнение счета</option><option value="3">Вывод</option><option value="33">Начисления за переход и просмотр</option><option value="38">Реф. отчисления</option><option value="45">Перевод средств с баланса компании</option><option value="46">Перевод средств на баланс компании</option><option value="456">Покупка кликов</option><option value="458">Возврат средств после удаления компании</option><option value="457">Покупка показов</option></select><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\'	).submit();">Search</button></span>');

							}else if(val == 'actiondate') {
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
                    <h2><?php echo $this->lang->line('admin_view_history_5');?> </h2>
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
						<?php if(!isset($not_found)): ?>
						  <table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_6');?> </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_7');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_8');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_9');?> </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_10');?>  </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_history_11');?> </th>
								<th class="column-title no-link last"><span class="nobr"><?php echo $this->lang->line('admin_view_history_12');?> </span>
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
										<td class=" ">
											<?php
											 // if($trans['type'] == 2)
			         //                          $desc = 'Пополнение';
			         //                        if($trans['type'] == 3)
			         //                          $desc = "Заказ выплаты";
			         //                        if($trans['type'] == 33)
			         //                            $desc = 'Начисления за переход и просмотр';
			         //                        if($trans['type'] == 38)
			         //                            $desc = 'Рефферальные начисления';
			         //                        if($trans['type'] == 45)
			         //                            $desc = 'Перевод средств с баланса компании';
			         //                        if($trans['type'] == 46)
			         //                          $desc = 'Перевод средств на баланс компании';
			         //                        if($trans['type'] == 456)
			         //                          $desc = 'Покупка кликов';
			         //                        if($trans['type'] == 458)
			         //                          $desc = 'Возврат средств после удаления компании';
			         //                        if($trans['type'] == 457)
			         //                          $desc = 'Покупка показов';
			         //                      	if($trans['type'] == 1912)
            //                       				$desc = 'Перевод средств с основного баланса на рекламный';
            //                       			if($trans['type'] == 1913)
            //                       				$desc = 'Покупка тарифа';
            //                       			if($trans['type'] == 1902)
            //                       				$desc = 'Начисления за выполнение условий бонуса';

											if($trans['type'] == 2)
			                                  $desc = $this->lang->line('type_income');
			                                if($trans['type'] == 3)
			                                  $desc = $this->lang->line('type_withdraw');
			                                if($trans['type'] == 33)
			                                  $desc = $this->lang->line('type_33');
			                                if($trans['type'] == 38)
			                                  $desc = $this->lang->line('type_38');
			                                if($trans['type'] == 45)
			                                  $desc = $this->lang->line('type_45');
			                                if($trans['type'] == 46)
			                                  $desc = $this->lang->line('type_46');
			                                if($trans['type'] == 456)
			                                  $desc = $this->lang->line('type_456');
			                                if($trans['type'] == 458)
			                                  $desc = $this->lang->line('type_458');
			                                if($trans['type'] == 457)
			                                  $desc = $this->lang->line('type_457');
			                                if($trans['type'] == 1912)
			                                  $desc = $this->lang->line('transfer_word_5');
			                                if($trans['type'] == 1913)
			                                  $desc = $this->lang->line('new_trans_1');
			                                if($trans['type'] == 1902)
			                                  $desc = $this->lang->line('new_trans_2');
			                                if($trans['type'] == 496)
			                                  $desc = $this->lang->line('mail_55');
			                                if($trans['type'] == 495)
			                                  $desc = $this->lang->line('mail_56');
			                                if($trans['type'] == 4558)
			                                  $desc = $this->lang->line('mail_57');
			                                if($trans['type'] == 1111)
			                                  $desc = $this->lang->line('struct_mess_1');
			                                if($trans['type'] == 1112)
			                                  $desc = $this->lang->line('struct_mess_2');
			                                if($trans['type'] == 1113)
			                                  $desc = $this->lang->line('struct_mess_3');
			                                if($trans['type'] == 1114)
			                                  $desc = $this->lang->line('struct_mess_4');
			                                if($trans['type'] == 1115)
			                                  $desc = $this->lang->line('struct_mess_5');
			                                if($trans['type'] == 1116)
			                                  $desc = $this->lang->line('struct_mess_6');
			                                if($trans['type'] == 2222)
			                                  $desc = 'Покупка тарифа VIP';
			                                if($trans['type'] == 3333)
			                                  $desc = 'Начисления с тарифа VIP';
			                                if($trans['type'] == 1117)
			                                  $desc = 'Начисления с тарифа Premium';
			                              	if($trans['type'] == 2220)
			                                  $desc = 'Покупка тарифа Business';
			                                if($trans['type'] == 2121)
			                                  $desc = 'Начисления с тарифа Business';

											echo $desc; ?></td>
										<td class=" "><?php
											if ($trans['receivername'] == null) {
			                                  $receivername = 'система';
			                                }else {
			                                	$receivername = $trans['receivername'];
			                                }
										 	echo $receivername;
										 	?></td>
										<td class=" "><?php
											if ($trans['sendername'] == null) {
			                                  $sender = 'система';
			                                }else {
			                                	$sender = $trans['sendername'];
			                                }
											echo $sender;
										?></td>
										<td class=" "><?php if($trans['status'] == 1):?>
												<?php echo $this->lang->line('admin_view_history_13');?>
											<?php elseif($trans['status'] == 2):?>
												<?php echo $this->lang->line('admin_view_history_14');?>
											<?php else:?>
												<?php echo $this->lang->line('admin_view_history_15');?>
											<?php endif;?></td>
										<td class="a-right a-right "><?php echo $trans['amount'];?> <?php echo $trans['currency'];?></td>
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
