  <div class="content-wrapper">
    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";
    ?>
    <!-- Main content -->
    <section class="content rek-page">
      <!-- Small boxes (Stat box) -->
      <div class="row limit">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-primary">
                  <div class="box-body box-profile">
                    <hr>
                    <div>
                      <h3> <?php echo $this->lang->line('yo_spons');?>: <span class="sponsor-name"><?php echo $sponsor_name;?></span> </h3>
                      <h5 style="text-align:center;" class="description-header"><span class="width-span">Skype:</span> <span><?php if($sponsor_skype != ''){echo $sponsor_skype;}else{echo '-';}?></span></h5>
                      <h5 style="text-align:center;" class="description-header"><span class="width-span">E-mail:</span> <span><?php echo $sponsor_mail;?></span></h5>
                      <h5 style="text-align:center;" class="description-header"><span class="width-span"><?php echo $this->lang->line('telephone');?>:</span> <span><?php if($sponsor_mob != ''){echo $sponsor_mob;}else{echo '-';}?></span></h5>
                    </div>
                    <hr>
                    <div class="ban_code">
                      <img src="/assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" align="center">
                    </div>
                    <div class="code-block">
                      <br>
                      <br>
                      <h1>Sponsors link 1: "Project 1"</h1>
                      <br>
                      <br>
                      <textarea>
                        <a href="<?php echo base_url();?>index.php/ref/<?php echo $this->session->reflink;?>"><img src="<?php echo base_url();?>assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" alt="beta" /></a>
                      </textarea>
                      <br>
                      <br>
                      <button>Copy</button>
                    </div>
                    <hr>
                    <div class="ban_code">
                      <img src="/assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" align="center">
                    </div>
                    <div class="code-block">
                      <br>
                      <br>
                      <h1>Sponsors link 2: "Project 2"</h1>
                      <br>
                      <br>
                      <textarea><a href="<?php echo base_url();?>index.php/ref/<?php echo $this->session->reflink;?>"><img src="<?php echo base_url();?>assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" alt="beta" /></a></textarea>
                      <br>
                      <br>
                      <button>Copy</button>
                    </div>
                    <hr>
                    <div class="ban_code">
                      <img src="/assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" align="center">
                    </div>
                    <div class="code-block">
                      <br>
                      <br>
                      <h1>Sponsors link 3: "Project 3"</h1>
                      <br>
                      <br>
                      <textarea><a href="<?php echo base_url();?>index.php/ref/<?php echo $this->session->reflink;?>"><img src="<?php echo base_url();?>assets/banners/300x250<?php if(true){}elseif(get_cookie('lang') == 'english'){echo '-en';}elseif(get_cookie('lang') == 'german'){echo '-de';}elseif(get_cookie('lang') == 'russian'){echo '-ru';} ?>.gif" alt="beta" /></a></textarea>
                      <br>
                      <br>
                      <button>Copy</button>
                    </div>
                  </div>
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
       <?php
        include 'banner_block.php';
      ?>
    </section>
  </div>
