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
        <option value="1" selected>Таблица основных конфигурационных значений(System bills)</option>
        <option value="2">Страница просмотра уровней(Page for look levels)</option>
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
    <h2>Таблица основных конфигурационных значений(System bills)</h2>
    <div>
      <hr>
      <div>
        Stats(Статистика):
        <br>
        <br>
        Count of active scales(Количество активных шкал всего): <?php echo $active_all_scales_count;?>
        <br>
        <br>
        Count of active scales without first(Количество активных шкал без первых уровней): <?php echo $active_all_scales_count-42;?>
        <br>
        <br>
        Sum for first sales(Часть пула для первых шкал в уровнях): <?php echo bcmul($comm_bakl_for_distr, 0.25, 2);?>
        <br>
        Sum per first sales(Сумма к начислению в первую шкалу уровня): <?php echo bcdiv(bcmul($comm_bakl_for_distr, 0.25, 2), 42, 2);?>
        <br>
        <br>
        Sum for other sales(Часть пула для остальных шкал в уровнях): <?php echo bcmul($comm_bakl_for_distr, 0.75, 2);?>
        <br>
        Sum per other sales(Сумма к начислению в остальные шкалы уровня): <?php echo bcdiv(bcmul($comm_bakl_for_distr, 0.75, 2), ($active_all_scales_count-42), 2);?>
      </div>
      <hr>
      Community pool part for distribution config
      <form method="post" action="com_distr_part_pool_change">
        <select name="oper">
          <option value="+">Добавить(+ Add)</option>
          <option value="-">Снять(- Sub)</option>
        </select>
        <p>Sum: <input type="text" name="sum"></p>
        <input type="submit" name="add_to_pool">
      </form>
      <hr>
      Community pool config
      <form method="post" action="com_pool_change">
        <select name="oper">
          <option value="+">Добавить(+ Add)</option>
          <option value="-">Снять(- Sub)</option>
        </select>
        <p>Sum: <input type="text" name="sum"></p>
        <input type="submit" name="add_to_pool">
      </form>
      <hr>
      Community pool percent
      <form method="post" action="com_perc_pool_change">
        <select name="oper">
          <option value="+">Добавить(+ Add)</option>
          <option value="-">Снять(- Sub)</option>
        </select>
        <p>Sum: <input type="text" name="sum"></p>
        <input type="submit" name="add_to_pool">
      </form>
      <hr>
    </div>
    <table border=1>
      <tr>
        <th>Название(name)</th>
        <th>Значение(value)</th>
      </tr>
      <tr>
        <td>Community Baklen pool</td>
        <td><?php echo $community_baklen; ?></td>
      </tr>
      <tr>
        <td>Community Baklen pool part for distr</td>
        <td><?php echo $comm_bakl_for_distr; ?></td>
      </tr>
      <tr>
        <td>Community Baklen pool percent</td>
        <td><?php echo $community_baklen_perc; ?></td>
      </tr>
      <tr>
        <td>Liga pool</td>
        <td><?php echo $liga_pool; ?></td>
      </tr>
      <tr>
        <td>Invest pool</td>
        <td><?php echo $invest_pool; ?></td>
      </tr>
      <tr>
        <td>Grunder pool</td>
        <td><?php echo $grunder_pool; ?></td>
      </tr>
      <tr>
        <td>Kosten</td>
        <td><?php echo $system_bill_kosten; ?></td>
      </tr>
      <tr>
        <td>Stripes payment</td>
        <td><?php echo $system_bill_sp; ?></td>
      </tr>
      <tr>
        <td>Rest (0.25)</td>
        <td><?php echo $system_bill_rest; ?></td>
      </tr>
      <tr>
        <td>Tax\mwst</td>
        <td><?php echo $system_bill_tax; ?></td>
      </tr>
      <tr>
        <td>
          Средства с командного или спонсорского начисления,<br> которые не могли быть начислены по причине<br> отсутствия спонсора в программе или отсутствия его вообще.<br>
          (Team bonus, sposnor bonus. There is no sponsor in the program or not at all.)
        </td>
        <td><?php echo $system_bill_sponsor_excess; ?></td>
      </tr>
    </table>
  </body>
</html>