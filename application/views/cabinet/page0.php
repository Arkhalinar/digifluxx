  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mycomp" style="position: relative;">
    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php"
    ?>

    <script type="text/javascript">
      function create_hystory(data) {

        $('.table_scroll_adap').slideUp('normal');

        //распарсили значения
        lvl = data.data.lvl;
        id = data.data.id;

        if($('#is_open_'+lvl+'_'+id).val() == 0) {

          //отправили аякс для подгрузки всей истории
          $.post(
            '/cabinet/page4/'+lvl+'_'+id,
            {},
            function(data) {

              // console.log(data);

              //вставили историю
              $('#spec_hist_table').html(data);
              $('.table_scroll_adap').slideDown('normal');

              $('.is_open').val(0);
              $('#is_open_'+lvl+'_'+id).val(1);
            }
          );

        }else {
          $('#is_open_'+lvl+'_'+id).val(0);
        }

      }

    </script>

      <div class="limit prog-page">
        <div class="row-content">
          <div class="list-prog">
            <button class="gold-btn" onclick="document.location.href='/cabinet/page0'"><?php echo $this->lang->line('bonus_p_1');?></button>
            <button onclick="document.location.href='/cabinet/page1'"><?php echo $this->lang->line('bonus_p_2');?></button>
            <button onclick="document.location.href='/cabinet/page2'"><?php echo $this->lang->line('bonus_p_3');?></button>
            <button onclick="document.location.href='/cabinet/page3'"><?php echo $this->lang->line('bonus_p_4');?></button>
          </div>
          <?php
              if(count($user_scales) > 0) {
          ?>
              <div class="all-filter">
                <div class="title-filter">
                  <img src="/assets/img/filter.png"> <?php echo $this->lang->line('bonus_sort');?>
                </div>
                <div class="select-filter">
                  <form>
                    <select id="sel_filter">
                      <option value="all"><?php echo $this->lang->line('bonus_sort_0');?></option>
                      <option value="active" <?php if($type == 'active'){ ?>selected<?php } ?>><?php echo $this->lang->line('bonus_sort_1');?></option>
                      <option value="closed" <?php if($type == 'closed'){ ?>selected<?php } ?>><?php echo $this->lang->line('bonus_sort_2');?></option>
                    </select>
                    <script type="text/javascript">
                      $('#sel_filter').on('change', function(){
                        document.location.href = '/cabinet/page0/'+$('#sel_filter').val();
                      })
                    </script>
                  </form>
                </div>
              </div>
          <?php
              }
          ?>
        </div>
        <div class="row-content no-auto">
          <div class="left-col">
            <h3><?php echo $this->lang->line('bonus_ph_1');?></h3>
            <?php
              if(count($user_scales) > 0) {
                foreach ($user_scales as $key => $value) {
            ?>
                  <div class="block-prog">
                    <div class="prog-standart">
                      <b><?php echo $this->lang->line('bonus_ph_lvl');?> <?php echo $key;?></b> <span><?php echo $this->lang->line('bonus_ph_zie');?>: 1000 C-Points / <?php $info = json_decode($mark_setts['lvl_'.$key]); echo $info->sh_konto;?> Credit</span>
                    </div>
                    <div class="block-timeline">
                      <?php
                        foreach ($value['scales'] as $key2 => $value2) {
                      ?>
                        <div class="line-top-text">
                        <?php
                          if($value2['status'] == 1 && $user_info['date_end_activation'] != 0 && time()-$user_info['date_end_activation'] < 0) {
                            echo '<span title="'.$this->lang->line('page0_mess_12').'">№'.(+$value2['num_in_row']+1).'</span> <span title="'.$this->lang->line('page0_mess_13').'">('.(+$value2['num_in_row_at_all']+1).')</span>';
                          }elseif($value2['status'] == 1) {
                            echo '<span title="'.$this->lang->line('page0_mess_12').'">№'.(+$value2['num_in_row_at_all']+1).'</span> <span title="'.$this->lang->line('page0_mess_13').'">('.(+$value2['num_in_row_at_all']+1).')</span>';
                          }
                        ?></div>
                        <div class="timeline" id="scale_<?php echo $key;?>_<?php echo $value2['id'];?>">
                          <div class="text-time">
                            <input type="hidden" name="is_open" class="is_open" id="is_open_<?php echo $key;?>_<?php echo $value2['id'];?>" value="0">
                            <div class="done" style="width: <?php if($value2['current_sum'] != 0){echo bcmul(100, bcdiv($value2['current_sum'], $value2['max_sum'], 2), 2);}else{echo 0;}?>%;"></div>
                            <?php if($value2['current_sum'] != 0){echo bcmul(1000, bcdiv($value2['current_sum'], $value2['max_sum'], 5), 3)+0;}else{echo 0;}?> <?php echo $this->lang->line('bonus_cp');?>
                          </div>
                        </div>
                        <script type="text/javascript">
                          $('#scale_<?php echo $key;?>_<?php echo $value2['id'];?>').on('click', {lvl: <?php echo $key;?>, id: <?php echo $value2['id'];?>}, create_hystory);
                        </script>
                      <?php
                        }
                      ?>
                    </div>
                  </div>            
            <?php
                }
              }else {
            ?>
                  <?php
                    $user_packet_info = json_decode($user_info['packet_status'], true);

                    $packet1 = $user_packet_info['packet_1'];
                    $packet2 = $user_packet_info['packet_2'];
                    $packet3 = $user_packet_info['packet_3'];
                    $packet4 = $user_packet_info['packet_4'];

                    if($packet1 == 1) {
                  ?>
                      <br>
                      <p style="width: 50%; margin: 0 auto; color:black; font-size:125%; text-align: center; border: 1px solid black; padding: 5px; background:linear-gradient(to top, #debe37 20%, #ede286 50%, #debe37 80%)!important; "><?php echo $this->lang->line('bonusprogramm_queue');?></p>
                      <br>
                      <div style="text-align: center; font-weight: bold;">
                        <p><?php echo $this->lang->line('page0_mess_1');?></p>
                        <p><?php echo $this->lang->line('page0_mess_2');?></p>

                        <p><?php echo $this->lang->line('page0_mess_3');?></p>
                        <p><?php echo $this->lang->line('page0_mess_4');?></p>

                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_5');?></p>
                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_6');?></p>

                        <p><?php echo $this->lang->line('page0_mess_7');?></p>
                        <p><?php echo $this->lang->line('page0_mess_8');?></p>
                        <p><?php echo $this->lang->line('page0_mess_9');?></p>
                        <p><?php echo $this->lang->line('page0_mess_10');?></p>
                      </div>
                  <?php  
                    }else {

                      if(isset($_GET['false'])) {
                    ?>
                      <br>
                      <p style="color:red;text-align: center;"><?php echo $this->lang->line('new_struct_mess_2');?></p>
                      <br>
                      <div style="text-align: center; font-weight: bold;">
                        <p><?php echo $this->lang->line('page0_mess_1');?></p>
                        <p><?php echo $this->lang->line('page0_mess_2');?></p>

                        <p><?php echo $this->lang->line('page0_mess_3');?></p>
                        <p><?php echo $this->lang->line('page0_mess_4');?></p>

                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_5');?></p>
                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_6');?></p>

                        <p><?php echo $this->lang->line('page0_mess_7');?></p>
                        <p><?php echo $this->lang->line('page0_mess_8');?></p>
                        <p><?php echo $this->lang->line('page0_mess_9');?></p>
                        <p><?php echo $this->lang->line('page0_mess_10');?></p>
                      </div>
                    <?php
                      }
                    ?>
                    <div class="list-prog">
                      <button class="gold-btn" onclick="document.location.href='/cabinet/buyplace/1'"><?php echo $this->lang->line('bonus_buy');?> (<?php echo $info = json_decode($mark_setts['packet_1']); echo $info->all_sum;?> Credit)</button>
                    </div>
                    <div style="text-align: center; font-weight: bold;">
                        <p><?php echo $this->lang->line('page0_mess_1');?></p>
                        <p><?php echo $this->lang->line('page0_mess_2');?></p>

                        <p><?php echo $this->lang->line('page0_mess_3');?></p>
                        <p><?php echo $this->lang->line('page0_mess_4');?></p>

                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_5');?></p>
                        <p style="color:blue;"><?php echo $this->lang->line('page0_mess_6');?></p>

                        <p><?php echo $this->lang->line('page0_mess_7');?></p>
                        <p><?php echo $this->lang->line('page0_mess_8');?></p>
                        <p><?php echo $this->lang->line('page0_mess_9');?></p>
                        <p><?php echo $this->lang->line('page0_mess_10');?></p>
                    </div>
            <?php
                  }
              }
            ?>
          </div>
          <div class="right-col">
              <div class="table_scroll_adap">
                <h3><?php echo $this->lang->line('bonus_his');?></h3>
                <table id="spec_hist_table" class="blueTable" role="grid" cellspacing="0" aria-describedby="example1_info">
                  
                </table>
              </div>
              <div class="block300">
                <?php
                  if(count($bans['300x250']) > 0) {
                    $current_banner = array_shift($bans['300x250']);
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
                    <a class="rek-iframe" href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img align="center" <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
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
          </div>
          <div style="clear:both;"></div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
         $('.prog-standart').click(function(){
          $(this).toggleClass('active-fon');
          $(this).next('.block-timeline').slideToggle('normal');
          return false;
         });
        });
       </script>

      <?php
        include 'banner_block.php';
      ?>
  </div>
  <script src="<?php echo base_url();?>assets/assets/js/math.js"></script>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->