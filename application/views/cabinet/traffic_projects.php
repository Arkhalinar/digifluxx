  <!-- Content Wrapper. Contains page content -->
  <style>
    .line-h .btn-primary{
      margin-bottom:5px;
    }
  </style>
  <div class="content-wrapper">
    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";


      $cats_select = [];

      foreach ($all_active_categs as $key => $value) {
        $cats_select[$value] = '<option value="-">-</option>';
        for ($a = 1; $a <= 4; $a++) {
          $actual_info = json_decode($mark_sett['category_'.$a.'_'.$value]);
          $cats_select[$value] .= '<option sum="'.$actual_info->all_sum.'" value="category_'.$a.'_'.$value.'">'.$actual_info->all_sum.' '.$this->lang->line('traf_projs_1').' ('.$actual_info->adding_count.' '.$this->lang->line('traf_projs_2').')</option>';
        }
      }

    ?>
    <section class="content myban-table">
      <div class="limit">
        <?php
          $whatpage = 'traf';
          include 'ad_menu_block.php';
        ?>
        <div class="row-content" style="overflow: auto;">
          <div class="all-filter">
            <div class="title-filter">
              <img src="/assets/img/filter.png">  <?php echo $this->lang->line('traf_projs_3');?>
              <div class="right-title-filter"><?php echo sprintf($this->lang->line('traf_projs_4'), count($comps));?> <a href="/cabinet/traffic_projects/reset"><?php echo $this->lang->line('traf_projs_5');?></a></div>
            </div>
            <div class="select-filter">
              <form>
                <select id="filter_status">
                  <option value="s_0">-</option>
                  <option value="s_1" <?php if(isset($_SESSION['filter_status']) && $_SESSION['filter_status'] == 's_1') { ?>selected<?php } ?>><?php echo $this->lang->line('traf_projs_6');?></option>
                  <option value="s_2" <?php if(isset($_SESSION['filter_status']) && $_SESSION['filter_status'] == 's_2') { ?>selected<?php } ?>><?php echo $this->lang->line('traf_projs_7');?></option>
                  <option value="s_3" <?php if(isset($_SESSION['filter_status']) && $_SESSION['filter_status'] == 's_3') { ?>selected<?php } ?>><?php echo $this->lang->line('traf_projs_8');?></option>
                </select>
                <script type="text/javascript">
                  $('#filter_status').on('change', function(){
                    document.location.href='/cabinet/traffic_projects/'+$('#filter_status').val();
                  })
                </script>
                <select id="filter_order">
                  <option value="o_0">-</option>
                  <option value="o_1" <?php if(isset($_SESSION['filter_order']) && $_SESSION['filter_order'] == 'o_1') { ?>selected<?php } ?>> <?php echo $this->lang->line('traf_projs_9');?></option>
                  <option value="o_2" <?php if(isset($_SESSION['filter_order']) && $_SESSION['filter_order'] == 'o_2') { ?>selected<?php } ?>> <?php echo $this->lang->line('traf_projs_10');?></option>
                </select>
                <script type="text/javascript">
                  $('#filter_order').on('change', function(){
                    document.location.href='/cabinet/traffic_projects/'+$('#filter_order').val();
                  })
                </script>
              </form>
            </div>
          </div>
        </div>
        <div class="row-content">
            <div class="new-company">
              <button class="btn btn-primary pokaz gold-btn" onclick="$('#modal-cr').show();"><?php echo $this->lang->line('tr_project2');?></button>
            </div>
            <div style="clear:both;" id="for_new_bans"></div>
            <?php
              for($i = 0; $i < count($comps); $i++) {
                $is_pay = false;
            ?>
                <div class="block-company">
                  <div class="name-block-company" style="width:30%;">
                    <div class="link-company">
                      <?php echo $this->lang->line('traf_projs_225');?><br>
                      <a href="#" id="url_of_ban_<?php echo $comps[$i]['ID'];?>"><?php echo json_decode($comps[$i]['url']); ?></a>
                    </div>
                  </div>
                  <div class="info-block-company" style="width:40%;">
                    <div class="line-block-company">
                        <span class="span-w"><img src="/assets/img/badge-comp.png" alt=""><?php echo $this->lang->line('traf_projs_226');?></span>
                        <?php
                          $stats = json_decode($comps[$i]['stats'], true);
                          foreach ($stats as $key => $value) {
                        ?>
                            <?php echo '<span id="country_'.$comps[$i]['ID'].'" style="display:none;">'.$key.'</span><b>'.$countries[$key]['name'].'</b>';?>
                        <?php
                          }
                        ?>
                    </div>
                    <div class="line-block-company">
                        <span class="span-w"><img src="/assets/img/badge-comp.png" alt=""><?php echo $this->lang->line('traf_projs_227');?></span>
                        <?php
                          foreach ($stats as $key => $value) {

                            if($value['have'] > 0) {
                              $is_pay = true;
                            }

                        ?>
                            <?php echo $value['done'].'/'.$value['have'];?> <?php echo $this->lang->line('traf_projs_228');?>
                        <?php
                          }
                        ?>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/star-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_12');?></span> <span id="status_<?php echo $comps[$i]['ID'];?>" <?php 
                          switch ($comps[$i]['Status']) {
                            case '0':
                              if($is_pay) {
                                echo  'style="color:blue;">'.$this->lang->line('mycomp_21');
                              }else{
                                echo  'style="color:blue;">-';
                              }
                              break;
                            case '1':
                              echo 'class="green">'.$this->lang->line('mycomp_activity');
                              break;
                            case '2':
                              echo  'style="color:tomato;">'.$this->lang->line('mycomp_24').' - ('.$comps[$i]['Comment'].')';
                              break;
                            case '3':
                              echo  'style="color:orange;">'.$this->lang->line('mycomp_25');
                              break;
                          }
                          ?></span>
                    </div>
                  </div>
                  <div class="panel-block-company" style="width:30%;">
                    <div class="line-block-company">
                      <form style="width:100%;" onsubmit="return false;">
                        <div><?php echo $this->lang->line('traf_projs_229');?></div>
                        <div style="padding-left: 0;">
                          <select name="buying_create_<?php echo $comps[$i]['ID'];?>" style="width: 70%;">
                          <?php
                            $stats = json_decode($comps[$i]['stats'], true);
                            foreach ($stats as $key => $value) {
                          ?>
                              <?php echo $cats_select[$countries[$key]['cid']];?>
                          <?php
                            }
                          ?>
                          </select>
                          <div style="float:right;">
                            <button class="btn btn-primary pokaz gold-btn" onclick="TPUp(<?php echo $comps[$i]['ID'];?>)"><?php echo $this->lang->line('traf_projs_230');?></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="line-block-company">
                      <img src="/assets/img/edit-comp.png" data-title="Edit" data-toggle="modal" data-target="#modal-ch" onclick="$('#id_for_ch_ban').val(<?php echo $comps[$i]['ID'];?>);$('#url_for_ch_ban').val($('#url_of_ban_<?php echo $comps[$i]['ID'];?>').text());" alt="" title="<?php echo $this->lang->line('myban_new_s_20');?>"> 
                      <img src="/assets/img/delete-comp.png" data-title="Delete" data-toggle="modal" data-target="#modal-balance_del" onclick="$('#id_for_del').val(<?php echo $comps[$i]['ID'];?>)" alt="" title="<?php echo $this->lang->line('myban_new_s_21');?>">

                    </div>
                  </div>
                </div>
            <?php
              }
            ?>
          </div>
      </div>
      <?php
        include 'banner_block.php';
      ?>
    </section>
  </div>

  <div class="modal fade in" id="modal-succ">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-succ').hide();" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p id="for_succ_modal" class="success"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-succ').hide();"><?php echo $this->lang->line('traf_projs_11');?></button>
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
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-err').hide();" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p class="error" id="for_err_modal"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-err').hide();" data-dismiss="modal"><?php echo $this->lang->line('traf_projs_11');?></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade in" id="modal-cr">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-cr').hide();CleanOutCrBan()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title"><?php echo $this->lang->line('traf_projs_12');?></h4>
        </div>
        <div class="modal-body">
            <form onsubmit="return false;" id="reg_b_form" method="post" enctype="multipart/form-data">
              <p id="err_cr_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <div class="form-group">
                <label for="Inputban3"><?php echo $this->lang->line('traf_projs_14');?>(<?php echo $this->lang->line('traf_projs_13');?>)</label>
                <input type="text" id="cr_url" class="form-control" name="url">
              </div>

              <div class="form-group">
                <label for="Inputban3"><?php echo $this->lang->line('traf_projs_15');?></label>
                <select name="cr_country">
                  <option value="-">-</option>
                  <?php
                    foreach ($countries as $key => $value) {
                  ?>
                      <option cid="<?php echo $value['cid'];?>" value="<?php echo $key;?>"><?php echo $value['name'];?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div style="clear:both;"></div>
              <div class="form-group f-g-b" id="for_pre">
                <input type="submit" class="btn btn-primary r-btn gold-btn" name="SendBan" value="<?php echo $this->lang->line('traf_projs_17');?>">
              </div>
            </form>
          <script type="text/javascript">
            $("#reg_b_form").submit(function() {

                CleanRedLines();

                $('#for_pre').html('<img style="display:block;width: 20%; margin: 0 auto;" src="/preloader.gif">');
                
                var data = new FormData();

                $.each( $(this).serializeArray(), function( key, value ){
                  data.append( value.name, value.value );
                });

                $.ajax({
                  url         : '<?php echo base_url();?>index.php/cabinet/add_traffic_projects',
                  type        : 'POST', // важно!
                  data        : data,
                  cache       : false,
                  processData : false,
                  contentType : false, 
                  success     : function( respond, status, jqXHR ) {

                    $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('traf_projs_17');?>">');
                    var data = JSON.parse(respond);
                    if( data['err'] == '0' ){

                      document.location.href=document.location.href;

                    }else {

                      if(data['error_field'] == 'url') {
                        $('#cr_url').css('border', '2px solid red');
                      }else if(data['error_field'] == 'lang') {
                        $('select[name=cr_lang_ban]').css('border', '2px solid red');
                      }else if(data['error_field'] == 'file') {
                        $('#file_bn_in').css('border', '2px solid red');
                      }else if(data['error_field'] == 'file_url') {
                        $('#file_url').css('border', '2px solid red');
                      }else if(data['error_field'] == 'size') {
                        $('#cr_size').css('border', '2px solid red');
                      }

                      $('#err_cr_b').html( data['mess'] );
                      $('#modal-cr').scrollTop(0);
                    }
                  },
                  error: function( jqXHR, status, errorThrown ) {
                    $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('traf_projs_17');?>">');
                    $('#err_cr_b').html( '<?php echo $this->lang->line('traf_projs_18'); ?>' );
                  }

                });
            });


            function CleanOutCrBan() {
              $('#err_cr_b').html( '' );

              $('#cr_size').val('125x125');
              // $('#cr_type_cont').val('file');
              $('#cr_type').val('1');
              $('#cr_url').val('');
              $('input[name=uploadfile]').val('');
              $('input[name=secureCode]').val('');

              // document.getElementById('captcha').src='captcha';
              
              CleanRedLines();

              // grecaptcha.reset();

            }

            function CleanRedLines() {
              $('#cr_url').css('border-width', '1px');
              $('#cr_url').css('border-style', 'solid');
              $('#cr_url').css('border-color', 'rgb(204, 204, 204)');
              $('#cr_url').css('border-image', 'initial');

              $('#file_url').css('border-width', '1px');
              $('#file_url').css('border-style', 'solid');
              $('#file_url').css('border-color', 'rgb(204, 204, 204)');
              $('#file_url').css('border-image', 'initial');

              $('#cr_size').css('border-width', '1px');
              $('#cr_size').css('border-style', 'solid');
              $('#cr_size').css('border-color', 'rgb(204, 204, 204)');
              $('#cr_size').css('border-image', 'initial');

              $('#file_bn_in').css('border', 'none');

            }

          </script>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade in" id="modal-ch">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="for_ch_close" onclick="$('#modal-ch').hide();CleanOutChBan()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title"><?php echo $this->lang->line('traf_projs_19');?></h4>
        </div>
        <div class="modal-body">
            <form onsubmit="return false;" id="ch_b_form" method="post" enctype="multipart/form-data">
              <input type="hidden" name="ID" id="id_for_ch_ban">
              <p id="err_ch_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <div class="form-group">
                <label for="Inputban3"><?php echo $this->lang->line('traf_projs_14');?>(<?php echo $this->lang->line('traf_projs_13');?>)</label>
                <input type="text" id="url_for_ch_ban" class="form-control" name="url">
              </div>
              <div style="clear:both;"></div>
              <div class="form-group f-g-b">
                <input type="submit" class="btn btn-primary r-btn gold-btn" name="SendBan" value="<?php echo $this->lang->line('traf_projs_20');?>">
              </div>
            </form>
            <script type="text/javascript">
              $("#ch_b_form").submit(function() {

                  CleanRedLines_Change();

                  var data = new FormData();

                  $.each( $(this).serializeArray(), function( key, value ){
                    data.append( value.name, value.value );
                  });

                  $.ajax({
                    url         : '<?php echo base_url();?>index.php/cabinet/ch_traffic_projects',
                    type        : 'POST', // важно!
                    data        : data,
                    cache       : false,
                    processData : false,
                    contentType : false, 
                    success     : function( respond, status, jqXHR ) {

                      var data = JSON.parse(respond);
                      if( data['err'] == '0' ){
                        document.location.href=document.location.href;
                      }else {
                        $('#modal-ch').scrollTop(0);
                        $('#err_ch_b').html( data['mess'] );

                        if(data['error_field'] == 'url') {
                          $('#url_for_ch_ban').css('border', '2px solid red');
                        }else if(data['error_field'] == 'lang') {
                          $('select[name=ch_lang_ban]').css('border', '2px solid red');
                        }else if(data['error_field'] == 'file') {
                          $('#file_bn_in2').css('border', '2px solid red'); 
                        }else if(data['error_field'] == 'file_url') {
                          $('#file_url2').css('border', '2px solid red');
                        }
                      }
                    },
                    error: function( jqXHR, status, errorThrown ) {
                      $('#err_ch_b').html( '<?php echo $this->lang->line('high_in_tr'); ?>' );
                    }

                  });
              });


              function CleanOutChBan() {
                $('#err_ch_b').html( '' );

                $('#cr_size').val('125x125');
                $('#cr_type_cont').val('1');
                $('#cr_type').val('1');
                $('input[name=uploadfile]').val('');

                CleanRedLines_Change();

              }

              function CleanRedLines_Change() {
                $('#url_for_ch_ban').css('border-width', '1px');
                $('#url_for_ch_ban').css('border-style', 'solid');
                $('#url_for_ch_ban').css('border-color', 'rgb(204, 204, 204)');
                $('#url_for_ch_ban').css('border-image', 'initial');

                $('#file_url2').css('border-width', '1px');
                $('#file_url2').css('border-style', 'solid');
                $('#file_url2').css('border-color', 'rgb(204, 204, 204)');
                $('#file_url2').css('border-image', 'initial');

                $('#file_bn_in2').css('border', 'none');

              }
            </script>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <div class="modal fade in" id="modal-balance_del">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-balance_del').hide();" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('traf_projs_21');?></h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id_for_del">
          <p><?php echo $this->lang->line('traf_projs_22');?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-balance_del').hide();Del()"><?php echo $this->lang->line('traf_projs_23');?></button>
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-balance_del').hide();" data-dismiss="modal"><?php echo $this->lang->line('traf_projs_24');?></button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function Del() {
      var id = $('#id_for_del').val();
      document.location.href='del_traffic_projects/'+id;
    }
    function TPUp(id) {
      $.post(
        'up_bal_traf_proj',
        {
          ID: id,
          packet: $('select[name=buying_create_'+id+']').val(),
          country: $('#country_'+id).text()
        },
        function(data){
          data = JSON.parse(data);
          if(data['err'] == 0) {
            document.location.href=document.location.href;
          }else {
            $('#for_err_modal').html(data['mess']);
            $('#modal-err').show();
          }
        }
      )
    }
    function ErrMess() {
      $('#for_err_modal').html('<?php echo $this->lang->line('mymess_page_new_1');?>');
      $('#modal-err').show('toggle');
    }
  </script>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->  