<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="DigiFluxx">
<title>DIGIFLUXX</title>

<!-- Bootstrap Core CSS -->
<link href="/home/assets/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="/home/assets/css/main.css" rel="stylesheet">
<link href="/home/assets/css/style.css" rel="stylesheet">
<link href="/home/assets/css/responsive.css" rel="stylesheet">
<link href="/home/assets/fonts/flaticon.css" rel="stylesheet">
<link href="/home/assets/css/ionicons.min.css" rel="stylesheet">

<!-- JavaScripts -->
<script src="/home/assets/js/modernizr.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Online Fonts -->
<link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700,900|Montserrat:300,400,500,600,700,800" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

<!-- Map -->
<script id="heatmap_script" src="https://heat.omb100.com/stat.js" site="15862" usr="28545"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>

<!-- LOADER -->
<div id="loader">
  <div class="position-center-center">
    <div class="ldr"></div>
  </div>
</div>

<!-- Wrap -->
<div id="wrap"> 
  
  <!-- header -->
  <header class="sticky">
    <div class="container"> 
      
      <!-- Logo -->
      <div class="logo"> <a href="/welcome/"><img class="img-responsive" src="/home/assets/images/logo.png" alt="" ></a> </div>
      <nav class="navbar ownmenu navbar-expand-lg">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="nav">
            <li class="scroll active"><a href="#hme">Home</a></li>
            <li class="scroll"> <a href="#about">About </a> </li>
            <li class="scroll"> <a href="#contact">FAQ</a> </li>
          </ul>
		</div>
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
      </nav>
    </div>
    <div class="clearfix"></div>
  </header>
  
  <!-- HOME MAIN  -->
  <section class="simple-head" data-stellar-background-ratio="0.5" id="hme"> 
    <!-- Particles -->
    <div id="particles-js"></div>
    <div class="position-center-center">
      <div class="container text-center">
        <h2><?php echo $this->lang->line('home_01');?></h2>
		<h1><?php echo $this->lang->line('home_02');?></h1>
        <p><?php echo $this->lang->line('home_03');?></p>
        <a href="/user/login" class="btn">Login</a> <a href="/user/reg" class="btn btn-inverse">Sign up</a> </div>
    </div>
  </section>
  
  <!-- Content -->
  <div id="content"> 
    
    <!-- Why Choose Us -->
    <section class="why-choose padding-top-50 padding-bottom-50" id="about">
      <div class="container"> 
        
        <!-- Why Choose Us  ROW-->
        <div class="row">
          <div class="col-md-7 margin-top-60"> 
            
            <!-- Tittle -->
            <div class="heading margin-bottom-20">
              <h6 class="margin-bottom-10"><?php echo $this->lang->line('home_04');?></h6>
              <h4><?php echo $this->lang->line('home_05');?></h4>
            </div>
            <p><?php echo $this->lang->line('home_06');?></p>
</div>
                    
          <!-- Image -->
          <div class="col-md-5 text-right"> <img src="/home/assets/images/e-shop-img.png" alt="Why Choose Us Image" > </div>
        </div>
        
                       
	</section>

	<section class="light-bg padding-top-150 padding-bottom-150" id="team">
	<div class="container">
       
	
	<!-- FAQS -->
        <div class="row">
          <div class="col-md-6"> 
            
            <!-- According Style 1 -->
            <div class="panel-group accordion" id="accordion"> 
              
              <!-- According 1 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed"> What is DigiFluxx ?</a> </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body"> DIGIFLUXX ist eine Werbeplattform. </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6"> 
            
            <!-- According Style 1 -->
            <div class="panel-group accordion" id="accordion"> 
              
              <!-- According 1 -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-1" class="collapsed"> Our Mission</a> </h4>
                </div>
                <div id="collapseOne-1" class="panel-collapse collapse">
                  <div class="panel-body"> Entwicklung von Kundenbindungsprogramme der neuen Generation, welches zur Kundengewinnung und Kundenbindung dient. </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Join our community -->

  </div>
  
  <!-- Footer -->
  <footer id="contact">
    
    <!-- Rights -->
    <div class="rights">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <p>© 2019 DIGIFLUXX UG. All Rights Reserved.</p>
          </div>
          <div class="col-md-6 text-right"> <a href="/welcome/impressum">Impressum </a> <a href="/welcome/term">Terms & Conditions </a> <a href="#">Privacy Policy</a> </div>
        </div>
      </div>
    </div>
  </footer>
</div>

<!-- GO TO TOP --> 
	<a href="#" class="cd-top"><i class="ion-chevron-up"></i></a> 
<!-- GO TO TOP End --> 

<!-- Script --> 
<script src="/home/assets/js/jquery-1.11.3.min.js"></script> 
<script src="/home/assets/js/bootstrap.min.js"></script> 
<script src="/home/assets/js/particles.min.js"></script> 
<script src="/home/assets/js/jquery.counterup.min.js"></script> 
<script src="/home/assets/js/jquery.sticky.js"></script> 
<script src="/home/assets/js/jquery.magnific-popup.min.js"></script> 
<script src="/home/assets/js/main.js"></script>
</body>
</html>
