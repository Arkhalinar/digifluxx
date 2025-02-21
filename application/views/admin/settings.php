	<!-- Switchery -->
    <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
	<script>
		$(document).ready(function(){
			 $('#datetimepicker2').datetimepicker({
                    locale: 'ru',
					format: 'YYYY-MM-DD hh:mm:ss',
                });
		});
	</script>
	
<!-- page content -->
    <div class="right_col" role="main">
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
		 <div class="x_title">
                    <h2><?php echo $this->lang->line('menu_settings');?></h2> 
					<div class="clearfix"></div>
                  </div>
				   <div class="x_content">
				   <?php if(isset($_SESSION['passchanged'])): ?>
						<p class="success"><?php echo $this->lang->line('pass_changed');?></p>
					<?php endif; ?>
		<form data-parsley-validate class="form-horizontal form-label-left" method="post">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_host"><?php echo $this->lang->line('smtp_host');?> <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="smtp_host" value="<?php echo $options['smtp_host']; ?>" name="smtp_host" required="required" class="form-control col-md-7 col-xs-12">
							<?php echo form_error('smtp_host');?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="smtp_user"><?php echo $this->lang->line('smtp_user');?><span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="smtp_user" name="smtp_user" value="<?php echo $options['smtp_user']; ?>" required="required" class="form-control col-md-7 col-xs-12">
							<?php echo form_error('smtp_user');?>
						</div>
                      </div>
                      <div class="form-group">
                        <label for="smtp_pass" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('smtp_pass');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="smtp_pass" class="form-control col-md-7 col-xs-12" type="password" value="<?php echo $options['smtp_pass']; ?>" required="required" name="smtp_pass">
							<?php echo form_error('smtp_pass');?>
						</div>
                      </div>
					<div class="form-group">
                        <label for="smtp_port" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('smtp_port');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="smtp_port" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['smtp_port']; ?>" required="required" name="smtp_port">
							<?php echo form_error('smtp_port');?>
						</div>
                      </div>
					  <div class="form-group">
                        <label for="bch_wallet_id" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('bch_wallet_id');?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="bch_wallet_id" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['blockchain_wallet_id']; ?>" name="bch_wallet_id">
							<?php echo form_error('bch_wallet_id');?>
						</div>
                      </div>
					  <div class="form-group">
                        <label for="bch_password" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('bch_password');?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="bch_password" class="form-control col-md-7 col-xs-12" type="password" value="<?php echo $options['blockchain_password']; ?>" name="bch_password">
							<?php echo form_error('bch_password');?>
						</div>
                      </div>
					  <div class="form-group">
                        <label for="api_key" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('bch_api_key');?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="api_key" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['blockchain_api_key']; ?>" name="api_key">
							<?php echo form_error('api_key');?>
						</div>
                      </div>
					  <div class="form-group">
                        <label for="xpub" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('bch_xpub');?></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="xpub" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['blockchain_xpub']; ?>" name="xpub">
							<?php echo form_error('xpub');?>
						</div>
                      </div>
					<div class="form-group">
                        <label for="percent" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('withdraw_percent');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="percent" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['withdraw_percentage']; ?>" required="required" name="percent" /> 
							<?php echo form_error('percent');?>
						</div>
                      </div>
					  <div class="form-group">
                        <label for="site_name" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('site_name');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="site_name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo $options['site_name']; ?>" required="required" name="site_name" /> 
							<?php echo form_error('site_name');?>
						</div>
                      </div>
					<div class="form-group">
                        <label for="percent" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('date_start');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class='input-group date' id='datetimepicker2'>
								<input type='text' name="start_date" value="<?php echo $options['start_date'];?>" class="form-control" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div> 
							<?php echo form_error('date_start');?>
						</div>
                      </div>					  
					  <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                
                              </div>

                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $this->lang->line('registration');?>
                        </label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" name="reg" <?php echo $options['registered_opened'] == 1 ? "checked='checked'" : '';?>> <?php echo $this->lang->line('opened');?>
                            </label>
                          </div>
                        </div>
                      </div>

					<div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $this->lang->line('site');?>
                        </label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" name="site" <?php echo $options['site_opened'] == 1 ? "checked='checked'" : '';?>> <?php echo $this->lang->line('s_opened');?>
                            </label>
                          </div>
                        </div>
                      </div>
					  
                      
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
                        </div>
                      </div>

                    </form>
					
					</div>
					</div>
					
					<div class="x_panel">
		 <div class="x_title">
                    <h2><?php echo $this->lang->line('data_change');?> </h2> 
					<div class="clearfix"></div>
                  </div>
				   <div class="x_content">
		<form data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url();?>index.php/adminpanel/pass_change" method="post">
                    
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('username');?>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" value="<?php echo $login['login']; ?>" name="username" required="required" class="form-control col-md-7 col-xs-12">
							<?php echo form_error('username');?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('current_password');?><span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="password" value="" required="required" class="form-control col-md-7 col-xs-12">
							<?php echo form_error('password', '<p class="error">', '</p>'); ?>
						</div>
                      </div>
                      <div class="form-group">
                        <label for="smtp_pass" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('new_password');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="password" name="newpassword" value="" required="required">
							<?php echo form_error('newpassword', '<p class="error">', '</p>'); ?>
						</div>
                      </div>
					<div class="form-group">
                        <label for="smtp_port" class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('repeat_new_password');?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="password" name="passconf" value="" required="required">
							<?php echo form_error('passconf', '<p class="error">', '</p>'); ?>
						</div>
                      </div>
					
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
                        </div>
                      </div>

                  </form>
					
					</div>
					</div>
					
					
					</div>
					</div>
					</div>