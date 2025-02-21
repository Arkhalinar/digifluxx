<div class="right-b">
	<?php
      if(count($bans['125x125']) > 0) {
      	$current_banner = array_shift($bans['125x125']);
      	$current_banner = array_shift($bans['125x125']);
      	
        $current_banner = array_shift($bans['125x125']);

        if($current_banner['cont_type'] != 3) {
          $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
          $addstr2 = "";

          if($current_banner['cont_type'] == 2) {
            $path = json_decode($current_banner['bnr']);
          }elseif($current_banner['cont_type'] == 1) {
            $path = '/'.$current_banner['bnr'];
          }else{
            $path = '';
          }

     ?>
        <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
        <script type="text/javascript">
            <?php echo $addstr2;?>  
        </script>
    <?php
        }else {
          echo base64_decode($current_banner['bnr']);
        }
      }
    ?>

    <?php
      if(count($bans['125x125']) > 0) {
        $current_banner = array_shift($bans['125x125']);
        if($current_banner['cont_type'] != 3) {
          $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
          $addstr2 = "";

          if($current_banner['cont_type'] == 2) {
            $path = json_decode($current_banner['bnr']);
          }elseif($current_banner['cont_type'] == 1) {
            $path = '/'.$current_banner['bnr'];
          }else{
            $path = '';
          }
    ?>
        <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
        <script type="text/javascript">
            <?php echo $addstr2;?>  
        </script>
    <?php
        }else {
          echo base64_decode($current_banner['bnr']);
        }
      }
    ?>

    <?php
      if(count($bans['125x125']) > 0) {
        $current_banner = array_shift($bans['125x125']);
        if($current_banner['cont_type'] != 3) {
          $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
          $addstr2 = "";
          
          if($current_banner['cont_type'] == 2) {
            $path = json_decode($current_banner['bnr']);
          }elseif($current_banner['cont_type'] == 1) {
            $path = '/'.$current_banner['bnr'];
          }else{
            $path = '';
          }
    ?>
        <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
        <script type="text/javascript">
            <?php echo $addstr2;?>  
        </script>
    <?php
        }else {
          echo base64_decode($current_banner['bnr']);
        }
      }
    ?>

    <?php
      if(count($bans['125x125']) > 0) {
        $current_banner = array_shift($bans['125x125']);
        if($current_banner['cont_type'] != 3) {
          $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
          $addstr2 = "";

          if($current_banner['cont_type'] == 2) {
            $path = json_decode($current_banner['bnr']);
          }elseif($current_banner['cont_type'] == 1) {
            $path = '/'.$current_banner['bnr'];
          }else{
            $path = '';
          }
    ?>
        <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
        <script type="text/javascript">
            <?php echo $addstr2;?>  
        </script>
    <?php
        }else {
          echo base64_decode($current_banner['bnr']);
        }
      }
    ?>

    <?php
      if(count($bans['125x125']) > 0) {
        $current_banner = array_shift($bans['125x125']);
        if($current_banner['cont_type'] != 3) {
          $addstr1 = "onclick='ClickCount(".$current_banner['ID'].")'";
          $addstr2 = "";

          if($current_banner['cont_type'] == 2) {
            $path = json_decode($current_banner['bnr']);
          }elseif($current_banner['cont_type'] == 1) {
            $path = '/'.$current_banner['bnr'];
          }else{
            $path = '';
          }
    ?>
        <a href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
        <script type="text/javascript">
            <?php echo $addstr2;?>  
        </script>
    <?php
        }else {
          echo base64_decode($current_banner['bnr']);
        }
      }
    ?>

</div>