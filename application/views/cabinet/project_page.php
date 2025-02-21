<div class="content-wrapper">
   <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";

      $spec_proj_info = json_decode($proj_info['add_info'], true);
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
          <h1 style="text-align: center;"><?php echo $proj_info['header'];?></h1>
          <hr>
          <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <?php
              if($spec_proj_info['type'] == 'html') {
            ?>
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <div style="overflow: visible;">
                    <div style="font-size: 110%;">
                      <?php echo $proj_info['body']; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php
              }else{
            ?>
              <iframe style="width:100%; height:<?php echo $spec_proj_info['height'];?>px;" src="<?php echo $spec_proj_info['url'];?>"></iframe>
            <?php
              }
            ?>
            <div class="code-block">
              <button type="button" onclick="SaveAndGo('<?php echo $proj_info['us_url']; ?>');" class="btn btn-primary gold-btn" data-toggle="modal" data-target="#modal-pass" id="ch_pas_modal"><?php echo $this->lang->line('prj_projs_1');?></button>
            </div>
            </div>
          </div>
          <script type="text/javascript">
            function SaveAndGo(url, id) {
              $.post(
                '<?php echo base_url();?>/cabinet/save_prj_stat',{url:url},function(data){window.open(url)}
              )
            }
          </script>
        </div>
      </div>
    </div>
     <?php
      include 'banner_block.php';
    ?>
  </section>
</div>













