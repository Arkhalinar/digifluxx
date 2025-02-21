<body class="login">
	<?php if(isset($link)): ?>
		<script>
			$(document).ready(function() {
				window.location = "#<?php echo $link; ?>";
			});
		</script>
	<?php endif; ?>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php echo form_open('adminpanel/login'); ?>
              <h1><?php echo $this->lang->line('adminpanel');?></h1>
			  <?php 
          if(isset($login_failed)): 
        ?>
				  <div>
					<p class="error"><i class="fa fa-exclamation-circle"></i><?php echo $this->lang->line('invalid_credentials');?></p>
					<div class="clearfix"></div>
				  </div>
			  <?php
          endif;
        ?>
        <?php 
          if(isset($_SESSION['error'])): 
        ?>
          <div>
            <p class="error"><i class="fa fa-exclamation-circle"></i><?php echo $_SESSION['error']; unset($_SESSION['error']);?></p>
            <div class="clearfix"></div>
          </div>
        <?php
          endif;
        ?>
              <div>
                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('username');?>" name="username" value="<?php echo set_value('username'); ?>" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="<?php echo $this->lang->line('password');?>" name="password" value="" required="" />
              </div>
              <div>
                <input type="text" name="code">
              </div>
              <div>
				        <input class="btn btn-default submit" type="submit" value="<?php echo $this->lang->line('submit');?>" />
              </div>

              <div class="clearfix"></div>

                <div class="clearfix"></div>
                <br />

                <!-- <div>
                  <h1><i class="fa fa-paw"></i></h1>
                </div> -->
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>