<div class="row-content text-center white-bg">
	<div class="list-rek <?php if($whatpage == 'ban'){ ?>active-list<?php } ?>" onclick="document.location.href='myban'">
		<img src="/assets/img/ads-rek.png" style="width:75px;height:75px;" alt="" title="<?php echo $this->lang->line('traf_projs_3');?>">
		<div class="name-list-rek"><?php echo $this->lang->line('ad_menu_1');?></div>
	</div>
	<div class="list-rek <?php if($whatpage == 'text'){ ?>active-list<?php } ?>" onclick="document.location.href='mytext'">
		<img src="/assets/img/copy.png" style="width:75px;height:75px;" alt="" title="<?php echo $this->lang->line('ad_menu_2');?>">
		<div class="name-list-rek" style="font-weight: bold;"><?php echo $this->lang->line('ad_menu_2');?></div>
	</div>
	<div class="list-rek <?php if($whatpage == 'traf'){ ?>active-list<?php } ?>" onclick="document.location.href='traffic_projects'">
		<img src="/assets/img/traffic.jpeg" style="width:75px;height:75px;" alt="" title="<?php echo $this->lang->line('ad_menu_3');?>">
		<div class="name-list-rek"><?php echo $this->lang->line('ad_menu_3');?></div>
	</div>
	<div class="list-rek <?php if($whatpage == 'vid'){ ?>active-list<?php } ?>" onclick="document.location.href='#'">
		<img src="/assets/img/play.png" style="width:75px;height:75px;" alt="" title="<?php echo $this->lang->line('ad_menu_4');?>">
		<div class="name-list-rek"><?php echo $this->lang->line('ad_menu_4');?></div>
	</div>
</div>