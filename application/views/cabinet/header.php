<!DOCTYPE html>
<html>
<head>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M2S3WP4');</script>
  <!-- End Google Tag Manager -->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta property="og:title" content="traffic-star">
  <meta property="og:site_name" content="traffic-star">
  <meta property="og:url" content="<?php echo base_url();?>">
  <meta property="og:description" content="traffic-star!">
  <meta property="og:image" content="<?php echo base_url();?>assets/img/meta_img.jpg">
  <meta property="og:image:secure_url" content="<?php echo base_url();?>assets/img/meta_img.jpg">
  <meta property="og:image:type" content="image/jpg">

  <title><?php echo $this->lang->line('header_1');?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
   <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/assets/css/normalize.css?v=290">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/assets/css/stiles.css?v=1001">

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
 <!-- HERE -->
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->



  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>examples/crop-avatar/dist/cropper.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>examples/crop-avatar/css/main.css?v=1">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets/css/rek_style.css?v=q12840">



  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


  <!-- Google Analytics -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script type="text/javascript">
    var gaProperty = 'UA-133733642-1';
    var disableStr = 'ga-disable-' + gaProperty;
    if (document.cookie.indexOf(disableStr + '=true') > -1) {
    window[disableStr] = true;
    }
    function gaOptout() {
    document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
    window[disableStr] = true;
    }
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133733642-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-133733642-1');
    gtag('set', 'anonymizeIp', true);
  </script>
  <!-- Google Analytics End -->

<!-- Map -->
<script id="heatmap_script" src="https://heat.omb100.com/stat.js" site="15868" usr="28545"></script>


</head>
<body class="hold-transition skin-blue sidebar-mini">

  <script type="text/javascript">
    function ClickCount(id, type) {
      $.post(
        '<?php echo base_url();?>welcome/count_up',
        {
          id: id,
          cont_type: type,
          type: 'click'
        },
        function(data) {}
      )
    }
  </script>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M2S3WP4"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

<script>
  function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
  }
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
</script>

<!-- End Banners -->

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo" style="font-weight: bold;">
      <style type="text/css">
        #log_img_head {
          display: inline;
          float: left;
          width: 20%;
          margin-top: 11px;
        }
        @media (max-width: 400px){
          #log_img_head {
            width: 10%;
          }
        }
      </style>
      <img onclick="document.location.href'/'" id="log_img_head" src="/assets/images/logo.png">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span onclick="document.location.href'/'" class="logo-mini"><img style="width: 80%;" src="/assets/images/logo.png"></span>
      <!-- logo for regular state and mobile devices -->
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="row widsto" style="margin-left: 0;">
        <div id="mini-nav-7">
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="ChIngVision()">
          <span class="sr-only">Toggle navigation</span>
        </a>
        </div>
        <script type="text/javascript">
          function ChIngVision() {
            if($('#log_img_head').css('display') == 'none') {
              $('#log_img_head').css('display', 'block');
            }else {
              $('#log_img_head').css('display', 'none');
            }
          }
          function LookLang() {
            if($('#langs').css('display') == 'none') {
              $('#langs').css('display', 'block');
            }else {
              $('#langs').css('display', 'none');
            }
          }
        </script>
        <div class="referal-block" style="display: none;">
            <?php echo $this->lang->line('header_2');?>: <span id="for_dbck" class="r-b"><?php echo base_url();?>ref/<?php echo $user_info['reflink'];?></span>
            <i class="fa fa-clone js-copy-bob-btn" aria-hidden="true" title="<?php echo $this->lang->line('header_3');?>"></i>
        </div>
        <script type="text/javascript">
          function copyTextToClipboard(text) {
            var textArea = document.createElement("textarea");

            // Place in top-left corner of screen regardless of scroll position.
            textArea.style.position = 'fixed';
            textArea.style.top = 0;
            textArea.style.left = 0;

            // Ensure it has a small width and height. Setting to 1px / 1em
            // doesn't work as this gives a negative w/h on some browsers.
            textArea.style.width = '2em';
            textArea.style.height = '2em';

            // We don't need padding, reducing the size if it does flash render.
            textArea.style.padding = 0;

            // Clean up any borders.
            textArea.style.border = 'none';
            textArea.style.outline = 'none';
            textArea.style.boxShadow = 'none';

            // Avoid flash of white box if rendered for any reason.
            textArea.style.background = 'transparent';


            textArea.value = text;

            document.body.appendChild(textArea);

            textArea.select();

            try {
              var successful = document.execCommand('copy');
              var msg = successful ? 'successful' : 'unsuccessful';
              // console.log('Copying text command was ' + msg);
            } catch (err) {
              // console.log('Oops, unable to copy');
            }

            document.body.removeChild(textArea);
          }
          var copyBobBtn = document.querySelector('.js-copy-bob-btn')
          copyBobBtn.addEventListener('click', function(event) {
            copyTextToClipboard('<?php echo base_url();?>ref/<?php echo $user_info['reflink'];?>');
          });
          $('#for_dbck').dblclick(function(){
            var target = document.getElementById('for_dbck');
            var rng, sel;
            if (document.createRange) {
              rng = document.createRange();
              rng.selectNode(target)
              sel = window.getSelection();
              sel.removeAllRanges();
              sel.addRange(rng);
            } else {
              var rng = document.body.createTextRange();
              rng.moveToElementText(target);
              rng.select();
            }
          })

         </script>
         <div class="exit-btn">
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="document.location.href='<?php echo base_url();?>index.php/user/logout'" title="<?php echo $this->lang->line('header_4');?>">
                  <img src="/assets/img/logout.png">
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="avatar-block">
          <img src="<?php echo base_url().$this->session->ava; ?>" alt="<?php echo $this->lang->line('header_5');?>">
        </div>

        <div class="lang-block">
           <ul class="nav navbar-nav navbar-right">
            <li class="">

              <a href="javascript:;" onclick="LookLang()" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img class="lang-menu" src="<?php echo base_url();?>assets/images/<?php if(get_cookie('lang') == 'russian'){ ?>rus.png?v=2" class="fa fa-envelope-o"> RU<?php }elseif(get_cookie('lang') == 'german'){ ?>de.png?v=2" class="fa fa-envelope-o"> DE<?php }else{ ?>en.png?v=2" class="fa fa-envelope-o"> EN<?php } ?>
              </a>

              <ul class="dropdown-menu dropdown-usermenu pull-right" id="langs" style="width: 95px; min-width: 50px;">
                <li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/russian" class="info-number" aria-expanded="false">
                    <img class="lang-menu" src="<?php echo base_url();?>assets/images/rus.png?v=2" class="fa fa-envelope-o">  RU
                  </a>
                </li>
                <li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/english" class="info-number" aria-expanded="false">
                    <img class="lang-menu" src="<?php echo base_url();?>assets/images/en.png?v=2" class="fa fa-envelope-o"> EN
                  </a>
                </li>
                <li role="presentation">
                  <a href="<?php echo base_url();?>index.php/user/switch_lang/german" class="info-number" aria-expanded="false">
                    <img class="lang-menu" src="<?php echo base_url();?>assets/images/de.png?v=2" class="fa fa-envelope-o"> DE
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <?php
          if($_SESSION['uid'] == 1) {
        ?>
        <div class="lang-block" style="padding-top:2.5px;">
          <i style="font-size: 45px;color:white; cursor:pointer;" class="fa fa-question-circle" aria-hidden="true"></i>
        </div>
        <?php
          }
        ?>

      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="user-panel-balanc"><?php echo $this->lang->line('header_6');?>: <span><span id="main_bal_h"><?php echo $user_info['add_amount_btc']+0;?> <?php echo $this->lang->line('header_7');?></span></span></div>
        <div class="user-panel-balanc"><?php echo $this->lang->line('header_8');?>: <span><span id="add_bal_h"><?php echo $user_info['amount_btc']+0;?> <?php echo $this->lang->line('header_7');?></span></span></div>
        <div class="btn btn-primary gold-btn" data-toggle="modal" data-target="#modal-default_pe"> <?php echo $this->lang->line('header_9');?> </div>
        <div class="btn btn-primary" id="with_btc" data-toggle="modal" data-target="#modal-default_pe2"> <?php echo $this->lang->line('header_10');?> </div>
      </div>
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview
        <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/index') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/wallets') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/transactions') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/refspage') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/setting') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/supp') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/banners') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/news') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/mycomp') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/myban') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/load') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/struct') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/structtr') && !strpos($_SERVER['REQUEST_URI'], 'cabinet/programm') ) {
            echo 'active';
          }
        ?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/index'">
          <a href="#">
            <img src="/assets/img/dashboard.png"> <span><?php echo $this->lang->line('header_11');?></span>
          </a>
        </li>
        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/load') || strpos($_SERVER['REQUEST_URI'], 'cabinet/mymess') || strpos($_SERVER['REQUEST_URI'], 'cabinet/mycomp') || strpos($_SERVER['REQUEST_URI'], 'cabinet/myban') || strpos($_SERVER['REQUEST_URI'], 'cabinet/traffic_projects')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/myban'">
          <a href="#">
            <img src="/assets/img/reka.png"> <span><?php echo $this->lang->line('header_12');?></span>
          </a>
        </li>
        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/transactions')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/transactions'">
          <a href="#">
            <img src="/assets/img/coins.png"> <span><?php echo $this->lang->line('header_14');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/refspage')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/refspage'">
          <a href="#">
            <img src="/assets/img/group.png"> <span><?php echo $this->lang->line('header_15');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/sponsor_projects')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/sponsor_projects'">
          <a href="#">
            <img src="/assets/img/newspaper.png"> <span><?php echo $this->lang->line('header_17');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/page0') || strpos($_SERVER['REQUEST_URI'], 'cabinet/page1') || strpos($_SERVER['REQUEST_URI'], 'cabinet/page2') || strpos($_SERVER['REQUEST_URI'], 'cabinet/page3')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/page0'">
          <a href="#">
            <img src="/assets/img/hierarchical-structure.png"> <span><?php echo $this->lang->line('header_18');?></span>
          </a>
        </li>
        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/setting')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/setting'">
          <a href="#">
            <img src="/assets/img/network.png"> <span><?php echo $this->lang->line('header_19');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/special')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/special'">
          <a href="#">
            <img src="/assets/img/code-24.png"> <span><?php echo $this->lang->line('header_13');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/supp')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/supp'">
          <a href="#">
            <img src="/assets/img/help.png"> <span><?php echo $this->lang->line('header_20');?></span>
          </a>
        </li>

        <li class="treeview <?php if(strpos($_SERVER['REQUEST_URI'], 'cabinet/banners')){echo 'active';}?>" onclick="document.location.href='<?php echo base_url();?>index.php/cabinet/banners'">
          <a href="#">
            <img src="/assets/img/ui.png"> <span><?php echo $this->lang->line('header_21');?></span>
          </a>
        </li>

        <?php
          if($_SESSION['uid'] == 1) {
        ?>

            <li class="treeview" data-toggle="modal" data-target="#pre_enter_block">
              <a href="#">
                Pre enter advertise
              </a>
            </li>

        <?php
          }
        ?>

      </ul>
      <div class="cab-rek-block">

        <?php

          if(count($bans['125x125']) > 0) {
            $current_banner = array_shift($bans['125x125']);
            if($current_banner['cont_type'] != 3) {
              $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
              $addstr2 = "";

              if($current_banner['cont_type'] == 2) {
                $path = json_decode($current_banner['bnr']);
              }elseif($current_banner['cont_type'] == 1) {
                $path = '/'.$current_banner['bnr'];
              }else{
                $path = '';
              }
        ?>
          <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
          <script type="text/javascript">
            <?php echo $addstr2;?>
          </script>
        <?php
            }else {
              echo base64_decode($current_banner['bnr']);
            }
          }
        ?>

        <br>
        <?php

          if(count($bans['125x125']) > 0) {
            $current_banner = array_shift($bans['125x125']);
            if($current_banner['cont_type'] != 3) {
              $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
              $addstr2 = "";

              if($current_banner['cont_type'] == 2) {
                $path = json_decode($current_banner['bnr']);
              }elseif($current_banner['cont_type'] == 1) {
                $path = '/'.$current_banner['bnr'];
              }else{
                $path = '';
              }
        ?>
          <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
          <script type="text/javascript">
            <?php echo $addstr2;?>
          </script>
        <?php
            }else {
              echo base64_decode($current_banner['bnr']);
            }
          }
        ?>
        <div class="footer-menu">
          <?php echo $this->lang->line('header_23');?>
        </div>
      </div>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div class="modal fade" id="modal-default_pe">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('header_24');?></h4>
        </div>
        <div class="modal-body">
          <div class="form-group" id="for_mess">
            <div id="for_err_Bitcoin">
              <form method="post" action="payforms" onsubmit="return false;">
                <?php echo $this->lang->line('header_25');?>
                <br><br>
                <select name="type_of_pay">
                  <option value="-"><?php echo $this->lang->line('header_26');?></option>
                  <option value="EUR"><?php echo $this->lang->line('header_27');?></option>
                  <?php
                  	if(false) {
                  ?>
                  		<option value="BTC"><?php echo $this->lang->line('header_28');?></option>
                  <?php
                  	}
                  ?>
                  <option value="STRIPE"><?php echo $this->lang->line('header_29');?></option>
                  <?php
                  	if(false) {
                  ?>
                  		<option value="SOFORT">SOFORT</option>
                  <?php
                  	}
                  ?>
                  <option value="CDT"><?php echo $this->lang->line('header_30');?></option>
                </select>
                <br><br>
                <?php echo sprintf($this->lang->line('header_31'), '<a href="/welcome/risk_warning_notice" target="_blank">', '</a>');?> <input type="checkbox" id="agree" name="risk_assign">
                <p id="for_ass_mess" style="color:red;"></p>
                <br><br>
                <div id="for_hide_before_choose_pay" style="display:none;">
                  <?php echo $this->lang->line('header_32');?><br>
                  <input type="text" class="form-control" name="amount" id="for_up_sum" placeholder="0" style="width:15%; display:inline;"> <?php echo $this->lang->line('header_33');?> ( ~ <span id="for_currency"></span> )
                  <div id="block_for_mess" style="display:none;"></div>
                  <style type="text/css">
                    .hr_for_hide {
                      display:none;
                    }
                  </style>
                  <hr class="hr_for_hide">
                  <div class="hr_for_hide" id="main_for_hide">
                    <img style="width: 200px; height: 200px;" id="img_for_hide" src="">
                    <p><?php echo $this->lang->line('header_34');?>
                      <br>
                      <br>
                      <input id="input_for_hide" style="width: 245px;" type="text" value="qDQWWdqQWFWfgeqwqdQWOD21d1QWD"> (<span style="cursor:pointer;" id="click_for_copy_hide"><?php echo $this->lang->line('header_3');?></span>)
                    </p>
                  </div>
                  <hr class="hr_for_hide">
                  <script src="https://js.stripe.com/v3/"></script>
                  <script type="text/javascript">
                    var input = document.getElementById('for_up_sum');
                    input.oninput = function(){ SetCurrentCurrency(); };

                    $('select[name=type_of_pay]').on('change', function(){ SetCurrentCurrency(); })

                    $('#agree').on('change', function(){
                      if(!$("#agree").prop("checked")) {
                        $("#for_ass_mess").text('<?php echo $this->lang->line('header_35');?>');
                        $('select[name=type_of_pay]').val('-')
                        $('#but_for_hide_if_not_btc').hide();
                        $('#block_for_mess').hide();
                        $('#block_for_mess').html('');
                        $('#for_hide_before_choose_pay').hide();
                      }
                    })

                    function SetCurrentCurrency() {
                      var curses = {'EUR':<?php echo $curr_arr['EUR'];?>, 'STRIPE':<?php echo $curr_arr['EUR'];?>, 'SOFORT':<?php echo $curr_arr['EUR'];?>, 'BTC':<?php echo $curr_arr['BTC'];?>, 'CDT':1};

                      var current_currency = $('select[name=type_of_pay]').val();
                      var current_value = $('#for_up_sum').val();

                      if(!$("#agree").prop("checked")) {
                        $("#for_ass_mess").text('<?php echo $this->lang->line('header_35');?>');
                        $('select[name=type_of_pay]').val('-')
                        $('#but_for_hide_if_not_btc').hide();
                        $('#block_for_mess').hide();
                        $('#block_for_mess').html('');
                        $('#for_hide_before_choose_pay').hide();
                      }else if(current_currency == '-') {
                        $("#for_ass_mess").text('');
                        $('#but_for_hide_if_not_btc').hide();
                        $('#block_for_mess').hide();
                        $('#block_for_mess').html('');
                        $('#for_hide_before_choose_pay').hide();
                      }else{
                        $("#for_ass_mess").text('');
                        $('#for_hide_before_choose_pay').show();
                        if(isNaN(current_value) || current_value == 0 || current_value == '') {
                          $('#for_currency').text('-');
                        }else if(current_value < 5 && current_currency != 'CDT'){
                          $('#for_currency').html('<b style="color:red;"><?php echo $this->lang->line('header_36');?></b>');
                        }else if(current_value < 1 && current_currency == 'CDT'){
                          $('#for_currency').html('<b style="color:red;"><?php echo $this->lang->line('header_37');?></b>');
                        }else{
                          var res = (current_value/curses[current_currency]);
                          res = +res+0;
                          if(current_currency == 'SOFORT') {
                            $('#for_succ_adv').html('');
                            $('#for_err_adv').html('');

                            $('#block_for_mess').html('<?php echo $this->lang->line('header_38');?>:<select id="country_code"><option value="DE">Germany</option><option value="AT">Austria</option><option value="BE">Belgium</option><option value="IT">Italy</option><option value="NL">Netherlands</option><option value="PL">Poland</option><option value="IC">Spain</option><option value="CH">Switzerland</option></select><br><br><button type="button" onclick="PaySofort()" class="btn btn-primary gold-btn"><?php echo $this->lang->line('header_39');?></button>');
                            $('#block_for_mess').show();
                            $('#for_currency').text( res.toFixed(2)+' EUR' );

                            $('.hr_for_hide').hide();
                            $('#but_for_hide_if_not_btc').show();

                          }else if(current_currency == 'STRIPE') {
                            $('#for_succ_adv').html('');
                            $('#for_err_adv').html('');

                            $('#block_for_mess').html('<br><br><button type="button" onclick="PayStripe()" class="btn btn-primary gold-btn"><?php echo $this->lang->line('header_39');?></button>');
                            $('#block_for_mess').show();
                            $('#for_currency').text( res.toFixed(2)+' EUR' );

                            $('.hr_for_hide').hide();
                            $('#but_for_hide_if_not_btc').show();

                          }else if(current_currency == 'CDT') {
                            $('#for_succ_adv').html('');
                            $('#for_err_adv').html('');

                            $('#block_for_mess').html('<br><br><p style="color:green;" id="for_succ_adv"></p><p style="color:red;" id="for_err_adv"></p><br><button type="button" onclick="PayCDT()" class="btn btn-primary gold-btn"><?php echo $this->lang->line('header_39');?></button>');
                            $('#block_for_mess').show();
                            $('#for_currency').text( res.toFixed(2)+' Credit' );

                            $('.hr_for_hide').hide();
                            $('#but_for_hide_if_not_btc').show();

                          }else if(current_currency == 'BTC') {
                            $('#block_for_mess').html('');
                            $('#block_for_mess').hide();

                            $('#for_currency').text( res.toFixed(8)+' '+current_currency );

                            $('#but_for_hide_if_not_btc').hide();
                            GetBitAddr();
                          }else {
                            $('#for_succ_adv').html('');
                            $('#for_err_adv').html('');

                            $('#block_for_mess').html('<br><?php echo sprintf($this->lang->line('header_40'), '<b style="color:orange; font-size: 120%;">', '</b>', '<span id="copy_adv" style="cursor:pointer; text-decoration:underline;">', '</span>', '<br><br>');?>:<br><br><p style="color:green;" id="for_succ_adv"></p><p style="color:red;" id="for_err_adv"></p><br><input type="text" name="wallet" id="wallet_for_adv"><br><br><button id="but_for_hide_if_not_btc" type="button" onclick="SaveAdv()" class="btn btn-primary gold-btn"><?php echo $this->lang->line('header_41');?></button>');
                            $('#block_for_mess').show();
                            var copyBobBtn = document.querySelector('#copy_adv')
                            copyBobBtn.addEventListener('click', function(event) {
                              copyTextToClipboard('E011632838465');
                            });

                            $('#for_currency').text( res.toFixed(2)+' '+current_currency );

                            $('.hr_for_hide').hide();
                            $('#but_for_hide_if_not_btc').show();
                          }
                        }
                      }
                    }


                    function PayCDT(current_value) {
                      $.post(
                        "/cabinet/tr_to_another_wal",
                        {
                          sum: $('#for_up_sum').val()
                        },
                        function(data) {
                          var data = JSON.parse(data);
                          if(data['err'] == 0) {

                            $('#for_err_adv').text('');
                            $('#for_succ_adv').text(data['mess']);

                            $('#main_bal_h').text(data['main_bal']+' <?php echo $this->lang->line('header_7');?>');
                            $('#add_bal_h').text(data['ads_bal']+' <?php echo $this->lang->line('header_7');?>');
                          }else {
                            $('#for_err_adv').text(data['mess']);
                            $('#for_succ_adv').text('');
                          }
                        },
                      );
                    }


                    function PaySofort() {

                      var curses = {'EUR':<?php echo $curr_arr['EUR'];?>, 'BTC':<?php echo $curr_arr['BTC'];?>, 'CDT':1};

                      var current_currency = $('select[name=type_of_pay]').val();
                      var current_value = $('#for_up_sum').val();
                      var res = (current_value/curses['EUR'])*100;

                      var stripe = Stripe('pk_live_mofRQo4oubrmdd9qLNE0qiOo');
                      stripe.createSource({
                        type: 'sofort',
                        amount: res.toFixed(0),
                        currency: 'eur',
                        statement_descriptor: '<?php echo time().'_'.$_SESSION['uid']; ?>',
                        redirect: {
                          return_url: 'https://digifluxx.com/cabinet/transactions?t_id',
                        },
                        sofort: {
                          country: $('#country_code').val(),
                        },
                      }).then(function(result) {
                        document.location.href=result.source.redirect.url;
                        // console.log(result.source);
                        // handle result.error or result.source
                      });
                    }

                    function PayStripe() {
                      var curses = {'EUR':<?php echo $curr_arr['EUR'];?>, 'BTC':<?php echo $curr_arr['BTC'];?>, 'CDT':1};

                      var current_currency = $('select[name=type_of_pay]').val();
                      var current_value = $('#for_up_sum').val();
                      var res = (current_value/curses['EUR']);

                      $.post(
                        '/cabinet/GetStripeId',
                        {
                          sum: res.toFixed(2)
                        },
                        function(data){
                          var data = JSON.parse(data);
                          if(data['error'] == 0) {
                            var stripe = Stripe('pk_live_mofRQo4oubrmdd9qLNE0qiOo');
                            stripe.redirectToCheckout({
                              sessionId: data['ssid']
                            }).then(function (result) {
                              console.log(result);
                            });
                          }
                        }
                      )
                    }

                    function GetBitAddr() {
                      $.ajax({
                        type: "POST",
                        timeout: 45000,
                        url: "/cabinet/GetAddressBCH",
                        success: function(data) {
                          var data = JSON.parse(data);
                          if(data['err'] == 0) {

                            $('#img_for_hide').attr('src', 'https://bitaps.com/api/qrcode/png/'+data['addr']);
                            $('#input_for_hide').val(data['addr']);

                            var copyBobBtn = document.querySelector('#click_for_copy_hide');
                            copyBobBtn.addEventListener('click', function(event) {
                              copyTextToClipboard(data['addr']);
                            });
                            $('.hr_for_hide').show();
                          }else {
                            $('#for_err_'+cur).html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_42');?></span>');
                          }
                        },
                        error: function(data){
                          $('#for_err_'+cur).html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_43');?></span>');
                        }
                      });
                    }

                    function SaveAdv() {
                      $('#for_succ_adv').html('');
                      $('#for_err_adv').html('');
                      $.post(
                        '/cabinet/GetAdvTempPay',
                        {
                          WalletOrTID: $('#wallet_for_adv').val()
                        },
                        function(data) {
                          var data = JSON.parse(data);
                          if(data['err'] == 0) {
                            $('#for_succ_adv').html('<span style="color:green; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_44');?></span>');
                          }else if(data['err'] == 1) {
                            $('#for_err_adv').html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_45');?></span>');
                          }else if(data['err'] == 2) {
                            $('#for_err_adv').html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_46');?></span>');
                          }else if(data['err'] == 3) {
                            $('#for_err_adv').html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_47');?></span>');
                          }else if(data['err'] == 4) {
                            $('#for_err_adv').html('<span style="color:red; font-size:105%; font-weight:bold;"><?php echo $this->lang->line('header_48');?></span>');
                          }
                        }
                      );
                    }

                    function UpBalance() {
                      var sys = $('select[name=type_of_pay]').val();
                      var sum = $('#for_up_sum').val();
                      document.location.href = '/cabinet/temppages/'+sum+'/'+sys;
                    }
                  </script>
                </div>
              </form>
            </div>
            <br>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <div class="modal fade" id="modal-default_pe2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onclick="$('.err_PE').css('display', 'none');$('.succ_PE').css('display', 'none');$('#PE_out').val(0);$('#wallet_input_PE').val(0);" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('header_49');?></h4>
        </div>
        <form action="" method="post" id="form_out_btc">
          <p style="font-weight: bold; font-size: 115%; display:none; text-align:center; background-color:tomato; padding: 10px;" class="err"></p>
          <p style="font-weight: bold; font-size: 115%; display:none; text-align:center; background-color:lime; padding: 10px;" class="succ"></p>
          <div class="modal-body">
            <div class="form-group">

              <select name="type_of_out">
                <option value="EUR"><?php echo $this->lang->line('header_27');?></option>
                <option value="BTC"><?php echo $this->lang->line('header_28');?></option>
              </select>
              <br><br>
              <label for="exampleInputEmail1"><?php echo $this->lang->line('header_50');?></label>
              <input type="text" class="form-control" name="sum" id="for_out_sum" placeholder="0" style="width:15%; display:inline;"> <?php echo $this->lang->line('header_52');?> ( ~ <span id="for_currency_out"></span> )  <br><br>

              <label for="exampleInputEmail2"><?php echo $this->lang->line('header_51');?></label>
              <input type="text" class="form-control" id="wallet_input" name="wallet" value="" autocomplete="off">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary pull-left gold-btn" onclick="$('.err_w').css('display', 'none');$('.succ_PE').css('display', 'none');$('#PE_out').val(0);" data-dismiss="modal"><?php echo $this->lang->line('header_53');?></button>
            <button type="button" class="btn btn-primary gold-btn" onclick="SendWithdrawal()"><?php echo $this->lang->line('header_54');?></button>
          </div>
        </form>
        <script type="text/javascript">
          var input = document.getElementById('for_out_sum');
          input.oninput = function(){ SetCurrentCurrencyOut(); };

          $('select[name=type_of_out]').on('change', function(){ SetCurrentCurrencyOut(); })

          function SetCurrentCurrencyOut() {
            var curses = {'EUR':1, 'BTC':7242};

            var current_currency = $('select[name=type_of_out]').val();
            var current_value = $('#for_out_sum').val();

            if(isNaN(current_value)) {
              $('#for_currency_out').text('-');
            }else{
              $('#for_currency_out').text( (current_value/curses[current_currency])+' '+current_currency );

              // curses[current_currency] = 1
              // current_value            = ?
            }
          }

          function SendWithdrawal() {
            $.post(
              '<?php echo base_url().'index.php/cabinet/withdraw';?>',
              {
                cur: $('select[name=type_of_out]').val(),
                sum: $('#for_out_sum').val(),
                wallet: $('#wallet_input').val()
              },
              function(data) {
                var data = JSON.parse(data);
                if(data['err'] == 0) {
                  $('.err').css('display', 'none');
                  $('.err').html('');
                  $('.succ').css('display', 'block');
                  $('.succ').html(data['mess']);

                  $('#main_bal_h').text(data['res_bal']+' <?php echo $this->lang->line('header_52');?>');

                }else {
                  $('.err').css('display', 'block');
                  $('.err').html(data['mess']);
                  $('.succ').css('display', 'none');
                  $('.succ').html('');
                }
              }
            )
          }
        </script>
      </div>
    </div>
  </div>



  <div class="modal fade" id="pre_enter_block">
    <div class="modal-dialog" style="width: 90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('header_55');?>">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" style="text-align: center;"><?php echo $this->lang->line('header_56');?></h4>
        </div>
        <br><br>
        <?php

          // var_dump($blocks);

          $block_count = count($blocks);
          for($a = 0; $a < $block_count; $a++)
          {
        ?>
            <br><br>
            <div class="row">
              <?php
                for($i = 1; $i <= 3; $i++)
                {
              ?>
                <div style="text-align: center;" class="col-sm-4 col-md-4 col-lg-4">
                  <?php
                    if(!is_null($blocks[$a]['block_'.$i]))
                    {
                      $info = json_decode($blocks[$a]['block_'.$i], true);
                      switch ($info['type']) {
                        case 'text':
                          echo '<p>'.$info['content'].'</p>';
                          break;
                        case 'img':
                          echo '<img src="'.$info['content'].'">';
                          break;
                        case 'vid':
                          echo '<iframe src="https://www.youtube.com/embed/'.$info['content'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>';
                          break;
                      }
                    }
                  ?>
                </div>
              <?php
                }
              ?>
            </div>
            <br><br>
        <?php
          }
        ?>
        <br><br>
      </div>
    </div>
  </div>
