<div class="modal fade in" id="modal-succ">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#modal-succ').hide();" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><?php echo $this->lang->line('attention_new');?></h4>
      </div>
      <div class="modal-body">
        <?php if(isset($_GET['success'])) { ?>
          <p class="success"><?php echo $this->lang->line('succ_pay_mess');?></p>
          <script type="text/javascript">
            $(document).ready(function(){
              $('#modal-succ').show();
            })
          </script>
        <?php 
          } 
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="$('#modal-succ').hide();" data-dismiss="modal"><?php echo $this->lang->line('submit');?></button>
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
        <h4 class="modal-title"><?php echo $this->lang->line('attention_new');?></h4>
      </div>
      <div class="modal-body">
        <?php if(isset($_GET['fail'])) { ?>
          <p class="error"><?php echo $this->lang->line('err_pay_mess');?></p>
          <script type="text/javascript">
            $(document).ready(function(){
              $('#modal-err').show();
            })
          </script>
        <?php 
          } 
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="$('#modal-err').hide();" data-dismiss="modal"><?php echo $this->lang->line('submit');?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<style type="text/css">
  .block-rez-img1,.block-rez-img2,.block-rez-img3,.block-rez-img4,.block-rez-img5,.block-rez-img6 {
    margin-left: 0px;
    margin-right: 0px;
  }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php
         echo $this->lang->line('financ_oper');?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('menu_main');?></a></li>
        <li class="active"><?php echo $this->lang->line('financ_oper');?></li>
      </ol>
    </section>

    <div class="cab-rek-block top-block">
        <?php
          if(count($bans['468x60']) > 0) {
            $current_banner = array_shift($bans['468x60']);
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
    </div>


    <!-- Main content -->
    <section class="content wallet-new">
      <div class="row">
        <div style="text-align:center; font-weight: bold; font-size: 175%; margin: 10% auto;"><?php echo $this->lang->line('tech_work_message');?></div>
      </div>
      <?php
        include 'banner_block.php';
      ?>
    </section>
    <!-- /.content -->
  </div>