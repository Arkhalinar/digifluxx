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
      <div class="limit">

        <div class="row-content" style="overflow: auto; text-align: center;">
          <div class="all-filter">
            <div class="title-filter"><?php echo $this->lang->line('code_generartion_42');?></div>
          </div>
        </div>

        <div class="row-content">
            <div class="new-company">
              <button class="btn btn-primary pokaz gold-btn" onclick="$('#modal-cr_ban').show();$('select[name=size]').val('125x125');"><?php echo $this->lang->line('code_generartion_1');?></button>
            </div>
            <div style="clear:both;" id="for_new_bans"></div>
            <?php 
              for($i = 0; $i < count($codes); $i++) {
            ?>
                <div class="block-company" id="bw_<?php echo $codes[$i]['id'];?>">
                  <div class="name-block-company">
                    <h4>
                      <?php
                        if($codes[$i]['type'] == 0)
                        {
                      ?>
                          <span id="nameOfAd_<?php echo $codes[$i]['id'];?>"><?php echo $this->lang->line('code_generartion_2');?></span>
                      <?php
                        }
                        else
                        {
                      ?>
                          <span id="nameOfAd_<?php echo $codes[$i]['id'];?>"><?php echo $this->lang->line('code_generartion_3');?></span>
                      <?php
                        }
                      ?> №<?php echo $codes[$i]['id'];?>
                    </h4>
                    <div class="line-block-company">
                       <textarea rows="8" cols="60"><script type="text/javascript" src="https://digifluxx.com/special/scpt?a=<?php echo $codes[$i]['id'];?>"></script><div class="digibnr_<?php echo $codes[$i]['id'];?>"></div></textarea>
                    </div>
                    <div class="line-block-company">
                       <button id="copy_<?php echo $codes[$i]['id'];?>"><?php echo $this->lang->line('code_generartion_2');?></button>
                    </div>
                    <script type="text/javascript">
                      var copyBobBtn = document.querySelector('#copy_<?php echo $codes[$i]['id'];?>');
                      copyBobBtn.addEventListener('click', function(event) {
                        copyTextToClipboard('<script type="text/javascript" src="https://digifluxx.com/special/scpt?a=<?php echo $codes[$i]['id'];?>">\<\/script><div class="digibnr_<?php echo $codes[$i]['id'];?>"></div>');
                      });
                    </script>
                  </div>
                  <div class="info-block-company">
                    <h4><?php echo $this->lang->line('code_generartion_4');?></h4>
                    <?php
                      $config = json_decode($codes[$i]['config'], true);
                    ?>
                    <div class="line-block-company" id="code_format_block_<?php echo $codes[$i]['id'];?>" <?php if($codes[$i]['type'] != 0) { ?>style="display:none;"<?php } ?>>
                       <span class="span-w"><?php echo $this->lang->line('code_generartion_5');?></span> <span id="code_format_<?php echo $codes[$i]['id'];?>"><?php if(isset($config['format'])) echo $config['format'];?></span>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><?php echo $this->lang->line('code_generartion_6');?></span> <span id="code_lang_<?php echo $codes[$i]['id'];?>"><?php
                          if($config['lang_type'] == 'auto'){
                            echo $this->lang->line('code_generartion_7');
                            $jqueryCodeForEdit = '';
                          }else{
                            switch ($config['static_lang']) {
                              case 'eng':
                                echo $this->lang->line('code_generartion_8');
                                break;
                              case 'ger':
                                echo $this->lang->line('code_generartion_9');
                                break;
                              case 'rus':
                                echo $this->lang->line('code_generartion_10');
                                break;
                              case 'all':
                                echo $this->lang->line('code_generartion_11');
                                break;
                            }
                            $jqueryCodeForEdit = "$('#ch_lang_choosing').show();$('select[name=ch_static_lang]').val('".$config['static_lang']."');";
                          }
                      ?></span>
                    </div>
                    <h4><?php echo $this->lang->line('code_generartion_12');?></h4>
                    <div class="line-block-company">
                       <span class="span-w"><?php echo $this->lang->line('code_generartion_13');?></span> <?php echo $codes[$i]['clicks'];?>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><?php echo $this->lang->line('code_generartion_14');?></span> <?php echo $codes[$i]['shows'];?>
                    </div>
                    <div class="line-block-company">
                       <span class="span-w"><?php echo $this->lang->line('code_generartion_15');?></span> <?php echo $codes[$i]['earned'];?> Credit
                    </div>
                  </div>
                  <div class="panel-block-company">
                    <div class="line-block-company">
                      <button onclick="$('#ch_size').val('<?php echo $config['format'];?>');$('#ch_lang_type').val('<?php echo $config['lang_type'];?>');<?php echo $jqueryCodeForEdit;?>$('#id_for_edit').val(<?php echo $codes[$i]['id'];?>);$('#modal-ch_ban').show();"><?php echo $this->lang->line('code_generartion_16');?></button>
                    </div>
                    <div class="line-block-company">
                      <button onclick="$('#id_for_del').val(<?php echo $codes[$i]['id'];?>);$('#modal-balance_del').show();"><?php echo $this->lang->line('code_generartion_17');?></button>
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
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-succ').hide();"><?php echo $this->lang->line('code_generartion_27');?></button>
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
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-err').hide();" data-dismiss="modal"><?php echo $this->lang->line('code_generartion_27');?></button>
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
          <h4 class="modal-title"><?php echo $this->lang->line('code_generartion_1');?></h4>
        </div>
        <div class="modal-body">
          <form onsubmit="return false;" id="reg_b_form" method="post" enctype="multipart/form-data">
            <p id="err_cr_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
            <div class="form-group">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_18');?></label>
              <select class="form-control" id="cr_type" name="type">
                <option value="0"><?php echo $this->lang->line('code_generartion_2');?></option>
                <option value="1"><?php echo $this->lang->line('code_generartion_3');?></option>
              </select>
            </div>
            <script type="text/javascript">
              $('#cr_type').on('change', function(){
                let crType = $('#cr_type').val();
                if(crType == '0') {
                  $('#cr_for_banner_choosing').show();
                }else{
                  $('#cr_for_banner_choosing').hide();
                }
              })
            </script>
            <div class="form-group" id="cr_for_banner_choosing">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_28');?>(<?php echo $this->lang->line('code_generartion_29');?>)</label>
              <select class="form-control" id="cr_size" name="format">
                <option value="125x125">125x125</option>
                <option value="300x250">300x250</option>
                <option value="468x60">468x60</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_19');?></label>
              <select class="form-control" id="lang_type" name="lang_type">
                <option value="auto"><?php echo $this->lang->line('code_generartion_20');?></option>
                <option value="static"><?php echo $this->lang->line('code_generartion_21');?></option>
              </select>
              <script type="text/javascript">
                $('#lang_type').on('change', function(){
                  let val = $('#lang_type').val();
                  if(val == 'auto') {
                    $('#lang_choosing').hide();
                  }else{
                    $('#lang_choosing').show();
                  }
                })
              </script>
            </div>
            <div class="form-group" id="lang_choosing" style="display:none;">
              <label for="Inputban3"><?php echo $this->lang->line('code_generartion_30');?>(<?php echo $this->lang->line('myban_new_s_26');?>)</label>
              <select name="static_lang">
                <option value="all"><?php echo $this->lang->line('code_generartion_31');?></option>
                <option value="rus"><?php echo $this->lang->line('code_generartion_32');?></option>
                <option value="eng"><?php echo $this->lang->line('code_generartion_33');?></option>
                <option value="ger"><?php echo $this->lang->line('code_generartion_34');?></option>
              </select>
            </div>
            <div style="clear:both;"></div>
            <div class="form-group f-g-b" id="for_pre">
              <input type="submit" class="btn btn-primary r-btn gold-btn" name="SendBan" value="<?php echo $this->lang->line('code_generartion_22');?>">
            </div>
          </form>
          <script type="text/javascript">
            $("#reg_b_form").submit(function() {

                $('#for_pre').html('<img style="display:block;width: 20%; margin: 0 auto;" src="/preloader.gif">');
                
                var data = new FormData();

                $.each( $(this).serializeArray(), function( key, value ){
                  data.append( value.name, value.value );
                });

                $.ajax({
                  url         : '<?php echo base_url();?>/special/create_code',
                  type        : 'POST', // важно!
                  data        : data,
                  cache       : false,
                  processData : false,
                  contentType : false, 
                  success     : function( respond, status, jqXHR ) {

                    $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('code_generartion_35');?>">');
                    var data = JSON.parse(respond);
                    if( data['err'] == '0' ){
                      var ban_info = data['ban_info'];

                      let lang_script;
                      let lang;
                      let add_str;

                      if(ban_info['lang_type'] == 'auto') {
                        lang = '<?php echo $this->lang->line('code_generartion_7');?>';
                        add_str = '';
                      }else {

                        if(ban_info['static_lang'] == 'all') {
                          lang = '<?php echo $this->lang->line('code_generartion_31');?>';
                        }else if(ban_info['static_lang'] == 'rus') {
                          lang = '<?php echo $this->lang->line('code_generartion_32');?>';
                        }else if(ban_info['static_lang'] == 'eng') {
                          lang = '<?php echo $this->lang->line('code_generartion_33');?>';
                        }else if(ban_info['static_lang'] == 'ger') {
                          lang = '<?php echo $this->lang->line('code_generartion_34');?>';
                        }

                        add_str = '$(\'#ch_lang_choosing\').show();$(\'select[name=ch_static_lang]\').val(\''+ban_info['static_lang']+'\');';
                      }

                      if(ban_info['type'] == 0) {
                        name = '<span id="nameOfAd_'+ban_info['id']+'"><?php echo $this->lang->line('code_generartion_2');?></span>';
                        format_info = '<div id="code_format_block_'+ban_info['id']+'" class="line-block-company"><span class="span-w"><?php echo $this->lang->line('code_generartion_5');?></span> <span id="code_format_'+ban_info['id']+'">'+ban_info['format']+'</span></div>';
                      }
                      else
                      {
                        name = '<span id="nameOfAd_'+ban_info['id']+'"><?php echo $this->lang->line('code_generartion_3');?></span>';
                        format_info = '<div id="code_format_block_'+ban_info['id']+'" class="line-block-company" style="display:none;"><span class="span-w"><?php echo $this->lang->line('code_generartion_5');?></span> <span id="code_format_'+ban_info['id']+'"></span></div>';
                      }

                      $('#for_new_bans').after('<div class="block-company"><div class="name-block-company"><h4> '+name+'№'+ban_info['id']+'</h4><div class="line-block-company"><textarea rows="8" cols="60"><script type="text/javascript" src="https://digifluxx.com/special/scpt?a='+ban_info['id']+'">\<\/script><div class="digibnr_'+ban_info['id']+'"></div></textarea></div><div class="line-block-company"><button id="copy_'+ban_info['id']+'"><?php echo $this->lang->line('code_generartion_26');?></button></div></div><div class="info-block-company"><h4><?php echo $this->lang->line('code_generartion_4');?></h4>'+format_info+'<div class="line-block-company"><span class="span-w"><?php echo $this->lang->line('code_generartion_6');?></span> <span id="code_lang_'+ban_info['id']+'">'+lang+'</span></div><h4><?php echo $this->lang->line('code_generartion_12');?></h4><div class="line-block-company"><span class="span-w"><?php echo $this->lang->line('code_generartion_13');?></span> 0</div><div class="line-block-company"><span class="span-w"><?php echo $this->lang->line('code_generartion_14');?></span> 0</div><div class="line-block-company"><span class="span-w"><?php echo $this->lang->line('code_generartion_15');?></span> 0 Credit</div></div><div class="panel-block-company"><div class="line-block-company"><button onclick="$(\'#ch_size\').val(\''+ban_info['format']+'\');$(\'#ch_lang_type\').val(\''+ban_info['lang_type']+'\');'+add_str+'$(\'#id_for_edit\').val('+ban_info['id']+');$(\'#modal-ch_ban\').show();"><?php echo $this->lang->line('code_generartion_16');?></button></div><div class="line-block-company"><button onclick="$(\'#id_for_del\').val('+ban_info['id']+');$(\'#modal-balance_del\').show();"><?php echo $this->lang->line('code_generartion_17');?></button></div></div></div>');

                      var copyBobBtn = document.querySelector('#copy_'+ban_info['id']);
                      copyBobBtn.addEventListener('click', function(event) {
                        copyTextToClipboard('<script type="text/javascript" src="https://digifluxx.com/special/scpt?a='+ban_info['id']+'">\<\/script><div class="digibnr_'+ban_info['id']+'"></div>');
                      });

                      $('#for_succ_modal').html('<?php echo $this->lang->line('code_generartion_23');?>');
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
                    }
                  },
                  error: function( jqXHR, status, errorThrown ) {
                    $('#for_pre').html('<input type="submit" class="btn btn-primary r-btn gold-btn" id="send_file" name="SendBan" value="<?php echo $this->lang->line('code_generartion_35');?>">');
                    $('#err_cr_b').html( '<?php echo $this->lang->line('code_generartion_36'); ?>' );
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
            <p id="err_cr_b" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
            <input type="hidden" name="id_for_edit" id="id_for_edit">
            <div class="form-group">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_18');?></label>
              <select class="form-control" id="ch_type" name="ch_type">
                <option value="0"><?php echo $this->lang->line('code_generartion_2');?></option>
                <option value="1"><?php echo $this->lang->line('code_generartion_3');?></option>
              </select>
            </div>
            <script type="text/javascript">
              $('#ch_type').on('change', function(){
                let chType = $('#ch_type').val();
                if(chType == '0') {
                  $('#ch_for_banner_choosing').show();
                }else{
                  $('#ch_for_banner_choosing').hide();
                }
              })
            </script>
            <div class="form-group" id="ch_for_banner_choosing">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_28');?>(<?php echo $this->lang->line('code_generartion_29');?>)</label>
              <select class="form-control" id="ch_size" name="ch_format">
                <option value="125x125">125x125</option>
                <option value="300x250">300x250</option>
                <option value="468x60">468x60</option>
              </select>
            </div>
            <div class="form-group">
              <label for="Inputban1"><?php echo $this->lang->line('code_generartion_19');?></label>
              <select class="form-control" id="ch_lang_type" name="ch_lang_type">
                <option value="auto"><?php echo $this->lang->line('code_generartion_20');?></option>
                <option value="static"><?php echo $this->lang->line('code_generartion_21');?></option>
              </select>
              <script type="text/javascript">
                $('#ch_lang_type').on('change', function(){
                  let val = $('#ch_lang_type').val();
                  if(val == 'auto') {
                    $('#ch_lang_choosing').hide();
                  }else{
                    $('#ch_lang_choosing').show();
                  }
                })
              </script>
            </div>
            <div class="form-group" id="ch_lang_choosing" style="display:none;">
              <label for="Inputban3"><?php echo $this->lang->line('code_generartion_30');?>(<?php echo $this->lang->line('myban_new_s_26');?>)</label>
              <select name="ch_static_lang">
                <option value="all"><?php echo $this->lang->line('code_generartion_31');?></option>
                <option value="rus"><?php echo $this->lang->line('code_generartion_32');?></option>
                <option value="eng"><?php echo $this->lang->line('code_generartion_33');?></option>
                <option value="ger"><?php echo $this->lang->line('code_generartion_34');?></option>
              </select>
            </div>
            <div style="clear:both;"></div>
            <div class="form-group f-g-b" id="for_pre">
              <input type="submit" class="btn btn-primary r-btn gold-btn" name="SendBan" value="<?php echo $this->lang->line('code_generartion_24');?>">
            </div>
          </form>
          <script type="text/javascript">
            $("#ch_b_form").submit(function() {

                var data = new FormData();

                $.each( $(this).serializeArray(), function( key, value ){
                  data.append( value.name, value.value );
                });

                $.ajax({
                  url         : '<?php echo base_url();?>special/ch_code_info',
                  type        : 'POST',
                  data        : data,
                  cache       : false,
                  processData : false,
                  contentType : false, 
                  success     : function( respond, status, jqXHR ) {
                    var data = JSON.parse(respond);
                    if( data['err'] == '0' ){

                      var ban_info = data['ban_info'];

                      $('#for_succ_modal').html('<?php echo $this->lang->line('code_generartion_25');?>');
                      $('#modal-succ').show();
                      $('#for_ch_close').click();

                      if(ban_info['type'] == 0) {

                        $('#code_format_block_'+ban_info['id']).show();
                        $('#code_format_'+ban_info['id']).text( ban_info['format'] );
                        $('#nameOfAd_'+ban_info['id']).text('<?php echo $this->lang->line('code_generartion_2');?>');

                      }else {

                        $('#code_format_block_'+ban_info['id']).hide();
                        $('#code_format_'+ban_info['id']).text('');
                        $('#nameOfAd_'+ban_info['id']).text('<?php echo $this->lang->line('code_generartion_3');?>');

                      }

                      if(ban_info['lang_type'] == 'auto') {
                        lang = '<?php echo $this->lang->line('code_generartion_7');?>';
                      }else {

                        if(ban_info['static_lang'] == 'all') {
                          lang = '<?php echo $this->lang->line('code_generartion_31');?>';
                        }else if(ban_info['static_lang'] == 'rus') {
                          lang = '<?php echo $this->lang->line('code_generartion_32');?>';
                        }else if(ban_info['static_lang'] == 'eng') {
                          lang = '<?php echo $this->lang->line('code_generartion_33');?>';
                        }else if(ban_info['static_lang'] == 'ger') {
                          lang = '<?php echo $this->lang->line('code_generartion_34');?>';
                        }

                        add_str = '$(\'#ch_lang_choosing\').show();$(\'select[name=ch_static_lang]\').val(\''+ban_info['static_lang']+'\');';
                      }

                      $('#code_lang_'+ban_info['id']).text(lang);

                      CleanOutChBan();

                    }else {
                      $('#modal-ch_ban').scrollTop(0);
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
                    $('#err_ch_b').html( '<?php echo $this->lang->line('code_generartion_36'); ?>' );
                  }

                });
            });


            function CleanOutChBan() {
              $('#err_ch_b').html( '' );

              $('#cr_size').val('125x125');
              $('#cr_type_cont').val('1');
              $('#cr_type').val('1');
              $('input[name=uploadfile]').val('');

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
          <h4 class="modal-title"><?php echo $this->lang->line('code_generartion_37');?></h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id_for_del">
          <p><?php echo $this->lang->line('code_generartion_38');?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-balance_del').hide();Del()"><?php echo $this->lang->line('code_generartion_39');?></button>
          <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-balance_del').hide();" data-dismiss="modal"><?php echo $this->lang->line('code_generartion_40');?></button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function Del(){
      var id = $('#id_for_del').val();
      $.post('/special/del_code/'+id,{}, function(){});
      $('#bw_'+id).remove();
    }
    function ErrMess() {
      $('#for_err_modal').html('<?php echo $this->lang->line('code_generartion_41');?>');
      $('#modal-err').show('toggle');
    }
  </script>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->  