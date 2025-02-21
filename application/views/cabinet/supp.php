  <script src='https://www.google.com/recaptcha/api.js'></script>
  <div class="content-wrapper">
    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";
    ?>


    <!-- Main content -->
    <section class="content support-page">
      <!-- Small boxes (Stat box) -->
       <!-- /.container -->
      <!-- Main row -->
      <div class="row-content limit">
        <div class="col-md-8 col-md-offset-2">
          <div class="box box-info">
            <div class="box-body">
              <?php
                if(isset($_GET['akro'])) {
              ?>  
                  <div class="box-footer clearfix">
                    <?php
                      if($user_info['is_pekunjia'] == 1) {
                    ?>
                        <h2><?php echo $this->lang->line('the_new_supp_1'); ?></h2>
                        <hr>
                    <?php
                      }else{
                    ?>  
                        <p id="for_res" style="color:green; text-align: center;"></p>
                        <button type="button" class="pull-right btn btn-primary gold-btn" onclick="SetStatusPek()">
                          <?php echo $this->lang->line('the_new_supp_2'); ?>
                        </button>
                    <?php
                      }
                    ?>
                  </div>
                  <script type="text/javascript">
                    function SetStatusPek() {
                      $.post(
                        '/cabinet/IamPekunjia',
                        {},
                        function(data) {
                          $('#for_res').text('<?php echo $this->lang->line('the_new_supp_1'); ?>');
                        }
                      )
                    }
                  </script>
              <?php
                }
              ?>
              <div style="text-align:center;">
                <?php
                  echo $this->lang->line('main_contacts_new');
                ?>
              </div>
              <form action="<?php echo base_url();?>index.php/cabinet/GetAndSendMes" id="form_send_mail" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" value="<?php echo $user_info['email'];?>" disabled="disabled" placeholder="Email:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('sup_f_2');?>">
                </div>
                <div>
                  <textarea class="textarea" name="message" placeholder="<?php echo $this->lang->line('sup_f_3');?>"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                  </textarea>
                </div>
                <br>
                <div class="form-group">
                  <div class="g-recaptcha" style="width:275px !important;" data-sitekey="6Lc7tsEUAAAAAF_GegQtL6IOA-axUx5RxBaPl6IA"></div>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-primary gold-btn" id="sendEmail" onclick="$('#form_send_mail').submit()">
                <?php echo $this->lang->line('sup_f_4');?>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row (main row) -->
      <?php
        include 'banner_block.php';
      ?>

      <div class="modal fade in" id="modal-succ">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-succ').hide('toggle');" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

              <?php if(isset($_SESSION['message_sent'])):?>
                <p class="success"><?php echo $this->lang->line('message_sent');?></p>
                <script type="text/javascript">
                  $('#modal-succ').show('toggle');
                </script>
              <?php unset($_SESSION['message_sent']); endif;?>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="$('#modal-succ').hide('toggle');" data-dismiss="modal"><?php echo $this->lang->line('submit');?></button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade in" id="modal-err">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-err').hide('toggle');" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <?php if(isset($_SESSION['error_captcha'])):?>
                <p class="error"><?php echo $this->lang->line('error_captcha');?></p>
                <script type="text/javascript">
                  $(document).ready(function(){
                    $('#modal-err').show('toggle');
                  })
                </script>
              <?php unset($_SESSION['error_captcha']); endif;?>
              <?php if(isset($_SESSION['error'])):?>
                <p class="error"><?php echo $this->lang->line('err_field_1');?></p>
                <script type="text/javascript">
                  $('#modal-err').show('toggle');
                </script>
              <?php unset($_SESSION['error']); endif;?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="$('#modal-err').hide('toggle');" data-dismiss="modal"><?php echo $this->lang->line('submit');?></button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    </section>
    <!-- /.content -->
  </div>