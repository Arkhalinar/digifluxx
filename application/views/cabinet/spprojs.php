<div class="content-wrapper">
   <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php"
    ?>
  <section class="content-header">
  </section>

  <!-- Main content -->
  <section class="content rek-page">
    <!-- Small boxes (Stat box) -->
    <div class="row limit">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <hr>
          <h1 style="text-align: center;"><?php echo $this->lang->line('sp_projs_1');?></h1>
          <hr>
          <div class="x_content">
            <?php 
            if(count($prjs) > 0) {
              if(count($prjs) == 1) {
                $size = 12;
              }else {
                $size = 6;
              }

              for($i = 0; $i < count($prjs); $i++) {
            ?>
                <div class="col-md-<?php echo $size;?> col-sm-<?php echo $size;?> col-xs-<?php echo $size;?>">
                  <div class="box box-primary">
                    <div class="box-body box-profile">
                      <h1 style="font-weight: bold; font-size: 115%;"><?php echo $prjs[$i]['header'];?></h1>
                      <div class="code-block">
                        <input id="in_pid_<?php echo $prjs[$i]['pid'];?>" type="hidden" value="<?php echo $prjs[$i]['pid'];?>">
                        <input id="in_url_<?php echo $prjs[$i]['pid'];?>" type="hidden" value="<?php echo $prjs[$i]['us_url'];?>">
                        <input id="in_type_<?php echo $prjs[$i]['pid'];?>" type="hidden" value="<?php echo $prjs[$i]['ref_url_for_check'];?>">
                        <button type="button" onclick="document.location.href='/cabinet/about_project/<?php echo $prjs[$i]['id']; ?>'" class="btn btn-primary gold-btn" data-toggle="modal" data-target="#modal-pass" id="ch_pas_modal"><?php echo $this->lang->line('sp_projs_2');?></button><img style="width:20px; height:20px;cursor:pointer;" data-toggle="modal" data-target="#modal-change" onclick="$('#prj_id').val($('#in_pid_<?php echo $prjs[$i]['pid'];?>').val());$('#us_url').val($('#in_url_<?php echo $prjs[$i]['pid'];?>').val());$('#ref_type').text($('#in_type_<?php echo $prjs[$i]['pid'];?>').val())" src="/assets/img/engeneer.jpg?1333">
                      </div>
                      <div>
                        <img onclick="document.location.href='/cabinet/about_project/<?php echo $prjs[$i]['id']; ?>'" style="width:40%;cursor:pointer;" src="<?php if($prjs[$i]['type'] == 'link'){ echo $prjs[$i]['img']; }else{ echo '/'.$prjs[$i]['img']; } ?>" align="center">
                      </div>
                    </div>
                  </div>
                </div>
            <?php
              }
            }else{
              ?>
                <h1 style="text-align: center;"><?php echo $this->lang->line('sp_projs_3');?></h1>
              <?php
            }
            ?>
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
    <div class="modal fade in" id="modal-change">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-change').hide();" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="form-group" id="for_content">
              <input id="prj_id" type="hidden">
              <label for="Inputban2"><?php echo $this->lang->line('sp_projs_4');?></label><br><input id="us_url" style="width:100%;" type="text" placeholder="https://..."><br><br><?php echo $this->lang->line('sp_projs_5');?><br> <span style="font-weight: bold;font-size: 110%;" id="ref_type"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary gold-btn" onclick="SaveLink()" data-dismiss="modal"><?php echo $this->lang->line('sp_projs_6');?></button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <script type="text/javascript">
      function SaveLink() {
        let id = $('#prj_id').val();
        let link = $('#us_url').val();

        $.post(
          '<?php echo base_url();?>/cabinet/ed_project',
          {
            'id':id,
            'url':link 
          },
          function(data){
            var data = JSON.parse(data);
            if( data['err'] == '0' ){
              $('#modal-change').hide();

              $('#for_succ_modal').html(data['mess']);
              $('#modal-succ').show();

              $('#for_us_link_'+id).html('<a target="_blank" href="'+data['new_url']+'">'+data['new_url']+'</a>');
              $('#in_url_'+id).val(data['new_url']);
            }else {
              $('#modal-change').hide();

              $('#for_err_modal').html(data['mess']);
              $('#modal-err').show();
            }
          }
        );
      }
    </script>
    <?php
      include 'banner_block.php';
    ?>
  </section>
</div>













