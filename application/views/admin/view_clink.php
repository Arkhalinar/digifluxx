	<!-- Switchery -->
    <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>


<!-- page content -->
    <div class="right_col" role="main">
    	<div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
					<form method="post" class="search-select" id="usearch" action="/index.php/adminpanel/view_clink">
						 <!--  -->
						<div class="input-group">
							<select name="type" class="form-control">
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'login'){ ?>selected<?php } ?> value="login">Владелец</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'language'){ ?>selected<?php } ?> value="language">Язык</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Site_url'){ ?>selected<?php } ?> value="Site_url">Ссылка</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'Status'){ ?>selected<?php } ?> value="Status">Статус</option>
							</select>
						</div>
						<div class="input-group" id="for_inputs">
							<input type="text" name="val" class="form-control" placeholder="Значение...">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="$('#usearch').submit();" type="button">Поиск</button>
							</span>
						</div>
						<?php
							if(isset($_SESSION['val'])) {
						?>
						<div class="input-group" id="for_inputs">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="document.location.href='/index.php/adminpanel/reset_clink'" type="button">Сбросить фильтрацию</button>
							</span>
						</div>
						<?php
							}
						?>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'Site_url') {
								$('#for_inputs').html('<input type="text" name="val" class="form-control" placeholder="value..."><span class="input-group-btn border-30"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'language') {
								$('#for_inputs').html('<select class="form-control" name="val"><option value="russian">Русский</option><option value="english">Английский</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'Status') {
								$('#for_inputs').html('<select class="form-control" name="val"><option value="0">Не верифицирована</option><option value="1">Верифицирована</option><option value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}
						})
						$(document).ready(function(){
							<?php if(isset($_SESSION['type']) && ($_SESSION['type'] == 'login' || $_SESSION['type'] == 'Site_url')) { ?>
								$('#for_inputs').html('<input type="text" name="val" class="form-control" value="<?php echo $_SESSION['val'];?>"><span class="input-group-btn border-30"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type']) && $_SESSION['type'] == 'language') { ?>
								$('#for_inputs').html('<select class="form-control" name="val"><option <?php if($_SESSION['val'] == 'russian'){ ?>selected<?php } ?> value="russian">Русский</option><option <?php if($_SESSION['val'] == 'english'){ ?>selected<?php } ?> value="english">Английский</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type']) && $_SESSION['type'] == 'Status') { ?>
								$('#for_inputs').html('<select class="form-control" name="val"><option <?php if($_SESSION['val'] == 0){ ?>selected<?php } ?> value="0">Не верифицирована</option><option <?php if($_SESSION['val'] == 1){ ?>selected<?php } ?> value="1">Верифицирована</option><option <?php if($_SESSION['val'] == 2){ ?>selected<?php } ?> value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
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
		 <div class="x_title">
                    <h2>Кеш ссылки </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
				   
					
					<div class="x_content" style="overflow-x: scroll;">
					<div class="snoska">
						<i class="fas fa-exclamation-circle orang"></i> - не верефицирован
						| <i class="fas fa-check-circle green"></i> - верефицирован
						| <i class="fas fa-ban red"></i> - откланен
					</div>
					<table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
								<th class="column-title">Логин | дата | Язык </th>
								<th class="column-title"> Ссылка </th>
								<th class="column-title">Статус </th>
								<th class="column-title no-link last">Действие </th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($comps as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd'; ?>
									<tr class="<?php echo $class;?> pointer">
										<td class="">
											<i class="fas fa-user"></i>
											<b><a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $trans['login'];?>"><?php echo $trans['login'];?></a></b>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('d.m.Y', $trans['Date']);?>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('H:i', $trans['Date']);?>
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
											<b>Ссылка:</b> <a style="text-decoration: underline;" target="_blank" href="<?php echo json_decode($trans['Site_url']);?>"><?php echo json_decode($trans['Site_url']);?></a> 
											<br><b>Язык:</b> <?php if($trans['lang'] == 'russian') { ?>
												<img class="img-lang" src="/assets/images/rus.png?v=2">
											<?php }elseif($trans['lang'] == 'english') { ?>
												<img class="img-lang" src="/assets/images/en.png?v=2">
											<?php }elseif($trans['lang'] == 'german') { ?>
												<img class="img-lang" src="/assets/images/de.png?v=2">
											<?php }elseif($trans['lang'] == 'all') { ?>
												<img style="width:50px; height: 50px;" class="img-lang" src="/assets/images/all.jpg?v=2">
											<?php } ?>
										</td>
										<td class="middle">
										<?php 
											if($trans['Status'] == 0) {
												echo '<i class="fas fa-exclamation-circle orang"></i>';
											}elseif($trans['Status'] == 1) {
												echo '<i class="fas fa-check-circle green"></i>';
											}elseif($trans['Status'] == 2) {
												echo '<i class="fas fa-ban red"></i>';
											}
										?> </td>
										<td class="middle btn-table-user text-center">
											<?php 
												if($trans['Status'] == 0 || $trans['Status'] == 2) {
											?>
												<i class="fas fa-check-square green" title="подтвердить" onclick="document.location.href='/index.php/adminpanel/acc_clink/<?php echo $trans['ID'];?>'"></i>
											<?php 
												}
											?>
											<i class="fas fa-trash-alt red" title="удалить" onclick="document.location.href='/index.php/adminpanel/del_clink/<?php echo $trans['ID'];?>'"></i>
											<p class="padding-top5">
												<form class="text-center" action="/index.php/adminpanel/cancel_clink/<?php echo $trans['ID'];?>" method="post">
													<textarea name="riason" id="reas_<?php echo $trans['ID'];?>" placeholder="Причина отказа"></textarea>
													<script type="text/javascript">
														$('#reas_<?php echo $trans['ID'];?>').on('click', function(){
															$('#null_radio_<?php echo $trans['ID'];?>').prop('checked', false);
														})
													</script>
													<br>
													0(сбросить):<input id="null_radio_<?php echo $trans['ID'];?>" type="radio" class="radio-btn" name="v1" title="Обнулить" onclick="$('#reas_<?php echo $trans['ID'];?>').val('')">
													1:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[1][$trans['language']][1];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'));">
													2:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[1][$trans['language']][2];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													3:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[1][$trans['language']][3];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													4:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[1][$trans['language']][4];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													5:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[1][$trans['language']][5];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													<p class="padding-top5">
														<input type="submit" class="refuse" name="CancelAds" value="отказать">
													</p>
												</form>
											</p>
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

					</div>
					</div>
					
					
					</div>
					
					
					
					</div>
					</div>
					</div>