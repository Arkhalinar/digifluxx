<div class="right_col" role="main">
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert"></span>
                    </button>
                    <strong><?php echo $this->lang->line('delete_user');?></strong> <?php echo $this->lang->line('no_restore');?>
                  </div>
				  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <a href="/index.php/adminpanel/users" class="btn btn-primary"><?php echo $this->lang->line('no');?></a>
                          <a href="/index.php/adminpanel/del_user/<?php echo $uid;?>/1" type="submit" class="btn btn-danger"><?php echo $this->lang->line('yes');?></a>
                        </div>
                  </div>
                  </div>
                  </div>