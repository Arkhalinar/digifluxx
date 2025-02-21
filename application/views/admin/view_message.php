<script>
	$('.reply').on('click', function() {
		$(".compose").slideToggle();
		$('#ulogin').val($(this).data('login'));
	});
	
	$('button.trash').on('click', function(){
		$('div.mail_view').load("<?php echo base_url();?>index.php/adminpanel/del_msg/" + $(this).data('id'));
		$('.mail_list_column').find($('.msg[data-id="' + $(this).data('id') + '"]')).remove()
	});
</script>
					<?php if(!isset($msg_deleted)):?>
                        <div class="inbox-body">
                          <div class="mail_heading row">
                            <div class="col-md-8">
                              <div class="btn-group">
                                <button class="btn btn-sm btn-primary reply" type="button" data-login="<?php echo $message['sender_login'];?>"><i class="fa fa-reply"></i> Reply</button>
                                <button class="btn btn-sm btn-default trash" type="button" data-id="<?php echo $message['id'];?>" data-placement="top" data-toggle="tooltip" data-original-title="Trash"><i class="fa fa-trash-o"></i></button>
								<br />
								<br />
								<?php if(!isset($blacklist)):?>
									<a href="<?php echo base_url();?>index.php/adminpanel/block_user/<?php echo $message['sender_login'];?>"> <?php echo $this->lang->line('add_to_bl');?></a>
								<?php else:?>
									<a href="<?php echo base_url();?>index.php/adminpanel/unblock_user/<?php echo $message['sender_login'];?>"> <?php echo $this->lang->line('remove_from_bl');?></a>
								<?php endif;?>
                              </div>
                            </div>
                            <div class="col-md-4 text-right">
                              <p class="date"> <?php echo $message['date_add'];?></p>
                            </div>
                            <div class="col-md-12">
                              <h4> <?php echo $message['title'];?></h4>
                            </div>
                          </div>
                          <div class="sender-info">
                            <div class="row">
                              <div class="col-md-12">
                                <strong><?php echo $this->lang->line('from');?>: <?php echo $message['sender_login'];?></strong>
                                <br />
								<strong><?php echo $this->lang->line('to_me');?></strong>
                             </div>
                            </div>
                          </div>
                          <div class="view-mail">
                            <p><?php echo $message['body_text'];?></p>
                          </div>
                        </div>
				<?php else:?>
					<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('message_deleted');?></p>
				<?php endif;?>