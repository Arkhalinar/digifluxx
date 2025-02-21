<!DOCTYPE html>
<html style="height: 100vh;">
  <head>
    <title>Testing</title>
     <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  </head>
  <body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <p>
      Выберите страницу(choose the page): <br>
      <select name="pages">
        <option value="1">Конфигурационная страница(System bills)</option>
        <option value="2" selected>Страница просмотра уровней(Page for look levels)</option>
        <option value="3">Страница просмотра основной истории(Page of main history)</option>
        <option value="4">Страница просмотра истории шкал(Page of special history)</option>
        <option value="5">Страница управления(Page for actions)</option>
        <option value="6">Страница просмотра пользователей(Page for looking users)</option>
        <option value="7">Страница конфигурации маркетинга(Page for marketing configuration)</option>
        <option value="8">Adminpanel</option>
      </select>
      <script type="text/javascript">
        $('select[name=pages]').on('change', function(){
          var val = $('select[name=pages]').val();
          if(val == 1) {
            document.location.href='/marketing_test/conf_page';
          }else if(val == 2) {
            document.location.href='/marketing_test/look_lvl';
          }else if(val == 3) {
            document.location.href='/marketing_test/hyst_page';
          }else if(val == 4) {
            document.location.href='/marketing_test/spec_hyst_page';
          }else if(val == 5) {
            document.location.href='/marketing_test/panel_page';
          }else if(val == 6) {
            document.location.href='/marketing_test/user_page';
          }else if(val == 7) {
            document.location.href='/marketing_test/mark_setts_page';
          }else if(val == 8) {
            document.location.href='/adminpanel/';
          }
        })
      </script>
    </p>
    <hr>
    <h2>Page for look levels (all - <?php echo $scales['all']; ?> | active - <?php echo $scales['active']; ?> | closed - <?php echo $scales['closed']; ?>)</h2>
    <form style="display:none;" method="post">
      <p>
        Level:
        <select name="lvl">
          <option value="1" <?php if(!isset($_SESSION['lvl']) || $_SESSION['lvl'] == 1){echo 'selected';}?>>1</option>
          <option value="2" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 2){echo 'selected';}?>>2</option>
          <option value="3" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 3){echo 'selected';}?>>3</option>
          <option value="4" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 4){echo 'selected';}?>>4</option>
          <option value="5" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 5){echo 'selected';}?>>5</option>
          <option value="6" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 6){echo 'selected';}?>>6</option>
          <option value="7" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 7){echo 'selected';}?>>7</option>
          <option value="7" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 8){echo 'selected';}?>>8</option>
          <option value="7" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 9){echo 'selected';}?>>9</option>
          <option value="10" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 10){echo 'selected';}?>>10</option>
          <option value="20" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 20){echo 'selected';}?>>20</option>
          <option value="30" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 30){echo 'selected';}?>>30</option>
          <option value="40" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 40){echo 'selected';}?>>40</option>
          <option value="50" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 50){echo 'selected';}?>>50</option>
          <option value="60" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 60){echo 'selected';}?>>60</option>
          <option value="60" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 70){echo 'selected';}?>>70</option>
          <option value="100" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 100){echo 'selected';}?>>100</option>
          <option value="200" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 200){echo 'selected';}?>>200</option>
          <option value="300" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 300){echo 'selected';}?>>300</option>
          <option value="400" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 400){echo 'selected';}?>>400</option>
          <option value="500" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 500){echo 'selected';}?>>500</option>
          <option value="500" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 600){echo 'selected';}?>>600</option>
          <option value="100" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 1000){echo 'selected';}?>>1000</option>
          <option value="200" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 2000){echo 'selected';}?>>2000</option>
          <option value="300" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 3000){echo 'selected';}?>>3000</option>
          <option value="400" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 4000){echo 'selected';}?>>4000</option>
          <option value="500" <?php if(isset($_SESSION['lvl']) && $_SESSION['lvl'] == 5000){echo 'selected';}?>>5000</option>
        </select>
      </p>
      <p>
        Type:
        <select name="type">
          <option value="all" <?php if(!isset($_SESSION['type']) || $_SESSION['type'] == 'all'){echo 'selected';}?>>All</option>
          <option value="1" <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '1'){echo 'selected';}?>>Only active</option>
          <option value="2" <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '2'){echo 'selected';}?>>Only closed</option>
        </select>
      </p>
      <input type="submit" name="Choose" value="Choose">
    </form>


    <script type="text/javascript">
      function create_hystory(data) {
        //распарсили значения
        lvl = data.data.lvl;
        id = data.data.id;

        //стерли событие создание истории
        $('#but_'+lvl+'_'+id).off('click', create_hystory);
        //добавили событие удаления истории
        $('#but_'+lvl+'_'+id).on('click', {lvl: lvl, id: id}, delete_hystory);
        //создали строку названия с классом для удаления
        $('#lvl_'+lvl+'_'+id).after('<tr class="table_for_delete_'+lvl+'_'+id+'" id="tr_for_hyst_'+lvl+'_'+id+'"><td colspan="2">Event</td><td colspan="2">Sum</td><td colspan="2">Date</td></tr>');
        //отправили аякс для подгрузки всей истории
        $.post(
          '/marketing_test/spec_hyst/'+lvl+'_'+id,
          {},
          function(data) {
            //вставили историю
            $('#tr_for_hyst_'+lvl+'_'+id).after(data);
          }
        );

      }

      function delete_hystory(data) {

        lvl = data.data.lvl;
        id = data.data.id;

        $('#but_'+lvl+'_'+id).off('click', delete_hystory);

        $('.table_for_delete_'+lvl+'_'+id).remove();

        $('#but_'+lvl+'_'+id).on('click', {lvl: lvl, id: id}, create_hystory);

      }
    </script>

    <hr>
    <?php

      $arr_of_lvl = [];

      for ($n=1; $n <= 42; $n++) { 
        $arr_of_lvl[] = $n;
      }
      
      $y = 0;
      foreach ( $arr_of_lvl as $key => $value) {
        $y++;

        if($y%2 == 1) {
    ?>
        <div style="width:100%; overflow: auto;">
    <?php
        }
    ?>
          <div style="float:<?php if($y%2 == 1){ ?>left<?php }elseif($y%2 == 0){ ?>right<?php } ?>; height:500px; overflow-y:scroll; width: 50%">
            <p style="float:left;">Level <?php echo $value;?> (all = <?php echo $scales[$value.'_statuses'][1]*1+$scales[$value.'_statuses'][2]*1;?> | active = <?php echo $scales[$value.'_statuses'][1]*1; ?> | closed = <?php echo $scales[$value.'_statuses'][2]*1; ?>)</p>
            <select name="filter_<?php echo $value; ?>" style="float:right;">
              <option value="0" <?php if(!isset($_SESSION['filter_'.$value]) || (isset($_SESSION['filter_'.$value]) && $_SESSION['filter_'.$value] == 0)) { ?> selected <?php } ?> >all</option>
              <option value="1" <?php if(isset($_SESSION['filter_'.$value]) && $_SESSION['filter_'.$value] == 1) { ?> selected <?php } ?> >active</option>
              <option value="2" <?php if(isset($_SESSION['filter_'.$value]) && $_SESSION['filter_'.$value] == 2) { ?> selected <?php } ?> >closed</option>
            </select>
            <script type="text/javascript">
              $('select[name=filter_<?php echo $value; ?>]').on('change', function(){
                document.location.href="/marketing_test/look_lvl/<?php echo $value; ?>_"+$('select[name=filter_<?php echo $value; ?>]').val();
              })
            </script>
            <table border=1 style="float:left; text-align: center; width:100%;">
              <tr>
                <th style="width:10%;">ID at table</th>
                <th style="width:30%;">User ID (sponsor ID)</th>
                <th style="width:10%;">Scale ID</th>
                <th style="width:30%;">Curr. sum / Max sum</th>
                <th style="width:10%;">Status</th>
                <th style="width:10%;">Look Hystory</th>
              </tr>

              <?php
                for($i = 0; $i < count($scales[$value]); $i++) {

                  if(isset($_SESSION['filter_'.$value]) && $_SESSION['filter_'.$value] == 1 && $scales[$value][$i]['status'] == 2) { continue; }

                  if(isset($_SESSION['filter_'.$value]) && $_SESSION['filter_'.$value] == 2 && $scales[$value][$i]['status'] == 1) { continue; }

              ?>
                <tr id="lvl_<?php echo $value; ?>_<?php echo $scales[$value][$i]['id'];?>">
                  <td><?php echo $scales[$value][$i]['id'];?></td>
                  <td><?php echo $scales[$value][$i]['uid'].' ('.$scales[$value][$i]['idsponsor'].')';?></td>
                  <td><?php echo $scales[$value][$i]['scid'];?></td>
                  <td><?php echo $scales[$value][$i]['current_sum'];?> / <?php echo $scales[$value][$i]['max_sum'];?></td>
                  <td>
                  <?php
                    if($scales[$value][$i]['status'] == 1) {
                      echo '<b style="color:green">active</b>';
                    }else{
                      echo '<b style="color:red">closed</b>';
                    }
                  ?>
                  </td>
                  <td>
                    <button id="but_<?php echo $value; ?>_<?php echo $scales[$value][$i]['id'];?>">Look</button>
                    <script type="text/javascript">
                      $('#but_<?php echo $value; ?>_<?php echo $scales[$value][$i]['id'];?>').on('click', {lvl: <?php echo $value; ?>, id: <?php echo $scales[$value][$i]['id'];?>}, create_hystory);
                    </script>
                    <?php
                      if($scales[$value][$i]['status'] == 1) {
                    ?>
                    <hr>
                    <form method="post">
                      <input type="hidden" name="curr_value" value="<?php echo $value; ?>_<?php echo $scales[$value][$i]['scid'];?>_<?php echo $scales[$value][$i]['uid'];?>">
                      <input style="width: 50%;" type="text" name="curr_sum" value=""><br><br>
                      <input type="submit" name="Save_Curr_Sum" value="Add to scale">
                    </form>
                    <?php
                    }
                    ?>
                  </td>
                </tr>
              <?php
                }
              ?>
            </table>
          </div>
    <?php
        if($y%2 == 0) {
    ?>
        </div>
        <hr>
    <?php
        }
      }
    ?>
  </body>
</html>