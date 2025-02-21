			<script src='https://www.google.com/recaptcha/api.js'></script>
			<div class="content">
				<div class="login">
					<h1 class="name-page"><?php echo $this->lang->line('recovery_new');?></h1>
					<div class="contact">
						<form action="/user/reset_pass" method="post" accept-charset="utf-8" style="text-align: center;">
							<?php echo form_error('email', '<p class="area error">', '</p>'); ?>
							<?php if(isset($_SESSION['er_cr_comp'])): ?>
							  <div class="area error">
								<?php echo $this->lang->line('error_captcha');?>
							  </div>
							<?php
								unset($_SESSION['er_cr_comp']);
							 endif; ?>
							<div class="area"><input type="text" name="email" value="<?php echo set_value('email'); ?>" required="" placeholder="E-mail"></div>
							<div class="g-recaptcha" data-sitekey="6Lc7tsEUAAAAAF_GegQtL6IOA-axUx5RxBaPl6IA"></div>
							<div class="area">
								<input class="btn" type="submit" value="<?php echo $this->lang->line('submit');?>">
							</div>		
						</form>
					</div>
				</div>
			</div>
