	<!-- TinyMCE -->
    <script src="<?php echo base_url();?>assets/js/tinymce/tinymce.min.js"></script>
	<script>
		$(document).ready(function() {
			tinymce.init({ 
				selector:'textarea',
				allow_conditional_comments: false,
				file_picker_types: 'image', 
				file_picker_callback: function(cb, value, meta) {
					var input = document.createElement('input');
					input.setAttribute('type', 'file');
					input.setAttribute('accept', 'image/*');
				
					input.onchange = function() {
					  var file = this.files[0];
					  var id = 'blobid' + (new Date()).getTime();
					  var blobCache = tinymce.activeEditor.editorUpload.blobCache;
					  var blobInfo = blobCache.create(id, file);
					  blobCache.add(blobInfo);
					  
					  // call the callback and populate the Title field with the file name
					  cb(blobInfo.blobUri(), { title: file.name });
					};
					input.click();
				}, 
				images_upload_url: 'upload_imgs',
				plugins: [
					'advlist autolink lists link image charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime media table contextmenu paste code imagetools'
				  ],
				toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			});
		});
	</script>

<!-- page content -->
    <div class="right_col" role="main">
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
		 <div class="x_title">
                    <h2><?php echo $this->lang->line('admin_menu_add_news');?> </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
				   <form data-parsley-validate class="form-horizontal form-label-left" method="post">
						<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('news_title');?> <?php echo $this->lang->line('admin_add_news_1');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <input type="text" name="title_russian" value="<?php if(isset($news['title_russian'])) echo $news['title_russian'];?><?php echo set_value('title_russian')?>" class="form-control col-md-12 col-xs-12">
							<?php echo form_error('title_russian');?>
						</div>
                      </div>	
					<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('news_text');?> <?php echo $this->lang->line('admin_add_news_2');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <textarea name="text_body_russian" rows="15" class="form-control col-md-12 col-xs-12"><?php if(isset($news['body_text_russian'])) echo $news['body_text_russian'];?><?php echo set_value('text_body_russian')?>
						  </textarea>
							<?php echo form_error('text_body_russian');?>
                        </div>
                      </div>
					  <hr />
					  <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english"><?php echo $this->lang->line('news_title');?> <?php echo $this->lang->line('admin_add_news_3');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <input type="text" name="title_english" value="<?php if(isset($news['title_english'])) echo $news['title_english'];?><?php echo set_value('title_english')?>" class="form-control col-md-12 col-xs-12">
							<?php echo form_error('title_english');?>
						</div>
                      </div>	
					<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('news_text');?> <?php echo $this->lang->line('admin_add_news_4');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <textarea name="text_body_english" rows="15" class="form-control col-md-12 col-xs-12"><?php if(isset($news['body_text_english'])) echo $news['body_text_english'];?><?php echo set_value('text_body_english')?>
						  </textarea>
							<?php echo form_error('text_body_english');?>
                        </div>
                      </div>
					  <hr />
					  <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('news_title');?> <?php echo $this->lang->line('admin_add_news_5');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <input type="text" name="title_german" value="<?php if(isset($news['title_german'])) echo $news['title_german'];?><?php echo set_value('title_german')?>" class="form-control col-md-12 col-xs-12">
							<?php echo form_error('title_german');?>
						</div>
                      </div>	
					<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('news_text');?> <?php echo $this->lang->line('admin_add_news_6');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <textarea name="text_body_german" rows="15" class="form-control col-md-12 col-xs-12"><?php if(isset($news['body_text_german'])) echo $news['body_text_german'];?><?php echo set_value('text_body_german')?>
						  </textarea>
							<?php echo form_error('text_body_german');?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title"><?php echo $this->lang->line('news_title');?> <?php echo $this->lang->line('admin_add_news_7');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <input type="text" name="title_hungar" value="<?php if(isset($news['title_hungar'])) echo $news['title_hungar'];?><?php echo set_value('title_hungar')?>" class="form-control col-md-12 col-xs-12">
							<?php echo form_error('title_hungar');?>
						</div>
                      </div>	
					<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('news_text');?> <?php echo $this->lang->line('admin_add_news_8');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <textarea name="text_body_hungar" rows="15" class="form-control col-md-12 col-xs-12"><?php if(isset($news['body_text_hungar'])) echo $news['body_text_hungar'];?><?php echo set_value('text_body_hungar')?>
						  </textarea>
							<?php echo form_error('text_body_hungar');?>
                        </div>
                      </div>
					  
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" name="seacrh" value="save" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
                        </div>
                      </div>
					  <div class="ln_solid"></div>

                    </form>
					
					</div>
					
					
					</div>
					
					
					
					</div>
					</div>
					</div>