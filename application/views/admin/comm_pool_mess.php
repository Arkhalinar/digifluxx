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
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Rus message</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<textarea name="rus"><?php echo $comm_pool_mess['russian'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Eng message</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<textarea name="eng"><?php echo $comm_pool_mess['english'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Ger message</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<textarea name="ger"><?php echo $comm_pool_mess['german'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" name="save_pool_mess" value="save" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
							</div>
						</div>
						<div class="ln_solid"></div>
                    </form>
					
					</div>
					
					
					</div>
					
					
					
					</div>
					</div>
					</div>