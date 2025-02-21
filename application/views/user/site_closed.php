<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Сайт закрыт</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link href="<?php echo base_url();?>assets/css/closed_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/960.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Clarendon_LT_Std_700.font.js"></script>
<script type="text/javascript">
	Cufon.replace('h1,h3', {fontFamily: 'Clarendon LT Std', hover:true})
</script>
</head>
<body>
<div id="shim"></div>
<div id="content">
	<div class="logo_box"><h1><?php echo $site_name;?></h1></div>          
	<div class="main_box">
		<h2><?php echo $this->lang->line('site_closed_message');?></h2>
		
		<ul class="info">
			<li>
				<h3>P</h3>
				<p>866-599-5350<br/>403-926-8331</p>
			</li>
			<li>
				<h3>A</h3>
				<p>301 Clematis. Suite 3000<br/>West Palm Beach, FL 33401</p>
			</li>
			<li>
				<h3>S</h3>
				<p class="social">
					<a href="#" class="tw"></a>
					<a href="#" class="fb"></a>				
					<a href="#" class="li"></a>
				</p>
			</li>
		</ul>
	</div>
</div>

</body>
</html>
