<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Новости </h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row" style="overflow-x:auto;">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
					  <div class="x_content">

						<!-- start project list -->
						<a href="/index.php/adminpanel/add_news2" class="btn btn-success btn-block" role="button">Создание новости</a> 
						<?php if(isset($_SESSION['news_added'])): ?>
							<p class="success">Новость успешно добавлена</p>
						<?php endif; ?>
						<?php if(isset($news)): ?>
						<div style="overflow-x: auto">
							<table class="table table-striped table-responsive projects">
							  <thead>
								<tr>
								  <th>Заголовок</th>
								  <th>Содержание</th>
								  <th>Редактировать</th>
								</tr>
							  </thead>
							  <tbody>
								<?php foreach($news as $n):?>
									<tr>
									  <td><?php echo $n['title_russian'];?></td>
									  <?php
										$content = preg_replace("/<img[^>]+\>/i", "(image) ", $n['body_text_russian']);
										?>
									  <td>
										<a href="/index.php/adminpanel/news_view/<?php echo $n['id'];?>"><?php echo strlen($content) > 700 ? substr($content, 0, 700) . '...' : $content;?> </a>
									  </td>
									  <td>
										<a href="/index.php/adminpanel/news_edit2/<?php echo $n['id'];?>"><i class="fa fa-edit" style="font-size:25px;"></i> </a>
									  </td>									  
									</tr>
								<?php endforeach;?>								  
							  </tbody>
							</table>
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<ul class="pagination pagination-split">
							<?php					
								echo $this->pagination->create_links();					
							?>
                        </ul>
                      </div>
							</div>
						<?php else: ?>
							<p class="info"><i class="fa fa-info-circle"></i><?php echo $this->lang->line('no_news');?></p>
						<?php endif; ?>
						<!-- end project list -->

					  </div>
				</div>
             </div>
            </div>
            </div>
          </div>
        <!-- /page content -->