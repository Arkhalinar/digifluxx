     <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>


<!-- page content -->
    <div class="right_col" role="main">
    	<div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
					<form method="post" class="search-select" id="usearch" action="/index.php/adminpanel/view_tprj">
						 <!--  -->
						<div class="input-group">
							<select name="type" class="form-control">
								<option <?php if(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'login'){ ?>selected<?php } ?> value="login">Владелец</option>
								<option <?php if(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'language'){ ?>selected<?php } ?> value="language">Язык</option>
								<option <?php if(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'format'){ ?>selected<?php } ?> value="format">Формат</option>
								<option <?php if(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'url'){ ?>selected<?php } ?> value="url">Ссылка</option>
								<option <?php if(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'Status'){ ?>selected<?php } ?> value="Status">Статус</option>
							</select>
						</div>
						<div class="input-group" id="for_inputs">
							<input type="text" name="val" class="form-control" placeholder="Значение...">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="$('#usearch').submit();" type="button">Поиск</button>
							</span>
						</div>
						<?php
							if(isset($_SESSION['val_b'])) {
						?>
						<div class="input-group" id="for_inputs">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="document.location.href='/index.php/adminpanel/reset_tprj'" type="button">Сбросить фильтрацию</button>
							</span>
						</div>
						<?php
							}
						?>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'url') {
								$('#for_inputs').html('<input type="text" name="val" class="form-control border-30" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'language') {
								$('#for_inputs').html('<select class="form-control" name="val"><option value="russian">Русский</option><option value="english">Английский</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'Status') {
								$('#for_inputs').html('<select class="form-control" name="val"><option value="0">Не верифицирована</option><option value="1">Верифицирована</option><option value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'format') {
								$('#for_inputs').html('<select class="form-control" name="val"><option value="125x125">125x125</option><option value="300x50">300x50</option><option value="300x250">300x250</option><option value="468x60">468x60</option><option value="728x90">728x90</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}
						})
						$(document).ready(function(){
							<?php if(isset($_SESSION['type_b']) && ($_SESSION['type_b'] == 'login' || $_SESSION['type_b'] == 'url')) { ?>
								$('#for_inputs').html('<input type="text" name="val" class="form-control border-30" value="<?php echo $_SESSION['val_b'];?>"><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'language') { ?>
								$('#for_inputs').html('<select class="form-control" name="val"><option <?php if($_SESSION['val_b'] == 'russian'){ ?>selected<?php } ?> value="russian">Русский</option><option <?php if($_SESSION['val_b'] == 'english'){ ?>selected<?php } ?> value="english">Английский</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'Status') { ?>
								$('#for_inputs').html('<select class="form-control" name="val"><option <?php if($_SESSION['val_b'] == 0){ ?>selected<?php } ?> value="0">Не верифицирована</option><option <?php if($_SESSION['val_b'] == 1){ ?>selected<?php } ?> value="1">Верифицирована</option><option <?php if($_SESSION['val_b'] == 2){ ?>selected<?php } ?> value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type_b']) && $_SESSION['type_b'] == 'format') { ?>
								$('#for_inputs').html('<select class="form-control" name="val"><option <?php if($_SESSION['val_b'] == '125x125'){ ?>selected<?php } ?> value="125x125">125x125</option><option <?php if($_SESSION['val_b'] == '300x50'){ ?>selected<?php } ?> value="300x50">300x50</option><option <?php if($_SESSION['val_b'] == '300x250'){ ?>selected<?php } ?> value="300x250">300x250</option><option <?php if($_SESSION['val_b'] == '468x60'){ ?>selected<?php } ?> value="468x60">468x60</option><option <?php if($_SESSION['val_b'] == '728x90'){ ?>selected<?php } ?> value="728x90">728x90</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php } ?>
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
				   <div class="x_content">
				   
				
					<div class="x_content" style="overflow-x: scroll;">
					<div class="snoska">
						<i class="fas fa-exclamation-circle orang"></i> - не верефицирован
						| <i class="fas fa-check-circle green"></i> - верефицирован
						| <i class="fas fa-ban red"></i> - откланен
						| <i class="fas fa-calendar-check blue"></i> - закончен
					</div>
					<form method="post" action="<?php echo base_url();?>index.php/adminpanel/process_tprjs">
					<table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
							  	<th>
	                              <input type="checkbox" id="check-all">
	                            </th>
								<th class="column-title">Id | Login | Lang </th>
				                <th class="column-title">Ссылка | Статистика</th>
				                <th class="column-title">Статус </th>
				                <th class="column-title no-link last">Причина отказа </th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($comps as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td>
			                              <input type="checkbox" class="in_form" name="table_records[]" value="<?php echo $trans['ID'];?>">
			                            </td>
										<td class=" ">
											<?php echo $trans['ID'];?>
											<br>
											<i class="fas fa-user"></i>
											<b><?php if($trans['type'] == 3){ ?>Спец баннер<?php }else{ ?><a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $trans['login'];?>"><?php echo $trans['login'];?></a><?php } ?>
											</b>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('d.m.Y', $trans['Date']);?>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('H:i', $trans['Date']);?>
											<br>
											<br>
					                    	<?php if($trans['language'] == 'russian') { ?>
												<img class="img-lang" src="/assets/images/rus.png?v=2">
											<?php }elseif($trans['language'] == 'english') { ?>
												<img class="img-lang" src="/assets/images/en.png?v=2">
											<?php }elseif($trans['language'] == 'german') { ?>
												<img class="img-lang" src="/assets/images/de.png?v=2">
											<?php } ?>
											<br>
											<br>
											<div>
												<b>Начислить траффик</b><br>
					                          	<?php
					                          		$stats = json_decode($trans['stats'], true);
					                          	?>
					                         	<select name="country_<?php echo $trans['ID'];?>" style="display:none;">
					                            	<?php
						                              	foreach ($stats as $key => $value) {
							                        ?>
							                           	<option cid="<?php echo $countries[$key]['cid'];?>" value="<?php echo $key;?>"><?php echo $countries[$key]['name'].' '.$value['done'].'/'.$value['have'];?> посещений</option>
							                        <?php
							                          }
							                        ?>
					                          	</select><br>
					                          	Посещений:<br>
												<input type="text" name="traf_add_<?php echo $trans['ID'];?>">
											</div>
										</td>
					                   
					                    <td class=" ">
					                    	<b>Ссылка:</b>
					                    		<?php if($trans['cont_type'] != 3) { ?>
					                    		<a href="<?php echo json_decode($trans['url']);?>" target="_blank"><?php echo json_decode($trans['url']);?></a>
					                    		<?php } ?>
					                    	<br><br>
					                    	<b>Посещений на счету:</b><br>
					                    	<select>
					                          <?php
				                              	foreach ($stats as $key => $value) {
					                          ?>
					                            	<option><?php echo $countries[$key]['name'].' '.$value['done'].'/'.$value['have'];?> посещений</option>
					                          <?php
					                            }
					                          ?>
					                        </select>
					                    </td>
					                    <td class="middle">
										<?php 
											if($trans['Status'] == 0) {
												echo '<i class="fas fa-exclamation-circle orang"></i>';
											}elseif($trans['Status'] == 1) {
												echo '<i class="fas fa-check-circle green"></i>';
											}elseif($trans['Status'] == 2) {
												echo '<i class="fas fa-ban red"></i>';
											}elseif($trans['Status'] == 3) {
												echo '<i class="fas fa-calendar-check blue"></i>';
											}
										?> </td>
					                    <td class="middle btn-table-user text-center">
											<?php 
												if($trans['cont_type'] != 3) { ?>
												<p class="padding-top10">
					                        		<textarea name="riason_<?php echo $trans['ID'];?>" id="reas_<?php echo $trans['ID'];?>" placeholder="Причина отказа"></textarea>
					                        		<script type="text/javascript">
														$('#reas_<?php echo $trans['ID'];?>').on('click', function(){
															$('#null_radio_<?php echo $trans['ID'];?>').prop('checked', false);
														})
													</script>
					                        		<br>
					                        		0(сбросить):<input id="null_radio_<?php echo $trans['ID'];?>" type="radio" class="radio-btn" name="v1" title="Обнулить" onclick="$('#reas_<?php echo $trans['ID'];?>').val('')">
													1:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[2][$trans['language']][1];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'));">
													2:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[2][$trans['language']][2];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													3:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[2][$trans['language']][3];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													4:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[2][$trans['language']][4];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													5:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[2][$trans['language']][5];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													<div class="padding-top5">
														<input type="button" class="refuse" onclick="CancelFunc(<?php echo $trans['ID'];?>)" name="CancelBnr" value="Отказать">
													</div>
												</p>
											<?php } ?>
					                    </td>
									  </tr>
								<?php endforeach; ?>

							</tbody>
					</table>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<label><?php echo $this->lang->line('transactions_marked');?></label>
                          <select name="act" class="form-control">
							<option value="1">Подтвердить</option>
							<option value="4">Начислить траффик</option>
							<option value="2">Отклонить</option>
							<option value="3">Удалить</option>
                          </select>
					  <input type="submit" />
                        </div>
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
							document.location.href='/index.php/adminpanel/cancel_tprj/'+id+'?rsn='+encodeURIComponent($('textarea[name=riason_'+id+']').val());
						}
					</script>