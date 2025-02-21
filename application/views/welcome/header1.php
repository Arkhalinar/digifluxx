<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Betaprojekt</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta property="og:title" content="Betaprojekt">
<meta property="og:site_name" content="Betaprojekt">
<meta property="og:url" content="">
<meta property="og:description" content="This is an advertising platform where advertisers can submit their ads for the selected target group and have the opportunity to earn money for viewing advertising campaigns.">
<meta property="og:image" content="/assets/images/meta1.jpg?v=1.0">
<meta property="og:image:secure_url" content="">
<meta property="og:image:type" content="image/jpg">
<link rel="icon" type="image/x-icon" href="/assets/favicon1.ico?v=1.0">
<!-- css -->
<link href="/assets/css/style.css?v=x41" rel="stylesheet">
<link href="/assets/css/media.css?v=17" rel="stylesheet">
<!-- slider -->
<link rel="stylesheet"  href="/assets/slick/slick.css"/>
<link rel="stylesheet" href="/assets/slick/slick-theme.css?v=5"/>

<!-- font -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="top-line-header">
					<div class="row">
						<a href="/user/login"><?php echo $this->lang->line('sign_in');?><span style="display:none;"><?php echo get_cookie('lang');?></span></a>
						<a href="/user/reg"><?php echo $this->lang->line('registration');?></a>
						<div class="lang">
							<div class="lang-btn">
								<img src="/assets/images/<?php if(get_cookie('lang') == NULL || get_cookie('lang') == 'english') { ?>en<?php }elseif(get_cookie('lang') == 'german'){ ?>de<?php }else{ ?>rus<?php } ?>.png" align="center">
								English
							</div>
							<div class="lang-all">
								<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/russian'"><img src="/assets/images/rus.png" align="center">
								Русский</a>
								<br>
								<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/english'"><img src="/assets/images/en.png" align="center">
								English</a>
								<br>
								<a onclick="document.location.href='<?php echo base_url();?>index.php/user/switch_lang/german'"><img src="/assets/images/de.png" align="center">
								German</a>
								</div>
							<script>
								$('.lang-btn').click(function(){
									$(".lang-all").slideToggle(400);
								});
							</script>
						</div>
					</div>
				</div>
				<div class="bottom-line-header">
					<div class="row">
						<div class="menu-btn">
							<i class="fas fa-bars"></i>
						</div>
						<div class="logo">
							<a href="/"><img src="/assets/images/logo.png?v=1"></a>
						</div>
						<div class="menu">
							<ul>
								<!-- <li class="main-block"><a href="/"><?php echo $this->lang->line('head_1');?></a></li> -->
								<li><a href="/"><?php echo $this->lang->line('menu_main');?></a></li>
								<li><a href="/welcome/mark">Marketing</a></li>
								<li><a href="/welcome/faq">FAQ</a></li>
								<li class="main-block"><a href="/welcome/privacy"><?php echo $this->lang->line('head_3');?></a></li>
								<li><a href="/welcome/contacts"><?php echo $this->lang->line('supp_page');?></a></li>
							</ul>
						</div>
						<script>
							$('.menu-btn').click(function(){
									$(".menu").slideToggle(500);
								});
						</script>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div>