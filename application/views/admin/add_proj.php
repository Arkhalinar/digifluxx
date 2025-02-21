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
					<h2 style="padding-top:5px;"><?php if(isset($packet)){ ?>Sponsor projects edit<?php } else{ ?>Sponsor projects creating<?php } ?></h2> 
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" method="post">
						<div class="form-group">
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Header</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<input type="text" name="header" <?php if(isset($packet)){ ?>value="<?php echo $packet['header'];?>"<?php } ?> class="form-control col-md-12 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">URL</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<input type="text" name="url" <?php if(isset($packet)){ ?>value="<?php echo $packet['url'];?>"<?php } ?> class="form-control col-md-12 col-xs-12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Ref URL</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<input type="text" name="ref_url_for_check" <?php if(isset($packet)){ ?>value="<?php echo $packet['ref_url_for_check'];?>"<?php } ?> class="form-control col-md-12 col-xs-12">
							</div>
						</div>
						<div class="form-group">
			                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_4');?></label>
			                <div class="col-md-11 col-sm-6 col-xs-12">
				                <select id="cr_type_cont" name="type_cont">
				                	<option value="file" <?php if(isset($packet) && $packet['type'] == 'file'){echo 'selected';}?>><?php echo $this->lang->line('myban_5');?></option>
				                	<option value="link" <?php if(isset($packet) && $packet['type'] == 'link'){echo 'selected';}?>><?php echo $this->lang->line('myban_6');?></option>
				                </select>
				            </div>
			            </div>
						<div class="form-group" id="for_content">
							<?php if(isset($packet) && $packet['type'] == 'link'){ ?>
				                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_6');?></label>
				                <div class="col-md-11 col-sm-6 col-xs-12">
				                	<input type="text" id="file_url" class="form-control" <?php if(isset($packet) && $packet['type'] == 'link'){echo 'value="'.$packet['img'].'"';}?> name="uploadfile">
				                </div>
			            	<?php }else{ ?>
			            		<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_7');?></label><div class="col-md-11 col-sm-6 col-xs-12"><input id="file_bn_in" type="file" class="form-control-file" name="uploadfile"></div>
			            	<?php } ?>
			            </div>
			            <hr>
			            <div class="form-group">
			            	<?php
			            		if(isset($packet)) {
			            			$add_info = json_decode($packet['add_info'], true);
			            		}
			            	?>
			                <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_4');?></label>
			                <div class="col-md-11 col-sm-6 col-xs-12">
				                <select id="cr_type_detail" name="detail_type_cont">
				                	<option value="html" <?php if(isset($packet) && $add_info['type'] == 'html'){echo 'selected';}?>>Описание</option>
				                	<option value="iframe" <?php if(isset($packet) && $add_info['type'] == 'iframe'){echo 'selected';}?>>IFRAME</option>
				                </select>
				            </div>
				            <script type="text/javascript">
				            	$('#cr_type_detail').on('change', function(){
				            		let val = $('#cr_type_detail').val();
				            		if(val == 'iframe') {
				            			$('#body_div').hide();
				            			$('#iframe_div').show();
				            		}else {
				            			$('#body_div').show();
				            			$('#iframe_div').hide();
				            		}
				            	})
				            </script>
			            </div>
			            <div class="form-group" id="body_div" <?php if(isset($packet) && $add_info['type'] == 'iframe'){echo 'style="display:none;"';}?>>
							<label class="control-label col-md-1 col-sm-3 col-xs-12">Body</label>
							<div class="col-md-11 col-sm-6 col-xs-12">
								<textarea name="body"><?php if(isset($packet)){  echo $packet['body']; } ?></textarea>
							</div>
						</div>
						<div id="iframe_div" <?php if(!isset($packet) || (isset($packet) && $add_info['type'] == 'html')){echo 'style="display:none;"';}?>>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12">IFRAME URL</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" name="iframe_url" <?php if(isset($packet) && $add_info['type'] == 'iframe'){echo 'value="'.$add_info['url'].'"';}?>>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">ВЫСОТА ОКНА</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" name="height" <?php if(isset($packet) && $add_info['type'] == 'iframe'){echo 'value="'.$add_info['height'].'"';}?>>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" name="save" value="save" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
							</div>
						</div>
						<div class="ln_solid"></div>
						<script type="text/javascript">
			              $('select[name=type_cont]').on('change', function(){
			                var val = $('select[name=type_cont]').val();
			                if(val == 'file') {
			                  $('#for_content').html('<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_7');?></label><div class="col-md-11 col-sm-6 col-xs-12"><input id="file_bn_in" type="file" class="form-control-file" name="uploadfile"></div>');
			                }else {
			                  $('#for_content').html('<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian"><?php echo $this->lang->line('myban_6');?></label><div class="col-md-11 col-sm-6 col-xs-12"><input id="file_url" type="text" class="form-control" name="uploadfile"></div>');
			                }
			              })
			            </script>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>