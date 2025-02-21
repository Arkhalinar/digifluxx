     <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>


<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>
			<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
		 		  <div class="x_title">
                    <h2>ADV </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
					<div class="x_content" style="overflow-x: scroll;">
					<form method="post" action="<?php echo base_url();?>index.php/adminpanel/process_banners">
					<table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
							  	<th>
	                              <!-- <input type="checkbox" id="check-all"> -->
	                            </th>
								<th class="column-title"><?php echo $this->lang->line('admin_view_adv_1');?> </th>
				                <th class="column-title"><?php echo $this->lang->line('admin_view_adv_2');?>  </th>
				                <th class="column-title"><?php echo $this->lang->line('admin_view_adv_3');?> </th>
				                <!-- <th class="column-title no-link last"><?php echo $this->lang->line('admin_view_adv_3');?> </th> -->
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($comps as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td>
			                              <input type="checkbox" class="in_form" name="table_records[]" value="<?php echo $trans['id'];?>">
			                            </td>
										<td class=" ">
											<?php echo $trans['id'];?>
											<br>
											<i class="fas fa-user"></i>
											<b>
												<a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $trans['login'];?>"><?php echo $trans['login'];?></a>
											</b>
											<br>
					                    	<?php if($trans['language'] == 'russian') { ?>
												<img class="img-lang" src="/assets/images/rus.png?v=2">
											<?php }elseif($trans['language'] == 'english') { ?>
												<img class="img-lang" src="/assets/images/en.png?v=2">
											<?php }elseif($trans['language'] == 'german') { ?>
												<img class="img-lang" src="/assets/images/de.png?v=2">
											<?php } ?>
										</td>
					                   
					                    <td class=" ">
					                      <?php echo json_decode($trans['wotid']);?>
					                    </td>
					                    <td class=" ">
					                    	<?php
					                    		if($trans['status'] == 1) {
					                    			echo 'closed';
					                    		}else {
					                    			echo 'Waiting';
					                    		}
					                    	?>
					                    </td>
					                    <!-- <td class="middle btn-table-user text-center">
											<p class="padding-top10">
				                        		<textarea name="riason_<?php echo $trans['id'];?>" id="reas_<?php echo $trans['id'];?>" placeholder="EUR"></textarea>
				                        		<script type="text/javascript">
													$('#reas_<?php echo $trans['id'];?>').on('click', function(){
														$('#null_radio_<?php echo $trans['id'];?>').prop('checked', false);
													})
												</script>
				                        		<br>
												<div class="padding-top5">
													<input type="button" class="refuse" onclick="CancelFunc(<?php echo $trans['id'];?>)" name="CancelBnr" value="Accept">
												</div>
											</p>
					                    </td> -->
									  </tr>
								<?php endforeach; ?>

							</tbody>
					</table>
					<!-- <div class="col-md-3 col-sm-3 col-xs-3">
						<label><?php echo $this->lang->line('transactions_marked');?></label>
                          <select name="act" class="form-control">
							<option value="1">Подтвердить</option>
							<option value="2">Отклонить</option>
							<option value="3">Удалить</option>
                          </select>
					  <input type="submit" />
                        </div> -->
					  </form>
					  <script type="text/javascript">
					  	$('#check-all').click(function(){
					  		if($('#check-all:checked') != undefined) {
					  			$('.in_form').click();
					  		}else {
					  			$('.in_form').attr('checked', 'checked');
					  		}
					  	})
					  </script>
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="pagination pagination-split">
							<?php					
								echo $this->pagination->create_links();					
							?>
                        </ul>
                      </div>

					</div>
					</div>
					
					
					</div>
					
					
					
					</div>
					</div>
					</div>



					<script type="text/javascript">
						function CancelFunc(id) {
							document.location.href='/adminpanel/accept_adv/'+id+'?sum='+$('textarea[name=riason_'+id+']').val();
						}
					</script>