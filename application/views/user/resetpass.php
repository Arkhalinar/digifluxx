  <div class="login-box-body">

    <p class="login-box-msg"><?php echo $this->lang->line('pass_reset');?></p>

    <form action="/user/reset_pass" method="post" accept-charset="utf-8" style="text-align: center;">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="E-mail*"  name="email" required="" value="<?php echo set_value('email'); ?>"/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <button type="submit" class="btn"><?php echo $this->lang->line('submit');?></button>
        </div>
      </div>
    </form>
    <br>
    <a style="display: block; text-align: center;" href="login"><?php echo $this->lang->line('login_form');?></a><br>
  </div>  