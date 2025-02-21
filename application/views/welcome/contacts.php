<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
      .area input.btn{
        margin: 0 auto!important
        width: 200px!important;
        line-height: 20px!important;
        background: #29f1c3; 
        color: #000;
      }
      .btn{
        margin: 0 auto!important
        width: 200px!important;
        line-height: 20px!important;
        background: #29f1c3; 
        color: #000;
      }
</style>
<div class="content">
  <h1 class="name-page"><?php echo $this->lang->line('supp_page');?></h1>
  <div class="faq">
    <div class="row">
      <div class="contact" style="text-align:center;">
        <div style="text-align:center;">
          <?php
            echo $this->lang->line('main_contacts_new');
          ?>
        </div>
        <form action="/welcome/contacts" method="post">
          <div class="area error">
            <?php
              if(isset($sent_fail)) {
                echo $this->lang->line('error_captcha');
              }
            ?>
          </div>
          <div class="area successfull">
            <?php
              if(isset($sent_ok)) {
                echo $this->lang->line('success');
              }
            ?>
          </div>
          <div class="area"><input type="text" name="email" placeholder="E-mail"></div>
          <div class="area"><input type="text" name="subject" placeholder="<?php echo $this->lang->line('supp_1');?>"></div>
          <div class="area textarea">
            <textarea name="message"></textarea>
          </div>
          <div class="area">
            <div class="g-recaptcha" data-sitekey="6LeyoIgUAAAAAEyl8oSMXFEue5vlpJA13yiB92Pt"></div>
            </div>
          <div class="area">
            <input class="btn" type="submit" value="<?php echo $this->lang->line('sup_f_4');?>">
          </div>    
        </form>
      </div>
    </div>
  </div>
</div>