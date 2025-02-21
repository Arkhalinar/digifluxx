<script>
$(document).ready(function(){
	$('a.remove_banner').on('click', function() {
		link = "<?php echo base_url();?>index.php/adminpanel/del_banner/" + $(this).data('link');
		$('#del_btn').attr('href', link);
		$('.show-md').click();
	});
});
</script>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $this->lang->line('banners_page');?> </h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
			  <!-- Small modal -->
                  <button type="button" style="display:none;" class="btn btn-primary show-md" data-toggle="modal" data-target=".del-modal-sm"><?php echo $this->lang->line('banners_page');?></button>

                  <div class="modal fade del-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"><?php echo $this->lang->line('confirm_delete_banner');?></h4>
                        </div>
                        <div class="modal-body">
                          <p><?php echo $this->lang->line('no_restore');?></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                          <a href="" id="del_btn" type="button" class="btn btn-default"><?php echo $this->lang->line('yes');?></a>
                        </div>

                      </div>
                    </div>
                  </div>
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
					  <div class="x_content">
						<!-- start project list -->
						<?php echo form_open_multipart('adminpanel/add_banner');?>
						<input type="file" name="userfile" size="20" />
						<input type="submit" value="upload" />
						</form>

						<?php if(isset($_SESSION['uploaded'])): ?>
							<p class="success"><?php echo $this->lang->line('banners_uploaded');?></p>
						<?php endif; ?>
						<?php if(isset($error)): ?>
							<p class="no_reflink"><?php echo $error;?></p>
						<?php endif; ?>
						<?php if(isset($_SESSION['file_deleted'])): ?>
							<p class="success"><i class="fa fa-check"></i><?php echo $this->lang->line('file_deleted');?></p>
						<?php endif; ?>
						<?php if(isset($banners)): ?>
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<?php foreach($banners as $banner):?>
									<div class="row" style="margin-top:20px;">
										<img src="<?php echo base_url();?>assets/uploads/banners/<?php echo $banner;?>" />
										<br /><a style="color:#f00;" href="#" data-link="<?php echo $banner;?>" class="remove_banner" /><?php echo $this->lang->line('delete');?></a>
									</div>
								<?php endforeach;?>
							</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('no_banners');?></p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->