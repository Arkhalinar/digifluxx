<!-- page content -->
    <div class="right_col" role="main">
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
		 		<div class="x_title">
                    <h2>Packets creating </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
					   <form data-parsley-validate class="form-horizontal form-label-left" method="post">
					   		<?php

					   			if(isset($_SESSION['err_bal_1'])) {
					   				echo '<p style="color:red;">Error at bonus programm 1, balance '.$_SESSION['err_bal_1'].'</p>';
					   				unset($_SESSION['err_bal_1']);
					   			}

					   			if(isset($_SESSION['err_bal_2'])) {
					   				echo '<p style="color:red;">Error at bonus programm 2, balance '.$_SESSION['err_bal_2'].'</p>';
					   				unset($_SESSION['err_bal_2']);
					   			}

					   			if(isset($_SESSION['err_bal_3'])) {
					   				echo '<p style="color:red;">Error at bonus programm 3, balance '.$_SESSION['err_bal_3'].'</p>';
					   				unset($_SESSION['err_bal_3']);
					   			}

					   			if(isset($_SESSION['err_bal_4'])) {
					   				echo '<p style="color:red;">Error at bonus programm 4, balance '.$_SESSION['err_bal_4'].'</p>';
					   				unset($_SESSION['err_bal_4']);
					   			}

					   			if(isset($_SESSION['err_price'])) {
					   				echo '<p style="color:red;">Error at price, '.$_SESSION['err_price'].'</p>';
					   				unset($_SESSION['err_price']);
					   			}

						   		if(isset($packet)) {
						   			$packet_name = json_decode($packet['name_of_packet'], true);
						   		}
					   		?>
							<div class="form-group">
	                        	<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Name(RUS)</label>
		                        <div class="col-md-11 col-sm-6 col-xs-12">
		                         	<input type="text" name="name_russian" value="<?php if(isset($packet_name['RUS'])) echo $packet_name['RUS'];?>" class="form-control col-md-12 col-xs-12">
								</div>
		                    </div>	
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Name(ENG)</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" name="name_english" value="<?php if(isset($packet_name['ENG'])) echo $packet_name['ENG'];?>" class="form-control col-md-12 col-xs-12">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Name(GER)</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" name="name_german" value="<?php if(isset($packet_name['GER'])) echo $packet_name['GER'];?>" class="form-control col-md-12 col-xs-12">
								</div>
							</div>
							<hr />
							<div class="form-group">
								<?php
							   		if(isset($packet)) {
							   			$packet_product = json_decode($packet['product'], true);
							   		}
						   		?>
		                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body">Products</label>
		                        <div class="col-md-11 col-sm-6 col-xs-12">
									<p>Bonus Program 1 <input type="checkbox" name="bp1" <?php if(!empty($packet_product[1])){echo 'checked';} ?> ></p>
									<div <?php if(empty($packet_product[1])){ ?>style="display:none;"<?php } ?> id="bonus_programm_1">
										<div>
											Scale at level
											<select name="level1">
												<option value="1" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 1){ ?>selected<?php } ?>>1</option>
												<option value="2" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 2){ ?>selected<?php } ?>>2</option>
												<option value="3" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 3){ ?>selected<?php } ?>>3</option>
												<option value="4" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 4){ ?>selected<?php } ?>>4</option>
												<option value="5" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 5){ ?>selected<?php } ?>>5</option>
												<option value="6" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 6){ ?>selected<?php } ?>>6</option>
												<option value="7" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 7){ ?>selected<?php } ?>>7</option>
												<option value="8" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 8){ ?>selected<?php } ?>>8</option>
												<option value="9" <?php if(!empty($packet_product[1]) && $packet_product[1]['lvl'] == 9){ ?>selected<?php } ?>>9</option>
											</select>
										</div>
										<div>
											Balance of scale at start<br>
											<input type="text" name="insta_balance1" value="<?php if(!empty($packet_product[1]) && $packet_product[1]['insta_balance'] != 0){ echo $packet_product[1]['insta_balance']; }else {echo 0;} ?>">
										</div>
									</div>
									<hr>
									<p>Bonus Program 2 <input type="checkbox" name="bp2" <?php if(!empty($packet_product[2])){echo 'checked';} ?> ></p>
									<div <?php if(empty($packet_product[2])){ ?>style="display:none;"<?php } ?> id="bonus_programm_2">
										<div>
											Scale at level
											<select name="level2">
												<option value="10" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 10){ ?>selected<?php } ?>>10</option>
												<option value="20" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 20){ ?>selected<?php } ?>>20</option>
												<option value="30" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 30){ ?>selected<?php } ?>>30</option>
												<option value="40" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 40){ ?>selected<?php } ?>>40</option>
												<option value="50" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 50){ ?>selected<?php } ?>>50</option>
												<option value="60" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 60){ ?>selected<?php } ?>>60</option>
												<option value="70" <?php if(!empty($packet_product[2]) && $packet_product[2]['lvl'] == 70){ ?>selected<?php } ?>>70</option>
											</select>
										</div>
										<div>
											Balance of scale at start<br>
											<input type="text" name="insta_balance2" value="<?php if(!empty($packet_product[2]) && $packet_product[2]['insta_balance'] != 0){ echo $packet_product[2]['insta_balance']; }else {echo 0;} ?>">
										</div>
									</div>
									<hr>
									<p>Bonus Program 3 <input type="checkbox" name="bp3" <?php if(!empty($packet_product[3])){echo 'checked';} ?> ></p>
									<div <?php if(empty($packet_product[3])){ ?>style="display:none;"<?php } ?> id="bonus_programm_3">
										<div>
											Scale at level
											<select name="level3">
												<option value="100" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 100){ ?>selected<?php } ?>>100</option>
												<option value="200" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 200){ ?>selected<?php } ?>>200</option>
												<option value="300" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 300){ ?>selected<?php } ?>>300</option>
												<option value="400" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 400){ ?>selected<?php } ?>>400</option>
												<option value="500" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 500){ ?>selected<?php } ?>>500</option>
												<option value="600" <?php if(!empty($packet_product[3]) && $packet_product[3]['lvl'] == 600){ ?>selected<?php } ?>>600</option>
											</select>
										</div>
										<div>
											Balance of scale at start<br>
											<input type="text" name="insta_balance3" value="<?php if(!empty($packet_product[3]) && $packet_product[3]['insta_balance'] != 0){ echo $packet_product[3]['insta_balance']; }else {echo 0;} ?>">
										</div>
									</div>
									<hr>
									<p>Bonus Program 4 <input type="checkbox" name="bp4" <?php if(!empty($packet_product[4])){echo 'checked';} ?> ></p>
									<div <?php if(empty($packet_product[4])){ ?>style="display:none;"<?php } ?> id="bonus_programm_4">
										<div>
											Scale at level
											<select name="level4">
												<option value="1000" <?php if(!empty($packet_product[4]) && $packet_product[4]['lvl'] == 1000){ ?>selected<?php } ?>>1000</option>
												<option value="2000" <?php if(!empty($packet_product[4]) && $packet_product[4]['lvl'] == 2000){ ?>selected<?php } ?>>2000</option>
												<option value="3000" <?php if(!empty($packet_product[4]) && $packet_product[4]['lvl'] == 3000){ ?>selected<?php } ?>>3000</option>
												<option value="4000" <?php if(!empty($packet_product[4]) && $packet_product[4]['lvl'] == 4000){ ?>selected<?php } ?>>4000</option>
												<option value="5000" <?php if(!empty($packet_product[4]) && $packet_product[4]['lvl'] == 5000){ ?>selected<?php } ?>>5000</option>
											</select>
										</div>
										<div>
											Balance of scale at start<br>
											<input type="text" name="insta_balance4" value="<?php if(!empty($packet_product[4]) && $packet_product[4]['insta_balance'] != 0){ echo $packet_product[4]['insta_balance']; }else {echo 0;} ?>">
										</div>
									</div>
									<script type="text/javascript">
										$('input[name=bp1]').on('click', function(){
											$('#bonus_programm_1').toggle();
										})
										$('input[name=bp2]').on('click', function(){
											$('#bonus_programm_2').toggle();
										})
										$('input[name=bp3]').on('click', function(){
											$('#bonus_programm_3').toggle();
										})
										$('input[name=bp4]').on('click', function(){
											$('#bonus_programm_4').toggle();
										})
									</script>
		                        </div>
		                    </div>
		                    <hr />
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title">Price(CDT)</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" name="price" value="<?php if(isset($packet['price'])) {echo $packet['price'];}else{echo 0;} ?>" class="form-control col-md-12 col-xs-12">
								</div>
							</div>	
	                      <div class="form-group">
	                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          <button type="submit" name="save" value="save" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
	                        </div>
	                      </div>
						  <div class="ln_solid"></div>

	                    </form>
					
					</div>
					
					
					</div>
					
					
					
					</div>
					</div>
					</div>