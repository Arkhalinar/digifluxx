  <div class="content-wrapper">
     <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";
    ?>


    <!-- Main content -->
    <section class="content">
      <div class="row-content limit">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <!-- <div class="tab-content"> -->
              <div class="tab-pane active" id="tab_0">
                <div class="box box-info">
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                      <div class="row">
                        <div>
                          <div class="box-header">
                            <h3 class="box-title"><?php echo $this->lang->line('out_1');?></h3>
                            <i class="fa fa-refresh" onclick="GetAllWithdraws();" ></i>
                          </div>
                          <div class="col-sm-123 table_scroll_adap">
                            <div class="box-body table-responsive no-padding">
                              <table class="blueTable" id="witho_pe">
                                <tbody>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th><?php echo $this->lang->line('Date');?></th>
                                    <th><?php echo $this->lang->line('Addr');?></th>
                                    <th><?php echo $this->lang->line('sum');?></th>
                                    <th><?php echo $this->lang->line('comment');?></th>
                                    <th style="width: 40px"><?php echo $this->lang->line('status_d');?></th>
                                  </tr>
                                  <?php
                                    if(count($widthdraws) > 0) {
                                      $i = 0;
                                      foreach($widthdraws as $r) {
                                        $i++;
                                  ?>
                                  <tr>
                                    <td><?php echo $i;?>.</td>
                                    <td><?php echo $r['date'];?></td>
                                    <td><?php echo $r['btc_address'];?></td>
                                    <td><?php echo rtrim(rtrim(number_format($r['sum'], 4, '.', ''), "0"), ".");?></td>
                                    <td><?php echo $r['riason'];?></td>
                                    <td>
                                     <?php 
                                      if($r['status'] == 2){
                                     ?>
                                        <span class="label label-warning"><?php echo $this->lang->line('withdraw_new_6');?></span>
                                     <?php
                                      }elseif($r['status'] == 3){
                                     ?>
                                        <span class="label label-danger"><?php echo $this->lang->line('withdraw_new_7');?></span>
                                     <?php
                                      }elseif($r['status'] == 1){
                                     ?>
                                        <span class="label label-success"><?php echo $this->lang->line('withdraw_new_8');?></span>
                                     <?php
                                      }
                                     ?>
                                    </td>
                                  </tr>
                                  <?php
                                      }
                                    }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <br><br>

                        <div class="box-header">
                          <h3 class="box-title"><?php echo $this->lang->line('all_trans');?></h3>
                        </div>
                        <div class="col-sm-123 table_scroll_adap">
                          <table id="example1" class="blueTable" role="grid" cellspacing="0" aria-describedby="example1_info">
                            <thead>
                              <tr role="row">
                                <th class="sorting_asc"><?php echo $this->lang->line('DATE');?></th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"><?php echo $this->lang->line('init');?></th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending"><?php echo $this->lang->line('about');?></th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"><?php echo $this->lang->line('SUM');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $odd = true; foreach($transactions_all as $t):?>
                              <?php

                                if(($t['type'] == 38 && $t['sendername'] == $this->session->username) || ($t['type'] == 2121 && $t['sendername'] == $this->session->username)) {
                                  continue;
                                }

                                if($t['type'] == 2 || $t['type'] == 458 || $t['type'] == 45 || $t['type'] == 33 || $t['type'] == 38 || $t['type'] == 1902 || $t['type'] == 3333 || $t['type'] == 1117 || $t['type'] == 1112 || $t['type'] == 2121 || $t['type'] == 9873 || $t['type'] == 9874 || $t['type'] == 99873 || $t['type'] == 98873) {
                                  $type = $this->lang->line('income');
                                  $color = '#0f0';
                                  $arrow = '+';
                                } else {
                                  $type = $this->lang->line('discharge');
                                  $color = '#f00';
                                  $arrow = '-';
                                }
                                
                                if($t['type'] == 2)
                                  $desc = $this->lang->line('type_income');
                                if($t['type'] == 3)
                                  $desc = $this->lang->line('type_withdraw');
                                if($t['type'] == 33)
                                  $desc = $this->lang->line('type_33');
                                if($t['type'] == 38)
                                  $desc = $this->lang->line('type_38');
                                if($t['type'] == 45)
                                  $desc = $this->lang->line('type_45');
                                if($t['type'] == 46)
                                  $desc = $this->lang->line('type_46');
                                if($t['type'] == 456)
                                  $desc = $this->lang->line('type_456');
                                if($t['type'] == 458)
                                  $desc = $this->lang->line('type_458');
                                if($t['type'] == 457)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 1912)
                                  $desc = $this->lang->line('transfer_word_5');
                                if($t['type'] == 1913)
                                  $desc = $this->lang->line('new_trans_1');
                                if($t['type'] == 1902)
                                  $desc = $this->lang->line('new_trans_2');
                                if($t['type'] == 496)
                                  $desc = $this->lang->line('mail_55');
                                if($t['type'] == 495)
                                  $desc = $this->lang->line('mail_56');
                                if($t['type'] == 4558)
                                  $desc = $this->lang->line('mail_57');
                                if($t['type'] == 1111)
                                  $desc = $this->lang->line('struct_mess_1');
                                if($t['type'] == 1112)
                                  $desc = $this->lang->line('struct_mess_2');
                                if($t['type'] == 1113)
                                  $desc = $this->lang->line('struct_mess_3');
                                if($t['type'] == 1114)
                                  $desc = $this->lang->line('struct_mess_4');
                                if($t['type'] == 1115)
                                  $desc = $this->lang->line('struct_mess_5');
                                if($t['type'] == 1116)
                                  $desc = $this->lang->line('struct_mess_6');
                                if($t['type'] == 2222)
                                  $desc = $this->lang->line('struct_mess_66');
                                if($t['type'] == 3333)
                                  $desc = $this->lang->line('struct_mess_67');
                                if($t['type'] == 1117)
                                  $desc = $this->lang->line('struct_mess_68');
                                if($t['type'] == 2220)
                                  $desc = $this->lang->line('struct_mess_688');
                                if($t['type'] == 2121)
                                  $desc = $this->lang->line('struct_mess_6888');
                                if($t['type'] == 1999)
                                  $desc = $this->lang->line('the_new_trans_1');
                                if($t['type'] == 2999)
                                  $desc = $this->lang->line('the_new_trans_2');
                                if($t['type'] == 3999)
                                  $desc = $this->lang->line('the_new_trans_3');
                                if($t['type'] == 4999)
                                  $desc = $this->lang->line('the_new_trans_4');
                                if($t['type'] == 9873)
                                  $desc = $this->lang->line('the_new_trans_5');
                                if($t['type'] == 9874)
                                  $desc = $this->lang->line('the_new_trans_6');
                                if($t['type'] == 99873)
                                  $desc = sprintf($this->lang->line('the_new_trans_7'), $t['hash_pe']);
                                if($t['type'] == 0)
                                  $desc = $this->lang->line('the_new_trans_8');
                                if($t['type'] == 98873)
                                  $desc = sprintf($this->lang->line('the_new_trans_9'), $t['hash_pe']);
                                if($t['type'] == 11999)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 12999)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 13999)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 14999)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 15999)
                                  $desc = $this->lang->line('type_457');
                                if($t['type'] == 2091)
                                  $desc = $this->lang->line('the_new_trans_10');
                                
                                


                                
                                if($t['sendername'] == $this->session->username) {
                                  $sender = $this->lang->line('you');
                                }elseif ($t['sendername'] == null) {
                                  $sender = $this->lang->line('type_system');
                                }else {
                                  $sender = $t['sendername'];
                                }
                                
                                if($t['receivername'] == $this->session->username) {
                                  $rcvr = $this->lang->line('you');
                                }elseif ($t['receivername'] == null) {
                                  $rcvr = $this->lang->line('type_system');
                                }else {
                                  $rcvr = $t['receivername'];
                                }
                                
                              ?>
                              <tr role="row" class="<?php if($odd){ ?>odd<?php $odd = false; }else{ ?>even<?php $odd = true; } ?>">
                                <td class="sorting_1"><?php echo $t['actiondate'];?></td>
                                <td><?php echo $sender;?></td>
                                <td><?php echo $desc;?></td>
                                <td><?php echo $arrow.' '.rtrim(rtrim(number_format($t['amount'], 4, '.', ''), "0"), ".").' Credit';?> </td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="new-pagination" style="margin:1% auto !important;">
                        <?php echo $pagi;?>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
            <!-- </div> -->
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <?php
        include 'banner_block.php';
      ?>
    </section>
    <!-- /.content -->
  </div>
  <?php
      if(isset($_GET['fail']) || isset($_GET['t_id'])) {
    ?>
        <div class="modal fade" id="modal-payment">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('out_1');?></h4>
              </div>
              <?php
                if(isset($_GET['fail'])) {
              ?>
                  <p style="font-weight: bold; font-size: 115%; text-align:center; background-color:tomato; padding: 10px;" class="err"><?php echo $this->lang->line('the_new_trans_11');?></p>
              <?php
                }elseif(isset($_GET['t_id'])) {
              ?>
                  <p style="font-weight: bold; font-size: 115%; text-align:center; background-color:lime; padding: 10px;" class="succ"><?php echo $this->lang->line('the_new_trans_12');?></p>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
        <span id="for_modal" style="display:none;" data-toggle="modal" data-target="#modal-payment"></span>
        <script type="text/javascript">
          $('#for_modal').click();
        </script>
    <?php
      }
    ?>