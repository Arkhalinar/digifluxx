<div class="right_col" role="main">
  <h2 style="text-align: center; margin: 10% auto;"><?php echo $this->lang->line('admin_add_code_1');?></h2>
  <div class="row">
    <p style="color:lightfreen; font-weight: bold; font-size: 105%; text-align: center;">
      <?php
        if(isset($_SESSION['success'])) {
          echo $_SESSION['success'];
          unset($_SESSION['success']);
        }
      ?>
    </p>
    <form style="display: block; width: 35%; margin: 1% auto;" method="post" action="add_code">
      <div>
        <?php echo $this->lang->line('admin_add_code_2');?>
        <select name="format">
          <option value="125x125">125x125</option>
          <option value="300x250">300x250</option>
          <option value="468x60">468x60</option>
          <option value="728x90">728x90</option>
        </select>
      </div>
      <hr>
      <div>
        <?php echo $this->lang->line('admin_add_code_3');?>
        <textarea name="code"></textarea>
      </div>
      <hr>
      <input class="style-btn" type="submit" name="add" value='<?php echo $this->lang->line('admin_add_code_4');?>'>
    </form>
  </div>

</div>