  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div>
      <form action="/cabinet/addbalance" method="post" style="width: 40%; margin: 15% auto;">
        <p style="text-align: center; font-size: 120%;">Buying <?php $post_sum = $sum; echo $sum; ?> Credits (<?php $sum = bcmul($sum, $curr_arr[$type], 2); echo $sum*1; switch ($type) {
          case 'EUR':
            echo ' EUR';
            break;
          case 'BTC':
            echo ' BTC';
            break;
          case 'CDT':
            echo ' Main Balance';
            break;
        } ?>) </p>
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="hidden" name="sum" value="<?php echo $post_sum; ?>">
        <input style="display:block; width: 20%; margin: 1% auto;" type="submit" name="Add" value="Buy">
      </form>
    </div>
  </div>
</div>
<!-- ./wrapper -->