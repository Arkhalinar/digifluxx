  <!-- Switchery -->
  
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Настройка цен внешний кодов</h3> 
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_content">
              <p style="color:red;">
                <?php
                  if(isset($_SESSION['code_ch_err'])) {
                    echo $_SESSION['code_ch_err'];
                    unset($_SESSION['code_ch_err']);
                  }
                ?>
              </p>
              <p style="color:green;">
                <?php
                  if(isset($_SESSION['code_ch_succ'])) {
                    echo $_SESSION['code_ch_succ'];
                    unset($_SESSION['code_ch_succ']);
                  }
                ?>
              </p>
              <form action="code_setts" method="post">
                <div class="admin-row">
                  Text advertise(Credit):<br>
                  <input style="width:450px;" type="text" name="prtext_ad" value="<?php echo $conf['text_ad']['sumForEarn'];?>">
                </div>
                <div class="admin-row">
                  125x125(Credit):<br>
                  <input style="width:450px;" type="text" name="pr125x125" value="<?php echo $conf['125x125']['sumForEarn'];?>">
                </div>
                <div class="admin-row">
                  300x250(Credit):<br>
                  <input style="width:450px;" type="text" name="pr300x250" value="<?php echo $conf['300x250']['sumForEarn'];?>">
                </div>
                <div class="admin-row">  
                  468x60(Credit):<br>
                  <input style="width:450px;" type="text" name="pr468x60" value="<?php echo $conf['468x60']['sumForEarn'];?>">
                </div>
                <input class="style-btn" type="submit" name="save" value="Сохранить">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
