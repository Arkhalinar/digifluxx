	<!-- Switchery -->
    <script src="<?php echo base_url();?>assets/vendors/switchery/dist/switchery.min.js"></script>

	
<!-- page content -->
	<script>
		$(document).ready(function() {
			$('.msg').on('click', function() {
				msg_container = $(this);
				$('div.mail_view').load("<?php echo base_url();?>index.php/adminpanel/read_msg/" + $(this).data('id'), function() {
					$(msg_container).find('.left i').toggle();
					$('#new_msgs').load("<?php echo base_url();?>index.php/adminpanel/new_message_count");
				});
			});

			$('div.checkbox label, div.checkbox div, div.checkbox *').on('click', function() {
				$('div.receiver').toggle();
			});
		});
	</script>
        <div class="right_col" role="main">
          <div class="">

            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $this->lang->line('menu_mail');?> </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $this->lang->line('incoming_mail');?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-3 mail_list_column">
					  <?php if(isset($_SESSION['no_such_user'])):?>
						<p class="no_reflink"><?php echo $this->lang->line('no_such_user');?></p>
					  <?php endif; ?>
						<?php if(isset($_SESSION['in_blacklist'])):?>
							<p class="no_reflink"><?php echo $this->lang->line('error_youre_blocked');?></p>
							<?php endif;?>
					  <?php if(isset($_SESSION['blacklist_error'])):?>
							<p class="no_reflink"><?php echo $this->lang->line('err_no_such_user');?></p>
							<?php endif;?>
							<?php if(isset($_SESSION['blacklisted'])):?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('user_blacklisted');?></p>
							<?php endif;?>
							<?php if(isset($_SESSION['unblacked'])):?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('user_unblocked');?></p>
							<?php endif;?>
					  <?php if(isset($_SESSION['message_sent'])):?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('message_sent');?></p>
						<?php endif;?>
						<?php if(isset($_SESSION['messages_sent'])):?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('messages_sent');?></p>
						<?php endif;?>
                        <button id="compose" class="btn btn-sm btn-success btn-block" type="button"><?php echo $this->lang->line('msg_compose');?></button>
						
						<?php foreach($mail as $m):?>
							<a href="#">
							  <div class="mail_list msg" data-id="<?php echo $m['id'];?>">
								<div class="left" >
									<?php if($m['is_read'] == 0):?>
										<i class="fa fa-circle"></i></i>
									<?php endif;?>
								</div>
								<div class="right">
								  <h3><?php echo $m['sender_login'];?> <small><?php echo $m['date_add'];?></small></h3>
								  <p><?php 
										$content = $m['body_text'];
										echo strlen($content) > 300 ? substr($content, 0, 300) . '...' : $content; ?>
									</p>
								</div>
							  </div>
							</a>
						<?php endforeach;?>
                      </div>
                      <!-- /MAIL LIST -->

                      <!-- CONTENT MAIL -->
                      <div class="col-sm-9 mail_view">
                        

                      </div>
                      <!-- /CONTENT MAIL -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
		
		<!-- compose -->
    <div class="compose col-md-6 col-xs-12">
	<form method="post" action="<?php echo base_url();?>index.php/adminpanel/mail">
      <div class="compose-header">
        <?php echo $this->lang->line('new_message');?>
        <button type="button" class="close compose-close">
          <span>×</span>
        </button>
      </div>

      <div class="compose-body">
        <div id="alerts"></div>

        <div id="editor" class="editor-wrapper">
		<div class="form-group">
					<div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" name="mass" > <?php echo $this->lang->line('mass_mail');?>
                            </label>
                          </div>
						<?php echo form_error('ulogin', '<p class="error">', '</p>'); ?>
						<div class="receiver">
                      <label><?php echo $this->lang->line('user_login');?></label>
                      <input type="text" value="<?php echo set_value('ulogin')?>" id="ulogin" name="ulogin" class="form-control">
                    </div>
					</div>
			 <div class="form-group">
						<?php echo form_error('title', '<p class="error">', '</p>'); ?>
                      <label><?php echo $this->lang->line('message_title');?></label>
                      <input type="text" required="" value="<?php echo set_value('title')?>" name="title" class="form-control">
                    </div>
					<div class="form-group">
						<?php echo form_error('message', '<p class="error">', '</p>'); ?>
                      <label><?php echo $this->lang->line('message_body');?></label>
                      <textarea required="" name="message" class="form-control" rows="4" placeholder="<?php echo $this->lang->line('message_body');?>"><?php echo set_value('message')?></textarea>
                    </div>
		</div>
      </div>

      <div class="compose-footer">
        <button id="send" class="btn btn-sm btn-success" type="submit"><?php echo $this->lang->line('send');?></button>
      </div>
	</form>
    </div>
    <!-- /compose -->
	