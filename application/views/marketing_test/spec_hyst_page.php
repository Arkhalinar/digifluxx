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
        <option value="4" selected>Страница просмотра истории шкал(Page of special history)</option>
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
    <p>Страница просмотра истории шкал(Page of special history)</p>
    <form method="post">
      Search by:
      <select name="type_action">
        <option value="0">-</option>
        <option value="1">Login</option>
        <option value="2">user id</option>
        <option value="3">scale id</option>
        <option value="4">sum</option>
        <option value="5">event</option>
      </select>
      <br>
      <br>
      <div id="res"></div>
      <br>
      <input type="submit" name="Choose" value="Choose">
    </form>
    <br><br>
    <script type="text/javascript">
      $('select[name=type_action]').on('change', function(){
        var val = $('select[name=type_action]').val();
        if(val == 1) {
          $('#res').html('User: <input type="text" name="login">');
        }else if(val == 2) {
          $('#res').html('user id: <input type="text" name="uid">');
        }else if(val == 3) {
          $('#res').html('scale id: <input type="text" name="scid">');
        }else if(val == 4) {
          $('#res').html('sum: <input type="text" name="sum">');
        }else if(val == 5) {
          $('#res').html('Событие: <select name="val"><option value="1">accrual of remaining funds</option><option value="2">accrual to the upper level scale</option><option value="33">accrual of  remaining funds from sponsorship accrual to the scale</option><option value="31">accrual of remaining funds from sponsorship accrual to the scale</option><option value="32">sponsor bonus</option><option value="332">accrual of sponsorship without a sponsor</option><option value="43">accrual of balance from team accrual to the scale</option><option value="41">accrual company scale as part of team</option><option value="42">team bonus</option><option value="432">accural team funds without the existence of a sponsor in a special account of the company</option><option value="731">pool accrual Community Baklen</option><option value="732">pool accrual Invest</option><option value="733">pool accrual Liga</option><option value="734">pool accrual Grunder</option><option value="735">kosten</option><option value="736">stripes payment</option><option value="737">rest of packets and activations</option><option value="738">tax of packets and activations</option></select>');
        }
      })
    </script>
    <hr>
    <table border=1>
      <tr>
        <th>user id</th>
        <th>scale id</th>
        <th>sum</th>
        <th>event</th>
        <th>date</th>
      </tr>
      <?php
      // var_dump($hyst);exit();
        if(count($hyst) > 0) {
          for ($i=0; $i < count($hyst); $i++) { 
      ?>
            <tr>
              <td><?php echo $hyst[$i]['uid'];?></td>
              <td><?php echo $hyst[$i]['scid'];?></td>
              <td><?php echo $hyst[$i]['sum'];?></td>
              <td>
              <?php
                switch ($hyst[$i]['type']) {
                  case '1':
                    echo 'accrual of remaining funds';
                    break;
                  case '2':
                    echo 'accrual to the upper level scale';
                    break;
                  case '33':
                    echo 'accrual of  remaining funds from sponsorship accrual to the scale';
                    break;
                  case '31':
                    echo 'accrual of remaining funds from sponsorship accrual to the scale';
                    break;
                  case '32':
                    echo 'sponsor bonus';
                    break;
                  case '332':
                    echo 'accrual of sponsorship without a sponsor';
                    break;
                  case '43':
                    echo 'accrual of remaining funds from team accrual to the scale';
                    break;
                  case '41':
                    echo 'accrual company scale as part of team';
                    break;
                  case '42':
                    echo 'team bonus';
                    break;
                  case '432':
                    echo 'accural team funds without the existence of a sponsor in a special account of the company';
                    break;
                  case '731':
                    echo 'pool accrual Community Baklen';
                    break;
                  case '732':
                    echo 'pool accrual Invest';
                    break;
                  case '733':
                    echo 'pool accrual Liga';
                    break;
                  case '734':
                    echo 'pool accrual Grunder';
                    break;
                  case '735':
                    echo 'kosten';
                    break;
                  case '736':
                    echo 'stripes payment';
                    break;
                  case '737':
                    echo 'rest of packets and activations';
                    break;
                  case '738':
                    echo 'tax of packets and activations';
                    break;
                  default:
                    echo '???';
                    break;
                }
              ?>
              </td>
              <td><?php echo $hyst[$i]['date'];?></td>
            </tr>
      <?php
          }
        }
      ?>
    </table>
  </body>
</html>