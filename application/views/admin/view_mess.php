<!-- Switchery -->
    <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>


<!-- page content -->
    <div class="right_col" role="main">
    	<div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
					<form method="post" class="search-select" id="usearch" action="/index.php/adminpanel/view_mess">
						 <!--  -->
						<div class="input-group">
							<select name="type" class="form-control">
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'login'){ ?>selected<?php } ?> value="login">Владелец</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'lang'){ ?>selected<?php } ?> value="lang">Язык</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'mail_name'){ ?>selected<?php } ?> value="mail_name">Ссылка</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'mail_header'){ ?>selected<?php } ?> value="mail_header">Название</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'mail_text'){ ?>selected<?php } ?> value="mail_text">Содержание</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'question'){ ?>selected<?php } ?> value="question">Вопрос</option>
								<option <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'answer'){ ?>selected<?php } ?> value="answer">Ответ</option>
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
								<button class="btn btn-default" onclick="document.location.href='/index.php/adminpanel/reset_mess'" type="button">Сбросить фильтрацию</button>
							</span>
						</div>
						<?php
							}
						?>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'mail_name' || val == 'mail_header' || val == 'mail_text' || val == 'question' || val == 'answer') {
								$('#for_inputs').html('<input type="text" name="val" class="form-control" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'lang') {
								$('#for_inputs').html('<select name="val" class="form-control"><option value="all">Все</option><option value="russian">Русский</option><option value="english">Английский</option><option value="german">Немецкий</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'Status') {
								$('#for_inputs').html('<select name="val" class="form-control"><option value="0">Не верифицирована</option><option value="1">Верифицирована</option><option value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'Duration') {
								$('#for_inputs').html('<select name="val" class="form-control"><?php for($i = 0; $i < count($setts[3]); $i++){ ?><option value="<?php echo $setts[3][$i]['Count'];?>"><?php echo $setts[3][$i]['Count'];?></option><?php } ?></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}
						})
						$(document).ready(function(){
							<?php if(isset($_SESSION['type']) && ($_SESSION['type'] == 'login' || $_SESSION['type'] == 'Comp_name' || $_SESSION['type'] == 'Site_url' || $_SESSION['type'] == 'Descr' )) { ?>
								$('#for_inputs').html('<input type="text" name="val" class="form-control" value="<?php echo $_SESSION['val'];?>"><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type']) && $_SESSION['type'] == 'language') { ?>
								$('#for_inputs').html('<select name="val" class="form-control"><option <?php if($_SESSION['val'] == 'russian'){ ?>selected<?php } ?> value="russian">Русский</option><option <?php if($_SESSION['val'] == 'english'){ ?>selected<?php } ?> value="english">Английский</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type']) && $_SESSION['type'] == 'Status') { ?>
								$('#for_inputs').html('<select name="val" class="form-control"><option <?php if($_SESSION['val'] == 0){ ?>selected<?php } ?> value="0">Не верифицирована</option><option <?php if($_SESSION['val'] == 1){ ?>selected<?php } ?> value="1">Верифицирована</option><option <?php if($_SESSION['val'] == 2){ ?>selected<?php } ?> value="2">Отклонен</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							<?php }elseif(isset($_SESSION['type']) && $_SESSION['type'] == 'Duration') { ?>
								$('#for_inputs').html('<select name="val" class="form-control"><?php for($i = 0; $i < count($setts[3]); $i++){ ?><option <?php if($_SESSION['val'] == $setts[3][$i]['Count']){ ?>selected<?php } ?> value="<?php echo $setts[3][$i]['Count'];?>"><?php echo $setts[3][$i]['Count'];?></option><?php } ?></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
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
                    <h2>Компании </h2> 
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
								<th class="column-title">Login </th>
								<th class="column-title">Название | Ссылка | Тип | Язык</th>
								<th class="column-title">Описание </th>
								<th class="column-title">Статус </th>
								<th class="column-title no-link last">Действие </th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($comps as $trans):?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td class=" ">
											<i class="fas fa-user"></i>
											<b><a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $trans['login'];?>"><?php echo $trans['login'];?></a></b>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('d.m.Y', $trans['Date']);?>
											<br>
											<i class="fas fa-calendar-alt"></i> <?php echo date('H:i', $trans['Date']);?>
											<br>
										</td>
										<td class=" ">
											<b>Название:</b> <b><span class="black"><?php echo $trans['mail_header'];?></span></b>
											<br>
											<b>Ссылка:</b><a style="text-decoration: underline;" target="_blank" href="<?php echo $trans['mail_name'];?>"><?php echo $trans['mail_name'];?></a> 
											<b>Тип:</b>
											<?php 
												if($trans['Status'] == 1) {
													echo 'раз в день';
												}elseif($trans['Status'] == 2) {
													echo 'раз в 3 дня';
												}elseif($trans['Status'] == 3) {
													echo 'раз в 7 дней';
												}elseif($trans['Status'] == 4) {
													echo 'уникальные поситители';
												}
											?> 
											<br>
											<b>Язык:</b>
											<?php if($trans['language'] == 'russian') { ?>
												<img class="img-lang" src="/assets/images/rus.png?v=2">
											<?php }elseif($trans['language'] == 'english') { ?>
												<img class="img-lang" src="/assets/images/en.png?v=2">
											<?php }elseif($trans['language'] == 'german') { ?>
												<img class="img-lang" src="/assets/images/de.png?v=2">
											<?php } ?>
										</td>
										<td class=" ">
											<?php echo $trans['mail_text'];?>
											<br><br>
											<b>Вопрос:</b> <?php echo $trans['question'];?>?
											<br><br>
											<b>Ответы:</b> <br>
				                            <?php
				                              $arr = json_decode($trans['answers']);
				                              $i = 1;
				                              foreach ($arr as $value) {
				                                $arr = explode('|||||', $value);
				                                if($arr[0] == 1) {
				                                	$add_str = 'Верный:';
				                                }else {
				                                	$add_str = 'Не верный:';
				                                }
				                                $str[$i] = $add_str.' - '.$arr[1].'<br>';
				                                $i++;
				                              }
				                              echo $str[1].$str[2].$str[3];
				                            ?>
				                            <br>
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
										</td>
										<td class="middle btn-table-user text-center">
											<?php 
												if($trans['Status'] == 0 || $trans['Status'] == 2) {
											?>
											<i class="fas fa-check-square green" title="подтвердить"  onclick="document.location.href='acc_mail/<?php echo $trans['id'];?>'"></i>
											<?php 
												}
											?>
											<i class="fas fa-trash-alt red" title="удалить"  onclick="document.location.href='del_mail/<?php echo $trans['id'];?>'"></i>
											<p class="padding-top10">
												<form action="cancel_mail/<?php echo $trans['id'];?>" method="post">
													<textarea id="reas_<?php echo $trans['ID'];?>" name="riason"></textarea>
													<script type="text/javascript">
														$('#reas_<?php echo $trans['ID'];?>').on('click', function(){
															$('#null_radio_<?php echo $trans['ID'];?>').prop('checked', false);
														})
													</script>
													<br>
													0(сбросить):<input id="null_radio_<?php echo $trans['ID'];?>" type="radio" class="radio-btn" name="v1" title="Обнулить" onclick="$('#reas_<?php echo $trans['ID'];?>').val('')">
													1:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[3][$trans['language']][1];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'));">
													2:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[3][$trans['language']][2];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													3:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[3][$trans['language']][3];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													4:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[3][$trans['language']][4];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													5:<input type="radio" class="radio-btn" name="v1" title="<?php echo $answers[3][$trans['language']][5];?>" onclick="$('#reas_<?php echo $trans['ID'];?>').val($(this).attr('title'))">
													<div class="padding-top5">
														<input class="refuse" type="submit" name="CancelAds" value="отказать">
													</div>
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