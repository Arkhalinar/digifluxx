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
      include "top-b.php"
    ?>

    <section class="content myban-table">
      <!-- <div>
        <button class="btn btn-primary" onclick="document.location.href='/cabinet/load'"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
      </div>
      <br> -->
      <div class="limit">
        <?php
          $whatpage = 'vid';
          include 'ad_menu_block.php';
        ?>
        <div class="row-content" style="overflow: auto;">
          <div class="all-filter">
            <div class="title-filter">
              <img src="/assets/img/filter.png">  <?php echo $this->lang->line('myban_new_s_1');?>
              <div class="right-title-filter"><?php echo sprintf($this->lang->line('myban_new_s_3'), count($comps));?> <a href="/cabinet/myvid/reset"><?php echo $this->lang->line('myban_new_s_2');?></a></div>
            </div>
            <div class="select-filter">
              <form>
                <select id="filter_status">
                  <option value="s_0">-</option>
                  <option value="s_1" <?php if(isset($_SESSION['filter_status_vad']) && $_SESSION['filter_status_vad'] == 's_1') { ?>selected<?php } ?>><?php echo $this->lang->line('myban_new_s_4');?></option>
                  <option value="s_2" <?php if(isset($_SESSION['filter_status_vad']) && $_SESSION['filter_status_vad'] == 's_2') { ?>selected<?php } ?>><?php echo $this->lang->line('myban_new_s_5');?></option>
                  <option value="s_3" <?php if(isset($_SESSION['filter_status_vad']) && $_SESSION['filter_status_vad'] == 's_3') { ?>selected<?php } ?>><?php echo $this->lang->line('myban_new_s_6');?></option>
                </select>
                <script type="text/javascript">
                  $('#filter_status').on('change', function(){
                    document.location.href='/cabinet/myvid/'+$('#filter_status').val();
                  })
                </script>
                <select id="filter_order">
                  <option value="o_0">-</option>
                  <option value="o_1" <?php if(isset($_SESSION['filter_order_vad']) && $_SESSION['filter_order_vad'] == 'o_1') { ?>selected<?php } ?>> <?php echo $this->lang->line('myban_new_s_7');?></option>
                  <option value="o_2" <?php if(isset($_SESSION['filter_order_vad']) && $_SESSION['filter_order_vad'] == 'o_2') { ?>selected<?php } ?>> <?php echo $this->lang->line('myban_new_s_8');?></option>
                </select>
                <script type="text/javascript">
                  $('#filter_order').on('change', function(){
                    document.location.href='/cabinet/myvid/'+$('#filter_order').val();
                  })
                </script>
              </form>
            </div>
          </div>
        </div>



        <div class="row-content">
            <div class="new-company">
              <button class="btn btn-primary pokaz gold-btn" onclick="$('#modal-cr_ban').show();"><?php echo $this->lang->line('mytext_s_1');?></button>
            </div>
            <div style="clear:both;" id="for_new_bans"></div>
            <?php 
              for($i = 0; $i < count($comps); $i++) {
            ?>
                <div class="block-company">
                  <div class="name-block-company">
                    <div class="link-company"><a href="#" id="url_of_vid_ad_<?php echo $comps[$i]['ID'];?>"><?php echo json_decode($comps[$i]['url']); ?></a></div>
                  </div>
                  <div class="info-block-company">
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/stats-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_9');?></span> <?php echo $comps[$i]['show_for_stat'];?>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/clock-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_10');?></span> <?php echo $comps[$i]['click_for_stat'];?>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/badge-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_11');?></span> <span id="bal_<?php echo $comps[$i]['ID'];?>"><?php echo $comps[$i]['count']+0-$comps[$i]['current_count']+0;?></span>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/star-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_12');?></span> <span id="status_<?php echo $comps[$i]['ID'];?>" <?php 
                          switch ($comps[$i]['Status']) {
                            case '0':
                              echo  'style="color:blue;">'.$this->lang->line('mycomp_21');
                              break;
                            case '1':
                              if($comps[$i]['Activity'] == 0) {
                                echo 'class="green">'.$this->lang->line('mycomp_deactivity');
                              }else {
                                echo 'class="green">'.$this->lang->line('mycomp_activity');
                              }
                              break;
                            case '2':
                              echo  'style="color:tomato;">'.$this->lang->line('mycomp_24');
                              break;
                            case '3':
                              echo  'style="color:orange;">'.$this->lang->line('mycomp_25');
                              break;
                          }
                          ?></span>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><img src="/assets/img/language-comp.png" alt=""><?php echo $this->lang->line('myban_new_s_13');?></span> <span id="lang_<?php echo $comps[$i]['ID'];?>"><?php
                        switch ($comps[$i]['lang']) {
                          case 'all':
                            echo $this->lang->line('mail_21');
                            break;
                          case 'russian':
                            echo $this->lang->line('mail_22');
                            break;
                          case 'english':
                            echo $this->lang->line('mail_23');
                            break;
                          case 'german':
                            echo $this->lang->line('mail_24');
                            break;
                        }
                       ?></span>
                    </div>
                  </div>
                  <div class="panel-block-company">
                    <?php
                      if($comps[$i]['Status'] == 1) {
                    ?>
                    <div class="line-block-company">
                      <form>
                        <div>Пополнить баланс</div>
                        <select name="count_add_<?php echo $comps[$i]['ID'];?>" style="width: 75%!important; border-radius: 3px; border: 1px solid #ccc; text-align: right; padding: 3px 5px 3px 5px;">
                          <option value="-">-</option>
                          <?php
                            switch ($user_info['tarif']) {
                              case NULL:
                                $mul = 0;
                                break;
                              case 'packet_1':
                                $mul = $mark_sett['bonus_1'];
                                break;
                              case 'packet_2':
                                $mul = $mark_sett['bonus_2'];
                                break;
                              case 'packet_3':
                                $mul = $mark_sett['bonus_3'];
                                break;
                              case 'packet_4':
                                $mul = $mark_sett['bonus_4'];
                                break;
                            }
                                for ($a = 1; $a <= 5; $a++) { 
                                  $actual_info = json_decode($mark_sett['active_'.$a]);
                                  
                          ?>
                                  <option value="<?php echo $actual_info->all_sum;?>"><?php echo $actual_info->all_sum;?> PCT (<?php echo bcmul($actual_info->all_sum, $curr_arr['CRT'], 0); ?> <?php echo $this->lang->line('myban_new_s_9');?>)</option>
                          <?php
                                }
                          ?>
                        </select>
                        <img src="/assets/img/plus-comp.png" alt="" title="<?php echo $this->lang->line('myban_new_s_14');?>" onclick="CompBal(<?php echo $comps[$i]['ID'];?>)">
                        <div class="orange"><?php echo $this->lang->line('myban_new_s_15');?>(<?php echo $mul;?>%): <?php echo '<span id="for_bonus_show_'.$comps[$i]['ID'].'">0</span>';?></div>
                      </form>
                    </div>
                    <script type="text/javascript">
                      $('select[name=count_add_<?php echo $comps[$i]['ID'];?>').on('change', function(){
                        var curs = +<?php echo $curr_arr['CRT'];?>+0;
                        var preval = +$('select[name=count_add_<?php echo $comps[$i]['ID'];?>').val()+0;
                        var val = preval*curs;
                        var perc = +<?php echo $mul;?>+0;
                        if(!isNaN(val)) {
                          $('#for_bonus_show_<?php echo $comps[$i]['ID'];?>').text('+'+(val*perc/100));
                        }else{
                          $('#for_bonus_show_<?php echo $comps[$i]['ID'];?>').text('0');
                        }
                      })
                    </script>
                    <?php
                      }
                    ?>
                    <div class="line-block-company">
                      <?php
                        if($comps[$i]['Status'] == 1) {
                          if($comps[$i]['Activity'] == 0) {
                      ?>
                          <span id="play_t_<?php echo $comps[$i]['ID']; ?>"><?php echo $this->lang->line('myban_new_s_16');?></span> <img id="play_i_<?php echo $comps[$i]['ID']; ?>" onclick="CompState(<?php echo $comps[$i]['ID']; ?>, 1)" src="/assets/img/play-comp.png" alt="" title="<?php echo $this->lang->line('myban_new_s_18');?>"> 
                      <?php
                          }else{
                      ?>
                          <span id="play_t_<?php echo $comps[$i]['ID']; ?>"><?php echo $this->lang->line('myban_new_s_17');?></span> <img id="play_i_<?php echo $comps[$i]['ID']; ?>" onclick="CompState(<?php echo $comps[$i]['ID']; ?>, 0)" src="/assets/img/stop-comp.png" alt="" title="<?php echo $this->lang->line('myban_new_s_19');?>"> 
                      <?php
                          }
                        }
                      ?>
                      

                      <img src="/assets/img/edit-comp.png" data-title="Edit" data-toggle="modal" data-target="#modal-ch_ban" onclick="$('#id_for_ch_vid_ad').val(<?php echo $comps[$i]['ID'];?>);$('#url_for_ch_vid_ad').val($('#url_of_vid_ad_<?php echo $comps[$i]['ID'];?>').text()); $('select[name=ch_lang_vid_ad] option[value=<?php echo $comps[$i]['lang']; ?>]').attr('selected', 'selected');" alt="" title="<?php echo $this->lang->line('myban_new_s_20');?>"> 
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








  <div class="modal fade in" id="modal-balance_del">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-balance_del').hide();" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('myban_35');?></h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id_for_del">
          <p><?php echo $this->lang->line('myban_36');?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-balance_del').hide();Del()"><?php echo $this->lang->line('mycomp_43');?></button>
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-balance_del').hide();" data-dismiss="modal"><?php echo $this->lang->line('mycomp_44');?></button>
        </div>
      </div>
    </div>
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
          <p id="for_succ_modal" class="success">
            <?php if(isset($_SESSION['suc_ban']) || isset($_SESSION['suc_load_ban']) || isset($_SESSION['suc_buy_ban']) || isset($_SESSION['del_b'])) { ?>
                <?php
                  if(isset($_SESSION['suc_ban'])) {
                    echo $_SESSION['suc_ban'];
                    $name_to_unset = 'suc_ban';
                  }elseif(isset($_SESSION['suc_load_ban'])) {
                    echo $_SESSION['suc_load_ban'];
                    $name_to_unset = 'suc_load_ban';
                  }elseif(isset($_SESSION['suc_buy_ban'])) {
                    echo $_SESSION['suc_buy_ban'];
                    $name_to_unset = 'suc_buy_ban';
                  }elseif(isset($_SESSION['del_b'])) {
                    echo $_SESSION['del_b'];
                    $name_to_unset = 'del_b';
                  }
                ?>
              <script type="text/javascript">
                $('#modal-succ').show();
              </script>
            <?php
              unset( $_SESSION[$name_to_unset] ); 
            } ?>
          </p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-succ').hide();"><?php echo $this->lang->line('submit');?></button>
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
          <p class="error" id="for_err_modal">
          <?php if(isset($_SESSION['er_ban']) || isset($_SESSION['er_load_ban']) || isset($_SESSION['er_buy_ban'])) { ?>
              <?php 
                if(isset($_SESSION['er_ban'])) {
                  echo $_SESSION['er_ban'];
                  $name_to_unset = 'er_ban';
                }elseif(isset($_SESSION['er_load_ban'])) {
                  echo $_SESSION['er_load_ban'];
                  $name_to_unset = 'er_load_ban';
                }elseif(isset($_SESSION['er_buy_ban'])) {
                  echo $_SESSION['er_buy_ban'];
                  $name_to_unset = 'er_buy_ban';
                }
              ?>
            <script type="text/javascript">
              $(document).ready(function(){
                $('#modal-err').modal();
              })
            </script>
          <?php 
            unset( $_SESSION[$name_to_unset] ); 
            } 
          ?>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-err').hide();" data-dismiss="modal"><?php echo $this->lang->line('submit');?></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade in" id="modal-cr_ban">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-cr_ban').hide();CleanOutCrBan()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title"><?php echo $this->lang->line('mytext_s_1');?></h4>
        </div>
        <div class="modal-body">
            <form onsubmit="return false;" id="reg_b_form" method="post" enctype="multipart/form-data">
              <p id="err_cr_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>

              <div class="form-group">
                <label for="Inputban3">URL(<?php echo $this->lang->line('myvid_s_1');?>)</label>
                <input type="text" id="cr_url" class="form-control" name="url">
              </div>

              <div class="form-group">
                <label for="Inputban3"><?php echo $this->lang->line('myban_new_s_13');?>(<?php echo $this->lang->line('myban_new_s_26');?>)</label>
                <select name="cr_lang_vid_ad">
                  <option value="all"><?php echo $this->lang->line('mail_21');?></option>
                  <option value="russian"><?php echo $this->lang->line('mail_22');?></option>
                  <option value="english"><?php echo $this->lang->line('mail_23');?></option>
                  <option value="german"><?php echo $this->lang->line('mail_24');?></option>
                </select>
              </div>
              <div style="clear:both;"></div>
              <div class="form-group f-g-b" id="for_pre">
                <input type="submit" class="btn btn-primary r-btn gold-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('myban_11');?>">
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
                url         : '<?php echo base_url();?>index.php/cabinet/addvid_ad',
                type        : 'POST', // важно!
                data        : data,
                cache       : false,
                processData : false,
                contentType : false, 
                success     : function( respond, status, jqXHR ) {
                  $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('myban_11');?>">');
                  var data = JSON.parse(respond);
                  if( data['err'] == '0' ){
                    var ban_info = JSON.parse(data['ban_info']);

                    if(ban_info['Status'] == 0) {
                      var status = '<span id="status_'+ban_info['ID']+'" style="color:blue;"><?php echo $this->lang->line('mycomp_21');?></span>';
                    }else if(ban_info['Status'] == 1) {
                      var status = '<span id="status_'+ban_info['ID']+'" class="green"><?php echo $this->lang->line('mycomp_deactivity');?></span>';
                    }else if(ban_info['Status'] == 2) {
                      var status = '<span id="status_'+ban_info['ID']+'" style="color:tomato;"><?php echo $this->lang->line('mycomp_24');?></span>';
                    }else if(ban_info['Status'] == 3) {
                      var status = '<span id="status_'+ban_info['ID']+'" style="color:orange;"><?php echo $this->lang->line('mycomp_25');?></span>';
                    }

                    if(ban_info['lang'] == 'all') {
                      lang = '<?php echo $this->lang->line('mail_21');?>';
                    }else if(ban_info['lang'] == 'russian') {
                      lang = '<?php echo $this->lang->line('mail_22');?>';
                    }else if(ban_info['lang'] == 'english') {
                      lang = '<?php echo $this->lang->line('mail_23');?>';
                    }else if(ban_info['lang'] == 'german') {
                      lang = '<?php echo $this->lang->line('mail_24');?>';
                    }

                    $('#for_new_bans').after('<div class="block-company"><div class="name-block-company"><div class="link-company"><a href="#" id="url_of_vid_ad_'+ban_info['ID']+'">'+JSON.parse(ban_info['url'])+'</a></div></div><div class="info-block-company"><div class="line-block-company"><span class="span-w"><img src="/assets/img/stats-comp.png" alt="">Today visit</span> 0</div><div class="line-block-company"><span class="span-w"><img src="/assets/img/clock-comp.png" alt="">Time</span> 0</div><div class="line-block-company"><span class="span-w"><img src="/assets/img/badge-comp.png" alt="">Balance</span> $<span id="bal_'+ban_info['ID']+'">'+ban_info['balance']+'</span></div><div class="line-block-company"><span class="span-w"><img src="/assets/img/star-comp.png" alt="">Status</span> '+status+'</div><div class="line-block-company"><span class="span-w"><img src="/assets/img/language-comp.png" alt="">Language</span> <span id="lang_'+ban_info['ID']+'">'+lang+'</span></div></div><div class="panel-block-company"><div class="line-block-company"><form><input type="text" name="count_add_'+ban_info['ID']+'" placeholder="$1"><img src="/assets/img/plus-comp.png" alt="" title="Пополнить баланс" onclick="CompBal('+ban_info['ID']+')"></form></div><div class="line-block-company"><img src="/assets/img/edit-comp.png" data-title="Edit" data-toggle="modal" data-target="#modal-ch_ban" onclick="$(\'#id_for_ch_vid_ad\').val('+ban_info['ID']+');$(\'#url_for_ch_vid_ad\').val($(\'#url_of_vid_ad_'+ban_info['ID']+'\').text()); $(\'select[name=ch_lang_vid_ad] option[value='+ban_info['lang']+']\').attr(\'selected\', \'selected\');" alt="" title="Редактировать"> <img src="/assets/img/delete-comp.png" data-title="Delete" data-toggle="modal" data-target="#modal-balance_del" onclick="$(\'#id_for_del\').val('+ban_info['ID']+')" alt="" title="Удалить кампанию"></div></div></div>');

                    $('#for_succ_modal').html(data['mess']);
                    $('#modal-succ').show();
                    $('#modal-cr_ban').hide();
                    CleanOutCrBan();

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
                    $('#modal-cr_ban').scrollTop(0);
                    // grecaptcha.reset();
                  }
                },
                error: function( jqXHR, status, errorThrown ) {
                  $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('myban_11');?>">');
                  $('#err_cr_b').html( '<?php echo $this->lang->line('high_in_tr'); ?>' );
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
  <div class="modal fade in" id="modal-ch_ban">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" id="for_ch_close" onclick="$('#modal-ch_ban').hide();CleanOutChBan()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title"><?php echo $this->lang->line('mycomp_26');?></h4>
        </div>
        <div class="modal-body">
          <form onsubmit="return false;" id="ch_b_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ID" id="id_for_ch_vid_ad">
            <p id="err_ch_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
            <div class="form-group">
              <label for="Inputban3">URL(<?php echo $this->lang->line('myvid_s_1');?>)</label>
              <input type="text" id="url_for_ch_vid_ad" class="form-control" name="url">
            </div>
            <div class="form-group">
              <label for="Inputban3"><?php echo $this->lang->line('myban_new_s_13');?>(<?php echo $this->lang->line('myban_new_s_26');?>)</label>
              <select name="ch_lang_vid_ad">
                <option value="all"><?php echo $this->lang->line('mail_21');?></option>
                <option value="russian"><?php echo $this->lang->line('mail_22');?></option>
                <option value="english"><?php echo $this->lang->line('mail_23');?></option>
                <option value="german"><?php echo $this->lang->line('mail_24');?></option>
              </select>
            </div>
            <div style="clear:both;"></div>
            <div class="form-group f-g-b">
              <input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('save');?>">
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
                  url         : '<?php echo base_url();?>index.php/cabinet/ch_vid_ad_info',
                  type        : 'POST', // важно!
                  data        : data,
                  cache       : false,
                  processData : false,
                  contentType : false, 
                  success     : function( respond, status, jqXHR ) {
                    // console.log(respond);
                    var data = JSON.parse(respond);
                    if( data['err'] == '0' ){
                      var ban_info = JSON.parse(data['ban_info']);

                      $('#for_succ_modal').html(data['mess']);
                      $('#modal-succ').show();
                      $('#for_ch_close').click();

                      $('#url_of_vid_ad_'+ban_info['ID']).html( ban_info['new_url'] );

                      var lang = $('select[name=ch_lang_vid_ad]').val();

                      if(lang == 'all') {
                        lang = '<?php echo $this->lang->line('mail_21');?>';
                      }else if(lang == 'russian') {
                        lang = '<?php echo $this->lang->line('mail_22');?>';
                      }else if(lang == 'english') {
                        lang = '<?php echo $this->lang->line('mail_23');?>';
                      }else if(lang == 'german') {
                        lang = '<?php echo $this->lang->line('mail_24');?>';
                      }

                      $('#lang_'+ban_info['ID']).html(lang);

                      $('#status_'+ban_info['ID']).html('<?php echo  $this->lang->line('mycomp_21'); ?>');

                      CleanOutChBan();

                    }else {
                      $('#modal-ch_ban').scrollTop(0);
                      $('#err_ch_b').html( data['mess'] );

                      if(data['error_field'] == 'url') {
                        $('#url_for_ch_ban').css('border', '2px solid red');
                      }else if(data['error_field'] == 'lang') {
                        $('select[name=ch_lang_ban]').css('border', '2px solid red');
                      }else if(data['error_field'] == 'head') {
                        $('#ch_head').css('border', '2px solid red'); 
                      }else if(data['error_field'] == 'body') {
                        $('#ch_body').css('border', '2px solid red');
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
  <script type="text/javascript">
    function Del(){
      var id = $('#id_for_del').val();
      document.location.href='del_vid_ad/'+id;
    }
    function Change() {
      var id = $('#id_for_ch').val();
      $.post(
        'ch_vid_ad_info',
        {
          ID: id,
          url: $('#in_ban_url_'+id).val(),
        },
        function(data){
          document.location.href="myvid";
        }
      )
    }
    function SaveConf(id) {
      $.post(
        'save_conf_text_ad',
        {
          ID: id,
          lang: $('select[name=lang_'+id+']').val(),
        },
        function(data) {
          $('#for_succ_modal').html('<?php echo $this->lang->line('ban_new_page_3');?>');
          $('#modal-succ').show();
          // console.log(data);
          // document.location.href="myban";
        }
      )
    }
    function ChangeImg() {
      var id = $('#id_for_ch').val();
      $('#form_img_'+id).submit();
    }
    function CompBal(id) {
      var val = $('input[name=count_add_'+id+']').val()
      $.post(
        'up_bal_vid_ad',
        {
          ID: id,
          count: val
        },
        function(data){
          // console.log(data);
          data = JSON.parse(data);
          if(data['error'] == 0) {
            $('#bal_'+id).text(data['bal_comp']);
            $('#add_bal_h').text(data['bal']+' PCT');

            var val =$('input[name=count_add_'+id+']').val(0)

            $('#for_succ_modal').html(data['mess']);
            $('#modal-succ').show();
            
          }else {

            $('#for_err_modal').html(data['mess']);
            $('#modal-err').show();
          }
        }
      )
    }

    function CompState(id, type) {
      $.post(
        'ch_vid_ad_state',
        {
          ID: id,
          type: type
        },
        function(data) {
          data = JSON.parse(data);
          if(data['error'] == 1) {
            $('#for_err_modal').html('Something wrong.');
            $('#modal-err').show();
          }else {

            var str2;

            if(type == 0) {
              str2 = '<?php echo $this->lang->line('ban_new_page_5');?>';
            }else {
              str2 = '<?php echo $this->lang->line('ban_new_page_6');?>';
            }

            $('#for_succ_modal').html('<?php echo $this->lang->line('ban_new_page_4');?> '+str2);
            $('#modal-succ').show();

            if(type == 0) {
              $('#play_t_'+id).html('Stoped');
              $('#play_i_'+id).remove();
              $('#play_t_'+id).after('<img id="play_i_'+id+'" onclick="CompState('+id+', 1)" src="/assets/img/play-comp.png" alt="" title="Включить показ">');

              $('#status_'+id).text('<?php echo $this->lang->line('mycomp_deactivity'); ?>');
            }else {
              $('#play_t_'+id).html('Running');
              $('#play_i_'+id).remove();
              $('#play_t_'+id).after('<img id="play_i_'+id+'" onclick="CompState('+id+', 0)" src="/assets/img/stop-comp.png" alt="" title="Остановить показ">');

              $('#status_'+id).text('<?php echo $this->lang->line('mycomp_activity'); ?>');
            }

          }
        }
      )
    }

  </script>
  <!-- My script for toggle -->
  <script>
    function ErrMess() {
      $('#for_err_modal').html('<?php echo $this->lang->line('mymess_page_new_1');?>');
      $('#modal-err').show('toggle');
    }
  </script>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->  