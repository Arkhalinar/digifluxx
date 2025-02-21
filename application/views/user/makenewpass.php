
  <div class="login-box-body" style="margin-top: 13%; text-align: center;">

    <p class="login-box-msg"><?php echo $this->lang->line('pass_reset');?></p>

    <?php echo form_open('user/makenewpass'); ?>
    <?php echo form_error('newpassword', '<p class="error">', '</p>'); ?>
      <div class="area">
        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('password');?>*"  name="newpassword" required=""/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="area">
        <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('passconf');?>*"  name="passconf" required=""/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn-work"><?php echo $this->lang->line('submit');?></button>
        </div>
      </div>
    </form>

    <a href="login"><?php echo $this->lang->line('login_form');?></a><br>
  </div>  