			<script src='https://www.google.com/recaptcha/api.js'></script>
			<div class="content login-content">
				<div class="login">
					<h1 class="name-page"><?php echo $this->lang->line('log_1');?></h1>
					<div class="contact">
						<form action="/user/login" method="post" accept-charset="utf-8">
							<?php if(isset($login_failed)): ?>
							  <div class="area error">
								<?php echo $this->lang->line('invalid_credentials');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['er_cr_comp'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('error_captcha');?>
							  </div>
							<?php
								unset($_SESSION['er_cr_comp']);
							 endif; ?>
							<?php if(isset($_SESSION['mail_sent'])): ?>
							  <div class="area successfull">
								<?php echo $this->lang->line('mail_sent');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['token_err'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('pass_token_err');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['pass_changed'])): ?>
							  <div class="area successfull">
								<?php echo $this->lang->line('pass_changed');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['mail_send_false'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('error_mail_sending');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['blocked'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('user_blocked');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['ip_verify'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('ip_verify');?>
							  </div>
							<?php endif; ?>
							<?php if(isset($_SESSION['ip_confirmed'])): ?>
							  <div class="area successfull">
								<?php echo $this->lang->line('ip_confirmed');?>
							  </div>
							<?php endif; ?>
							<div class="area"><input type="text"  placeholder="<?php echo $this->lang->line('username');?>" name="username" value="<?php if(isset($_POST['username'])) {echo $_POST['username']; } ?>"  required=""></div>
							<div class="area"><input type="password" placeholder="<?php echo $this->lang->line('password');?>" name="password" value="" required="" ></div>
							<div class="area">
								<div class="g-recaptcha" data-sitekey="6Lc7tsEUAAAAAF_GegQtL6IOA-axUx5RxBaPl6IA"></div>
							</div>
							<div class="area rec"><a href="/user/reset_pass"><?php echo $this->lang->line('faq2_q');?></a></div>
							<div class="area">
								<input class="btn" type="submit" value="<?php echo $this->lang->line('subm_in');?>">
							</div>		
						</form>
					</div>
				</div>
			</div>
