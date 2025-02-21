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
        <option value="6" selected>Страница просмотра пользователей(Page for looking users)</option>
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
    <p>Страница просмотра пользователей(Page for looking users)</p>
    Search form:<br>
    <form method="post">
      <p>
        Type:
        <select name="type_us">
          <option value='empty'>reset</option>
          <option value='login'>login</option>
          <option value='id'>user id</option>
        </select>
      </p>
      <p>
        Value:<input type="text" name="val_us">
      </p>
      <input type="submit" name="Choose" value="Choose">
    </form>
    <hr>
    Add User Form:<br>
    <form method="post">
      <p>
        Login:
        <input type="text" name="login">
        <br><br>
        Sponsor:
        <select name="idsponsor">
          <?php
            for($i = 0; $i < count($users); $i++) {
          ?>
            <option value='<?php echo $users[$i]['id']; ?>'><?php echo $users[$i]['login'].'(uid - '.$users[$i]['id'].')';?></option>
          <?php
            }
          ?>
        </select>
        <br><br>
        Balance:
        <input type="text" name="balance">
      </p>
      <input type="submit" name="Create" value="Create">
    </form>
    <hr>
    <?php
      if(!empty($user)) {
        if(count($user) == 1) {
    ?>
        <p>User <?php echo $user[0]['login'].'('.$user[0]['id'].')';?></p>
    <?php
        }
    ?>
      <table border=1 style="text-align: center;">
        <tr>
          <th>ID</th>
          <th>Login</th>
          <th>Sponsor ID</th>
          <th>Main balance</th>
          <th>AD balance</th>
          <th>SPEC balance</th>
          <th>status</th>
          <th>status reinvest 1</th>
          <th>status reinvest 10</th>
          <th>status reinvest 100</th>
          <th>action</th>
        </tr>
        <?php
          if(!empty($user)) {
            for ($i=0; $i < count($user); $i++) { 
        ?>
          <tr>
            <td><?php echo $user[$i]['id'];?></td>
            <td><?php echo $user[$i]['login'];?></td>
            <td><?php echo $user[$i]['idsponsor'];?></td>
            <td><?php echo $user[$i]['amount_btc'];?></td>
            <td><?php echo $user[$i]['add_amount_btc'];?></td>
            <td><?php echo $user[$i]['rest_amount_btc'];?></td>
            <td>
              <?php
                if($user[$i]['bonus_active_status'] == 1){
                  echo 'active';
                }else {
                  echo 'not active';
                }
              ?>
            </td>
            <td>
              <?php
                if($user[$i]['reinv_1'] == 1){
                  echo 'on';
                }else {
                  echo 'off';
                }
              ?>
            </td>
            <td>
              <?php
                if($user[$i]['reinv_10'] == 1){
                  echo 'on';
                }else {
                  echo 'off';
                }
              ?>
            </td>
            <td>
              <?php
                if($user[$i]['reinv_100'] == 1){
                  echo 'on';
                }else {
                  echo 'off';
                }
              ?>
            </td>
            <td>
              <form method="post">
                <p>
                  New sposnor(uid): 
                  <input type="text" name="idsponsor">
                </p>
                <p>
                  New balance: <input type="text" name="balance">
                </p>
                <input type="hidden" name="uid" value="<?php echo $user[$i]['id']; ?>">
                <input type="submit" name="Resave" value="Save">
              </form>
            </td>
          </tr>
        <?php
            }
          }
        ?>
      </table>
    <?php
      }
    ?>
  </body>
</html>