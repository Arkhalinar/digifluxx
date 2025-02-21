<!DOCTYPE html>
<html style="height: 100vh; overflow: hidden;">
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
        <option value="5" selected>Страница управления(Page for actions)</option>
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
    <p>Страница управления(Page for actions)</p>
    <form method="post">
      <div>
        Choose the action <?php if(isset($_SESSION['resb']) && isset($_SESSION['typeb'])){ ?>(<b style="color: <?php if($_SESSION['typeb'] == 'error') {echo 'red';}elseif($_SESSION['typeb'] == 'success') {echo 'green';} ?>;"><?php echo $_SESSION['resb']; unset($_SESSION['resb']); unset($_SESSION['typeb']);?></b>)<?php } ?>
        <select name="type_action">
          <option value="0">-</option>
          <option value="1">Buy packet by user</option>
          <option value="2">Buy packet by users</option>
          <option value="3">Buy activation by user</option>
          <option value="4">Buy activation by users</option>
          <option value="6">Initiate pool distribution</option>
          <option value="5">Reset system</option>
        </select>
      </div>
      <br>
      <br>
      <div id="res"></div>
      <br>
      <input type="submit" name="Choose" value="Choose">
    </form>
    <script type="text/javascript">
      $('select[name=type_action]').on('change', function(){
        var val = $('select[name=type_action]').val();
        if(val == 1) {
          $('#res').html('Login: <input type="text" name="login"><br><br><select name="packet"><option value="1">Buy packet 1</option><option value="2">Buy packet 2</option><option value="3">Buy packet 3</option><option value="4">Buy packet 4</option></select>');
        }else if(val == 2) {
          $('#res').html('user id - from: <input type="text" name="id_begin"> to: <input type="text" name="id_end"><br><br><select name="packet"><option value="1">Buy packet 1</option><option value="2">Buy packet 2</option><option value="3">Buy packet 3</option><option value="4">Buy packet 4</option></select>');
        }else if(val == 3) {
          $('#res').html('Login: <input type="text" name="login"><br><br><select name="active"><option value="30_1">Activation 30 days(1 packet)</option><option value="30_2">Activation 30 days(2 packet)</option><option value="30_3">Activation 30 days(3 packet)</option><option value="300_1">Activation 300 days(1 packet)</option><option value="300_2">Activation 300 days(2 packet)</option><option value="300_3">Activation 300 days(3 packet)</option></select>');
        }else if(val == 4) {
          $('#res').html('Интервал ID пользователей - от: <input type="text" name="id_begin"> до: <input type="text" name="id_end"><br><br><select name="active"><option value="30_1">Activation 30 days(1 packet)</option><option value="30_2">Activation 30 days(2 packet)</option><option value="30_3">Activation 30 days(3 packet)</option><option value="300_1">Activation 300 days(1 packet)</option><option value="300_2">Activation 300 days(2 packet)</option><option value="300_3">Activation 300 days(3 packet)</option></select>');
        }else if(val == 5) {
          $('#res').html('Yes, reset system <input type="checkbox" name="restart_system" value="go">');
        }else if(val == 6) {
          $('#res').html('Pool: <select name="pool"><option value="comm_bak">Community baklen</option></select>');
          // <option value="Invest">Invest</option><option value="Liga">Liga</option><option value="Grunder">Grunder</option>
        }
      })
    </script>
    <hr>
  </body>
</html>