<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php
      include "right-b.php";
      include "text_ads.php";
      include "top-b.php";
    ?>


    <section class="content rek-page">
      <div class="row limit">
        <div class=" col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img style="cursor:pointer;" onclick="window.scrollTo(0,100);$('#but_for_ch').click()" class="profile-user-img img-responsive img-circle" src="<?php echo base_url().$this->session->ava; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $this->session->username; ?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('refs_link_head');?>:</b></span>
                  <span class="name-data ref-data">
                    <span id="for_dbck" class="r-b"><?php echo base_url();?>ref/<?php echo $user_info['reflink'];?></span>
                    <i id="for_copy_s" class="fa fa-clone" aria-hidden="true" title="<?php echo $this->lang->line('copy_word');?>"></i>
                  </span>
                  <script type="text/javascript">
                      var copyBobBtn = document.querySelector('#for_copy_s');
                      copyBobBtn.addEventListener('click', function(event) {
                        copyTextToClipboard('<?php echo base_url();?>ref/<?php echo $user_info['reflink'];?>');
                      });
                    </script>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('username');?>:</b></span>
                  <span class="name-data"><a class="pull-right"><?php echo $user_info['login']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('name');?>:</b></span>
                  <span class="name-data"><a id="name_field" class="pull-right"><?php echo $user_info['name']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('last_name');?>:</b></span>
                  <span class="name-data"><a id="sname_field" class="pull-right"><?php echo $user_info['lastname']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b>E-mail:</b></span>
                  <span class="name-data"><a class="pull-right"><?php echo $user_info['email']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('mobile_num');?>:</b></span>
                  <span class="name-data"><a id="mob_field" class="pull-right"><?php echo $user_info['mobile_num']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b>Skype:</b></span>
                  <span class="name-data"><a class="pull-right" id="skype_field"><?php echo $user_info['skype']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b>Country:</b></span>
                  <span class="name-data"><a class="pull-right" id="country_field">
                  <?php
                    $country_arr = array(
                            "AX" => 'AALAND ISLANDS',
                            "AF" => 'AFGHANISTAN',
                            "AL" => 'ALBANIA',
                            "DZ" => 'ALGERIA',
                            "AS" => 'AMERICAN SAMOA',
                            "AD" => 'ANDORRA',
                            "AO" => 'ANGOLA',
                            "AI" => 'ANGUILLA',
                            "AQ" => 'ANTARCTICA',
                            "AG" => 'ANTIGUA AND BARBUDA',
                            "AR" => 'ARGENTINA',
                            "AM" => 'ARMENIA',
                            "AW" => 'ARUBA',
                            "AU" => 'AUSTRALIA',
                            "AT" => 'AUSTRIA',
                            "AZ" => 'AZERBAIJAN',
                            "BS" => 'BAHAMAS',
                            "BH" => 'BAHRAIN',
                            "BD" => 'BANGLADESH',
                            "BB" => 'BARBADOS',
                            "BY" => 'BELARUS',
                            "BE" => 'BELGIUM',
                            "BZ" => 'BELIZE',
                            "BJ" => 'BENIN',
                            "BM" => 'BERMUDA',
                            "BT" => 'BHUTAN',
                            "BO" => 'BOLIVIA',
                            "BA" => 'BOSNIA AND HERZEGOWINA',
                            "BW" => 'BOTSWANA',
                            "BV" => 'BOUVET ISLAND',
                            "BR" => 'BRAZIL',
                            "IO" => 'BRITISH INDIAN OCEAN TERRITORY',
                            "BN" => 'BRUNEI DARUSSALAM',
                            "BG" => 'BULGARIA',
                            "BF" => 'BURKINA FASO',
                            "BI" => 'BURUNDI',
                            "KH" => 'CAMBODIA',
                            "CM" => 'CAMEROON',
                            "CA" => 'CANADA',
                            "CV" => 'CAPE VERDE',
                            "KY" => 'CAYMAN ISLANDS',
                            "CF" => 'CENTRAL AFRICAN REPUBLIC',
                            "TD" => 'CHAD',
                            "CL" => 'CHILE',
                            "CN" => 'CHINA',
                            "CX" => 'CHRISTMAS ISLAND',
                            "CO" => 'COLOMBIA',
                            "KM" => 'COMOROS',
                            "CK" => 'COOK ISLANDS',
                            "CR" => 'COSTA RICA',
                            "CI" => 'COTE D`IVOIRE',
                            "CU" => 'CUBA',
                            "CY" => 'CYPRUS',
                            "CZ" => 'CZECH REPUBLIC',
                            "DK" => 'DENMARK',
                            "DJ" => 'DJIBOUTI',
                            "DM" => 'DOMINICA',
                            "DO" => 'DOMINICAN REPUBLIC',
                            "EC" => 'ECUADOR',
                            "EG" => 'EGYPT',
                            "SV" => 'EL SALVADOR',
                            "GQ" => 'EQUATORIAL GUINEA',
                            "ER" => 'ERITREA',
                            "EE" => 'ESTONIA',
                            "ET" => 'ETHIOPIA',
                            "FO" => 'FAROE ISLANDS',
                            "FJ" => 'FIJI',
                            "FI" => 'FINLAND',
                            "FR" => 'FRANCE',
                            "GF" => 'FRENCH GUIANA',
                            "PF" => 'FRENCH POLYNESIA',
                            "TF" => 'FRENCH SOUTHERN TERRITORIES',
                            "GA" => 'GABON',
                            "GM" => 'GAMBIA',
                            "GE" => 'GEORGIA',
                            "DE" => 'GERMANY',
                            "GH" => 'GHANA',
                            "GI" => 'GIBRALTAR',
                            "GR" => 'GREECE',
                            "GL" => 'GREENLAND',
                            "GD" => 'GRENADA',
                            "GP" => 'GUADELOUPE',
                            "GU" => 'GUAM',
                            "GT" => 'GUATEMALA',
                            "GN" => 'GUINEA',
                            "GW" => 'GUINEA-BISSAU',
                            "GY" => 'GUYANA',
                            "HT" => 'HAITI',
                            "HM" => 'HEARD AND MC DONALD ISLANDS',
                            "HN" => 'HONDURAS',
                            "HK" => 'HONG KONG',
                            "HU" => 'HUNGARY',
                            "IS" => 'ICELAND',
                            "IN" => 'INDIA',
                            "ID" => 'INDONESIA',
                            "IQ" => 'IRAQ',
                            "IE" => 'IRELAND',
                            "IL" => 'ISRAEL',
                            "IT" => 'ITALY',
                            "JM" => 'JAMAICA',
                            "JP" => 'JAPAN',
                            "JO" => 'JORDAN',
                            "KZ" => 'KAZAKHSTAN',
                            "KE" => 'KENYA',
                            "KI" => 'KIRIBATI',
                            "KW" => 'KUWAIT',
                            "KG" => 'KYRGYZSTAN',
                            "LA" => 'LAO PEOPLE`S DEMOCRATIC REPUBLIC',
                            "LV" => 'LATVIA',
                            "LB" => 'LEBANON',
                            "LS" => 'LESOTHO',
                            "LR" => 'LIBERIA',
                            "LY" => 'LIBYAN ARAB JAMAHIRIYA',
                            "LI" => 'LIECHTENSTEIN',
                            "LT" => 'LITHUANIA',
                            "LU" => 'LUXEMBOURG',
                            "MO" => 'MACAU',
                            "MG" => 'MADAGASCAR',
                            "MW" => 'MALAWI',
                            "MY" => 'MALAYSIA',
                            "MV" => 'MALDIVES',
                            "ML" => 'MALI',
                            "MT" => 'MALTA',
                            "MH" => 'MARSHALL ISLANDS',
                            "MQ" => 'MARTINIQUE',
                            "MR" => 'MAURITANIA',
                            "MU" => 'MAURITIUS',
                            "YT" => 'MAYOTTE',
                            "MX" => 'MEXICO',
                            "MC" => 'MONACO',
                            "MN" => 'MONGOLIA',
                            "MS" => 'MONTSERRAT',
                            "MA" => 'MOROCCO',
                            "MZ" => 'MOZAMBIQUE',
                            "MM" => 'MYANMAR',
                            "NA" => 'NAMIBIA',
                            "NR" => 'NAURU',
                            "NP" => 'NEPAL',
                            "NL" => 'NETHERLANDS',
                            "AN" => 'NETHERLANDS ANTILLES',
                            "NC" => 'NEW CALEDONIA',
                            "NZ" => 'NEW ZEALAND',
                            "NI" => 'NICARAGUA',
                            "NE" => 'NIGER',
                            "NG" => 'NIGERIA',
                            "NU" => 'NIUE',
                            "NF" => 'NORFOLK ISLAND',
                            "MP" => 'NORTHERN MARIANA ISLANDS',
                            "NO" => 'NORWAY',
                            "OM" => 'OMAN',
                            "PK" => 'PAKISTAN',
                            "PW" => 'PALAU',
                            "PA" => 'PANAMA',
                            "PG" => 'PAPUA NEW GUINEA',
                            "PY" => 'PARAGUAY',
                            "PE" => 'PERU',
                            "PH" => 'PHILIPPINES',
                            "PN" => 'PITCAIRN',
                            "PL" => 'POLAND',
                            "PT" => 'PORTUGAL',
                            "PR" => 'PUERTO RICO',
                            "QA" => 'QATAR',
                            "RE" => 'REUNION',
                            "RO" => 'ROMANIA',
                            "RU" => 'RUSSIAN FEDERATION',
                            "RW" => 'RWANDA',
                            "SH" => 'SAINT HELENA',
                            "KN" => 'SAINT KITTS AND NEVIS',
                            "LC" => 'SAINT LUCIA',
                            "PM" => 'SAINT PIERRE AND MIQUELON',
                            "VC" => 'SAINT VINCENT AND THE GRENADINES',
                            "WS" => 'SAMOA',
                            "SM" => 'SAN MARINO',
                            "ST" => 'SAO TOME AND PRINCIPE',
                            "SA" => 'SAUDI ARABIA',
                            "SN" => 'SENEGAL',
                            "CS" => 'SERBIA AND MONTENEGRO',
                            "SC" => 'SEYCHELLES',
                            "SL" => 'SIERRA LEONE',
                            "SG" => 'SINGAPORE',
                            "SK" => 'SLOVAKIA',
                            "SI" => 'SLOVENIA',
                            "SB" => 'SOLOMON ISLANDS',
                            "SO" => 'SOMALIA',
                            "ZA" => 'SOUTH AFRICA',
                            "GS" => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
                            "ES" => 'SPAIN',
                            "LK" => 'SRI LANKA',
                            "SD" => 'SUDAN',
                            "SR" => 'SURINAME',
                            "SJ" => 'SVALBARD AND JAN MAYEN ISLANDS',
                            "SZ" => 'SWAZILAND',
                            "SE" => 'SWEDEN',
                            "CH" => 'SWITZERLAND',
                            "SY" => 'SYRIAN ARAB REPUBLIC',
                            "TW" => 'TAIWAN',
                            "TJ" => 'TAJIKISTAN',
                            "TH" => 'THAILAND',
                            "TL" => 'TIMOR-LESTE',
                            "TG" => 'TOGO',
                            "TK" => 'TOKELAU',
                            "TO" => 'TONGA',
                            "TT" => 'TRINIDAD AND TOBAGO',
                            "TN" => 'TUNISIA',
                            "TR" => 'TURKEY',
                            "TM" => 'TURKMENISTAN',
                            "TC" => 'TURKS AND CAICOS ISLANDS',
                            "TV" => 'TUVALU',
                            "UG" => 'UGANDA',
                            "UA" => 'UKRAINE',
                            "AE" => 'UNITED ARAB EMIRATES',
                            "GB" => 'UNITED KINGDOM',
                            "US" => 'UNITED STATES',
                            "UM" => 'UNITED STATES MINOR OUTLYING ISLANDS',
                            "UY" => 'URUGUAY',
                            "UZ" => 'UZBEKISTAN',
                            "VU" => 'VANUATU',
                            "VE" => 'VENEZUELA',
                            "VN" => 'VIET NAM',
                            "WF" => 'WALLIS AND FUTUNA ISLANDS',
                            "EH" => 'WESTERN SAHARA',
                            "YE" => 'YEMEN',
                            "ZM" => 'ZAMBIA',
                            "ZW" => 'ZIMBABWE');

                    if(is_null($user_info['country'])) {
                      echo ' - ';
                    }else {
                      echo $country_arr[$user_info['country']];
                    }
                  ?>
                  </a></span>
                </li>
                <li class="list-group-item">
                  <span class="name-set"><b><?php echo $this->lang->line('date_reg');?>:</b></span>
                  <span class="name-data"><a class="pull-right"><?php echo $user_info['regdate']; ?></a></span>
                </li>
                <li class="list-group-item">
                  <div class="select-filter">
                    <div class="re-invest"><b><?php echo $this->lang->line('sett330');?>:</b></div>
                    <div class="re-invest">30%</div>
                    <div class="switch-btn <?php if($user_info['percent_sponsor_cashback'] == 0){ ?>switch-on<?php } ?>" data-id="#bl-1" style="margin: 10px;"></div>
                    <div class="re-invest">0%</div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="select-filter">
                    <div class="re-invest"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $this->lang->line('sett331');?>:</b></div>
                    <div class="re-invest">30%</div>
                    <div class="switch-btn <?php if($user_info['percent_team_cashback'] == 0){ ?>switch-on<?php } ?>" data-id="#bl-2" style="margin: 10px;"></div>
                    <div class="re-invest">0%</div>
                  </div>
                </li>
              </ul>
              <button type="button" class="btn btn-primary gold-btn" id="but_for_ch" data-toggle="modal" data-target="#modal-avatar" id="ch_data_modal"> <?php echo $this->lang->line('datachange');?> </button>
              <button type="button" class="btn btn-primary gold-btn" data-toggle="modal" data-target="#modal-pass" id="ch_pas_modal"> <?php echo $this->lang->line('passchange');?> </button>
              <script type="text/javascript">
                   $(function () {
                      $('.switch-btn').click(function () {
                        $(this).toggleClass('switch-on');
                        if($(this).hasClass('switch-on')) {
                          $(this).trigger('on.switch');
                          var val = 0;
                        }else {
                          $(this).trigger('off.switch');
                          var val = 30;
                        }

                        $.post(
                          '/cabinet/save_percent',
                          {
                            val: val,
                            type: $(this).attr('data-id')
                          },
                          function(data){
                            console.log(data);
                          }
                        )
                      });
                    });
                  </script>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="modal-avatar">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CleanOut()">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $this->lang->line('yourdata');?></h4>
          </div>
          <div class="modal-body">
            <div class="container" style="width:300px;" id="crop-avatar">

                  <!-- Current avatar -->
                  <div class="avatar-view" title="<?php echo $this->lang->line('change_ava');?>" onclick="$('#avatarInput').click()">
                    <!-- $('#avatar-modal').show() -->
                    <!-- <div class="avatar-view" title="<?php echo $this->lang->line('change_ava');?>" onclick="$('#avatar-modal').show()"> -->

                    <!-- Changing avatar -->
                    <img src="<?php echo base_url().$this->session->ava; ?>" alt="Avatar">
                  </div>

                  <!-- Cropping modal -->
                   <!--  -->
                    <!--  -->
                  <div tabindex="-1" aria-hidden="true" class="modal" id="avatar-modal" aria-labelledby="avatar-modal-label" role="dialog" style="z-index: 9999999;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form class="avatar-form" action="<?php echo base_url();?>index.php/cabinet/crop" enctype="multipart/form-data" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="avatar-modal-label"><?php echo $this->lang->line('ch_av');?></h4>
                          </div>
                          <div class="modal-body">
                            <div class="avatar-body">

                              <!-- Upload image and data -->
                              <div class="avatar-upload">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <label for="avatarInput"><?php echo $this->lang->line('loc_upl');?></label>
                                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                <script type="text/javascript">
                                  $('#avatarInput').on('change', function() {
                                    $('#submit_ava_save').click();
                                  })
                                </script>
                              </div>

                              <!-- Crop and preview -->
                              <div class="row">
                                <div class="col-md-9">
                                  <div class="avatar-wrapper"></div>
                                </div>
                                <div class="col-md-3">
                                  <div class="avatar-preview preview-md"></div>
                                  <div class="avatar-preview preview-sm"></div>
                                </div>
                              </div>

                              <div class="row avatar-btns">
                                <div class="col-md-9">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees"><?php echo $this->lang->line('trn_lft');?></button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                                  </div>
                                  <br><br>
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees"><?php echo $this->lang->line('trn_rght');?></button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                                  </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                  <button type="submit" id="submit_ava_save" class="btn btn-primary btn-block avatar-save gold-btn"><?php echo $this->lang->line('save');?></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Loading state -->
                  <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                </div>
            <form onsubmit="return false;" id="ed_form" method="post">
              <p id="succ" style="color:lightgreen; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <p id="err_ch" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <div class="box-body">
                <p id="err_name" class="error"></p>
                <div class="input-group">
                  <span class="input-group-addon">Имя:</span>
                  <input type="text" class="form-control" value="<?php echo $user_info['name']; ?>" id="chname" name="name" placeholder="<?php echo $this->lang->line('name');?>">
                </div>
                <p id="err_lname" class="error"></p>
                <div class="input-group">
                  <span class="input-group-addon"><?php echo $this->lang->line('last_name');?>:</span>
                  <input type="text" class="form-control" value="<?php echo $user_info['lastname']; ?>" id="chlname" name="lastname" placeholder="<?php echo $this->lang->line('last_name');?>">
                </div>
                <p id="err_skype" class="error"></p>
                <div class="input-group">
                  <span class="input-group-addon">Skype:</span>
                  <input type="text" class="form-control" value="<?php echo $user_info['skype']; ?>" id="chskype" name="skype" placeholder="skype">
                </div>
                <p id="err_mob" class="error"></p>
                <div class="input-group">
                  <span class="input-group-addon"><?php echo $this->lang->line('mobile_num');?>:</span>
                  <input type="text" class="form-control" value="<?php echo $user_info['mobile_num']; ?>" id="chmob" name="mobilenum" placeholder="<?php echo $this->lang->line('mobile_num');?>">
                </div>
                <p id="err_country" class="error"></p>
                <div class="input-group">
                  <span class="input-group-addon">Country:</span>
                  <select class="form-control" name="country" id="country">
                    <option value="-"> Your Country </option>
                    <option <?php if($user_info['country'] == 'AX') {echo 'selected';} ?> value="AX">AALAND ISLANDS</option>
                    <option <?php if($user_info['country'] == 'AF') {echo 'selected';} ?> value="AF">AFGHANISTAN</option>
                    <option <?php if($user_info['country'] == 'AL') {echo 'selected';} ?> value="AL">ALBANIA</option>
                    <option <?php if($user_info['country'] == 'DZ') {echo 'selected';} ?> value="DZ">ALGERIA</option>
                    <option <?php if($user_info['country'] == 'AS') {echo 'selected';} ?> value="AS">AMERICAN SAMOA</option>
                    <option <?php if($user_info['country'] == 'AD') {echo 'selected';} ?> value="AD">ANDORRA</option>
                    <option <?php if($user_info['country'] == 'AO') {echo 'selected';} ?> value="AO">ANGOLA</option>
                    <option <?php if($user_info['country'] == 'AI') {echo 'selected';} ?> value="AI">ANGUILLA</option>
                    <option <?php if($user_info['country'] == 'AQ') {echo 'selected';} ?> value="AQ">ANTARCTICA</option>
                    <option <?php if($user_info['country'] == 'AG') {echo 'selected';} ?> value="AG">ANTIGUA AND BARBUDA</option>
                    <option <?php if($user_info['country'] == 'AR') {echo 'selected';} ?> value="AR">ARGENTINA</option>
                    <option <?php if($user_info['country'] == 'AM') {echo 'selected';} ?> value="AM">ARMENIA</option>
                    <option <?php if($user_info['country'] == 'AW') {echo 'selected';} ?> value="AW">ARUBA</option>
                    <option <?php if($user_info['country'] == 'AU') {echo 'selected';} ?> value="AU">AUSTRALIA</option>
                    <option <?php if($user_info['country'] == 'AT') {echo 'selected';} ?> value="AT">AUSTRIA</option>
                    <option <?php if($user_info['country'] == 'AZ') {echo 'selected';} ?> value="AZ">AZERBAIJAN</option>
                    <option <?php if($user_info['country'] == 'BS') {echo 'selected';} ?> value="BS">BAHAMAS</option>
                    <option <?php if($user_info['country'] == 'BH') {echo 'selected';} ?> value="BH">BAHRAIN</option>
                    <option <?php if($user_info['country'] == 'BD') {echo 'selected';} ?> value="BD">BANGLADESH</option>
                    <option <?php if($user_info['country'] == 'BB') {echo 'selected';} ?> value="BB">BARBADOS</option>
                    <option <?php if($user_info['country'] == 'BY') {echo 'selected';} ?> value="BY">BELARUS</option>
                    <option <?php if($user_info['country'] == 'BE') {echo 'selected';} ?> value="BE">BELGIUM</option>
                    <option <?php if($user_info['country'] == 'BZ') {echo 'selected';} ?> value="BZ">BELIZE</option>
                    <option <?php if($user_info['country'] == 'BJ') {echo 'selected';} ?> value="BJ">BENIN</option>
                    <option <?php if($user_info['country'] == 'BM') {echo 'selected';} ?> value="BM">BERMUDA</option>
                    <option <?php if($user_info['country'] == 'BT') {echo 'selected';} ?> value="BT">BHUTAN</option>
                    <option <?php if($user_info['country'] == 'BO') {echo 'selected';} ?> value="BO">BOLIVIA</option>
                    <option <?php if($user_info['country'] == 'BA') {echo 'selected';} ?> value="BA">BOSNIA AND HERZEGOWINA</option>
                    <option <?php if($user_info['country'] == 'BW') {echo 'selected';} ?> value="BW">BOTSWANA</option>
                    <option <?php if($user_info['country'] == 'BV') {echo 'selected';} ?> value="BV">BOUVET ISLAND</option>
                    <option <?php if($user_info['country'] == 'BR') {echo 'selected';} ?> value="BR">BRAZIL</option>
                    <option <?php if($user_info['country'] == 'IO') {echo 'selected';} ?> value="IO">BRITISH INDIAN OCEAN TERRITORY</option>
                    <option <?php if($user_info['country'] == 'BN') {echo 'selected';} ?> value="BN">BRUNEI DARUSSALAM</option>
                    <option <?php if($user_info['country'] == 'BG') {echo 'selected';} ?> value="BG">BULGARIA</option>
                    <option <?php if($user_info['country'] == 'BF') {echo 'selected';} ?> value="BF">BURKINA FASO</option>
                    <option <?php if($user_info['country'] == 'BI') {echo 'selected';} ?> value="BI">BURUNDI</option>
                    <option <?php if($user_info['country'] == 'KH') {echo 'selected';} ?> value="KH">CAMBODIA</option>
                    <option <?php if($user_info['country'] == 'CM') {echo 'selected';} ?> value="CM">CAMEROON</option>
                    <option <?php if($user_info['country'] == 'CA') {echo 'selected';} ?> value="CA">CANADA</option>
                    <option <?php if($user_info['country'] == 'CV') {echo 'selected';} ?> value="CV">CAPE VERDE</option>
                    <option <?php if($user_info['country'] == 'KY') {echo 'selected';} ?> value="KY">CAYMAN ISLANDS</option>
                    <option <?php if($user_info['country'] == 'CF') {echo 'selected';} ?> value="CF">CENTRAL AFRICAN REPUBLIC</option>
                    <option <?php if($user_info['country'] == 'TD') {echo 'selected';} ?> value="TD">CHAD</option>
                    <option <?php if($user_info['country'] == 'CL') {echo 'selected';} ?> value="CL">CHILE</option>
                    <option <?php if($user_info['country'] == 'CN') {echo 'selected';} ?> value="CN">CHINA</option>
                    <option <?php if($user_info['country'] == 'CX') {echo 'selected';} ?> value="CX">CHRISTMAS ISLAND</option>
                    <option <?php if($user_info['country'] == 'CO') {echo 'selected';} ?> value="CO">COLOMBIA</option>
                    <option <?php if($user_info['country'] == 'KM') {echo 'selected';} ?> value="KM">COMOROS</option>
                    <option <?php if($user_info['country'] == 'CK') {echo 'selected';} ?> value="CK">COOK ISLANDS</option>
                    <option <?php if($user_info['country'] == 'CR') {echo 'selected';} ?> value="CR">COSTA RICA</option>
                    <option <?php if($user_info['country'] == 'CI') {echo 'selected';} ?> value="CI">COTE D'IVOIRE</option>
                    <option <?php if($user_info['country'] == 'CU') {echo 'selected';} ?> value="CU">CUBA</option>
                    <option <?php if($user_info['country'] == 'CY') {echo 'selected';} ?> value="CY">CYPRUS</option>
                    <option <?php if($user_info['country'] == 'CZ') {echo 'selected';} ?> value="CZ">CZECH REPUBLIC</option>
                    <option <?php if($user_info['country'] == 'DK') {echo 'selected';} ?> value="DK">DENMARK</option>
                    <option <?php if($user_info['country'] == 'DJ') {echo 'selected';} ?> value="DJ">DJIBOUTI</option>
                    <option <?php if($user_info['country'] == 'DM') {echo 'selected';} ?> value="DM">DOMINICA</option>
                    <option <?php if($user_info['country'] == 'DO') {echo 'selected';} ?> value="DO">DOMINICAN REPUBLIC</option>
                    <option <?php if($user_info['country'] == 'EC') {echo 'selected';} ?> value="EC">ECUADOR</option>
                    <option <?php if($user_info['country'] == 'EG') {echo 'selected';} ?> value="EG">EGYPT</option>
                    <option <?php if($user_info['country'] == 'SV') {echo 'selected';} ?> value="SV">EL SALVADOR</option>
                    <option <?php if($user_info['country'] == 'GQ') {echo 'selected';} ?> value="GQ">EQUATORIAL GUINEA</option>
                    <option <?php if($user_info['country'] == 'ER') {echo 'selected';} ?> value="ER">ERITREA</option>
                    <option <?php if($user_info['country'] == 'EE') {echo 'selected';} ?> value="EE">ESTONIA</option>
                    <option <?php if($user_info['country'] == 'ET') {echo 'selected';} ?> value="ET">ETHIOPIA</option>
                    <option <?php if($user_info['country'] == 'FO') {echo 'selected';} ?> value="FO">FAROE ISLANDS</option>
                    <option <?php if($user_info['country'] == 'FJ') {echo 'selected';} ?> value="FJ">FIJI</option>
                    <option <?php if($user_info['country'] == 'FI') {echo 'selected';} ?> value="FI">FINLAND</option>
                    <option <?php if($user_info['country'] == 'FR') {echo 'selected';} ?> value="FR">FRANCE</option>
                    <option <?php if($user_info['country'] == 'GF') {echo 'selected';} ?> value="GF">FRENCH GUIANA</option>
                    <option <?php if($user_info['country'] == 'PF') {echo 'selected';} ?> value="PF">FRENCH POLYNESIA</option>
                    <option <?php if($user_info['country'] == 'TF') {echo 'selected';} ?> value="TF">FRENCH SOUTHERN TERRITORIES</option>
                    <option <?php if($user_info['country'] == 'GA') {echo 'selected';} ?> value="GA">GABON</option>
                    <option <?php if($user_info['country'] == 'GM') {echo 'selected';} ?> value="GM">GAMBIA</option>
                    <option <?php if($user_info['country'] == 'GE') {echo 'selected';} ?> value="GE">GEORGIA</option>
                    <option <?php if($user_info['country'] == 'DE') {echo 'selected';} ?> value="DE">GERMANY</option>
                    <option <?php if($user_info['country'] == 'GH') {echo 'selected';} ?> value="GH">GHANA</option>
                    <option <?php if($user_info['country'] == 'GI') {echo 'selected';} ?> value="GI">GIBRALTAR</option>
                    <option <?php if($user_info['country'] == 'GR') {echo 'selected';} ?> value="GR">GREECE</option>
                    <option <?php if($user_info['country'] == 'GL') {echo 'selected';} ?> value="GL">GREENLAND</option>
                    <option <?php if($user_info['country'] == 'GD') {echo 'selected';} ?> value="GD">GRENADA</option>
                    <option <?php if($user_info['country'] == 'GP') {echo 'selected';} ?> value="GP">GUADELOUPE</option>
                    <option <?php if($user_info['country'] == 'GU') {echo 'selected';} ?> value="GU">GUAM</option>
                    <option <?php if($user_info['country'] == 'GT') {echo 'selected';} ?> value="GT">GUATEMALA</option>
                    <option <?php if($user_info['country'] == 'GN') {echo 'selected';} ?> value="GN">GUINEA</option>
                    <option <?php if($user_info['country'] == 'GW') {echo 'selected';} ?> value="GW">GUINEA-BISSAU</option>
                    <option <?php if($user_info['country'] == 'GY') {echo 'selected';} ?> value="GY">GUYANA</option>
                    <option <?php if($user_info['country'] == 'HT') {echo 'selected';} ?> value="HT">HAITI</option>
                    <option <?php if($user_info['country'] == 'HM') {echo 'selected';} ?> value="HM">HEARD AND MC DONALD ISLANDS</option>
                    <option <?php if($user_info['country'] == 'HN') {echo 'selected';} ?> value="HN">HONDURAS</option>
                    <option <?php if($user_info['country'] == 'HK') {echo 'selected';} ?> value="HK">HONG KONG</option>
                    <option <?php if($user_info['country'] == 'HU') {echo 'selected';} ?> value="HU">HUNGARY</option>
                    <option <?php if($user_info['country'] == 'IS') {echo 'selected';} ?> value="IS">ICELAND</option>
                    <option <?php if($user_info['country'] == 'IN') {echo 'selected';} ?> value="IN">INDIA</option>
                    <option <?php if($user_info['country'] == 'ID') {echo 'selected';} ?> value="ID">INDONESIA</option>
                    <option <?php if($user_info['country'] == 'IQ') {echo 'selected';} ?> value="IQ">IRAQ</option>
                    <option <?php if($user_info['country'] == 'IE') {echo 'selected';} ?> value="IE">IRELAND</option>
                    <option <?php if($user_info['country'] == 'IL') {echo 'selected';} ?> value="IL">ISRAEL</option>
                    <option <?php if($user_info['country'] == 'IT') {echo 'selected';} ?> value="IT">ITALY</option>
                    <option <?php if($user_info['country'] == 'JM') {echo 'selected';} ?> value="JM">JAMAICA</option>
                    <option <?php if($user_info['country'] == 'JP') {echo 'selected';} ?> value="JP">JAPAN</option>
                    <option <?php if($user_info['country'] == 'JO') {echo 'selected';} ?> value="JO">JORDAN</option>
                    <option <?php if($user_info['country'] == 'KZ') {echo 'selected';} ?> value="KZ">KAZAKHSTAN</option>
                    <option <?php if($user_info['country'] == 'KE') {echo 'selected';} ?> value="KE">KENYA</option>
                    <option <?php if($user_info['country'] == 'KI') {echo 'selected';} ?> value="KI">KIRIBATI</option>
                    <option <?php if($user_info['country'] == 'KW') {echo 'selected';} ?> value="KW">KUWAIT</option>
                    <option <?php if($user_info['country'] == 'KG') {echo 'selected';} ?> value="KG">KYRGYZSTAN</option>
                    <option <?php if($user_info['country'] == 'LA') {echo 'selected';} ?> value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
                    <option <?php if($user_info['country'] == 'LV') {echo 'selected';} ?> value="LV">LATVIA</option>
                    <option <?php if($user_info['country'] == 'LB') {echo 'selected';} ?> value="LB">LEBANON</option>
                    <option <?php if($user_info['country'] == 'LS') {echo 'selected';} ?> value="LS">LESOTHO</option>
                    <option <?php if($user_info['country'] == 'LR') {echo 'selected';} ?> value="LR">LIBERIA</option>
                    <option <?php if($user_info['country'] == 'LY') {echo 'selected';} ?> value="LY">LIBYAN ARAB JAMAHIRIYA</option>
                    <option <?php if($user_info['country'] == 'LI') {echo 'selected';} ?> value="LI">LIECHTENSTEIN</option>
                    <option <?php if($user_info['country'] == 'LT') {echo 'selected';} ?> value="LT">LITHUANIA</option>
                    <option <?php if($user_info['country'] == 'LU') {echo 'selected';} ?> value="LU">LUXEMBOURG</option>
                    <option <?php if($user_info['country'] == 'MO') {echo 'selected';} ?> value="MO">MACAU</option>
                    <option <?php if($user_info['country'] == 'MG') {echo 'selected';} ?> value="MG">MADAGASCAR</option>
                    <option <?php if($user_info['country'] == 'MW') {echo 'selected';} ?> value="MW">MALAWI</option>
                    <option <?php if($user_info['country'] == 'MY') {echo 'selected';} ?> value="MY">MALAYSIA</option>
                    <option <?php if($user_info['country'] == 'MV') {echo 'selected';} ?> value="MV">MALDIVES</option>
                    <option <?php if($user_info['country'] == 'ML') {echo 'selected';} ?> value="ML">MALI</option>
                    <option <?php if($user_info['country'] == 'MT') {echo 'selected';} ?> value="MT">MALTA</option>
                    <option <?php if($user_info['country'] == 'MH') {echo 'selected';} ?> value="MH">MARSHALL ISLANDS</option>
                    <option <?php if($user_info['country'] == 'MQ') {echo 'selected';} ?> value="MQ">MARTINIQUE</option>
                    <option <?php if($user_info['country'] == 'MR') {echo 'selected';} ?> value="MR">MAURITANIA</option>
                    <option <?php if($user_info['country'] == 'MU') {echo 'selected';} ?> value="MU">MAURITIUS</option>
                    <option <?php if($user_info['country'] == 'YT') {echo 'selected';} ?> value="YT">MAYOTTE</option>
                    <option <?php if($user_info['country'] == 'MX') {echo 'selected';} ?> value="MX">MEXICO</option>
                    <option <?php if($user_info['country'] == 'MC') {echo 'selected';} ?> value="MC">MONACO</option>
                    <option <?php if($user_info['country'] == 'MN') {echo 'selected';} ?> value="MN">MONGOLIA</option>
                    <option <?php if($user_info['country'] == 'MS') {echo 'selected';} ?> value="MS">MONTSERRAT</option>
                    <option <?php if($user_info['country'] == 'MA') {echo 'selected';} ?> value="MA">MOROCCO</option>
                    <option <?php if($user_info['country'] == 'MZ') {echo 'selected';} ?> value="MZ">MOZAMBIQUE</option>
                    <option <?php if($user_info['country'] == 'MM') {echo 'selected';} ?> value="MM">MYANMAR</option>
                    <option <?php if($user_info['country'] == 'NA') {echo 'selected';} ?> value="NA">NAMIBIA</option>
                    <option <?php if($user_info['country'] == 'NR') {echo 'selected';} ?> value="NR">NAURU</option>
                    <option <?php if($user_info['country'] == 'NP') {echo 'selected';} ?> value="NP">NEPAL</option>
                    <option <?php if($user_info['country'] == 'NL') {echo 'selected';} ?> value="NL">NETHERLANDS</option>
                    <option <?php if($user_info['country'] == 'AN') {echo 'selected';} ?> value="AN">NETHERLANDS ANTILLES</option>
                    <option <?php if($user_info['country'] == 'NC') {echo 'selected';} ?> value="NC">NEW CALEDONIA</option>
                    <option <?php if($user_info['country'] == 'NZ') {echo 'selected';} ?> value="NZ">NEW ZEALAND</option>
                    <option <?php if($user_info['country'] == 'NI') {echo 'selected';} ?> value="NI">NICARAGUA</option>
                    <option <?php if($user_info['country'] == 'NE') {echo 'selected';} ?> value="NE">NIGER</option>
                    <option <?php if($user_info['country'] == 'NG') {echo 'selected';} ?> value="NG">NIGERIA</option>
                    <option <?php if($user_info['country'] == 'NU') {echo 'selected';} ?> value="NU">NIUE</option>
                    <option <?php if($user_info['country'] == 'NF') {echo 'selected';} ?> value="NF">NORFOLK ISLAND</option>
                    <option <?php if($user_info['country'] == 'MP') {echo 'selected';} ?> value="MP">NORTHERN MARIANA ISLANDS</option>
                    <option <?php if($user_info['country'] == 'NO') {echo 'selected';} ?> value="NO">NORWAY</option>
                    <option <?php if($user_info['country'] == 'OM') {echo 'selected';} ?> value="OM">OMAN</option>
                    <option <?php if($user_info['country'] == 'PK') {echo 'selected';} ?> value="PK">PAKISTAN</option>
                    <option <?php if($user_info['country'] == 'PW') {echo 'selected';} ?> value="PW">PALAU</option>
                    <option <?php if($user_info['country'] == 'PA') {echo 'selected';} ?> value="PA">PANAMA</option>
                    <option <?php if($user_info['country'] == 'PG') {echo 'selected';} ?> value="PG">PAPUA NEW GUINEA</option>
                    <option <?php if($user_info['country'] == 'PY') {echo 'selected';} ?> value="PY">PARAGUAY</option>
                    <option <?php if($user_info['country'] == 'PE') {echo 'selected';} ?> value="PE">PERU</option>
                    <option <?php if($user_info['country'] == 'PH') {echo 'selected';} ?> value="PH">PHILIPPINES</option>
                    <option <?php if($user_info['country'] == 'PN') {echo 'selected';} ?> value="PN">PITCAIRN</option>
                    <option <?php if($user_info['country'] == 'PL') {echo 'selected';} ?> value="PL">POLAND</option>
                    <option <?php if($user_info['country'] == 'PT') {echo 'selected';} ?> value="PT">PORTUGAL</option>
                    <option <?php if($user_info['country'] == 'PR') {echo 'selected';} ?> value="PR">PUERTO RICO</option>
                    <option <?php if($user_info['country'] == 'QA') {echo 'selected';} ?> value="QA">QATAR</option>
                    <option <?php if($user_info['country'] == 'RE') {echo 'selected';} ?> value="RE">REUNION</option>
                    <option <?php if($user_info['country'] == 'RO') {echo 'selected';} ?> value="RO">ROMANIA</option>
                    <option <?php if($user_info['country'] == 'RU') {echo 'selected';} ?> value="RU">RUSSIAN FEDERATION</option>
                    <option <?php if($user_info['country'] == 'RW') {echo 'selected';} ?> value="RW">RWANDA</option>
                    <option <?php if($user_info['country'] == 'SH') {echo 'selected';} ?> value="SH">SAINT HELENA</option>
                    <option <?php if($user_info['country'] == 'KN') {echo 'selected';} ?> value="KN">SAINT KITTS AND NEVIS</option>
                    <option <?php if($user_info['country'] == 'LC') {echo 'selected';} ?> value="LC">SAINT LUCIA</option>
                    <option <?php if($user_info['country'] == 'PM') {echo 'selected';} ?> value="PM">SAINT PIERRE AND MIQUELON</option>
                    <option <?php if($user_info['country'] == 'VC') {echo 'selected';} ?> value="VC">SAINT VINCENT AND THE GRENADINES</option>
                    <option <?php if($user_info['country'] == 'WS') {echo 'selected';} ?> value="WS">SAMOA</option>
                    <option <?php if($user_info['country'] == 'SM') {echo 'selected';} ?> value="SM">SAN MARINO</option>
                    <option <?php if($user_info['country'] == 'ST') {echo 'selected';} ?> value="ST">SAO TOME AND PRINCIPE</option>
                    <option <?php if($user_info['country'] == 'SA') {echo 'selected';} ?> value="SA">SAUDI ARABIA</option>
                    <option <?php if($user_info['country'] == 'SN') {echo 'selected';} ?> value="SN">SENEGAL</option>
                    <option <?php if($user_info['country'] == 'CS') {echo 'selected';} ?> value="CS">SERBIA AND MONTENEGRO</option>
                    <option <?php if($user_info['country'] == 'SC') {echo 'selected';} ?> value="SC">SEYCHELLES</option>
                    <option <?php if($user_info['country'] == 'SL') {echo 'selected';} ?> value="SL">SIERRA LEONE</option>
                    <option <?php if($user_info['country'] == 'SG') {echo 'selected';} ?> value="SG">SINGAPORE</option>
                    <option <?php if($user_info['country'] == 'SK') {echo 'selected';} ?> value="SK">SLOVAKIA</option>
                    <option <?php if($user_info['country'] == 'SI') {echo 'selected';} ?> value="SI">SLOVENIA</option>
                    <option <?php if($user_info['country'] == 'SB') {echo 'selected';} ?> value="SB">SOLOMON ISLANDS</option>
                    <option <?php if($user_info['country'] == 'SO') {echo 'selected';} ?> value="SO">SOMALIA</option>
                    <option <?php if($user_info['country'] == 'ZA') {echo 'selected';} ?> value="ZA">SOUTH AFRICA</option>
                    <option <?php if($user_info['country'] == 'GS') {echo 'selected';} ?> value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
                    <option <?php if($user_info['country'] == 'ES') {echo 'selected';} ?> value="ES">SPAIN</option>
                    <option <?php if($user_info['country'] == 'LK') {echo 'selected';} ?> value="LK">SRI LANKA</option>
                    <option <?php if($user_info['country'] == 'SD') {echo 'selected';} ?> value="SD">SUDAN</option>
                    <option <?php if($user_info['country'] == 'SR') {echo 'selected';} ?> value="SR">SURINAME</option>
                    <option <?php if($user_info['country'] == 'SJ') {echo 'selected';} ?> value="SJ">SVALBARD AND JAN MAYEN ISLANDS</option>
                    <option <?php if($user_info['country'] == 'SZ') {echo 'selected';} ?> value="SZ">SWAZILAND</option>
                    <option <?php if($user_info['country'] == 'SE') {echo 'selected';} ?> value="SE">SWEDEN</option>
                    <option <?php if($user_info['country'] == 'CH') {echo 'selected';} ?> value="CH">SWITZERLAND</option>
                    <option <?php if($user_info['country'] == 'SY') {echo 'selected';} ?> value="SY">SYRIAN ARAB REPUBLIC</option>
                    <option <?php if($user_info['country'] == 'TW') {echo 'selected';} ?> value="TW">TAIWAN</option>
                    <option <?php if($user_info['country'] == 'TJ') {echo 'selected';} ?> value="TJ">TAJIKISTAN</option>
                    <option <?php if($user_info['country'] == 'TH') {echo 'selected';} ?> value="TH">THAILAND</option>
                    <option <?php if($user_info['country'] == 'TL') {echo 'selected';} ?> value="TL">TIMOR-LESTE</option>
                    <option <?php if($user_info['country'] == 'TG') {echo 'selected';} ?> value="TG">TOGO</option>
                    <option <?php if($user_info['country'] == 'TK') {echo 'selected';} ?> value="TK">TOKELAU</option>
                    <option <?php if($user_info['country'] == 'TO') {echo 'selected';} ?> value="TO">TONGA</option>
                    <option <?php if($user_info['country'] == 'TT') {echo 'selected';} ?> value="TT">TRINIDAD AND TOBAGO</option>
                    <option <?php if($user_info['country'] == 'TN') {echo 'selected';} ?> value="TN">TUNISIA</option>
                    <option <?php if($user_info['country'] == 'TR') {echo 'selected';} ?> value="TR">TURKEY</option>
                    <option <?php if($user_info['country'] == 'TM') {echo 'selected';} ?> value="TM">TURKMENISTAN</option>
                    <option <?php if($user_info['country'] == 'TC') {echo 'selected';} ?> value="TC">TURKS AND CAICOS ISLANDS</option>
                    <option <?php if($user_info['country'] == 'TV') {echo 'selected';} ?> value="TV">TUVALU</option>
                    <option <?php if($user_info['country'] == 'UG') {echo 'selected';} ?> value="UG">UGANDA</option>
                    <option <?php if($user_info['country'] == 'UA') {echo 'selected';} ?> value="UA">UKRAINE</option>
                    <option <?php if($user_info['country'] == 'AE') {echo 'selected';} ?> value="AE">UNITED ARAB EMIRATES</option>
                    <option <?php if($user_info['country'] == 'GB') {echo 'selected';} ?> value="GB">UNITED KINGDOM</option>
                    <option <?php if($user_info['country'] == 'US') {echo 'selected';} ?> value="US">UNITED STATES</option>
                    <option <?php if($user_info['country'] == 'UM') {echo 'selected';} ?> value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option>
                    <option <?php if($user_info['country'] == 'UY') {echo 'selected';} ?> value="UY">URUGUAY</option>
                    <option <?php if($user_info['country'] == 'UZ') {echo 'selected';} ?> value="UZ">UZBEKISTAN</option>
                    <option <?php if($user_info['country'] == 'VU') {echo 'selected';} ?> value="VU">VANUATU</option>
                    <option <?php if($user_info['country'] == 'VE') {echo 'selected';} ?> value="VE">VENEZUELA</option>
                    <option <?php if($user_info['country'] == 'VN') {echo 'selected';} ?> value="VN">VIET NAM</option>
                    <option <?php if($user_info['country'] == 'WF') {echo 'selected';} ?> value="WF">WALLIS AND FUTUNA ISLANDS</option>
                    <option <?php if($user_info['country'] == 'EH') {echo 'selected';} ?> value="EH">WESTERN SAHARA</option>
                    <option <?php if($user_info['country'] == 'YE') {echo 'selected';} ?> value="YE">YEMEN</option>
                    <option <?php if($user_info['country'] == 'ZM') {echo 'selected';} ?> value="ZM">ZAMBIA</option>
                    <option <?php if($user_info['country'] == 'ZW') {echo 'selected';} ?> value="ZW">ZIMBABWE</option>
                  </select>
                </div>
                <!-- /input-group -->
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary gold-btn" onclick="ChData()"><?php echo $this->lang->line('submit');?></button>
          </div>
          <script type="text/javascript">
            function ChData() {
              $.ajax({
                type: "POST",
                timeout: 45000,
                url: "<?php echo base_url();?>index.php/cabinet/profile",
                data: "name="+$('#chname').val()+"&lastname="+$('#chlname').val()+"&skype="+$('#chskype').val()+"&mobilenum="+$('#chmob').val()+"&country="+$('#country').val(),
                success: function(data) {
                  var data = JSON.parse(data);
                  if(data['err'] == 0) {
                    $('#err_mob').html('');
                    $('#err_skype').html('');
                    $('#err_lname').html('');
                    $('#err_name').html('');
                    $('#succ').html(data['mess']);
                    $('#name_field').html($('#chname').val());
                    $('#sname_field').html($('#chlname').val());
                    $('#mob_field').html($('#chmob').val());
                    $('#skype_field').html($('#chskype').val());
                    $('#country_field').html($('option[value='+$('#country').val()+']').text());
                  }else {
                    $('#succ ').html('');
                    $('#err_mob').html(data['mess_mob']);
                    $('#err_skype').html(data['mess_skype']);
                    $('#err_lname').html(data['mess_lname']);
                    $('#err_name').html(data['mess_name']);
                    $('#err_country').html(data['mess_country']);
                  }
                },
                error: function(data) {
                  $('#err_ch').html('<?php echo $this->lang->line('hign_in_tr');?>');
                }
              });
            }
            function CleanOut() {
              $('#err_mob').html('');
              $('#err_skype').html('');
              $('#err_lname').html('');
              $('#err_name').html('');
              $('#succ ').html('');
            }
          </script>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-pass">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="CleanOutP()">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $this->lang->line('passchange');?></h4>
          </div>
          <div class="modal-body">
            <form role="form" lpformnum="1" onsubmit="retun false;" id="pas_form" method="post">
              <p id="succ_chp" style="color:lightgreen; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <p id="err_chp" style="color:tomato; font-size: 16px; font-weight: bold; text-align: center;"></p>
              <div class="box-body">
                <div class="form-group">
                  <p id="err_pas" class="error"></p>
                  <label for="exampleInputEmail1"><?php echo $this->lang->line('current_password');?></label>
                  <input type="password" name="password" class="form-control" id="pass" placeholder="<?php echo $this->lang->line('current_password');?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <p id="err_npas" class="error"></p>
                  <label for="exampleInputPassword1"><?php echo $this->lang->line('new_password');?></label>
                  <input type="password" name="newpassword" class="form-control" id="npass" placeholder="<?php echo $this->lang->line('new_password');?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <p id="err_cpas" class="error"></p>
                  <label for="exampleInputPassword2"><?php echo $this->lang->line('repeat_new_password');?></label>
                  <input type="password" name="passconf" class="form-control" id="cpass" placeholder="<?php echo $this->lang->line('repeat_new_password');?>" autocomplete="off">
                </div>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary gold-btn" onclick="ChPas()"><?php echo $this->lang->line('submit');?></button>
          </div>
          <script type="text/javascript">
            function ChPas() {
              $.ajax({
                type: "POST",
                timeout: 45000,
                url: "<?php echo base_url();?>index.php/cabinet/change_password",
                data: "password="+$('#pass').val()+"&newpassword="+$('#npass').val()+"&passconf="+$('#cpass').val(),
                success: function(data) {
                  console.log(data);
                  var data = JSON.parse(data);
                  if(data['err'] == 0) {
                    $('#err_pas').html('');
                    $('#err_npas').html('');
                    $('#err_cpas').html('');
                    $('#succ_chp').html(data['mess']);
                  }else {
                    $('#succ_chp').html('');
                    $('#err_pas').html(data['mess_pass']);
                    $('#err_npas').html(data['mess_npass']);
                    $('#err_cpas').html(data['mess_cpass']);
                  }
                },
                error: function(data) {
                  $('#err_chp').html('<?php echo $this->lang->line('hign_in_tr');?>');
                }
              });
            }
            function CleanOutP() {
              $('#err_pas').html('');
              $('#err_npas').html('');
              $('#err_cpas').html('');
              $('#succ_chp').html('');
              $('#pass').val('');
              $('#npass').val('');
              $('#cpass').val('');
            }
          </script>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <?php
      include 'banner_block.php';
    ?>
  </div>
