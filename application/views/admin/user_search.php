<!-- Switchery -->
<script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>
  <div class="right_col" role="main">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $this->lang->line('admin_user_search_1');?> </h2> 
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <div class="x_content">
              <?php if (isset($_SESSION['updated'])):?>
              <p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('admin_user_search_2');?></p>
              <?php endif; ?>

              <?php if (isset($_SESSION['mess_reus'])):?>
              <p class="info"><i class="fa fa-info-circle"></i><?php echo $_SESSION['mess_reus']; unset($_SESSION['mess_reus']);?></p>
              <?php endif; ?>

              <?php if (isset($_SESSION['active'])):?>
              <p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('user_active');?></p>
              <?php endif; ?>
              <?php echo validation_errors(); ?>
              <?php

                  // var_dump($user);exit();

               if(isset($user)): ?>

              <form data-parsley-validate class="form-horizontal form-label-left" method="post" action="<?php echo base_url();?>index.php/adminpanel/users">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username"><?php echo $this->lang->line('admin_user_search_3');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="username" disabled name="username" value="<?php echo $user['login']?>" class="form-control col-md-7 col-xs-12">
                    <input type="hidden" name="us_id" value="<?php echo $user['id']?>" class="form-control col-md-7 col-xs-12">
                    <a href="<?php echo base_url();?>adminpanel/gouser/<?php echo $user['login'];?>"><?php echo $this->lang->line('admin_user_search_4');?></a>
                    <?php echo form_error('save_username');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"><?php echo $this->lang->line('admin_user_search_5');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="email" value="<?php echo $user['email']?>" name="save_email" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_email');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="newpassword"><?php echo $this->lang->line('admin_user_search_6');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" id="passnewpasswordword" value="" name="newpassword" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('newpassword', '<p class="error">', '</p>'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="passconf"><?php echo $this->lang->line('admin_user_search_7');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="password" id="passconf" value="" name="passconf" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('passconf', '<p class="error">', '</p>'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="skype"><?php echo $this->lang->line('admin_user_search_8');?> </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php //var_dump($user);exit();?>
                    <input type="text" id="skype" value="<?php echo $user['skype'];?>" name="save_skype" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_skype');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobilenum"><?php echo $this->lang->line('admin_user_search_9');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="mobilenum" value="<?php echo $user['mobile_num']?>" name="save_mobilenum" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_mobilenum');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('admin_user_search_10');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" value="<?php echo $user['name']?>" name="save_name" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_name');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="skype"><?php echo $this->lang->line('admin_user_search_11');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="lastname" value="<?php echo $user['lastname']?>" name="save_lastname" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_lastname');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sponsor"><?php echo $this->lang->line('admin_user_search_12');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="sponsor_login" value="<?php echo $user['sponsor_login']?>" name="save_sponsor_login" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_sponsor_login');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="balance"><?php echo $this->lang->line('admin_user_search_13');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="balance" value="<?php echo $user['amount_btc']?>" name="save_balance_btc" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_balance');?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="balance"><?php echo $this->lang->line('admin_user_search_14');?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="balance" value="<?php echo $user['add_amount_btc']?>" name="save_balance_btc2" class="form-control col-md-7 col-xs-12">
                    <?php echo form_error('save_balance');?>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit"  value="save" name="save" class="btn btn-success"><?php echo $this->lang->line('admin_user_search_20');?> </button>
                  </div>
                </div>
              </form>
              <div style="text-align: center;">
                <hr>
                <?php
                  $user_status = json_decode($user['packet_status'], true);
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
                <hr>
              </div>
              <form class="form-horizontal form-label-left" method="post" action="/adminpanel/users/<?php echo $user['id'];?>">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="balance">Packets</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name='name_of_added_packet'>
                      <option value="Packet_1">Packet 1</option>
                      <option value="Packet_2">Packet 2</option>
                      <option value="Packet_3">Packet 3</option>
                      <option value="Packet_4">Packet 4</option>
                      <?php
                        $count = count($manual_packets);
                        for ($i = 0; $i < $count; $i++) { 
                      ?>
                        <option value="<?php echo $manual_packets[$i]['id']; ?>"><?php $arr_of_names = json_decode($manual_packets[$i]['name_of_packet'], true); echo $arr_of_names['ENG']; ?></option>
                      <?php
                        }
                      ?>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="Packet_add" class="btn btn-success"><?php echo $this->lang->line('admin_user_search_20');?> </button>
                  </div>
                </div>
              </form>
            </div>
            <?php else: ?>
            <p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('nothing_found');?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
