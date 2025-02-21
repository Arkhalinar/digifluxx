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
        <option value="2">Страница просмотра уровней(Page for look levels)</option>
        <option value="3">Страница просмотра основной истории(Page of main history)</option>
        <option value="4">Страница просмотра истории шкал(Page of special history)</option>
        <option value="5">Страница управления(Page for actions)</option>
        <option value="6">Страница просмотра пользователей(Page for looking users)</option>
        <option value="7" selected>Страница конфигурации маркетинга(Page for marketing configuration)</option>
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
    <h2>Page for config marketing</h2>

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
    Choose the configs
    <select id="conf_for_choosing">
      <option value="-">-</option>
      <?php
          foreach ($setts as $key => $value) {
            if(in_array($key, ['bonus_1', 'bonus_2', 'bonus_3', 'bonus_4', 'inside_outside_curs'])) {
              continue;
            }
            $actual_info = json_decode($value);
      ?>
          <option value="<?php echo $key;?>"><?php
            switch (true) {
              case ($key == 'lvl_1'):
                echo 'Programm 1 Level 1 distribution';
                break;
              case ($key == 'lvl_2'):
                echo 'Programm 1 Level 2 distribution';
                break;
              case ($key == 'lvl_3'):
                echo 'Programm 1 Level 3 distribution';
                break;
              case ($key == 'lvl_4'):
                echo 'Programm 1 Level 4 distribution';
                break;
              case ($key == 'lvl_5'):
                echo 'Programm 1 Level 5 distribution';
                break;
              case ($key == 'lvl_6'):
                echo 'Programm 1 Level 6 distribution';
                break;
              case ($key == 'lvl_7'):
                echo 'Programm 1 Level 7 distribution';
                break;
              case ($key == 'lvl_8'):
                echo 'Programm 1 Level 8 distribution';
                break;
              case ($key == 'lvl_9'):
                echo 'Programm 1 Level 9 distribution';
                break;
              case ($key == 'lvl_10'):
                echo 'Programm 1 Level 10 distribution';
                break;
              case ($key == 'lvl_11'):
                echo 'Programm 1 Level 11 distribution';
                break;
              case ($key == 'lvl_12'):
                echo 'Programm 1 Level 12 distribution';
                break;
              case ($key == 'lvl_13'):
                echo 'Programm 1 Level 13 distribution';
                break;
              case ($key == 'lvl_14'):
                echo 'Programm 2 Level 14 distribution';
                break;
              case ($key == 'lvl_15'):
                echo 'Programm 2 Level 15 distribution';
                break;
              case ($key == 'lvl_16'):
                echo 'Programm 2 Level 16 distribution';
                break;
              case ($key == 'lvl_17'):
                echo 'Programm 2 Level 17 distribution';
                break;
              case ($key == 'lvl_18'):
                echo 'Programm 2 Level 18 distribution';
                break;
              case ($key == 'lvl_19'):
                echo 'Programm 2 Level 19 distribution';
                break;
              case ($key == 'lvl_20'):
                echo 'Programm 2 Level 20 distribution';
                break;
              case ($key == 'lvl_21'):
                echo 'Programm 2 Level 21 distribution';
                break;
              case ($key == 'lvl_22'):
                echo 'Programm 2 Level 22 distribution';
                break;
              case ($key == 'lvl_23'):
                echo 'Programm 2 Level 23 distribution';
                break;
              case ($key == 'lvl_24'):
                echo 'Programm 2 Level 24 distribution';
                break;
              case ($key == 'lvl_25'):
                echo 'Programm 3 Level 25 distribution';
                break;
              case ($key == 'lvl_26'):
                echo 'Programm 3 Level 26 distribution';
                break;
              case ($key == 'lvl_27'):
                echo 'Programm 3 Level 27 distribution';
                break;
              case ($key == 'lvl_28'):
                echo 'Programm 3 Level 28 distribution';
                break;
              case ($key == 'lvl_29'):
                echo 'Programm 3 Level 29 distribution';
                break;
              case ($key == 'lvl_30'):
                echo 'Programm 3 Level 30 distribution';
                break;
              case ($key == 'lvl_31'):
                echo 'Programm 3 Level 31 distribution';
                break;
              case ($key == 'lvl_32'):
                echo 'Programm 3 Level 32 distribution';
                break;
              case ($key == 'lvl_33'):
                echo 'Programm 3 Level 33 distribution';
                break;
              case ($key == 'lvl_34'):
                echo 'Programm 4 Level 34 distribution';
                break;
              case ($key == 'lvl_35'):
                echo 'Programm 4 Level 35 distribution';
                break;
              case ($key == 'lvl_36'):
                echo 'Programm 4 Level 36 distribution';
                break;
              case ($key == 'lvl_37'):
                echo 'Programm 4 Level 37 distribution';
                break;
              case ($key == 'lvl_38'):
                echo 'Programm 4 Level 38 distribution';
                break;
              case ($key == 'lvl_39'):
                echo 'Programm 4 Level 39 distribution';
                break;
              case ($key == 'lvl_40'):
                echo 'Programm 4 Level 40 distribution';
                break;
              case ($key == 'lvl_41'):
                echo 'Programm 4 Level 41 distribution';
                break;
              case ($key == 'lvl_42'):
                echo 'Programm 4 Level 42 distribution';
                break;
              case ($key == 'packet_1'):
                echo 'Buying packet 1 distribution';
                break;
              case ($key == 'packet_2'):
                echo 'Buying packet 2 distribution';
                break;
              case ($key == 'packet_3'):
                echo 'Buying packet 3 distribution';
                break;
              case ($key == 'packet_4'):
                echo 'Buying packet 4 distribution';
                break;
              case ($key == 'active_1'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_2'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_3'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_4'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_5'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_1_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_2_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_3_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_4_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_5_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case (strpos($key, 'category_') === 0):
                $InfoArr = explode('_', $key);
                echo 'Category '.$categs[$InfoArr[2]].'  price ('.$InfoArr[1].')';
                break;
            }
          ?></option>
      <?php
        }
      ?>
    </select>
    <script type="text/javascript">
      $('#conf_for_choosing').on('change', function(){
        var val = $('#conf_for_choosing').val();
        if(val != '-') {
          document.location.href='/marketing_test/mark_setts_page/'+val;
        }
      })
    </script>
    <hr>
    <?php

      if($type != '') {

        $value = $key = $type;

        $actual_info = json_decode($setts[$value]);

    ?>
        <div style="width:100%; overflow: auto;">
          <div>
            <p><?php
            switch (true) {
              case ($key == 'lvl_1'):
                echo 'Programm 1 Level 1 distribution';
                break;
              case ($key == 'lvl_2'):
                echo 'Programm 1 Level 2 distribution';
                break;
              case ($key == 'lvl_3'):
                echo 'Programm 1 Level 3 distribution';
                break;
              case ($key == 'lvl_4'):
                echo 'Programm 1 Level 4 distribution';
                break;
              case ($key == 'lvl_5'):
                echo 'Programm 1 Level 5 distribution';
                break;
              case ($key == 'lvl_6'):
                echo 'Programm 1 Level 6 distribution';
                break;
              case ($key == 'lvl_7'):
                echo 'Programm 1 Level 7 distribution';
                break;
              case ($key == 'lvl_8'):
                echo 'Programm 1 Level 8 distribution';
                break;
              case ($key == 'lvl_9'):
                echo 'Programm 1 Level 9 distribution';
                break;
              case ($key == 'lvl_10'):
                echo 'Programm 1 Level 10 distribution';
                break;
              case ($key == 'lvl_11'):
                echo 'Programm 1 Level 11 distribution';
                break;
              case ($key == 'lvl_12'):
                echo 'Programm 1 Level 12 distribution';
                break;
              case ($key == 'lvl_13'):
                echo 'Programm 1 Level 13 distribution';
                break;
              case ($key == 'lvl_14'):
                echo 'Programm 2 Level 14 distribution';
                break;
              case ($key == 'lvl_15'):
                echo 'Programm 2 Level 15 distribution';
                break;
              case ($key == 'lvl_16'):
                echo 'Programm 2 Level 16 distribution';
                break;
              case ($key == 'lvl_17'):
                echo 'Programm 2 Level 17 distribution';
                break;
              case ($key == 'lvl_18'):
                echo 'Programm 2 Level 18 distribution';
                break;
              case ($key == 'lvl_19'):
                echo 'Programm 2 Level 19 distribution';
                break;
              case ($key == 'lvl_20'):
                echo 'Programm 2 Level 20 distribution';
                break;
              case ($key == 'lvl_21'):
                echo 'Programm 2 Level 21 distribution';
                break;
              case ($key == 'lvl_22'):
                echo 'Programm 2 Level 22 distribution';
                break;
              case ($key == 'lvl_23'):
                echo 'Programm 2 Level 23 distribution';
                break;
              case ($key == 'lvl_24'):
                echo 'Programm 2 Level 24 distribution';
                break;
              case ($key == 'lvl_25'):
                echo 'Programm 3 Level 25 distribution';
                break;
              case ($key == 'lvl_26'):
                echo 'Programm 3 Level 26 distribution';
                break;
              case ($key == 'lvl_27'):
                echo 'Programm 3 Level 27 distribution';
                break;
              case ($key == 'lvl_28'):
                echo 'Programm 3 Level 28 distribution';
                break;
              case ($key == 'lvl_29'):
                echo 'Programm 3 Level 29 distribution';
                break;
              case ($key == 'lvl_30'):
                echo 'Programm 3 Level 30 distribution';
                break;
              case ($key == 'lvl_31'):
                echo 'Programm 3 Level 31 distribution';
                break;
              case ($key == 'lvl_32'):
                echo 'Programm 3 Level 32 distribution';
                break;
              case ($key == 'lvl_33'):
                echo 'Programm 3 Level 33 distribution';
                break;
              case ($key == 'lvl_34'):
                echo 'Programm 4 Level 34 distribution';
                break;
              case ($key == 'lvl_35'):
                echo 'Programm 4 Level 35 distribution';
                break;
              case ($key == 'lvl_36'):
                echo 'Programm 4 Level 36 distribution';
                break;
              case ($key == 'lvl_37'):
                echo 'Programm 4 Level 37 distribution';
                break;
              case ($key == 'lvl_38'):
                echo 'Programm 4 Level 38 distribution';
                break;
              case ($key == 'lvl_39'):
                echo 'Programm 4 Level 39 distribution';
                break;
              case ($key == 'lvl_40'):
                echo 'Programm 4 Level 40 distribution';
                break;
              case ($key == 'lvl_41'):
                echo 'Programm 4 Level 41 distribution';
                break;
              case ($key == 'lvl_42'):
                echo 'Programm 4 Level 42 distribution';
                break;
              case ($key == 'packet_1'):
                echo 'Buying packet 1 distribution';
                break;
              case ($key == 'packet_2'):
                echo 'Buying packet 2 distribution';
                break;
              case ($key == 'packet_3'):
                echo 'Buying packet 3 distribution';
                break;
              case ($key == 'packet_4'):
                echo 'Buying packet 4 distribution';
                break;
              case ($key == 'active_1'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_2'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_3'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_4'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_5'):
                echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_1_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_2_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_3_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_4_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case ($key == 'active_5_1'):
                echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                break;
              case (strpos($key, 'category_') === 0):
                $InfoArr = explode('_', $key);
                echo 'Category '.$categs[$InfoArr[2]].'  price ('.$InfoArr[1].')';
                break;
            }
          ?></p>
            <div style="overflow-y:scroll; height:500px;">
              <table border=1 style="float:left; text-align: center; width:100%;">
                <tr>
                  <th style="width:10%;">Type</th>
                  <th style="width:30%;">Value</th>
                </tr>
                  <tr>
                    <td>
                      up scale refills
                      <form method="post">
                        <input type="hidden" name="type" value="<?php echo $value;?>">
                    </td>
                    <td>
                      <table style="margin: 0 auto;">
                        <?php
                          $all_sum = 0;
                          for($i = 1; $i <= 42; $i++) {
                        ?>
                            <tr>
                              <td>Level <?php echo $i;?></td>
                              <td>
                                <input type="text" name="lvl_<?php echo $i;?>" value="<?php if(isset($actual_info->scales_for_up->$i)){echo $actual_info->scales_for_up->$i; $all_sum += $actual_info->scales_for_up->$i;}else{echo 0;} ?>">
                              </td>
                            </tr>
                        <?php
                          }
                        ?>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>shoping konto</td>
                    <td><input type="text" name="sh_konto" value="<?php echo $actual_info->sh_konto; $all_sum += $actual_info->sh_konto;?>"></td>
                  </tr>
                  <tr>
                    <td>sponsor bonus</td>
                    <td><input type="text" name="sponsor" value="<?php echo $actual_info->sponsor; $all_sum += $actual_info->sponsor;?>"></td>
                  </tr>
                  <tr>
                    <td>team bonus</td>
                    <td><input type="text" name="team" value="<?php echo $actual_info->team;  $all_sum += $actual_info->team;?>"></td>
                  </tr>
                  <tr>
                    <td>grunder pool</td>
                    <td><input type="text" name="grunder_pool" value="<?php echo $actual_info->grunder_pool;  $all_sum += $actual_info->grunder_pool;?>"></td>
                  </tr>
                  <tr>
                    <td>liga pool</td>
                    <td><input type="text" name="liga_pool" value="<?php echo $actual_info->liga_pool; $all_sum += $actual_info->liga_pool;?>"></td>
                  </tr>
                  <tr>
                    <td>community baklen pool</td>
                    <td><input type="text" name="comm_back_pool" value="<?php echo $actual_info->comm_back_pool; $all_sum += $actual_info->comm_back_pool;?>"></td>
                  </tr>
                  <tr>
                    <td>system bill</td>
                    <td><input type="text" name="system" value="<?php echo $actual_info->system; $all_sum += $actual_info->system;?>"></td>
                  </tr>
                  <tr>
                    <td>invest pool</td>
                    <td><input type="text" name="invest_pool" value="<?php echo $actual_info->invest_pool; $all_sum += $actual_info->invest_pool;?>"></td>
                  </tr>
                  <tr>
                    <td>cashback</td>
                    <td><input type="text" name="cashback" value="<?php echo $actual_info->cashback; $all_sum += $actual_info->cashback;?>"></td>
                  </tr>
                  <tr>
                    <td>tax</td>
                    <td><input type="text" name="tax" value="<?php echo $actual_info->tax; $all_sum += $actual_info->tax;?>"></td>
                  </tr>
                  <tr>
                    <td>stripes payment</td>
                    <td><input type="text" name="stripes payment" value="<?php echo $actual_info->stripes_payment; $all_sum += $actual_info->stripes_payment;?>"></td>
                  </tr>
                  <tr>
                    <td>rest</td>
                    <td><input type="text" name="rest" value="<?php echo $actual_info->rest; $all_sum += $actual_info->rest;?>"></td>
                  </tr>

                  <?php
                    if(isset($actual_info->adding_count)) {
                  ?>
                      <tr>
                        <td>adding count</td>
                        <td><input type="text" name="adding_count" value="<?php echo $actual_info->adding_count;?>"></td>
                      </tr>
                  <?php
                    }
                  ?>

                  <tr>
                    <td>all summ</td>
                    <td><?php echo $all_sum.'('.$actual_info->all_sum.')';?></td>
                  </tr>
                  <tr>
                    <td>Save configs</td>
                    <td>
                      <select name="type_of_save">
                        <option value="as_input">save</option>
                        <option value="as_copy">save as</option>
                      </select>
                      <select name="copy_as">
                        <option value="-">-</option>
                        <?php
                            foreach ($setts as $key => $value) {
                              if(in_array($key, ['bonus_1', 'bonus_2', 'bonus_3', 'bonus_4', 'inside_outside_curs'])) {
                                continue;
                              }
                              $actual_info = json_decode($value);
                        ?>
                            <option value="<?php echo $key;?>"><?php
                              switch (true) {
                                case ($key == 'lvl_1'):
                                  echo 'Programm 1 Level 1 distribution';
                                  break;
                                case ($key == 'lvl_2'):
                                  echo 'Programm 1 Level 2 distribution';
                                  break;
                                case ($key == 'lvl_3'):
                                  echo 'Programm 1 Level 3 distribution';
                                  break;
                                case ($key == 'lvl_4'):
                                  echo 'Programm 1 Level 4 distribution';
                                  break;
                                case ($key == 'lvl_5'):
                                  echo 'Programm 1 Level 5 distribution';
                                  break;
                                case ($key == 'lvl_6'):
                                  echo 'Programm 1 Level 6 distribution';
                                  break;
                                case ($key == 'lvl_7'):
                                  echo 'Programm 1 Level 7 distribution';
                                  break;
                                case ($key == 'lvl_8'):
                                  echo 'Programm 1 Level 8 distribution';
                                  break;
                                case ($key == 'lvl_9'):
                                  echo 'Programm 1 Level 9 distribution';
                                  break;
                                case ($key == 'lvl_10'):
                                  echo 'Programm 1 Level 10 distribution';
                                  break;
                                case ($key == 'lvl_11'):
                                  echo 'Programm 1 Level 11 distribution';
                                  break;
                                case ($key == 'lvl_12'):
                                  echo 'Programm 1 Level 12 distribution';
                                  break;
                                case ($key == 'lvl_13'):
                                  echo 'Programm 1 Level 13 distribution';
                                  break;
                                case ($key == 'lvl_14'):
                                  echo 'Programm 2 Level 14 distribution';
                                  break;
                                case ($key == 'lvl_15'):
                                  echo 'Programm 2 Level 15 distribution';
                                  break;
                                case ($key == 'lvl_16'):
                                  echo 'Programm 2 Level 16 distribution';
                                  break;
                                case ($key == 'lvl_17'):
                                  echo 'Programm 2 Level 17 distribution';
                                  break;
                                case ($key == 'lvl_18'):
                                  echo 'Programm 2 Level 18 distribution';
                                  break;
                                case ($key == 'lvl_19'):
                                  echo 'Programm 2 Level 19 distribution';
                                  break;
                                case ($key == 'lvl_20'):
                                  echo 'Programm 2 Level 20 distribution';
                                  break;
                                case ($key == 'lvl_21'):
                                  echo 'Programm 2 Level 21 distribution';
                                  break;
                                case ($key == 'lvl_22'):
                                  echo 'Programm 2 Level 22 distribution';
                                  break;
                                case ($key == 'lvl_23'):
                                  echo 'Programm 2 Level 23 distribution';
                                  break;
                                case ($key == 'lvl_24'):
                                  echo 'Programm 2 Level 24 distribution';
                                  break;
                                case ($key == 'lvl_25'):
                                  echo 'Programm 3 Level 25 distribution';
                                  break;
                                case ($key == 'lvl_26'):
                                  echo 'Programm 3 Level 26 distribution';
                                  break;
                                case ($key == 'lvl_27'):
                                  echo 'Programm 3 Level 27 distribution';
                                  break;
                                case ($key == 'lvl_28'):
                                  echo 'Programm 3 Level 28 distribution';
                                  break;
                                case ($key == 'lvl_29'):
                                  echo 'Programm 3 Level 29 distribution';
                                  break;
                                case ($key == 'lvl_30'):
                                  echo 'Programm 3 Level 30 distribution';
                                  break;
                                case ($key == 'lvl_31'):
                                  echo 'Programm 3 Level 31 distribution';
                                  break;
                                case ($key == 'lvl_32'):
                                  echo 'Programm 3 Level 32 distribution';
                                  break;
                                case ($key == 'lvl_33'):
                                  echo 'Programm 3 Level 33 distribution';
                                  break;
                                case ($key == 'lvl_34'):
                                  echo 'Programm 4 Level 34 distribution';
                                  break;
                                case ($key == 'lvl_35'):
                                  echo 'Programm 4 Level 35 distribution';
                                  break;
                                case ($key == 'lvl_36'):
                                  echo 'Programm 4 Level 36 distribution';
                                  break;
                                case ($key == 'lvl_37'):
                                  echo 'Programm 4 Level 37 distribution';
                                  break;
                                case ($key == 'lvl_38'):
                                  echo 'Programm 4 Level 38 distribution';
                                  break;
                                case ($key == 'lvl_39'):
                                  echo 'Programm 4 Level 39 distribution';
                                  break;
                                case ($key == 'lvl_40'):
                                  echo 'Programm 4 Level 40 distribution';
                                  break;
                                case ($key == 'lvl_41'):
                                  echo 'Programm 4 Level 41 distribution';
                                  break;
                                case ($key == 'lvl_42'):
                                  echo 'Programm 4 Level 42 distribution';
                                  break;
                                case ($key == 'packet_1'):
                                  echo 'Buying packet 1 distribution';
                                  break;
                                case ($key == 'packet_2'):
                                  echo 'Buying packet 2 distribution';
                                  break;
                                case ($key == 'packet_3'):
                                  echo 'Buying packet 3 distribution';
                                  break;
                                case ($key == 'packet_4'):
                                  echo 'Buying packet 4 distribution';
                                  break;
                                case ($key == 'active_1'):
                                  echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_2'):
                                  echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_3'):
                                  echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_4'):
                                  echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_5'):
                                  echo 'Promo packet(inside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_1_1'):
                                  echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_2_1'):
                                  echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_3_1'):
                                  echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_4_1'):
                                  echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                                  break;
                                case ($key == 'active_5_1'):
                                  echo 'Promo packet(outside) '.$actual_info->all_sum.' credits';
                                  break;
                                case (strpos($key, 'category_') === 0):
                                  $InfoArr = explode('_', $key);
                                  echo 'Category '.$categs[$InfoArr[2]].'  price ('.$InfoArr[1].')';
                                  break;
                              }
                            ?></option>
                        <?php
                          }
                        ?>
                      </select>
                        <input type="submit" name="Save">
                      </form>
                    </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
        <hr>
    <?php
      }
    ?>
  </body>
</html>