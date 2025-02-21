  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
      include "right-b.php";
    ?>
    <div class="text-ban">

      <?php
        include "text_ads.php";
        include "top-b.php";
      ?>

    </div>
    <div class="limit">
      
      <?php
       if(isset($show_news2) && isset($user_info['is_looked_news']) && $user_info['is_looked_news'] == 0) {
      ?>
        <div class="ser-info-block">
          <div class="close-info" title="Закрыть"> <img src="/assets/img/delete.png"> </div>
          <h3><img src="/assets/img/user-info.png">
            <?php
              if($user_info['u_lang'] == 'russian'){
               echo $show_news2['title_russian']; 
              }elseif($user_info['u_lang'] == 'german'){
               echo $show_news2['title_german'];
              }elseif($user_info['u_lang'] == 'english'){
               echo $show_news2['title_english'];
              }elseif($user_info['u_lang'] == 'hungarian'){
               echo $show_news2['title_hungar'];
              }else{
               echo $show_news2['title_english']; 
              } 
            ?>
          </h3>
          <div>
            <?php
              if($user_info['u_lang'] == 'russian'){
                echo $show_news2['body_text_russian'];
              }elseif($user_info['u_lang'] == 'german'){
                echo $show_news2['body_text_german'];
              }elseif($user_info['u_lang'] == 'english'){
                echo $show_news2['body_text_english'];
              }elseif($user_info['u_lang'] == 'hungarian'){
                echo $show_news2['body_text_hungar'];
              }else{
                echo $show_news2['body_text_english']; 
              }
            ?>
          </div>
          <script type="text/javascript">
            $(document).ready(function(){
              $( ".close-info" ).click(function() {
                $( ".ser-info-block" ).hide();
                $.post(
                  '<?php echo base_url();?>index.php/cabinet/ChStatus',
                  {
                    key: 'main_pass_jeIQdjdwjqQI',
                    method: 'i_admin_get_data'
                  },
                  function(data){}
                )
              });
            });
          </script>
        </div>
      <?php
        }
      ?>
      
      <?php
       if(isset($show_news3) && isset($user_info['is_looked_news2']) && $user_info['is_looked_news_2'] == 0) {
      ?>
        <div class="white-info-block">
          <div class="close-white-info" title="Закрыть"> <img src="/assets/img/delete.png"> </div>
          <h3><img src="/assets/img/user-info.png">
            <?php
              if($user_info['u_lang'] == 'russian'){
               echo $show_news3['title_russian']; 
              }elseif($user_info['u_lang'] == 'german'){
               echo $show_news3['title_german'];
              }elseif($user_info['u_lang'] == 'english'){
               echo $show_news3['title_english'];
              }elseif($user_info['u_lang'] == 'hungarian'){
               echo $show_news3['title_hungar'];
              }else{
               echo $show_news3['title_english']; 
              } 
            ?>
          </h3>
          <div>
            <?php
              if($user_info['u_lang'] == 'russian'){
                echo $show_news3['body_text_russian'];
              }elseif($user_info['u_lang'] == 'german'){
                echo $show_news3['body_text_german'];
              }elseif($user_info['u_lang'] == 'english'){
                echo $show_news3['body_text_english'];
              }elseif($user_info['u_lang'] == 'hungarian'){
                echo $show_news3['body_text_hungar'];
              }else{
                echo $show_news3['body_text_english']; 
              }
            ?>
          </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function(){
            $( ".close-white-info" ).click(function() {
              $( ".white-info-block" ).hide();
              $.post(
                '<?php echo base_url();?>index.php/cabinet/ChStatus2',
                {
                  key: 'main_pass_jeIQdjdwjqQI',
                  method: 'i_admin_get_data'
                },
                function(data){}
              )
            });
          });
        </script>
      <?php
        }
      ?>
      
      <script>
        
        $( ".close-white-info" ).click(function() {
          $( ".white-info-block" ).hide();
        });
      </script>


      <div class="row-content">
        <div class="referal">
          <img src="/assets/img/refer.png">
          <?php echo $this->lang->line('refs_link_head');?>: <span id="for_dbck" class="r-b"><?php echo base_url();?>ref/<?php echo $user_info['reflink'];?></span>
              <i class="fa fa-clone js-copy-bob-btn akra_bira" aria-hidden="true" title="<?php echo $this->lang->line('copy_word');?>"></i>
          <div class="user-main-info">
            <span>|</span> <?php echo $this->lang->line('index_s_18');?>: <b><?php echo $user_info['login'];?></b> <span>|</span> <?php echo $this->lang->line('index_s_17');?>: <b style="cursor:pointer;" onclick="document.location.href='/cabinet/refspage'"><?php echo $sponsor_name;?></b>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        var copyBobBtn = document.querySelector('.akra_bira')
        copyBobBtn.addEventListener('click', function(event) {
          copyTextToClipboard('<?php echo base_url();?>ref/<?php echo $user_info['reflink'];?>');
        });
        $('#for_dbck').dblclick(function(){
          var target = document.getElementById('for_dbck');
          var rng, sel;
          if (document.createRange) {
            rng = document.createRange();
            rng.selectNode(target)
            sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(rng);
          } else {
            var rng = document.body.createTextRange();
            rng.moveToElementText(target);
            rng.select();
          }
        })

       </script>

      <div class="row-content content-dashboard">
        <div class="left-dashboard">
          <p>
            <div class="big-avatar" style="cursor:pointer;" onclick="document.location.href='/cabinet/setting'">
              <img src="<?php echo base_url().$this->session->ava; ?>">
            </div>
            <div class="time-avatar">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <div class="info-avatar">
              <div></div>
              <div><?php echo $user_info['name'];?> <?php echo $user_info['lastname'];?></div>
              <div>
              <?php

                $user_packet_info = json_decode($user_info['packet_status'], true);

                $packet1 = $user_packet_info['packet_1'];
                $packet2 = $user_packet_info['packet_2'];
                $packet3 = $user_packet_info['packet_3'];
                $packet4 = $user_packet_info['packet_4'];

                if(($packet1 == 1 || $packet2 == 1 || $packet3 == 1 || $packet4 == 1) && $user_info['date_end_activation'] != 0 && time()-$user_info['date_end_activation'] < 0) {
                  $time_at_sec = $user_info['date_end_activation']-time();
                  $hour = bcdiv($time_at_sec%86400, 3600, 0);
                  $days = bcdiv($time_at_sec, 86400, 0);
                  if($hour == 0) {
                    $addstring = '';
                  }else {
                    $addstring = $this->lang->line('index_s_4');
                  }
                  $format = $this->lang->line('index_s_3').$addstring;
                  echo sprintf($format, $days, $hour).'<br><br><b style="cursor:pointer;" onclick="document.location.href=\'/cabinet/page0\'">'.$this->lang->line('index_s_2').'</b>';
                }else {
                  echo $this->lang->line('index_s_6').'<br><br><b style="cursor:pointer;" onclick="document.location.href=\'/cabinet/page0\'">'.$this->lang->line('index_s_7').'</b>';
                }
              ?></div>
            </div>
            <div class="block-stat" style="display:block; width:75%; margin: 3% auto; text-align: center;">
              <div class="level">Community bonus pool (<?php echo $mark_setts['community_baklen_perc']+0;?>%)</div>

              <div class = "progress">
                <div class = "progress-bar" role = "progressbar" aria-valuenow = "60" 
                    aria-valuemin = "0" aria-valuemax = "100" style = "width: <?php echo $mark_setts['community_baklen_perc']+0;?>%;">
                  <?php echo $mark_setts['community_baklen_perc']+0;?>%
                </div>
              </div>

              <div class="text-accunt"><?php echo $comm_pool_mess[get_cookie('lang')];?></div>
            </div>
          </p>
          <div class="name-accaunt"><?php echo $this->lang->line('index_s_1');?></div>
          <div class="all-stat-accaunt">
            <?php
              if(count($scale_1) > 0) {
                foreach ($scale_1 as $i => $value) {
                  for ($y = 0; $y < count($scale_1[$i]['scales']); $y++) { 
                    if($scale_1[$i]['scales'][$y]['status'] == 1) {
                      break 2;
                    }
                  }
                }
            ?>
              <div class="block-stat">
                <div class="level"><?php echo $this->lang->line('index_s_5');?> <?php echo $i;?></div>
                <div class="blue-text"><?php echo bcmul(bcdiv($scale_1[$i]['scales'][$y]['current_sum'], $scale_1[$i]['scales'][$y]['max_sum'], 3), 1000, 0); ?> Pkt</div>
                <div class="text-accunt"><?php echo $this->lang->line('bonus_p_1');?></div>
                <div class="btn-prog" onclick="document.location.href='/cabinet/page0'"> <i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo $this->lang->line('index_s_8');?></div>
              </div>
            <?php
              }
            ?>

            <?php
              if(count($scale_10) > 0) {
                foreach ($scale_10 as $i => $value) {
                  for ($y = 0; $y < count($scale_10[$i]['scales']); $y++) { 
                    if($scale_10[$i]['scales'][$y]['status'] == 1) {
                      break 2;
                    }
                  }
                }
            ?>
              <div class="block-stat">
                <div class="level"><?php echo $this->lang->line('index_s_5');?> <?php echo $i;?></div>
                <div class="blue-text"><?php echo bcmul(bcdiv($scale_10[$i]['scales'][$y]['current_sum'], $scale_10[$i]['scales'][$y]['max_sum'], 3), 1000, 0); ?> Pkt</div>
                <div class="text-accunt"><?php echo $this->lang->line('bonus_p_2');?></div>
                <div class="btn-prog" onclick="document.location.href='/cabinet/page1'"> <i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo $this->lang->line('index_s_8');?></div>
              </div>
            <?php
              }
            ?>
            <hr>
            <?php
              if(count($scale_100) > 0) {
                foreach ($scale_100 as $i => $value) {
                  for ($y = 0; $y < count($scale_100[$i]['scales']); $y++) { 
                    if($scale_100[$i]['scales'][$y]['status'] == 1) {
                      break 2;
                    }
                  }
                }
            ?>
              <div class="block-stat">
                <div class="level"><?php echo $this->lang->line('index_s_5');?> <?php echo $i;?></div>
                <div class="blue-text"><?php echo bcmul(bcdiv($scale_100[$i]['scales'][$y]['current_sum'], $scale_100[$i]['scales'][$y]['max_sum'], 3), 1000, 0); ?> Pkt</div>
                <div class="text-accunt"><?php echo $this->lang->line('bonus_p_3');?></div>
                <div class="btn-prog" onclick="document.location.href='/cabinet/page2'"> <i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo $this->lang->line('index_s_8');?></div>
              </div>
            <?php
              }
            ?>

             <?php
              if(count($scale_1000) > 0) {
                foreach ($scale_1000 as $i => $value) {
                  for ($y = 0; $y < count($scale_1000[$i]['scales']); $y++) { 
                    if($scale_1000[$i]['scales'][$y]['status'] == 1) {
                      break 2;
                    }
                  }
                }
            ?>
              <div class="block-stat">
                <div class="level"><?php echo $this->lang->line('index_s_5');?> <?php echo $i;?></div>
                <div class="blue-text"><?php echo bcmul(bcdiv($scale_1000[$i]['scales'][$y]['current_sum'], $scale_1000[$i]['scales'][$y]['max_sum'], 3), 1000, 0); ?> Pkt</div>
                <div class="text-accunt"><?php echo $this->lang->line('bonus_p_4');?></div>
                <div class="btn-prog" onclick="document.location.href='/cabinet/page3'"> <i class="fa fa-arrow-down" aria-hidden="true"></i> <?php echo $this->lang->line('index_s_8');?></div>
              </div>
            <?php
              }
            ?>
          </div>
          <!-- <div class="timer-block">
            <div class="name-timer"><?php echo $this->lang->line('index_s_16');?></div>
            <div class="timer">
              <?php
                if($mark_setts['date_start_program'] <= time()) {
                  $days = 0;
                  $hours = 0;
                  $mins = 0;
                  $secs = 0;
                }else {
                  $time_to_end = $mark_setts['date_start_program']-time();
                  $days = bcdiv($time_to_end, 86400, 0);
                  $for_next = $time_to_end%86400;
                  $hours = bcdiv($for_next, 3600, 0);
                  $for_next = $for_next%3600;
                  $mins = bcdiv($for_next, 60, 0);
                  $for_next = $for_next%60;
                  $secs = $for_next;
                }
              ?>
              <div class="block-time">
                  <div><?php echo $days;?></div>
                  <?php echo $this->lang->line('index_s_9');?>
              </div>
              <div class="block-time">
                  <div><?php echo $hours;?></div>
                  <?php echo $this->lang->line('index_s_10');?>
              </div>
              <div class="block-time">
                  <div><?php echo $mins;?></div>
                  <?php echo $this->lang->line('index_s_11');?>
              </div>
              <div class="block-time">
                  <div><?php echo $secs;?></div>
                  <?php echo $this->lang->line('index_s_12');?>
              </div>
            </div>
          </div> -->
          <?php
          // var_dump($show_news);exit();
           if(isset($show_news)) {
          ?>
              <div class="news-block">  
                  <div class="status-accaunt">
                    <?php echo $this->lang->line('index_s_13');?>
                  </div>
                  <?php
                    for($i = 0; $i < count($show_news); $i++) {
                  ?>
                      <div class="text-news"> 
                        <div class="name-news">
                          <?php
                            if($user_info['u_lang'] == 'russian'){
                             echo $show_news[$i]['title_russian']; 
                            }elseif($user_info['u_lang'] == 'german'){
                             echo $show_news[$i]['title_german'];
                            }elseif($user_info['u_lang'] == 'english'){
                             echo $show_news[$i]['title_english'];
                            }elseif($user_info['u_lang'] == 'hungarian'){
                             echo $show_news[$i]['title_hungar'];
                            }else{
                             echo $show_news[$i]['title_english']; 
                            } ?> | <span><?php echo $show_news[$i]['date_add'];?></span></div>
                        <div class="all-text-news"> 
                          <?php
                            if($user_info['u_lang'] == 'russian'){
                              echo mb_substr($show_news[$i]['body_text_russian'], 0, 140).'<span onclick="document.location.href=\'/cabinet/news\'" style="text-decoration:underline; cursor:pointer;">...</span>';
                            }elseif($user_info['u_lang'] == 'german'){
                              echo mb_substr($show_news[$i]['body_text_german'], 0, 140).'<span onclick="document.location.href=\'/cabinet/news\'" style="text-decoration:underline; cursor:pointer;">...</span>';
                            }elseif($user_info['u_lang'] == 'english'){
                              echo mb_substr($show_news[$i]['body_text_english'], 0, 140).'<span onclick="document.location.href=\'/cabinet/news\'" style="text-decoration:underline; cursor:pointer;">...</span>';
                            }elseif($user_info['u_lang'] == 'hungarian'){
                              echo mb_substr($show_news[$i]['body_text_hungar'], 0, 140).'<span onclick="document.location.href=\'/cabinet/news\'" style="text-decoration:underline; cursor:pointer;">...</span>';
                            }else{
                              echo mb_substr($show_news[$i]['body_text_english'], 0, 140).'<span onclick="document.location.href=\'/cabinet/news\'" style="text-decoration:underline; cursor:pointer;">...</span>';
                            }
                          ?>
                        </div>  
                      </div>  
                  <?php
                    }
                  ?>
              </div>
          <?php
           }
          ?>
        </div>
        <div class="right-dashboard">
          <div class="status-accaunt">
            <?php echo $this->lang->line('index_s_14');?>
          </div>
          <div class="table-info">
            <div class="row-table">
              <b><?php echo $this->lang->line('index_s_15');?></b>
            </div>
            <div class="row-table">
              <i class="fa fa-picture-o" aria-hidden="true"></i> <?php echo $this->lang->line('dashboard_010');?> <span class="right-num"><?php echo $user_ad_stat['ban125']+0; ?></span>
            </div>
            <div class="row-table">
              <i class="fa fa-picture-o" aria-hidden="true"></i> <?php echo $this->lang->line('dashboard_011');?> <span class="right-num"><?php echo $user_ad_stat['ban468']+0; ?></span>
            </div>
            <div class="row-table">
              <i class="fa fa-picture-o" aria-hidden="true"></i> <?php echo $this->lang->line('dashboard_012');?> <span class="right-num"> <?php echo $user_ad_stat['ban728']+0; ?></span>
            </div>
            <div class="row-table">
              <i class="fa fa-picture-o" aria-hidden="true"></i> <?php echo $this->lang->line('dashboard_013');?> <span class="right-num"><?php echo $user_ad_stat['ban300']+0; ?></span>
            </div>
            <div class="row-table">
              <i class="fa fa-align-left" aria-hidden="true"></i> Text <span class="right-num"><?php echo $user_ad_stat['mail']+0; ?></span>
            </div>
            <div class="row-table">
              <i class="fa fa-camera-retro fa-lg" aria-hidden="true"></i> Video <span class="right-num"><?php echo $user_ad_stat['vid']+0; ?></span>
            </div>
            <div class="row-table all-m">
              <i class="fa fa-bullhorn" aria-hidden="true"></i> <?php echo $this->lang->line('dashboard_016');?> <span class="right-num"><?php echo $user_ad_stat['all']+0; ?></span>
            </div>
          </div>
          <div class="dash-ban">

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
                  <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img align="center" <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
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
        </div>
      </div>
      <?php
        include 'banner_block.php';
      ?>
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->