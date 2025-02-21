<!-- page content -->
    <div class="right_col" role="main">
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
		 		<div class="x_title">
                    <h2>Country creating</h2> 
                    <div class="clearfix"></div>
                  </div>
				   <div class="x_content">
					   <form data-parsley-validate class="form-horizontal form-label-left" method="post">
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_russian">Name</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<input type="text" <?php if(isset($packet)){ ?>value="<?php echo $packet['name'];?>"<?php } ?> name="name" class="form-control col-md-12 col-xs-12">
								</div>
							</div>	
							<hr />
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-3 col-xs-12" for="title_english">Category</label>
								<div class="col-md-11 col-sm-6 col-xs-12">
									<select name="cid">
										<?php
											$count = count($categs);

											$str = '';

											for($i = 0; $i < $count; $i++){

												if(isset($packet) && $packet['cid'] == $categs[$i]['id']) {
													$str = 'selected';
												}

												echo '<option value="'.$categs[$i]['id'].'" '.$str.'>'.$categs[$i]['name'].'</option>';

												$str = '';
											}
										?>
									</select>
								</div>
							</div>
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