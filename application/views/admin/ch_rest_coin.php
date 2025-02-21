	<!-- Switchery -->
	
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Форма снятия коинов</h3> 
          <hr>
          <h2>Текущий баланс: <span style="font-weight: bold; font-size: 130%; color: black;"><?php echo $Cur_Coin_bal;?></span></h2> 
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <?php if(isset($_SESSION['error'])){ ?>
          <p class="error"><?php echo $_SESSION['error'];unset($_SESSION['error']);?></p>
          <?php }elseif(isset($_SESSION['success'])){ ?>
          <p class="success"><?php echo $_SESSION['success'];unset($_SESSION['success']);?></p>
          <?php } ?>
          <form action="https://folk-co.in/adminpanel/ch_rest_coin" class="form-horizontal form-label-left" method="post" id="form_sub_coins">
            <input type="text" name="new_coin_val">
            <button onclick="$('#form_sub_coins').submit()" type="submit" class="btn btn-success">Снять</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>Форма активации автоснятия</h3>
          <hr>
          <h2>Текущий статус задачи: <span style="font-weight: bold; font-size: 130%; color: black;"><?php echo $Status;?></span></h2> 
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <?php if(isset($_SESSION['error2'])){ ?>
          <p class="error"><?php echo $_SESSION['error2'];unset($_SESSION['error2']);?></p>
          <?php }elseif(isset($_SESSION['success2'])){ ?>
          <p class="success"><?php echo $_SESSION['success2'];unset($_SESSION['success2']);?></p>
          <?php } ?>
          <form action="https://folk-co.in/adminpanel/ch_active_cron" class="form-horizontal form-label-left" method="post" id="form_sub_coins">
            Статус: <input type="checkbox" name="status" <?php if($Status == 'Включено'){ ?>checked<?php } ?>><br><br>
            Минимально минут(кратно 5): <input type="text" name="min_min" value="<?php echo $Min_min;?>"><br><br>
            Максимально минут(кратно 5): <input type="text" name="max_min" value="<?php echo $Max_min;?>"><br><br>
            Минимально коинов: <input type="text" name="min_coin" value="<?php echo $Min_coin;?>"><br><br>
            Максимально коинов: <input type="text" name="max_coin" value="<?php echo $Max_coin;?>"><br><br>
            <button onclick="$('#form_active_cron').submit()" type="submit" class="btn btn-success">Сохранить</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h3>История снятий</h3>
          <hr>
        </div>
        <div class="x_content">
          <table class="table table-striped jambo_table">
            <thead>
              <tr class="headings">
                <th class="column-title">Сумма  </th>
                <th class="column-title">Дата  </th>
                <th class="column-title">Тип  </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($transactionss as $trans):?>
                <tr class="pointer">
                  <td class=" "><?php echo $trans['Amount'];?></td>
                  <td class=" "><?php echo $trans['Date'];?> </td>
                  <td class=" ">
                    <?php if($trans['Type'] == 1):?>
                      Ручной
                    <?php elseif($trans['Type'] == 2): ?>
                      Автоматический
                    <?php  endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
