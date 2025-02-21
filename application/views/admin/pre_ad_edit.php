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
                    <h2>Block editing (<a href="/adminpanel/pre_ad_panel">Back</a>)</h2> 
                    <div class="clearfix"></div>
                </div>
				<div class="x_content">
					<?php
						if( isset($_SESSION['err_pre_enter_ad1']))
						{
							echo '<p style="color:red;">'.$_SESSION['err_pre_enter_ad1'].'</p>';
							unset($_SESSION['err_pre_enter_ad1']);
						}

						if( isset($_SESSION['err_pre_enter_ad2']))
						{
							echo '<p style="color:red;">'.$_SESSION['err_pre_enter_ad2'].'</p>';
							unset($_SESSION['err_pre_enter_ad2']);
						}

						if( isset($_SESSION['err_pre_enter_ad3']))
						{
							echo '<p style="color:red;">'.$_SESSION['err_pre_enter_ad3'].'</p>';
							unset($_SESSION['err_pre_enter_ad3']);
						}

						if(is_null($block[0]['block_1']))
						{
							$block_1 = NULL;
						}
						else
						{
							$block_1 = json_decode($block[0]['block_1'], true);
						}

						if(is_null($block[0]['block_2']))
						{
							$block_2 = NULL;
						}
						else
						{
							$block_2 = json_decode($block[0]['block_2'], true);
						}

						if(is_null($block[0]['block_3']))
						{
							$block_3 = NULL;
						}
						else
						{
							$block_3 = json_decode($block[0]['block_3'], true);
						}

					?>
				   	<form enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" method="post">
				   		<input type="hidden" name="block_id" value="<?php echo $block[0]['id'];?>">
				   		<div>
				   			<div>
				   				<span style="font-size: 150%; font-weight: bold;">LEFT</span><br>
				   				Type<br>
				   				<select name="type_left">
				   					<option value="-" <?php if(is_null($block_1)) {echo 'selected';} ?>>-</option>
				   					<option value="text" <?php if(!is_null($block_1) && $block_1['type'] == 'text') {echo 'selected';} ?>>Text</option>
				   					<option value="img" <?php if(!is_null($block_1) && $block_1['type'] == 'img') {echo 'selected';} ?>>Image</option>
				   					<option value="vid" <?php if(!is_null($block_1) && $block_1['type'] == 'vid') {echo 'selected';} ?>>Video</option>
				   				</select>
				   				<script type="text/javascript">
				   					$('select[name=type_left]').on('change', function(){
				   						val = $('select[name=type_left]').val();
				   						switch (val)
				   						{
				   							case ('-'):
				   								$('#empty').show();
				   								$('#text').hide();
				   								$('#video').hide();
				   								$('#img').hide();
				   								break;
				   							case ('text'):
				   								$('#empty').hide();
				   								$('#text').show();
				   								$('#video').hide();
				   								$('#img').hide();
				   								break;
				   							case ('vid'):
				   								$('#empty').hide();
				   								$('#text').hide();
				   								$('#video').show();
				   								$('#img').hide();
				   								break;
				   							case ('img'):
				   								$('#empty').hide();
				   								$('#text').hide();
				   								$('#video').hide();
				   								$('#img').show();
				   								break;
				   						}
				   					});
				   				</script>
				   			</div>
				   			<hr />
				   			<div id="for_left">
				   				<div id="empty" <?php if(!is_null($block_1)) {echo 'style="display:none;"';} ?>>
				   				</div>
				   				<div id="text" <?php if(is_null($block_1) || $block_1['type'] != 'text') {echo 'style="display:none;"';} ?>>
									<div class="form-group">
				                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Text to add</label>
				                        <div class="col-md-11 col-sm-6 col-xs-12">
				                          <textarea name="text_left" rows="15" class="form-control col-md-12 col-xs-12"><?php if(!is_null($block_1) && $block_1['type'] == 'text') {echo $block_1['content'];} ?></textarea>
										</div>
				                    </div>
				                </div>
				                <div id="video" <?php if(is_null($block_1) || $block_1['type'] != 'vid') {echo 'style="display:none;"';} ?>>
					                <div class="form-group">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Video</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="vid_left" value="<?php if(!is_null($block_1) && $block_1['type'] == 'vid') {echo 'https://www.youtube.com/watch?v='.$block_1['content'];} ?>" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
								<div id="img" <?php if(is_null($block_1) || $block_1['type'] != 'img') {echo 'style="display:none;"';} ?>>
									Image type<br>
					   				<select name="type_img">
					   					<option value="dwnl">Download</option>
					   					<option value="link">Link</option>
					   				</select>
					   				<script type="text/javascript">
					   					$('select[name=type_img]').on('change', function(){
					   						val = $('select[name=type_img]').val();
					   						switch (val)
					   						{
					   							case ('link'):
					   								$('#link').show();
					   								$('#dwnl').hide();
					   								break;
					   							case ('dwnl'):
					   								$('#link').hide();
					   								$('#dwnl').show();
					   								break;
					   						}
					   					});
					   				</script>
									<div class="form-group" id="dwnl">
										<select name="size_left">
											<option value="125x125">125x125</option>
											<option value="300x50">300x50</option>
											<option value="300x250">300x250</option>
											<option value="300x600">300x600</option>
											<option value="468x60">468x60</option>
											<option value="728x90">728x90</option>
										</select>
										<hr>
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Download</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="file" name="left_img" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
									<div class="form-group" id="link" style="display:none;">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Link</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="link_left" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
							</div>
				        </div>
				        <hr>
				        <div>
				   			<div>
				   				<span style="font-size: 150%; font-weight: bold;">MIDDLE</span><br>
				   				Type<br>
				   				<select name="type_mid">
				   					<option value="-" <?php if(is_null($block_2)) {echo 'selected';} ?>>-</option>
				   					<option value="text" <?php if(!is_null($block_2) && $block_2['type'] == 'text') {echo 'selected';} ?>>Text</option>
				   					<option value="img" <?php if(!is_null($block_2) && $block_2['type'] == 'img') {echo 'selected';} ?>>Image</option>
				   					<option value="vid" <?php if(!is_null($block_2) && $block_2['type'] == 'vid') {echo 'selected';} ?>>Video</option>
				   				</select>
				   				<script type="text/javascript">
				   					$('select[name=type_mid]').on('change', function(){
				   						val = $('select[name=type_mid]').val();
				   						switch (val)
				   						{
				   							case ('-'):
				   								$('#empty_mid').show();
				   								$('#text_mid').hide();
				   								$('#video_mid').hide();
				   								$('#img_mid').hide();
				   								break;
				   							case ('text'):
				   								$('#empty_mid').hide();
				   								$('#text_mid').show();
				   								$('#video_mid').hide();
				   								$('#img_mid').hide();
				   								break;
				   							case ('vid'):
				   								$('#empty_mid').hide();
				   								$('#text_mid').hide();
				   								$('#video_mid').show();
				   								$('#img_mid').hide();
				   								break;
				   							case ('img'):
				   								$('#empty_mid').hide();
				   								$('#text_mid').hide();
				   								$('#video_mid').hide();
				   								$('#img_mid').show();
				   								break;
				   						}
				   					});
				   				</script>
				   			</div>
				   			<hr />
				   			<div id="for_mid">
				   				<div id="empty_mid" <?php if(!is_null($block_2)) {echo 'style="display:none;"';} ?>>
				   				</div>
				   				<div id="text_mid" <?php if(is_null($block_2) || $block_2['type'] != 'text') {echo 'style="display:none;"';} ?>>
									<div class="form-group">
				                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Text to add</label>
				                        <div class="col-md-11 col-sm-6 col-xs-12">
				                          <textarea name="text_mid" rows="15" class="form-control col-md-12 col-xs-12"><?php if(!is_null($block_2) && $block_2['type'] == 'text') {echo $block_2['content'];} ?></textarea>
										</div>
				                    </div>
				                </div>
				                <div id="video_mid" <?php if(is_null($block_2) || $block_2['type'] != 'vid') {echo 'style="display:none;"';} ?>>
					                <div class="form-group">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Video</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="vid_mid" value="<?php if(!is_null($block_2) && $block_2['type'] == 'vid') {echo 'https://www.youtube.com/watch?v='.$block_2['content'];} ?>" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
								<div id="img_mid" <?php if(is_null($block_2) || $block_2['type'] != 'img') {echo 'style="display:none;"';} ?>>
									Image type<br>
					   				<select name="type_img_mid">
					   					<option value="dwnl">Download</option>
					   					<option value="link">Link</option>
					   				</select>
					   				<script type="text/javascript">
					   					$('select[name=type_img_mid]').on('change', function(){
					   						val = $('select[name=type_img_mid]').val();
					   						switch (val)
					   						{
					   							case ('link'):
					   								$('#link_mid').show();
					   								$('#dwnl_mid').hide();
					   								break;
					   							case ('dwnl'):
					   								$('#link_mid').hide();
					   								$('#dwnl_mid').show();
					   								break;
					   						}
					   					});
					   				</script>
									<div class="form-group" id="dwnl_mid">
										<select name="size_mid">
											<option value="125x125">125x125</option>
											<option value="300x50">300x50</option>
											<option value="300x250">300x250</option>
											<option value="300x600">300x600</option>
											<option value="468x60">468x60</option>
											<option value="728x90">728x90</option>
										</select>
										<hr>
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Download</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="file" name="mid_img" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
									<div class="form-group" id="link_mid" style="display:none;">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Link</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="link_mid" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
							</div>
				        </div>
				        <hr>
				        <div>
				   			<div>
				   				<span style="font-size: 150%; font-weight: bold;">RIGHT</span><br>
				   				Type<br>
				   				<select name="type_right">
				   					<option value="-" <?php if(is_null($block_3)) {echo 'selected';} ?>>-</option>
				   					<option value="text" <?php if(!is_null($block_3) && $block_3['type'] == 'text') {echo 'selected';} ?>>Text</option>
				   					<option value="img" <?php if(!is_null($block_3) && $block_3['type'] == 'img') {echo 'selected';} ?>>Image</option>
				   					<option value="vid" <?php if(!is_null($block_3) && $block_3['type'] == 'vid') {echo 'selected';} ?>>Video</option>
				   				</select>
				   				<script type="text/javascript">
				   					$('select[name=type_right]').on('change', function(){
				   						val = $('select[name=type_right]').val();
				   						switch (val)
				   						{
				   							case ('-'):
				   								$('#empty_right').show();
				   								$('#text_right').hide();
				   								$('#video_right').hide();
				   								$('#img_right').hide();
				   								break;
				   							case ('text'):
				   								$('#empty_right').hide();
				   								$('#text_right').show();
				   								$('#video_right').hide();
				   								$('#img_right').hide();
				   								break;
				   							case ('vid'):
				   								$('#empty_right').hide();
				   								$('#text_right').hide();
				   								$('#video_right').show();
				   								$('#img_right').hide();
				   								break;
				   							case ('img'):
				   								$('#empty_right').hide();
				   								$('#text_right').hide();
				   								$('#video_right').hide();
				   								$('#img_right').show();
				   								break;
				   						}
				   					});
				   				</script>
				   			</div>
				   			<hr />
				   			<div id="for_right">
				   				<div id="empty_right" <?php if(!is_null($block_3)) {echo 'style="display:none;"';} ?>>
				   				</div>
				   				<div id="text_right" <?php if(is_null($block_3) || $block_3['type'] != 'text') {echo 'style="display:none;"';} ?>>
									<div class="form-group">
				                        <label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Text to add</label>
				                        <div class="col-md-11 col-sm-6 col-xs-12">
				                          <textarea name="text_right" rows="15" class="form-control col-md-12 col-xs-12"><?php if(!is_null($block_3) && $block_3['type'] == 'text') {echo $block_3['content'];} ?></textarea>
										</div>
				                    </div>
				                </div>
				                <div id="video_right" <?php if(is_null($block_3) || $block_3['type'] != 'vid') {echo 'style="display:none;"';} ?>>
					                <div class="form-group">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Video</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="vid_right" value="<?php if(!is_null($block_3) && $block_3['type'] == 'vid') {echo 'https://www.youtube.com/watch?v='.$block_3['content'];} ?>" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
								<div id="img_right" <?php if(is_null($block_3) || $block_3['type'] != 'img') {echo 'style="display:none;"';} ?>>
									Image type<br>
					   				<select name="type_img_right">
					   					<option value="dwnl">Download</option>
					   					<option value="link">Link</option>
					   				</select>
					   				<script type="text/javascript">
					   					$('select[name=type_img_right]').on('change', function(){
					   						val = $('select[name=type_img_right]').val();
					   						switch (val)
					   						{
					   							case ('link'):
					   								$('#link_right').show();
					   								$('#dwnl_right').hide();
					   								break;
					   							case ('dwnl'):
					   								$('#link_right').hide();
					   								$('#dwnl_right').show();
					   								break;
					   						}
					   					});
					   				</script>
									<div class="form-group" id="dwnl_right">
										<select name="size_right">
											<option value="125x125">125x125</option>
											<option value="300x50">300x50</option>
											<option value="300x250">300x250</option>
											<option value="300x600">300x600</option>
											<option value="468x60">468x60</option>
											<option value="728x90">728x90</option>
										</select>
										<hr>
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Download</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="file" name="right_img" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
									<div class="form-group" id="link_right" style="display:none;">
										<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Link</label>
										<div class="col-md-11 col-sm-6 col-xs-12">
											<input type="text" name="link_right" class="form-control col-md-12 col-xs-12">
										</div>
									</div>
								</div>
							</div>
				        </div>
						<hr>
						<div>
							Language:<br>
							<select name="lang">
								<option value="all" <?php if($block[0]['lang'] == 'all') {echo 'selected';} ?>>All</option>
								<option value="eng" <?php if($block[0]['lang'] == 'eng') {echo 'selected';} ?>>English</option>
								<option value="rus" <?php if($block[0]['lang'] == 'rus') {echo 'selected';} ?>>Russian</option>
								<option value="ger" <?php if($block[0]['lang'] == 'ger') {echo 'selected';} ?>>German</option>
							</select>
						</div>
						<hr>
						<div>
							Status:<br>
							<select name="status">
								<option value="1" <?php if($block[0]['status'] == 1) {echo 'selected';} ?>>ON</option>
								<option value="0" <?php if($block[0]['status'] == 0) {echo 'selected';} ?>>OFF</option>
							</select>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" name="save" value="save" class="btn btn-success"><?php echo $this->lang->line('submit');?></button>
							</div>
						</div>
						<div class="ln_solid"></div>
				    </form>
				</div>
				</div>
			</div>
		</div>
	</div>