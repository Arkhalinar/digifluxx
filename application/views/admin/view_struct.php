<script>
function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

$(document).ready(function() {
	if(getCookie('scr_width') === undefined) {
		setCookie('scr_width', $(window).width(), 3600);
	}
});


 <!-- page content -->
		<script>
			$(document).ready(function() {
				$('#usearch button').on('click', function(){
					$('#usearch').submit();
				});
			});
		</script>
        <div class="right_col" role="main">
		<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form method="post" id="usearch">
                  <div class="input-group">
					<input type="text" name="username" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><?php echo $this->lang->line('search');?></button>
					</form>
                    </span>
                  </div>
                </div>
              </div>
			  
         <br />
		  
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $this->lang->line('structures_view');?> </h2>
                    
                    <div class="clearfix"></div>
					<div class="clearfix"></div>
				</div>

                  <div class="x_content">
                    
						<div class="table-responsive">
						<?php if(!isset($not_found) && isset($user_level)): ?>
							<div class="x_content">

							<?php if($user_level > 0): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th style="width: 1%"><?php echo $this->lang->line('level');?></th>
								  <th style="width: 20%">№ <?php echo $this->lang->line('of_places');?></th>
								  <th><?php echo $this->lang->line('filled');?></th>
								  <th><?php echo $this->lang->line('progress');?></th>
								</tr>
							  </thead>
							  <tbody>
								<?php $level_counter = 1; ?>
								<?php foreach($struct as $s):?>
									<tr>
									  <td><?php echo $level_counter;?></td>
									  <td>
										<a href="/index.php/adminpanel/view_struct/<?php echo $s['first_place'];?>/<?php echo $level_counter;?>"><?php echo $s['places'];?> (<?php echo $this->lang->line('total_places');?>: <?php echo $s['count_places'];?>)</a>
									  </td>
									  <td>
										<ul class="list-inline">
										  <?php for($i=1; $i<=$s['level_closure']; $i++): ?>
											  <li>
												<img src="<?php echo base_url();?>/assets/images/user.png" class="avatar" alt="Avatar">
											  </li>
											<?php endfor; ?>
										</ul>
									  </td>
									  <td class="project_progress">
										<div class="progress progress_sm">
										  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $s['lvl_percent_closure'];?>"></div>
										</div>
										<small><?php echo $s['lvl_percent_closure'];?>% <?php echo $this->lang->line('complete');?></small>
									  </td>
									</tr>
									<?php $level_counter++;?>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							</div>
							<?php endif;?>
							<!-- start project list -->
							 <div id="chart_div"></div>
							<!-- end project list -->

						  </div>
						<?php else: ?>
								<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('nothing_found');?></p>
							<?php endif; ?>
						</div>
					

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script>
			$(document).ready(function(){
				google.charts.load('current', {packages:["orgchart"]});
				google.charts.setOnLoadCallback(drawChart);

				  function drawChart() {
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Name');
					data.addColumn('string', 'Manager');
					data.addColumn('string', 'ToolTip');

					// For each orgchart box, provide the name, manager, and tooltip to show.
					data.addRows([
					[{v:'<?php echo $users[0]["place"]?>', f:'<i class="fa fa-user"></i><p><?php echo $users[0]["name"];?></p>'},
					   '', 'Head'],
					<?php for($i=1; $i<count($users); $i++): ?>
						[{v:'<?php echo $users[$i]["place"];?>', f: '<i data-id="<?php echo $users[$i]['place'];?>" class="fa fa-' + "<?php echo $users[$i]['ico'];?>" + '"></i><p><?php echo $users[$i]["name"];?></p>'},
					   '<?php echo $users[$i]["parent"];?>', ''],
					<?php endfor; ?>
					]);

					// Create the chart.
					var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
					// Draw the chart, setting the allowHtml option to true for the tooltips.
					google.visualization.events.addListener(chart, 'ready', function() {
						$('.google-visualization-orgchart-node').on('click', function() {
						  uid = $(this).find('i').data('id');
						  if(uid === undefined)
							  uid = 1;
						  window.location.href='<?php echo base_url();?>index.php/adminpanel/view_struct/' + uid + '/<?php echo $level;?>;
						});
					});
					chart.draw(data, {allowHtml:true});
				  }
			});
		</script>
        <!-- /page content -->
