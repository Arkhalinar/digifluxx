
        <div class="right_col" role="main">
          <div class="col-md-6">
            <div class="block-stat-style">
              <h5 style="text-align: right;">
                <b>Отображение бонуса в кабинете:</b>
                <button class="style-btn" onclick="document.location.href='?ch_st_cab=<?php if($setts['status_bonus_cab'] == 0){ echo 1; }else{ echo 0; } ?>'"><?php if($setts['status_bonus_cab'] == 0){ ?><i class="fas fa-eye green"></i> Включить<?php }else{ ?><i class="fas fa-eye-slash red"></i> Выключить<?php } ?></button>
              </h4>
              <div>
                <div>
                  <p style="color:red;">
                    <?php
                      if(isset($_SESSION['sett_ch_err'])) {
                        echo $_SESSION['sett_ch_err'];
                        unset($_SESSION['sett_ch_err']);
                      }
                    ?>
                  </p>
                  <p style="color:green;">
                    <?php
                      if(isset($_SESSION['sett_ch_succ'])) {
                        echo $_SESSION['sett_ch_succ'];
                        unset($_SESSION['sett_ch_succ']);
                      }
                    ?>
                  </p>
                  <form action="save_bonus_sett" method="post">
                    <div class="admin-row">
                      <span class="half">Необходимое количество для бонус 2</span>
                      <input type="text" name="bonus2_wal" value="<?php echo $setts['bonus2_wal'];?>">
                    </div>
                    <div class="admin-row">
                      <span class="half">Выплата за бонус 2</span>
                      <input type="text" name="price_for_bonus2" value="<?php echo $setts['price_for_bonus2'];?>">
                    </div>
                    <div class="text-center">
                      <input class="style-btn" type="submit" name="save" value="Сохранить">
                    </div>
                  </form>
                </div>
              </div>
              <div style="clear:both;"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="block-stat-style">
              <h5 style="text-align: right;"><b>Отображение информационного окна на главной:</b> 
              <button class="style-btn" onclick="document.location.href='?ch_st_main=<?php if($setts['status_bonus_main'] == 0){ echo 1; }else{ echo 0; } ?>'"><?php if($setts['status_bonus_main'] == 0){ ?><i class="fas fa-eye green"></i> Включить<?php }else{ ?><i class="fas fa-eye-slash red"></i> Выключить<?php } ?></button>
              </h5>
              <h5 style="text-align: right;"><b>Доступ по спец ссылке:</b> 
                <button class="style-btn" onclick="document.location.href='/adminpanel/ch_link_state?ch_st_main_link=<?php if($setts['state_link_bonus_main'] == 0){ echo 1; }else{ echo 0; } ?>'"><?php if($setts['state_link_bonus_main'] == 0){ ?><i class="fas fa-eye green"></i> Включить<?php }else{ ?><i class="fas fa-eye-slash red"></i> Выключить<?php } ?></button>
              </h5>
              <div style="display:none;" id="link_block">
                <h5 style="text-align: right;">
                  <b>Ссылка для просмотра:</b> 
                  <a class="style-btn" href="?<?php echo $setts['path_link_bonus_main']; ?>" target="_blank"><i class="fas fa-running"></i> Перейти</a>
                </h5>
              </div>
              <?php if($setts['state_link_bonus_main'] == 1) { ?>
                <script type="text/javascript">
                  $('#link_block').show();
                </script>
              <?php } ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div>
                  <p style="color:red;">
                    <?php
                      if(isset($_SESSION['sett_ch_err2'])) {
                        echo $_SESSION['sett_ch_err2'];
                        unset($_SESSION['sett_ch_err2']);
                      }
                    ?>
                  </p>
                  <p style="color:green;">
                    <?php
                      if(isset($_SESSION['sett_ch_succ2'])) {
                        echo $_SESSION['sett_ch_succ2'];
                        unset($_SESSION['sett_ch_succ2']);
                      }
                    ?>
                  </p>
                  <form action="save_time_bonus_sett" method="post">
                    <div class="admin-row">
                      <span class="half"><i class="fas fa-clock"></i> Время до показа всплывающего окна</span>
                      <input type="text" style="width: 50px;" name="time_before_show_bonus" value="<?php echo $setts['time_before_show_bonus'];?>">
                      <select name="type_time_before_show_bonus">
                        <option value="s" <?php if($setts['type_time_before_show_bonus'] == 's') { echo 'selected'; } ?>>Секунд</option>
                        <option value="m" <?php if($setts['type_time_before_show_bonus'] == 'm') { echo 'selected'; } ?>>Минут</option>
                        <option value="h" <?php if($setts['type_time_before_show_bonus'] == 'h') { echo 'selected'; } ?>>Часов</option>
                      </select>
                    </div>

                    <div class="admin-row">
                      <span><b>Конфигурация жизни cookie</b></span>
                      <select name="type_bonus_main">
                        <option value="0" <?php if($setts['type_bonus_main'] == '0') { echo 'selected'; } ?>>Время жизни 0, показ окна каждый раз.</option>
                        <option value="1" <?php if($setts['type_bonus_main'] == '1') { echo 'selected'; } ?>>Время жизни - до окончания сессии(до закрытия окна браузера)</option>
                        <option value="2" <?php if($setts['type_bonus_main'] == '2') { echo 'selected'; } ?>>Задать время жизни</option>
                      </select>
                      <script type="text/javascript">
                        $('select[name=type_bonus_main]').on('change', function(){
                          if($('select[name=type_bonus_main]').val() == '2') {
                            $('#for_time').show();
                          }else {
                            $('#for_time').hide();
                          }
                        });
                      </script>
                    </div>
                    <div id="for_time" style="display:none;">
                      <div class="admin-row">
                        <span style="text-align: left;"><b>Время жизни cookie</b></span>
                        <input type="text" name="count_bonus_main" value="<?php echo $setts['count_bonus_main'];?>">
                        <select name="type_count_bonus_main">
                          <option value="s" <?php if($setts['type_count_bonus_main'] == 's') { echo 'selected'; } ?>>Секунд</option>
                          <option value="m" <?php if($setts['type_count_bonus_main'] == 'm') { echo 'selected'; } ?>>Минут</option>
                          <option value="h" <?php if($setts['type_count_bonus_main'] == 'h') { echo 'selected'; } ?>>Часов</option>
                          <option value="d" <?php if($setts['type_count_bonus_main'] == 'd') { echo 'selected'; } ?>>Дней</option>
                        </select>
                      </div>
                    </div>
                      <?php
                        if($setts['type_bonus_main'] == '2') { 
                      ?>
                        <script type="text/javascript">
                          $('#for_time').show();
                        </script>
                      <?php
                        }
                      ?>
                    <br>
                    <div class="text-center">
                      <input class="style-btn" type="submit" name="save" value="Сохранить">
                    </div>
                  </form>
                </div>
              </div>
              <div style="clear:both;"></div>
            </div>
          </div>

        </div>
        <!-- /page content