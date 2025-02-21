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
                    <h2><?php echo $this->lang->line('menu_product');?> </h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
				   <form data-parsley-validate class="form-horizontal form-label-left" method="post">
						<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('link');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <input type="text" name="link" rows="15" class="form-control col-md-12 col-xs-12" value="<?php echo $link;?>"/>
							<?php echo form_error('link');?>
                        </div>
                      </div>
						
						<div class="form-group">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="text_body"><?php echo $this->lang->line('news_text');?>
                        </label>
                        <div class="col-md-11 col-sm-6 col-xs-12">
                          <textarea name="text_body" rows="15" class="form-control col-md-12 col-xs-12"><?php echo $text;?><?php echo set_value('text')?>
						  </textarea>
							<?php echo form_error('text_body');?>
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