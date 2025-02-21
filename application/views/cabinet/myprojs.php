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
        <div class="row-content">
          <script type="text/javascript">
            function SaveLink(id) {
              let link = $('#us_url_'+id).val();
              $.post(
                '<?php echo base_url();?>/cabinet/ed_project',
                {
                  'id':id,
                  'url':link 
                },
                function(data){
                  var data = JSON.parse(data);
                  if( data['err'] == '0' ){
                    $('#for_succ_modal').html(data['mess']);
                    $('#modal-succ').show();

                    $('#for_us_link_'+id).html('<a target="_blank" href="'+data['new_url']+'">'+data['new_url']+'</a>');
                  }else {
                    $('#for_err_modal').html(data['mess']);
                    $('#modal-err').show();
                  }
                }
              );
            }
          </script>
            <div style="clear:both;" id="for_new_bans"></div>
            <hr>
            <h2 style="text-align: center;"><?php echo $this->lang->line('my_projs_1');?></h2>
            <hr>
            <?php 
              if(count($prjs_info['prjs']) > 0) {
                for($i = 0; $i < count($prjs_info['prjs']); $i++) {
            ?>
                  <div class="block-company">
                    <div class="name-block-company">
                      <h4 id="head_<?php echo $prjs_info['prjs'][$i]['id'];?>"><?php echo $prjs_info['prjs'][$i]['header'];?></h4>
                      <div class="block-rek-img-company">
                        <img id="img_of_prj_<?php echo $prjs_info['prjs'][$i]['id'];?>" src="<?php if($prjs_info['prjs'][$i]['type'] == 'link'){ echo $prjs_info['prjs'][$i]['img']; }else{ echo '/'.$prjs_info['prjs'][$i]['img']; } ?>">
                      </div>
                      <div class="block-rek-img-company" id="body_<?php echo $prjs_info['prjs'][$i]['id'];?>"><?php echo $prjs_info['prjs'][$i]['body'];?></div>
                      <div class="link-company">
                        <a target="_blank" href="<?php echo $prjs_info['prjs'][$i]['url']; ?>" id="url_of_prj_<?php echo $prjs_info['prjs'][$i]['id'];?>"><?php echo $prjs_info['prjs'][$i]['url']; ?></a>
                      </div>
                    </div>
                    <div class="info-block-company">
                      <div class="line-block-company">
                        <span class="span-w">
                          <img src="/assets/img/clock-comp.png" alt=""><?php echo $this->lang->line('my_projs_2');?>
                        </span> <?php
                            if(isset($prjs_info['us_prjs'][$prjs_info['prjs'][$i]['id']])) {
                              echo $prjs_info['us_prjs'][$prjs_info['prjs'][$i]['id']]['clicks'];
                            }else{
                              echo 0;
                            }
                          ?>
                      </div>
                    </div>
                    <div class="panel-block-company">
                      <div class="line-block-company">
                        <p id="block_for_result" style="display:none;"></p>
                        <p><?php echo $this->lang->line('my_projs_3');?>:</p>
                        <?php
                          if(isset($prjs_info['us_prjs'][$prjs_info['prjs'][$i]['id']])) {
                        ?>
                            <p srtyle="font-size:105%; font-weight:bold;" id="for_us_link_<?php echo $prjs_info['prjs'][$i]['id'];?>"><a target="_blank" href="<?php echo $prjs_info['us_prjs'][$prjs_info['prjs'][$i]['id']]['us_url']; ?>"><?php echo $prjs_info['us_prjs'][$prjs_info['prjs'][$i]['id']]['us_url']; ?></a></p>
                        <?php
                          }else{
                        ?>
                            <p srtyle="font-size:105%; font-weight:bold;" id="for_us_link_<?php echo $prjs_info['prjs'][$i]['id'];?>"><?php echo $this->lang->line('my_projs_4');?></p>
                        <?php
                          }
                        ?>
                        <p>
                          <input id="us_url_<?php echo $prjs_info['prjs'][$i]['id'];?>" style="text-align: left;" type="text" name="us_url_<?php echo $prjs_info['prjs'][$i]['id'];?>" placeholder="<?php echo $this->lang->line('my_projs_5');?>">
                        </p>
                        <p><button onclick="SaveLink(<?php echo $prjs_info['prjs'][$i]['id'];?>)"><?php echo $this->lang->line('my_projs_6');?></button></p>
                      </div>
                    </div>
                  </div>
            <?php
                }
              }else{
            ?>
                  <div class="block-company">
                    <h1 style="text-align: center;"><?php echo $this->lang->line('my_projs_7');?></h1>
                  </div>
            <?php
              }
            ?>
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
              <p id="for_succ_modal" class="success"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary gold-btn" data-dismiss="modal" onclick="$('#modal-succ').hide();"><?php echo $this->lang->line('my_projs_8');?></button>
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
              <button type="button" class="btn btn-primary gold-btn" onclick="$('#modal-err').hide();" data-dismiss="modal"><?php echo $this->lang->line('my_projs_8');?></button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php
        include 'banner_block.php';
      ?>
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->  