<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
        include "right-b.php";
        include "text_ads.php";
      ?>


    <div class="content">
        <div class="row-content limit">
          <?php
            if(count($news) == 0) {
          ?>
            <h2 style="text-align: center; margin-bottom:400px;"><?php echo $this->lang->line('no_news')?></h2>
          <?php
            }else {
            	if($user_info['u_lang'] == 'hungarian')  {
            		$user_info['u_lang'] = 'hungar';
            	}
              $i = 1;
            	foreach ($news as $key => $value) {
          ?>
        <div class="row-content row-news">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><?php if(isset($user_info['u_lang'])){echo $value['title_'.$user_info['u_lang']];}else{echo $value['title_english'];}?></h3>
              </div>
              <form role="form" lpformnum="1" action="#" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php if(isset($user_info['u_lang'])){echo $value['body_text_'.$user_info['u_lang']];}else{echo $value['body_text_english'];}?></label>
                  </div>
                </div>
                <div class="box-footer">
                  <?php echo $value['date_add'];?>
                </div>
              </form>
            </div>
          </div> 
        </div>
        <?php
            $i++;
        	}
        }
        ?>
        </div>
    <?php
        include 'banner_block.php';
      ?>
    </div>
  </div>
