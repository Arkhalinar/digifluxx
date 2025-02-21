
        <div class="right_col" role="main">		  
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="block-stat-style">
                <h2><?php echo $this->lang->line('admin_dashboard_1');?> <i class="fa fa-users" aria-hidden="true"></i></h2>
  			        <div class="widget_summary ser-block">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_2');?></span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $us_stat_info['count_us'];?></span>
                  </div>
  				       </div>
                <div class="clearfix"></div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_3');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $us_stat_info['count_us_24'];?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_4');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $us_stat_info['count_us_30'];?> </span>
                  </div>
                </div>
              </div>
              <div class="block-stat-style">
                <h2><?php echo $this->lang->line('admin_dashboard_5');?> <i class="fa fa-money" aria-hidden="true"></i></h2>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_6');?> (<i class="fab fa-btc"></i>) </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo rtrim(rtrim(number_format($respond, 8, '.', ''), "0"), ".");?> </span>
                  </div>
                </div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span>Stripe (<i class="fa fa-eur" aria-hidden="true"></i>) </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $stripe_bal;?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_7');?> (<i class="fa fa-eur" aria-hidden="true"></i>) </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $respond2;?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_8');?> (<i class="fa fa-eur" aria-hidden="true"></i>) </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;">0<?php //echo $respond2;?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary">
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_9');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo rtrim(rtrim(number_format($get_us_bals['main'], 8, '.', ''), "0"), ".");?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary"> 
                  <div class="w_left w_40">
                    <span><?php echo $this->lang->line('admin_dashboard_10');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo rtrim(rtrim(number_format($get_us_bals['add'], 8, '.', ''), "0"), ".");?> </span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="widget_summary"> 
                  <div class="w_left w_20">
                    <span><?php echo $this->lang->line('admin_dashboard_11');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $all_click;?></span>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="widget_summary"> 
                  <div class="w_left w_20">
                    <span><?php echo $this->lang->line('admin_dashboard_12');?> </span>
                  </div>
                  <div class="w_right w_20">
                    <span style="line-height:1.1;"><?php echo $all_show;?></span>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

            <div class=" col-md-6   col-sm-6 col-xs-12">
              <div class="block-stat-style">  
                <h2><?php echo $this->lang->line('admin_dashboard_13');?> <i class="fa fa-bar-chart" aria-hidden="true"></i></h2>
                  <div class="widget_summary orang-block">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_14');?></span>
                    </div>
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_tar']['all'];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_15');?> </span>
                    </div>
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_24']['all'];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_16');?> </span>
                    </div>
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_30']['all'];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary blue-tarif-block">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_17');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_tar'][1];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_18');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_24'][1];?></span>
                    </div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_19');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_30'][1];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary blue-tarif-block">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_20');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_tar'][2];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_21');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_24'][2];?></span>
                    </div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_22');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_30'][2];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary blue-tarif-block">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_23');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_tar'][3];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_24');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_24'][3];?></span>
                    </div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_25');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_30'][3];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary blue-tarif-block">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_26');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_tar'][4];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_27');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_24'][4];?></span>
                    </div>
                  </div>
                  <div class="widget_summary">
                    <div class="w_left w_40">
                      <span><?php echo $this->lang->line('admin_dashboard_28');?> </span>
                    </div> 
                    <div class="w_right w_20">
                      <span style="line-height:1.1;"><?php echo $us_stat_info['count_30'][4];?></span>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-3">
                <div class="stat-block-big block-stat-style">
                  <span class="ser"><?php echo $this->lang->line('admin_dashboard_29');?></span> <?php echo $this->lang->line('admin_dashboard_30');?>
                  <p class="number-stat-block-big"><?php echo $stat_of_ad['banner'][0];?></p>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_31');?> <?php echo $stat_of_ad['banner'][1];?>
                  </div>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_32');?> <?php echo $stat_of_ad['banner'][2];?>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-block-big block-stat-style">
                  <span class="ser"><?php echo $this->lang->line('admin_dashboard_33');?></span> <?php echo $this->lang->line('admin_dashboard_30');?>
                  <p class="number-stat-block-big"><?php echo $stat_of_ad['text'][0];?></p>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_31');?> <?php echo $stat_of_ad['text'][1];?>
                  </div>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_32');?> <?php echo $stat_of_ad['text'][2];?>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-block-big block-stat-style">
                  <span class="ser">Traffic projects</span> <?php echo $this->lang->line('admin_dashboard_30');?>
                  <p class="number-stat-block-big"><?php echo $stat_of_ad['traf'][0];?></p>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_31');?> <?php echo $stat_of_ad['traf'][1];?>
                  </div>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_32');?> <?php echo $stat_of_ad['traf'][2];?>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-block-big block-stat-style">
                  <span class="ser"><?php echo $this->lang->line('admin_dashboard_34');?></span> <?php echo $this->lang->line('admin_dashboard_30');?>
                  <p class="number-stat-block-big"><?php echo $stat_of_ad['vid'][0];?></p>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_31');?> <?php echo $stat_of_ad['vid'][1];?>
                  </div>
                  <div class="dop-info">
                    <?php echo $this->lang->line('admin_dashboard_32');?> <?php echo $stat_of_ad['vid'][2];?>
                  </div>
                </div>
              </div>
            </div>
			   </div>
         <div class="row">
            <div class=" col-md-6 col-sm-6 col-xs-12">
              <div class="block-stat-style">  
                <h2>Last registrations </h2>

                  <?php
                    $count = count($last_regs);
                    for($i = 0; $i < $count; $i++) {
                  ?>
                      <div class="widget_summary">
                        <div class="w_left w_40">
                          <span><?php echo $last_regs[$i]['login'].' ('.$last_regs[$i]['regdate'].')';?></span>
                        </div>
                        <div class="w_right w_20">
                          <span style="line-height:1.1;"><?php

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

                            if(is_null($last_regs[$i]['country'])) {
                              echo ' - ';
                            }else {
                              echo $country_arr[$last_regs[$i]['country']];
                            }
                          ?></span>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                  <?php
                    }
                  ?>
                </div>
            </div>

            <div class=" col-md-6 col-sm-6 col-xs-12">
              <div class="block-stat-style">  
                <h2>Last buying </h2>

                  <?php
                    $count = count($last_buying);
                    for($i = 0; $i < $count; $i++) {
                  ?>
                      <div class="widget_summary">
                        <div class="w_left w_40">
                          <span><?php echo $last_buying[$i]['login'].' ('.$last_buying[$i]['actiondate'].')';?></span>
                        </div>
                        <div class="w_right w_20">
                          <span style="line-height:1.1;"><?php
                            $t = $last_buying[$i];

                            if($t['type'] == 1999)
                              $desc = 'Buying Bonus programm 1';
                            if($t['type'] == 2999)
                              $desc = 'Buying Bonus programm 2';
                            if($t['type'] == 3999)
                              $desc = 'Buying Bonus programm 3';
                            if($t['type'] == 4999)
                              $desc = 'Buying Bonus programm 4';
                            if($t['type'] == 11999)
                              $desc = $this->lang->line('type_457');
                            if($t['type'] == 12999)
                              $desc = $this->lang->line('type_457');
                            if($t['type'] == 13999)
                              $desc = $this->lang->line('type_457');
                            if($t['type'] == 14999)
                              $desc = $this->lang->line('type_457');
                            if($t['type'] == 15999)
                              $desc = $this->lang->line('type_457');
                           
                            echo $desc;

                          ?></span>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                  <?php
                    }
                  ?>

                </div>
            </div>
            
         </div>
        </div>
        <!-- /page content