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
        <option value="3" selected>Страница просмотра основной истории(Page of main history)</option>
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
    <h2>Страница просмотра основной истории(Page of main history)</h2>
    <form method="post">
      Search by:
      <select name="type">
        <option value="0">-</option>
        <option value="1">Login</option>
        <option value="2">Sum</option>
        <option value="3">Event</option>
      </select>
      <br><br>
      <div id="res"></div>
      <br>
      <input type="submit" name="Choose" value="Choose">
    </form>
    <br><br>
    <script type="text/javascript">
      $('select[name=type]').on('change', function(){
        var val = $('select[name=type]').val();
        if(val == 1) {
          $('#res').html('Login: <input type="text" name="val">');
        }else if(val == 2) {
          $('#res').html('Sum: <input type="text" name="val">');
        }else if(val == 3) {
          $('#res').html('Event: <select name="val"><option value="1999">Buying packet 1</option><option value="2999">Buying packet 2</option><option value="3999">Buying packet 3</option><option value="4999">Activation for 30 days(1 packet)</option><option value="5999">Activation for 30 days(2 packet)</option><option value="6999">Activation for 30 days(3 packet)</option><option value="7999">Activation for 300 days(1 packet)</option><option value="8999">Activation for 300 days(2 packet)</option><option value="9999">Activation for 300 days(3 packet)</option><option value="8228">Refills for closed last level without reinvest</option><option value="9873">Shoping conto</option><option value="9874">cashback</option></select>');
        }
      })
    </script>
    <h???>
    <table border=1>
      <tr>
        <th>Initiator</th>
        <th>Receiver</th>
        <th>Sum</th>
        <th>Event</th>
        <th>Date</th>
      </tr>
      <?php
        if(!empty($hyst)) {
          for ($i=0; $i < count($hyst); $i++) { 
      ?>
            <tr>
              <td><?php echo $hyst[$i]['idreceiver'];?></td>
              <td><?php echo $hyst[$i]['idsender'];?></td>
              <td><?php echo $hyst[$i]['amount'];?></td>
              <td>
              <?php
                switch ($hyst[$i]['type']) {
                  case '1999':
                    echo 'Buying packet 1';
                    break;
                  case '2999':
                    echo 'Buying packet 2';
                    break;
                  case '3999':
                    echo 'Buying packet 3';
                    break;
                  case '4999':
                    echo 'Activation for 30 days(1 packet)';
                    break;
                  case '5999':
                    echo 'Activation for 30 days(2 packet)';
                    break;
                  case '6999':
                    echo 'Activation for 30 days(3 packet)';
                    break;
                  case '7999':
                    echo 'Activation for 300 days(1 packet)';
                    break;
                  case '8999':
                    echo 'Activation for 300 days(2 packet)';
                    break;
                  case '9999':
                    echo 'Activation for 300 days(3 packet)';
                    break;
                  case '8228':
                    echo 'Refills for closed last level without reinvest';
                    break;
                  case '9873':
                    echo 'Shoping conto';
                    break;
                  case '9874':
                    echo 'Cashback';
                    break;
                  default:
                    echo '???';
                    break;
                }
              ?>
              </td>
              <td><?php echo $hyst[$i]['actiondate'];?></td>
            </tr>
      <?php
          }
        }
      ?>
    </table>
  </body>
</html>