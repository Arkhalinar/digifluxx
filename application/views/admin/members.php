	<!-- Switchery -->
    <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>


<!-- page content -->
    <div class="right_col" role="main">
    	<div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
					<form method="post" class="search-select" id="usearch" action="/index.php/adminpanel/members">
						 <!--  -->
						<div class="input-group">
						 	<select name="type" class="form-control">
								<option value="login">Логин(полное соответствие)</option>
								<option value="login2">Логин(частичное соответствие)</option>
								<option value="reflink">reflink</option>
								<option value="email">E-mail</option>
								<option value="amount">Основной баланс</option>
								<option value="amount2">Рекламный баланс</option>
								<option value="skype">Скайп</option>
								<option value="regdate">Дата регистрации</option>
								<option value="mobile_num">Мобильный телефон</option>
								<option value="u_lang">Язык</option>
								<option value="name">Имя</option>
								<option value="lastname">Фамилия</option>
								<option value="is_pekunjia">Pekunjia</option>
								<option value="isonline">Онлайн</option>
							</select>
						</div>
						<div class="input-group" id="for_inputs">
							<input type="text" name="val" class="form-control" placeholder="Значение...">
							<span class="input-group-btn">
								<button class="btn btn-default" onclick="$('#usearch').submit();" type="button">Поиск</button>
							</span>
						</div>
					</form>
					<script type="text/javascript">
						$('#usearch select[name="type"]').change(function(){
							var val = $('#usearch select[name="type"]').val();
							if(val == 'login' || val == 'login2' || val == 'email' || val == 'skype' || val == 'mobile_num' || val == 'name' || val == 'lastname' || val == 'reflink') {
								$('#for_inputs').html('<input type="text" name="val" class="form-control" placeholder="value..."><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'amount' || val == 'amount2') {
								$('#for_inputs').html('От <input type="text" name="val1" class="form-control ot-do" placeholder="value..."> <br> до <input type="text" name="val2" class="form-control ot-do" placeholder="value..."><br><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'u_lang') {
								$('#for_inputs').html('<select name="val" class="form-control"><option value="russian">Русский</option><option value="english">Английский</option><option value="german">Немецкий</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'isonline') {
								$('#for_inputs').html('<select name="val" class="form-control"><option value="on">Онлайн</option><option value="off">Оффлайн</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'is_pekunjia') {
								$('#for_inputs').html('<select name="val" class="form-control"><option value="1">From pekunjia</option><option value="0">New user</option></select><span class="input-group-btn"><button class="btn btn-default border-30" type="button" onclick="$(\'#usearch\').submit();">Search</button></span>');
							}else if(val == 'regdate') {
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
                    <h2>Пользователи </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
				   
					
					<div class="x_content" style="overflow-x: scroll;">
						<div class="snoska">
							<i class="far fa-question-circle"></i> - не подтвержден
							| <i class="fas fa-running ser"></i> - активный
							| <i class="fas fa-check-circle green"></i> - проплатил
							| <i class="fas fa-ban red"></i> - заблокирован
						</div>
					<table class="table table-striped jambo_table">
							<thead>
							  <tr class="headings">
								<th class="column-title">Логин|онлайн</th>
								<th class="column-title">E-mail  </th>
								<th class="column-title">Статус </th>
								<th class="column-title">Логин спонсора </th>
								<th class="column-title">Баланс BTC</th>
								<th class="column-title">Язык </th>
								<th class="column-title">Редактировать</th>
								</th>
							  </tr>
							</thead>
							
							<tbody>
								<?php $counter = 0;
								foreach($members as $m):?>
									<?php if($m['is_pekunjia'] == 0){$spec_info = '<b style="color:red;">new user</b>';}else{$spec_info = '<b style="color:green;">from pekunjia</b>';} ?>
									<?php $class = $counter % 2 == 0 ? 'even' : 'odd';?>
									<tr class="<?php echo $class;?> pointer">
										<td class="middle"><a href="<?php echo base_url();?>adminpanel/users/<?php echo $m['id'];?>"><?php echo $m['login'].' |'.$m['id'].'| ('.$spec_info.')';?></a></td>
										<td class="middle"><?php echo $m['email'];?> </td>
										<td class="middle">
											<?php if($m['status'] == 1):?>
												<?php echo '<i class="far fa-question-circle"></i>';?>
											<?php elseif($m['status'] == 2): ?>
												<?php echo '<i class="fas fa-running ser"></i>';?>
											<?php elseif($m['status'] == 3): ?>
												<?php echo '<i class="fas fa-check-circle green"></i>';?>
											<?php elseif($m['status'] == 4): ?>
												<?php echo '<i class="fas fa-ban red"></i>';?>
											<?php endif ;?>
										</td>
										<td class="middle"><?php echo $m['sponsor_login'];?></td>
										<td class=" ">
											<i class="fas fa-money-bill-alt green"></i> <?php echo $m['add_amount_btc'];?> <br> <i class="fas fa-shopping-cart ser"></i> <?php echo $m['amount_btc'];?>
											<hr>
											<?php
							                  $user_status = json_decode($m['packet_status'], true);
							                  if($user_status['packet_1'] == 1) {
							                    echo 'Packet 1 - <span style="color:green;">active</span><br><br>';
							                  }else{
							                    echo 'Packet 1 - <span style="color:red;">not active</span><br><br>';
							                  }
							                  if($user_status['packet_2'] == 1) {
							                    echo 'Packet 2 - <span style="color:green;">active</span><br><br>';
							                  }else{
							                    echo 'Packet 2 - <span style="color:red;">not active</span><br><br>';
							                  }
							                  if($user_status['packet_3'] == 1) {
							                    echo 'Packet 3 - <span style="color:green;">active</span><br><br>';
							                  }else{
							                    echo 'Packet 3 - <span style="color:red;">not active</span><br><br>';
							                  }
							                  if($user_status['packet_4'] == 1) {
							                    echo 'Packet 3 - <span style="color:green;">active</span><br><br>';
							                  }else{
							                    echo 'Packet 3 - <span style="color:red;">not active</span><br><br>';
							                  }
							                ?>
										</td>
										<td class="middle">
											<?php if($m['u_lang'] == 'russian') { ?>
												<img class="img-lang" src="/assets/images/rus.png?v=2">
											<?php }elseif($m['u_lang'] == 'english') { ?>
												<img class="img-lang" src="/assets/images/en.png?v=2">
											<?php }elseif($m['u_lang'] == 'german') { ?>
												<img class="img-lang" src="/assets/images/de.png?v=2">
											<?php } ?>
										</td>
										<td class="middle btn-table-user">
											<a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $m['login'];?>"><i class="fas fa-eye" title="в кабинет"></i></a>
											<form action="<?php echo base_url();?>adminpanel/users/<?php echo $m['id'];?>" id="formedit<?php echo $m['login'];?>" method="post">
												<input type="hidden" name="username" value="<?php echo $m['login'];?>">
												<input type="hidden" name="seacrh" value="Редактировать">
												<i class="fas fa-edit" title="редактировать" onclick="$('#formedit<?php echo $m['login'];?>').submit()"></i>
											</form>
											<i class="fas fa-info-circle" title="информация"></i>
											<i class="fas fa-user-lock" title="заблокировать"></i>
											<i class="fas fa-trash-alt red" title="удалить"></i>
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