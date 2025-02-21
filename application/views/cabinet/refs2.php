  <div class="content-wrapper">
    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";
    ?>


    <!-- Main content -->
    <section class="content ref-page">
      <!-- Small boxes (Stat box) -->
      <div class="limit">
        <div class="row-content ">
          <div class="description-block">
            <h3> <?php echo $this->lang->line('yo_spons');?>: <span class="sponsor-name"><?php echo $sponsor_name;?></span> </h3>
            <h5 style="text-align:left;" class="description-header"><span class="width-span">Skype:</span> <span><?php if($sponsor_skype != ''){echo $sponsor_skype;}else{echo '-';}?></span></h5>
            <h5 style="text-align:left;" class="description-header"><span class="width-span">E-mail:</span> <span><?php echo $sponsor_mail;?></span></h5>
            <h5 style="text-align:left;" class="description-header"><span class="width-span"><?php echo $this->lang->line('telephone');?>:</span> <span><?php if($sponsor_mob != ''){echo $sponsor_mob;}else{echo '-';}?></span></h5>
          </div>
        </div>
        <div class="row-content ">
          <div class="col-md-12">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs pull-right" style="text-align: center; border:none;">

                <li class="active">
                  <a href="#tab_1" data-toggle="tab" onclick="GetRefs(1, 1)" aria-expanded="true">1</a>
                </li>
                <li>
                  <a href="#tab_2" data-toggle="tab" onclick="GetRefs(2, 1)" aria-expanded="false">2</a>
                </li>
                <li>
                  <a href="#tab_3" data-toggle="tab" onclick="GetRefs(3, 1)" aria-expanded="false">3</a>
                </li>
                <li>
                  <a href="#tab_4" data-toggle="tab" onclick="GetRefs(4, 1)" aria-expanded="false">4</a>
                </li>
                <li>
                  <a href="#tab_5" data-toggle="tab" onclick="GetRefs(5, 1)" aria-expanded="false">5</a>
                </li>
                <li>
                  <a href="#tab_6" data-toggle="tab" onclick="GetRefs(6, 1)" aria-expanded="false">6</a>
                </li>
                <li>
                  <a href="#tab_7" data-toggle="tab" onclick="GetRefs(7, 1)" aria-expanded="false">7</a>
                </li>
                <li>
                  <a href="#tab_8" data-toggle="tab" onclick="GetRefs(8, 1)" aria-expanded="false">8</a>
                </li>
                <li>
                  <a href="#tab_9" data-toggle="tab" onclick="GetRefs(9, 1)" aria-expanded="false">9</a>
                </li>
                <li>
                  <a href="#tab_10" data-toggle="tab" onclick="GetRefs(10, 1)" aria-expanded="false">10</a>
                </li>
                <li>
                  <a href="#tab_11" data-toggle="tab" onclick="GetRefs(11, 1)" aria-expanded="false">11</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '1');?> <span id="for_count_1"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">E-mail</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_1">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_1" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_2">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '2');?> <span id="for_count_2"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_2">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_2" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_3">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '3');?> <span id="for_count_3"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_3">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_3" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_4">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '4');?> <span id="for_count_4"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_4">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_4" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_5">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '5');?> <span id="for_count_5"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_5">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_5" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_6">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '6');?> <span id="for_count_6"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_6">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_6" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_7">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '7');?> <span id="for_count_7"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_7">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_7" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_8">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '8');?> <span id="for_count_8"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_8">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_8" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_9">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '9');?> <span id="for_count_9"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_9">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_9" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_10">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '10');?> <span id="for_count_10"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_10">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_10" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
                <div class="tab-pane" id="tab_11">
                  <div class="row" style="color:black;">
                    <div class="col-xs-123">
                      <div class="box">
                        <div class="box-header">
                          <?php echo sprintf($this->lang->line('refs_new_1'), '11');?> <span id="for_count_11"></span>
                        </div>
                        <div class="box-body">
                          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                              <div class="col-sm-12">
                                <table id="example1" class="blueTable" role="grid" aria-describedby="example1_info">
                                  <thead>
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;"><?php echo $this->lang->line('refs_s_1');?></th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 199px;">Sponsor</th>
                                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156px;"><?php echo $this->lang->line('refs_s_2');?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_for_refs_11">
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="new-pagination" id="page_11" style="margin:1% auto !important;"></div>
                    </div>
                  </div>                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        function GetRefs(lvl, page) {
          $.post(
            '/cabinet/get_refs',
            {
              lvl: lvl,
              page: page
            },
            function(data){

              var data = JSON.parse(data);

              switch(data['page_type']) {
                case '1':
                  $('#page_'+lvl).html('');
                  break;
                case '2':
                  $('#page_'+lvl).html('<span class="active-page">1</span><span onclick="GetRefs('+lvl+', 2)">2</span>');
                  break;
                case '3':
                  $('#page_'+lvl).html('<span onclick="GetRefs('+lvl+', '+(page-1)+')">'+(page-1)+'</span><span class="active-page">'+page+'</span>');
                  break;
                case '4':
                  $('#page_'+lvl).html('<span onclick="GetRefs('+lvl+', '+(page-1)+')">'+(page-1)+'</span><span class="active-page">'+page+'</span><span onclick="GetRefs('+lvl+', '+(page+1)+')">'+(page+1)+'</span>')
                  break;
              }

              var refs_html = '';

              

              var reflinks_array = new Array();

              for (var i = 0; i < data['refs'].length; i++) {
    
                

                if(i % 2 == 1) {
                  var cls = 'odd';
                }else {
                  var cls = 'even';
                }

                if(data['refs'][i]['packet'] != 0) {
                  var packet = '<span style="color:green;">Packet '+data['refs'][i]['packet']+'</span>';
                }else {
                  var packet = '<span style="color:red;">Not active</span>';
                }

                if(lvl == 1) {

                  refs_html += '<tr role="row" class="'+cls+'"><td class="sorting_1">'+data['refs'][i]['login']+'(<span style="cursor:pointer;color:blue;" id="ref-'+data['refs'][i]['login']+'_'+data['refs'][i]['reflink']+'">reflink</span> <i style="cursor:pointer;" id="copy-'+data['refs'][i]['login']+'_'+data['refs'][i]['reflink']+'" class="fa fa-clone" aria-hidden="true" title="<?php echo $this->lang->line('copy_word');?>"></i>)</td><td>'+data['refs'][i]['value']+'</td><td>'+packet+'</td></tr>';

                  reflinks_array.push(data['refs'][i]['login']+'_'+data['refs'][i]['reflink']);

                }else {

                  refs_html += '<tr role="row" class="'+cls+'"><td class="sorting_1">'+data['refs'][i]['login']+'</td><td>'+data['refs'][i]['value']+'</td><td>'+packet+'</td></tr>';

                }
              }

              $('#tbody_for_refs_'+lvl).html(refs_html);

              $('#for_count_'+lvl).text(data['count']);

              if(lvl == 1) {

                for (var a = 0; a < reflinks_array.length; a++) {

                  actual = reflinks_array[a];

                  copyBobBtn = document.querySelector('#copy-'+reflinks_array[a]);
                  copyBobBtn.addEventListener('click', function(event) {

                    reflink = $(this).attr('id').split('_');

                    copyTextToClipboard('<?php echo base_url();?>ref/'+reflink[1]);

                  });

                  copyBobBtn = document.querySelector('#ref-'+reflinks_array[a]);
                  copyBobBtn.addEventListener('mouseover', function(event) {
  
                    id = $(this).attr('id');

                    reflink = id.split('_');

                    $('#'+id).text('<?php echo base_url();?>ref/'+reflink[1]);
                  })

                  copyBobBtn.addEventListener('mouseout', function(event) {

                    id = $(this).attr('id');

                    reflink = id.split('_');
                    
                    $('#'+id).text('reflink');
                  })

                }

              }

            }
          )
        }
        GetRefs(1, 1);
      </script>
      <?php
        include 'banner_block.php';
      ?>
    </section>
  </div>