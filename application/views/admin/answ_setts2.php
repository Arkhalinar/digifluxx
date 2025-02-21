	<!-- Switchery -->
	
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div>
      <div>
        <div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
              <p style="color:red;">
                <?php
                  if(isset($_SESSION['sett_ch_err3'])) {
                    echo $_SESSION['sett_ch_err3'];
                    unset($_SESSION['sett_ch_err3']);
                  }
                ?>
              </p>
              <p style="color:green;">
                <?php
                  if(isset($_SESSION['sett_ch_succ3'])) {
                    echo $_SESSION['sett_ch_succ3'];
                    unset($_SESSION['sett_ch_succ3']);
                  }
                ?>
              </p>
              <form action="answ_setts2" method="post">
                <div class="col-md-4">
                  <div class="block-stat-style tarif-style">
                    <h3><?php echo $this->lang->line('admin_answ_setts2_1');?></h3>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №1:<br>
                        <input type="text" name="answ_ru_1" value="<?php echo $answers[2]['russian'][1];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №2:<br>
                        <input type="text" name="answ_ru_2" value="<?php echo $answers[2]['russian'][2];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №3:<br>
                        <input type="text" name="answ_ru_3" value="<?php echo $answers[2]['russian'][3];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №4:<br>
                        <input type="text" name="answ_ru_4" value="<?php echo $answers[2]['russian'][4];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №5:<br>
                        <input type="text" name="answ_ru_5" value="<?php echo $answers[2]['russian'][5];?>">
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="block-stat-style tarif-style">
                    <h3><?php echo $this->lang->line('admin_answ_setts2_2');?></h3>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №1:<br>
                        <input type="text" name="answ_en_1" value="<?php echo $answers[2]['english'][1];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №2:<br>
                        <input type="text" name="answ_en_2" value="<?php echo $answers[2]['english'][2];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №3:<br>
                        <input type="text" name="answ_en_3" value="<?php echo $answers[2]['english'][3];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №4:<br>
                        <input type="text" name="answ_en_4" value="<?php echo $answers[2]['english'][4];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №5:<br>
                        <input type="text" name="answ_en_5" value="<?php echo $answers[2]['english'][5];?>">
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="block-stat-style tarif-style">
                    <h3><?php echo $this->lang->line('admin_answ_setts2_3');?></h3>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №1:<br>
                        <input type="text" name="answ_ger_1" value="<?php echo $answers[2]['german'][1];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №2:<br>
                        <input type="text" name="answ_ger_2" value="<?php echo $answers[2]['german'][2];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №3:<br>
                        <input type="text" name="answ_ger_3" value="<?php echo $answers[2]['german'][3];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №4:<br>
                        <input type="text" name="answ_ger_4" value="<?php echo $answers[2]['german'][4];?>">
                      </div>
                      <div class="admin-row">
                        <?php echo $this->lang->line('admin_answ_setts2_4');?> №5:<br>
                        <input type="text" name="answ_ger_5" value="<?php echo $answers[2]['german'][5];?>">
                      </div>
                  </div>
                </div>
                <input type="hidden" name="type" value="2">
                <div style="text-align: center;">
                  <input style="margin-top: 5%;" class="style-btn" type="submit" name="save" value="<?php echo $this->lang->line('admin_answ_setts2_5');?>">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
