<div class="cab-rek-block">
<?php
    if(count($bans['468x60']) > 0) {
      $current_banner = array_shift($bans['468x60']);
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
      <a class="rek-b"  href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
      <script type="text/javascript">
        $(document).ready(function(){
          if($('.mini-rek-b').css('display') == 'none') {
            <?php echo $addstr2;?>  
          }
        })
      </script>
  <?php
      }else {
        echo base64_decode($current_banner['bnr']);
      }
    }
  ?>
  <?php
    if(count($bans['468x60']) > 0) {
      $current_banner = array_shift($bans['468x60']);
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
      <a class="rek-b"  href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
      <script type="text/javascript">
        $(document).ready(function(){
          if($('.mini-rek-b').css('display') == 'none') {
            <?php echo $addstr2;?>  
          }
        })
      </script>
  <?php
      }else {
        echo base64_decode($current_banner['bnr']);
      }
    }
  ?>
  <br>
  <?php
    if(count($bans['468x60']) > 0) {
      $current_banner = array_shift($bans['468x60']);
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
      <a class="rek-b"  href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
      <script type="text/javascript">
        $(document).ready(function(){
          if($('.mini-rek-b').css('display') == 'none') {
            <?php echo $addstr2;?>  
          }
        })
      </script>
  <?php
      }else {
        echo base64_decode($current_banner['bnr']);
      }
    }
  ?>
  <?php
    if(count($bans['468x60']) > 0) {
      $current_banner = array_shift($bans['468x60']);
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
      <a class="rek-b"  href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
      <script type="text/javascript">
        $(document).ready(function(){
          if($('.mini-rek-b').css('display') == 'none') {
            <?php echo $addstr2;?>  
          }
        })
      </script>
  <?php
      }else {
        echo base64_decode($current_banner['bnr']);
      }
    }
  ?>

  <?php
    if(count($bans['300x250']) > 0) {
      $current_banner = array_shift($bans['300x250']);
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
      <a class="mini-rek-b"  href="<?php echo json_decode($current_banner['url']); ?>" target="_blank"><img <?php echo $addstr1;?> src="<?php echo $path;?>"></a>
      <script type="text/javascript">
        $(document).ready(function(){
          if($('.mini-rek-b').css('display') == 'block') {
            <?php echo $addstr2;?>  
          }
        })
      </script>
  <?php
      }else {
        echo base64_decode($current_banner['bnr']);
      }
    }
  ?>
</div>