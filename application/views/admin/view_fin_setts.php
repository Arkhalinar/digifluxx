	<!-- Switchery -->
	
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Настройка кошелька</h3> 
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
              <form action="view_fin_setts" method="post">
              	<h3>Данные кошелька</h3>
                <div class="admin-row">
                  ReedCode:(<a target="_blank" href="https://bitaps.com/<?php echo $setts['ReedCode'];?>">ССЫЛКА</a>) <br>
                  <input style="width:450px;" type="text" name="ReedCode" value="<?php echo $setts['ReedCode'];?>">
                </div>
                <div class="admin-row">
                  Addr:(<a target="_blank" href="https://bitaps.com/<?php echo $setts['Addr'];?>">ССЫЛКА</a>) <br>
                  <input style="width:450px;" type="text" name="Addr" value="<?php echo $setts['Addr'];?>">
                </div>
                <div class="admin-row">  
                  Inv: <br>
                  <input style="width:450px;" type="text" name="Inv" value="<?php echo $setts['Inv'];?>">
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
