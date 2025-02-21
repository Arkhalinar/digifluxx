<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title><?php echo $this->lang->line('admin_head_titel');?>DIGIFLUXX</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url();?>assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/cabinet2.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/admin.css?v=213.234" rel="stylesheet">
	
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!-- jQuery -->
    <script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
	
	
	
	
	
	

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url();?>index.php/adminpanel/index" class="site_title"><?php echo $this->lang->line('admin_head_titel');?></a>
            </div>

            <div class="clearfix"></div>

            <div>
              <?php echo $this->lang->line('admin_head_1');?> <?php echo date('H:i');?>
            </div>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $this->lang->line('general');?></h3>
                <ul class="nav side-menu">
                  <li><a href="/index.php/adminpanel/"> <?php echo $this->lang->line('admin_head_2');?> </a></li>
                  <li><a href="/index.php/adminpanel/view_adv"> <?php echo $this->lang->line('admin_head_3');?> </a></li>
                  <li><a href="/index.php/adminpanel/payments"> <?php echo $this->lang->line('admin_head_4');?> </a></li>
                  <li><a href="/index.php/adminpanel/payments_accepted"> <?php echo $this->lang->line('admin_head_5');?> </a></li>
                  <li><a href="/index.php/adminpanel/payments_decleaned"> <?php echo $this->lang->line('admin_head_6');?> </a></li>
                  <li><a href="/index.php/adminpanel/view_user_history"> <?php echo $this->lang->line('admin_head_7');?></a></li>
      				    <li><a href="/index.php/adminpanel/members"> <?php echo $this->lang->line('admin_head_8');?> </a></li>
                  <hr>
                  <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('admin_head_9');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="/index.php/adminpanel/answ_setts"> <?php echo $this->lang->line('admin_head_10');?> </a></li>
                      <li><a href="/index.php/adminpanel/answ_setts2"> <?php echo $this->lang->line('admin_head_11');?> </a></li>
                      <li><a href="/index.php/adminpanel/answ_setts3"> <?php echo $this->lang->line('admin_head_12');?> </a></li>
                    </ul>
                  </li>
                  <hr>
                  <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('admin_head_13');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="/index.php/adminpanel/view_tprj"> Traffic projects </a></li>
                      <li><a href="/index.php/adminpanel/view_bnr"> <?php echo $this->lang->line('admin_head_14');?> </a></li>
                      <li><a href="/index.php/adminpanel/view_ads"> <?php echo $this->lang->line('admin_head_15');?> </a></li>
                      <li><a href="#"> <?php echo $this->lang->line('admin_head_16');?> </a></li>
                      <!-- /index.php/adminpanel/view_mess -->
                    </ul>
                  </li>
                  <hr>
                  <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('admin_head_17');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="/index.php/adminpanel/view_fin_setts"> <?php echo $this->lang->line('admin_head_18');?> </a></li>
                    </ul>
                  </li>
                  <hr>
                  <li><a href="/index.php/marketing_test/panel_page"> <?php echo $this->lang->line('admin_head_19');?> </a></li>
                  <hr>
                  <li><a href="/index.php/adminpanel/traf_proj_panel"> Project panel </a></li>
                  <li><a href="/index.php/adminpanel/category_panel"> Traffic Category panel </a></li>
                  <li><a href="/index.php/adminpanel/country_panel"> Traffic Country panel </a></li>
                  <hr>
                  <li><a href="/index.php/adminpanel/add_code"> <?php echo $this->lang->line('admin_head_20');?> </a></li>
                  <li><a href="/index.php/adminpanel/news_panel"> <?php echo $this->lang->line('admin_head_21');?> </a></li>

                  <li><a href="/index.php/adminpanel/news_panel2"> <?php echo $this->lang->line('admin_head_21');?> 2 </a></li>
                  <li><a href="/index.php/adminpanel/news_panel3"> <?php echo $this->lang->line('admin_head_21');?> 3 </a></li>

                  <li><a href="/index.php/adminpanel/packet_panel"> Packet constructor </a></li>

				          <li><a href="/index.php/adminpanel/save_mail"> <?php echo $this->lang->line('admin_head_22');?> </a></li>

                  <li><a href="/index.php/adminpanel/code_setts"> Code setts </a></li>

                  <li><a href="/index.php/adminpanel/pre_ad_panel"> Adver construct </a></li>

                  <li><a href="/index.php/adminpanel/comm_pool_mess"> Community pool message </a></li>
                </ul>
              </div>

            </div>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
				
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    ADMIN
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!-- <li>
                      <a href="<?php echo base_url();?>index.php/adminpanel/settings">
                        <span><?php echo $this->lang->line('settings');?></span>
                      </a>
                    </li> -->
                    <li><a href="<?php echo base_url();?>index.php/adminpanel/logout"><i class="fa fa-sign-out pull-right"></i> <?php echo $this->lang->line('logout');?></a></li>
                  </ul>
                </li>

                <!-- <li role="presentation" class="dropdown">
                  <a href="<?php echo base_url();?>index.php/adminpanel/mail" class="info-number" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <?php if(isset($_SESSION['new_messages']) && $_SESSION['new_messages'] > 0):?>
						<span class="badge bg-green" id="new_msgs"><?php echo $_SESSION['new_messages'];?></span>
					<?php endif;?>
                  </a>
                </li>-->
				
				
				<!--<li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $this->lang->line('language');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right" id="langs">
                    				<li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/german" class="info-number" aria-expanded="false">
                    <img height="20px" src="<?php echo base_url();?>assets/images/de.png" class="fa fa-envelope-o"></i>
                  German</a>				  
                </li>
				<li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/russian" class="info-number" aria-expanded="false">
                    <img height="20px" src="<?php echo base_url();?>assets/images/ru.png" class="fa fa-envelope-o"></i>
                  Русский</a>				  
                </li>
				<li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/english" class="info-number" aria-expanded="false">
                    <img height="20px" src="<?php echo base_url();?>assets/images/uk.png" class="fa fa-envelope-o"></i>
                  English</a>				  
                </li>
                  </ul>
                </li> -->
				
				
				
              </ul>
            </nav>
			<div class="lang">
							<div class="lang-btn">
								<img src="/assets/images/<?php if(get_cookie('lang') == NULL || get_cookie('lang') == 'english') { ?>en<?php }elseif(get_cookie('lang') == 'german'){ ?>de<?php }else{ ?>rus<?php } ?>.png" align="center">
								<?php if(get_cookie('lang') == NULL || get_cookie('lang') == 'english') { ?>English<?php }elseif(get_cookie('lang') == 'german'){ ?>German<?php }else{ ?>Russian<?php } ?>
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
        <!-- /top navigation -->