<?php
class Traffic_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function get_answers() {
        $query = $this->db->query("SELECT * FROM saved_answers");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[$row['type']][$row['lang']][$row['number']] = $row['answer'];
        }

        return $result;
    }
    public function save_answers($arr) {
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_1']."' WHERE lang='russian' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_2']."' WHERE lang='russian' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_3']."' WHERE lang='russian' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_4']."' WHERE lang='russian' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_5']."' WHERE lang='russian' AND number=5 AND type=".$_POST['type']);

        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_1']."' WHERE lang='english' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_2']."' WHERE lang='english' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_3']."' WHERE lang='english' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_4']."' WHERE lang='english' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_5']."' WHERE lang='english' AND number=5 AND type=".$_POST['type']);

        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_1']."' WHERE lang='german' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_2']."' WHERE lang='german' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_3']."' WHERE lang='german' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_4']."' WHERE lang='german' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_5']."' WHERE lang='german' AND number=5 AND type=".$_POST['type']);
    }





    public function getBansForShow($arr, $conf = array('lang' => 'all')) {

        /*
            $arr:
                'text_ad'
                'ban_ad':
                    '125x125'
                    '300x250'
                    '468x60'
                    '728x90'
        */

        // if(isset($_GET['allali'])) {
        //   var_dump(func_num_args());
        //   var_dump($conf);
        //   exit();
        // }

        if(!isset($conf) || !is_array($conf)) {
            
            $conf = array('lang' => 'all');

        }elseif(!is_string($conf['lang']) || $conf['lang'] == NULL) {
            $conf = array('lang' => 'all');

        }elseif($conf['lang'] != 'all' && $conf['lang'] != 'russian' && $conf['lang'] != 'german' && $conf['lang'] != 'english') {
            $conf = array('lang' => 'all');


        }



        $result = array();
        
        if(count($arr['ban_ad']) > 0) {
            $result['125x125'] = array();
            // $result['300x50'] = array();
            $result['300x250'] = array();
            // $result['300x600'] = array();
            $result['468x60'] = array();
            // $result['728x90'] = array();

            if($arr['ban_ad']['125x125'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='125x125' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['125x125']);

                foreach ($query->result_array() as $row) {
                    $result['125x125'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE traffic_projects SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['125x125']) < $arr['ban_ad']['125x125']) {

                    $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='125x125' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['125x125']-count($result['125x125'])));

                    foreach ($query->result_array() as $row) {
                        $result['125x125'][] = $row;
                    }

                    $this->db->query("UPDATE traffic_projects SET seen=0 WHERE format='125x125'");

                }
            }

            if($arr['ban_ad']['300x250'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='300x250' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['300x250']);

                foreach ($query->result_array() as $row) {
                    $result['300x250'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE traffic_projects SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['300x250']) < $arr['ban_ad']['300x250']) {

                    $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='300x250' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['300x250']-count($result['300x250'])));

                    foreach ($query->result_array() as $row) {
                        $result['300x250'][] = $row;
                    }

                    $this->db->query("UPDATE traffic_projects SET seen=0 WHERE format='300x250'");

                }
            }

            if($arr['ban_ad']['468x60'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='468x60' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['468x60']);

                foreach ($query->result_array() as $row) {
                    $result['468x60'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE traffic_projects SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['468x60']) < $arr['ban_ad']['468x60']) {

                    $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='468x60' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['468x60']-count($result['468x60'])));

                    foreach ($query->result_array() as $row) {
                        $result['468x60'][] = $row;
                    }

                    $this->db->query("UPDATE traffic_projects SET seen=0 WHERE format='468x60'");

                }
            }

            // if($arr['ban_ad']['728x90'] > 0) {
            //     $arr_id = array();

            //     $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='728x90' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['728x90']);

            //     foreach ($query->result_array() as $row) {
            //         $result['728x90'][] = $row;
            //         $arr_id[] = $row['ID'];
            //     }

            //     if(count($arr_id) > 0) {
            //         $this->db->query('UPDATE traffic_projects SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
            //         $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
            //     }else {
            //         $last_add_str = '';
            //     }

            //     if(count($result['728x90']) < $arr['ban_ad']['728x90']) {

            //         $query = $this->db->query("SELECT * FROM traffic_projects WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='728x90' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['728x90']-count($result['728x90'])));

            //         foreach ($query->result_array() as $row) {
            //             $result['728x90'][] = $row;
            //         }

            //         $this->db->query("UPDATE traffic_projects SET seen=0 WHERE format='728x90'");

            //     }

            // }
        }

        if($arr['text_ad'] > 0) {
            $result['text_ad'] = array();

            $arr_id = array();

            $query = $this->db->query("SELECT * FROM moder_text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND count-current_count>0 AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['text_ad']);

            foreach ($query->result_array() as $row) {
                $result['text_ad'][] = $row;
                $arr_id[] = $row['ID'];
            }

            if(count($arr_id) > 0) {
                $this->db->query('UPDATE moder_text_ad SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE ID IN ('.implode(', ', $arr_id).')');
                $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
            }else {
                $last_add_str = '';
            }

            if(count($result['text_ad']) < $arr['text_ad']) {

                $query = $this->db->query("SELECT * FROM moder_text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND count-current_count>0 AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['text_ad']-count($result['text_ad'])));

                foreach ($query->result_array() as $row) {
                    $result['text_ad'][] = $row;
                }

                $this->db->query("UPDATE moder_text_ad SET seen=0");

            }

        }

        return $result;
    }





    /*
        banner operations
    */
    public function ch_ban_state($uid, $id, $type) {
        // echo "UPDATE compaign SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid;exit();
        $this->db->query("UPDATE traffic_projects SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;
    }
    public function update_banner_conf($uid, $idb, $lang) {
        $this->db->query("UPDATE traffic_projects SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);
    }
    public function up_count_ban($id, $type) {
        if($type == 'text') {
            $query = $this->db->query("SELECT * FROM moder_text_ad WHERE count-current_count>0 AND ID=".$this->db->escape_str($id));
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE moder_text_ad SET click_for_stat=click_for_stat+1 WHERE ID=".$id);
            }
        }else {
            $query = $this->db->query("SELECT * FROM traffic_projects WHERE count-current_count>0 AND id=".$this->db->escape_str($id));
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE traffic_projects SET click_for_stat=click_for_stat+1 WHERE id=".$id);
            }
        }
    }
    public function add_spec_code($format, $code) {
        $this->db->query("INSERT INTO traffic_projects(uid, bnr, cont_type, url, format, type, Status, Date) VALUES(1, '".base64_encode($code)."', 3, '', '".$format."', 0, 1, ".time().")");
    }
    public function buy_ads($uid, $type2, $size2, $count) {

        // echo 555;
        // exit();

        $type_of_buy = $type2;

        // if($type2 == 1) {
        //     $type = 'click';
        //     $type2 = 456;
        // }else {
            $type = 'show';
            $type2 = 457;
        // }

        if($type_of_buy == 0) {

            $query = $this->db->query("SELECT * FROM ads_setts");
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            $Price = bcmul($arr['Price_'.$type.'_'.$size2], $count, 4);

            // var_dump($Price);exit();

            $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$Price." AND id=".$uid);
            if($query->num_rows() > 0) {

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$Price.", bal_".$type."_".$size2."=bal_".$type."_".$size2."+".$count." WHERE id=".$uid."");

                $this->db->query("UPDATE new_stat_for_admin SET Banner_buy_sum=Banner_buy_sum+".$Price);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(".$type2.", 'BTC', ".$uid.", 1, ".$Price.", '".$count."', now())");

                foreach ($query->result_array() as $row) {
                    $arr = $row;
                }

                $arr_sett = $this->get_setts();

                $LvlRef2 = array();
                for($i = 0; $i < count($arr_sett[225]); $i++) {
                    $LvlRef2[$arr_sett[225][$i]['Lvl']+0] = $arr_sett[225][$i]['Percent'];
                }

                $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
                $row = $query->row_array();

                if($row['idsponsor'] != NULL) {
                    //рефферальные
                    //Начинаем с 1-го уровня и задаем флаг
                    $cont = true;
                    $lvl = 1;

                    while($cont) {

                        //проверяем есть ли в конфигах лвл больше или равно нашему
                        $query = $this->db->query("SELECT * FROM refs_refills5 WHERE Lvl>=".$lvl);
                        if($query->num_rows()) {

                            //если есть гонимся дале
                            //смотрим спонсора выше на 1 лвл

                            if($row['idsponsor'] == NULL) {
                                $cont = false;
                                continue;    
                            }

                            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row['idsponsor']);

                            $row = $query->row_array();

                            //тут смотрим, есть ли в вынутом сверху массиве текущий уровень
                            if(array_key_exists($lvl, $LvlRef2)) {

                                if($row['Count_ref_lvl'] < $lvl ) {
                                    $lvl++;
                                    continue;
                                }

                                //если есть делаем начисления
                                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE id=".$row['id']);

                                $this->db->query("UPDATE new_stat_for_admin SET Banner_buy_ref=Banner_buy_ref+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4));

                                $this->db->query("INSERT INTO payments(type, btc_address, currency, idreceiver, idsender, status, amount, actiondate) VALUES(38, '3', 'BTC', ".$row['id'].", ".$uid.", 1, ".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", now())");

                                $this->db->query("UPDATE user_statistics SET refs_banner=refs_banner+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", all_money=all_money+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE uid=".$row['id']);

                            }
                            $lvl++;
                        }else {
                            //ели нет сбрасываем флаг
                            $cont = false;
                        }

                    }

                }

                return array('new_bal' => bcsub($arr['amount_btc'], $Price, 8));
            }else {
                return false;
            }

        }elseif($type_of_buy == 1 || $type_of_buy == 2 || $type_of_buy == 3 || $type_of_buy == 4) {
            $query = $this->db->query("SELECT * FROM special_buying");
            $arr = array();
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }

            $Price = $arr[$type_of_buy-1]['price'];
            $count = $arr[$type_of_buy-1]['count'];

            // exit();

            $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$Price." AND id=".$uid);
            if($query->num_rows() > 0) {

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$Price.", bal_".$type."_".$size2."=bal_".$type."_".$size2."+".$count." WHERE id=".$uid."");

                $this->db->query("UPDATE new_stat_for_admin SET Banner_packet_buy_sum=Banner_packet_buy_sum+".$Price);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(".$type2.", 'USD', ".$uid.", 1, ".$Price.", '".$count."', now())");

                foreach ($query->result_array() as $row) {
                    $arr = $row;
                }

                $arr_sett = $this->get_setts();

                $LvlRef2 = array();
                for($i = 0; $i < count($arr_sett[225]); $i++) {
                    $LvlRef2[$arr_sett[225][$i]['Lvl']+0] = $arr_sett[225][$i]['Percent'];
                }

                $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
                $row = $query->row_array();

                if($row['idsponsor'] != NULL) {
                    //рефферальные
                    //Начинаем с 1-го уровня и задаем флаг
                    $cont = true;
                    $lvl = 1;

                    while($cont) {

                        //проверяем есть ли в конфигах лвл больше или равно нашему
                        $query = $this->db->query("SELECT * FROM refs_refills5 WHERE Lvl>=".$lvl);
                        if($query->num_rows()) {

                            //если есть гонимся дале
                            //смотрим спонсора выше на 1 лвл

                            if($row['idsponsor'] == NULL) {
                                $cont = false;
                                continue;    
                            }

                            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row['idsponsor']);

                            $row = $query->row_array();

                            //тут смотрим, есть ли в вынутом сверху массиве текущий уровень
                            if(array_key_exists($lvl, $LvlRef2)) {

                                if($row['Count_ref_lvl'] < $lvl ) {
                                    $lvl++;
                                    continue;
                                }

                                //если есть делаем начисления
                                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE id=".$row['id']);

                                $this->db->query("UPDATE new_stat_for_admin SET Banner_packet_buy_ref=Banner_packet_buy_ref+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4));

                                $this->db->query("INSERT INTO payments(type, btc_address, currency, idreceiver, idsender, status, amount, actiondate) VALUES(38, '4', 'BTC', ".$row['id'].", ".$uid.", 1, ".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", now())");

                                $this->db->query("UPDATE user_statistics SET refs_banner=refs_banner+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", all_money=all_money+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE uid=".$row['id']);

                            }
                            $lvl++;
                        }else {
                            //ели нет сбрасываем флаг
                            $cont = false;
                        }

                    }

                }

                return array('new_bal' => bcsub($arr['amount_btc'], $Price, 8));
            }else {
                return false;
            }
        }
    }
    public function ch_ban_type_ad($uid, $id, $setts) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            $future_new_bal = $result['count']-$result['current_count'];
            if($result['type_of_ad'] == 0) {
                $new_type = 1;
                $new_bal = ceil($future_new_bal*1/$setts['inside_outside_curs']);
            }else {
                $new_type = 0;
                $new_bal = $future_new_bal*$setts['inside_outside_curs'];
            }
            $this->db->query("UPDATE traffic_projects SET type_of_ad=".$new_type.", current_count=0, count=".$new_bal." WHERE ID=".$id." AND uid=".$uid);
            return ['new_bal' => $new_bal, 'future_new_bal' => $future_new_bal];
        }else {
            return false;
        }
    }
    public function update_bn_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function copy_ban($uid, $id) {

        $result = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND uid=".$uid);

        if($result->num_rows() > 0) {
            $ban_info = $result->row_array();

            $this->db->query("INSERT INTO traffic_projects(uid, bnr, cont_type, type_of_ad, url, format, lang, Status, type, Date) VALUES(".$uid.", '".$ban_info['bnr']."', ".$ban_info['cont_type'].", ".$ban_info['type_of_ad'].", '".$ban_info['url']."', '".$ban_info['format']."', '".$ban_info['lang']."', ".$ban_info['Status'].", ".$ban_info['type'].", ".time().")");
            return $this->db->insert_id();
        }
        exit();
    }
    public function add_new_tproj($uid, $url, $country) {
        $this->db->query("INSERT INTO traffic_projects(uid, url, stats, Date) VALUES(".$uid.", '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".json_encode([$country=>['done'=>0, 'have'=>0]])."', ".time().")");
    }
    public function add_balance_tproj($id, $uid, $country, $adding_count) {
        $result = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND uid=".$uid);

        if($result->num_rows() > 0) {
            $info = $result->row_array();
            $stat = json_decode($info['stats'], true);
            if(isset($stat[$country])) {
                $stat[$country]['have'] = $stat[$country]['have']+$adding_count;
            }else{
                $stat[$country] = ['done'=>0,'have'=>$adding_count];
            }
        }

        $this->db->query("UPDATE traffic_projects SET stats='".json_encode($stat)."' WHERE ID=".$id." AND uid=".$uid);
    }
    public function del($uid, $id) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            $this->db->query("DELETE FROM traffic_projects WHERE ID=".$id);
        }
    }
    public function take_my_proj($uid, $st, $fm, $od) {

        // echo $st;
        // echo '<br>';
        // echo $fm;
        // echo '<br>';
        // echo $od;

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($fm) {
            case 'f_1':
                $str_f = "format='125x125'";
                $search_arr[] = $str_f;
                break;
            case 'f_2':
                $str_f = "format='300x250'";
                $search_arr[] = $str_f;
                break;
            case 'f_3':
                $str_f = "format='468x60'";
                $search_arr[] = $str_f;
                break;
            case 'f_4':
                $str_f = "format='728x90'";
                $search_arr[] = $str_f;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
            case '':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM traffic_projects WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_tprj($id) {
        // echo "UPDATE traffic_projects SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE traffic_projects SET status=1 WHERE ID=".$id);
    }
    public function del_tprj($id) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }


            $this->db->query("DELETE FROM traffic_projects WHERE ID=".$id);
        }
    }
    public function cancel_tprj($id, $riason) {
        $this->db->query("UPDATE traffic_projects SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);
    }
    public function add_traf_to_tprj($id, $adding_count, $country) {
        $result = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id);

        if($result->num_rows() > 0) {
            $info = $result->row_array();
            $stat = json_decode($info['stats'], true);
            if(isset($stat[$country])) {
                $stat[$country]['done'] = $stat[$country]['done']+$adding_count;
            }else{
                $stat[$country] = ['done'=>$adding_count,'have'=>$adding_count];
            }
        }

        $this->db->query("UPDATE traffic_projects SET stats='".json_encode($stat)."' WHERE ID=".$id);

    }

    public function accept_adv($id, $sum) {
        $query = $this->db->query("SELECT * FROM temp_adv_pay WHERE id=".$id);
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        $query = $this->db->query("SELECT * FROM curs_btc WHERE Cur='EUR'");
        $result2 = array();
        foreach ($query->result_array() as $row) {
            $result2[] = $row;
        }

        $this->db->query("UPDATE users SET amount_btc=amount_btc+".round(bcmul($sum, $result2[0]['Credits'], 2))." WHERE id=".$result[0]['uid']);
        $this->db->query("UPDATE temp_adv_pay SET status=1 WHERE id=".$id);
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, actiondate) VALUES(2, 'EUR', ".$result[0]['uid'].", 1, ".round(bcmul($sum, $result2[0]['Credits'], 2)).", 'for ".$sum." EUR buying ".round(bcmul($sum, $result2[0]['Credits'], 2))."', now())");
    }
    public function take_all_advs($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM temp_adv_pay as t1 INNER JOIN users as t2 ON t1.uid=t2.id ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_advs_total_count() {

        $query = $this->db->query("SELECT * FROM temp_adv_pay as t1 INNER JOIN users as t2 ON t1.uid=t2.id");

        return $query->num_rows();
    }




    public function take_all_tprj($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_tprj_total_count() {

        $query = $this->db->query("SELECT * FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_tprj_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_tprj_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_ban_for_look($uid) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_ban_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_traffic_projects_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_traffic_projects($ID, $uid, $url) {
        $this->db->query("UPDATE traffic_projects SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_tproj($uid, $ID, $shows) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            $this->db->query("UPDATE traffic_projects SET count=count+".$shows." WHERE ID=".$ID);
            
            return true;
        }else {
            return false;
        }
    }
    public function take_tproj($id) {
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end banner operations
    */


    /*
        moder_vid_ad operations
    */
    public function ch_vid_ad_state($uid, $id, $type) {
        
        $this->db->query("UPDATE moder_vid_ad SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;

    }
    public function update_vid_ad_conf($uid, $idb, $lang) {

        $this->db->query("UPDATE moder_vid_ad SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);

    }
    public function update_vid_ad_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function add_new_vid_ad($uid, $url, $lang) {

        $this->db->query("INSERT INTO vid_ad(uid, url, lang, Date) VALUES(".$uid.", '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$lang."', ".time().")");
        return $this->db->insert_id();
    }
    public function ch_old_vid_ad($id, $uid, $url, $lang) {

        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            $arr = $row;
        }

        $this->db->query("UPDATE moder_vid_ad SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0, lang='".$lang."' WHERE ID=".$id);
    }
    public function del_vid_ad($uid, $id) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            //$this->db->query("UPDATE moder_vid_ad SET amount_btc=amount_btc+".($arr['count']-$arr['current_count'])." WHERE id=".$uid."");

            $this->db->query("DELETE FROM moder_vid_ad WHERE ID=".$id);
        }
    }
    public function take_my_vid_ad($uid, $st, $od) {

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_vid_ad($id) {
        // echo "UPDATE traffic_projects SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE moder_vid_ad SET status=1 WHERE ID=".$id);
    }
    public function del_vid_ads($id) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            //$this->db->query("UPDATE users SET amount_btc=amount_btc+".$arr['count']." WHERE id=".$arr['uid']."");
            $this->db->query("DELETE FROM moder_vid_ad WHERE ID=".$id);
        }
    }
    public function cancel_vid_ad($id, $riason) {

        $this->db->query("UPDATE moder_vid_ad SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);

    }
    public function take_all_vid_ad($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM moder_vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_vid_ad_total_count() {

        $query = $this->db->query("SELECT * FROM moder_vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_vid_ad_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM moder_vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_vid_ad_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM moder_vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_vid_ad_for_look($uid) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_vid_ad_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_vid_ad_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_vid_ad($uid, $ID, $url) {
        $this->db->query("UPDATE traffic_projects SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_vid_ad($uid, $ID, $bal) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // $this->db->query("UPDATE users SET amount_btc=amount_btc-".$bal." WHERE id=".$uid);
            $this->db->query("UPDATE moder_vid_ad SET balance=balance+".$bal." WHERE ID=".$ID);

            return true;
        }else {
            return false;
        }
    }
    public function take_vid_ad($id) {
        $query = $this->db->query("SELECT * FROM moder_vid_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end moder_vid_ad operations
    */


    /*
        moder_text_ad operations
    */
    public function ch_text_ad_state($uid, $id, $type) {
        
        $this->db->query("UPDATE moder_text_ad SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;

    }
    public function ch_text_type_ad($uid, $id, $setts) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            $future_new_bal = $result['count']-$result['current_count'];
            if($result['type_of_ad'] == 0) {
                $new_type = 1;
                $new_bal = ceil($future_new_bal*1/$setts['inside_outside_curs']);
            }else {
                $new_type = 0;
                $new_bal = $future_new_bal*$setts['inside_outside_curs'];
            }
            $this->db->query("UPDATE moder_text_ad SET type_of_ad=".$new_type.", current_count=0, count=".$new_bal." WHERE ID=".$id." AND uid=".$uid);
            return ['new_bal' => $new_bal, 'future_new_bal' => $future_new_bal];
        }else {
            return false;
        }
    }
    public function copy_text($uid, $id) {

        $result = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id." AND uid=".$uid);

        if($result->num_rows() > 0) {
            $ban_info = $result->row_array();

            $this->db->query("INSERT INTO text_ad(uid, type_of_ad, head, body, url, lang, Date) VALUES(".$uid.", ".$ban_info['type_of_ad'].", '".$ban_info['head']."', '".$ban_info['body']."', '".$ban_info['url']."', '".$ban_info['lang']."', ".time().")");
            return $this->db->insert_id();
        }
        exit();
    }
    public function update_text_ad_conf($uid, $idb, $lang) {

        $this->db->query("UPDATE moder_text_ad SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);

    }
    public function update_text_ad_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function add_new_text_ad($uid, $type_of_ad, $head, $body, $url, $lang) {

        $this->db->query("INSERT INTO text_ad(uid, type_of_ad, head, body, url, lang, Date) VALUES(".$uid.", ".$type_of_ad.", '".$head."', '".$body."', '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$lang."', ".time().")");
        return $this->db->insert_id();
    }
    public function ch_old_text_ad($id, $uid, $head, $body, $url, $lang) {

        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            $arr = $row;
        }

        $this->db->query("UPDATE moder_text_ad SET head='".$head."', body='".$body."', url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0, lang='".$lang."' WHERE ID=".$id);
    }
    public function del_text_ad($uid, $id) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            //$this->db->query("UPDATE moder_text_ad SET amount_btc=amount_btc+".($arr['count']-$arr['current_count'])." WHERE id=".$uid."");

            $this->db->query("DELETE FROM moder_text_ad WHERE ID=".$id);
        }
    }
    public function take_my_text_ad($uid, $st, $od) {

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
            case '':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_text_ad($id) {
        // echo "UPDATE traffic_projects SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE moder_text_ad SET status=1 WHERE ID=".$id);
    }
    public function del_text_ads($id) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            $this->db->query("DELETE FROM moder_text_ad WHERE ID=".$id);
        }
    }
    public function cancel_text_ad($id, $riason) {

        $this->db->query("UPDATE moder_text_ad SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);

    }
    public function take_all_text_ad($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM moder_text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_text_ad_total_count() {

        $query = $this->db->query("SELECT * FROM moder_text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_text_ad_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM moder_text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM traffic_projects as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_text_ad_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM moder_text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_text_ad_for_look($uid) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_text_ad_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_text_ad_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_text_ad($uid, $ID, $url) {
        $this->db->query("UPDATE traffic_projects SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_text_ad($uid, $ID, $bal, $shows) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // $this->db->query("UPDATE users SET amount_btc=amount_btc-".$bal." WHERE id=".$uid);
            $this->db->query("UPDATE moder_text_ad SET count=count+".$shows." WHERE ID=".$ID);

            // $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, actiondate) VALUES(457, 'PCT', ".$uid.", 1, ".$bal.", 'buying ".$shows." shows(text)', now())");

            return true;
        }else {
            return false;
        }
    }
    public function take_text_ad($id) {
        $query = $this->db->query("SELECT * FROM moder_text_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end moder_text_ad operations
    */



     /*
        bonus operations
    */
    public function update_bonus_setts($arr) {
        $this->db->query("UPDATE `settings` SET `bonus2_wal`=".$arr['bonus2_wal'].", `price_for_bonus2`=".$arr['price_for_bonus2']);
    }
    public function update_time_bonus_setts($arr) {
        $this->db->query("UPDATE `settings` SET `type_bonus_main`=".$arr['type_bonus_main'].", `type_count_bonus_main`='".$arr['type_count_bonus_main']."', `count_bonus_main`=".$arr['count_bonus_main'].", `type_time_before_show_bonus`='".$arr['type_time_before_show_bonus']."', `time_before_show_bonus`=".$arr['time_before_show_bonus']);
    }
    public function update_link_bonus_setts($str) {

        if($str == 1) {
            $numb = rand();
            $path = md5($numb);
            $this->db->query("UPDATE `settings` SET `state_link_bonus_main`=1, path_link_bonus_main='".$path."'");
        }else {
            $this->db->query("UPDATE `settings` SET `state_link_bonus_main`=0, path_link_bonus_main=''");
        }
    }
    /*
        end bonus operations
    */



    /*
        fin and setts operations operations
    */
    public function saveWalToRet($uid, $wallet) {
        $this->db->query("UPDATE users SET wallet_to_return='".$wallet."' WHERE id=".$uid);
    }
    public function ch_st_main($val) {
        $this->db->query("UPDATE settings SET status_bonus_main=".$val);
    }
    public function ch_st_cab($val) {
        $this->db->query("UPDATE settings SET status_bonus_cab=".$val);   
    }
    public function get_info_bonus2($uid) {
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=2 AND idreceiver=".$uid);
        $row = $query->row();

        $query = $this->db->query("SELECT * FROM settings");
        $row2 = $query->row();

        return array( "all_income" => $row->sum, "need_to_get_bon" => $row2->bonus2_wal, "gift" => $row2->price_for_bonus2);
    }
    public function getBal($uid) {
        $query = $this->db->query("SELECT amount_btc FROM users WHERE id=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            echo rtrim(rtrim(number_format($result['amount_btc'], 8, '.', ''), "0"), ".");
        }else {
            echo 0;
        }
    }
    public function TransferToAnotherBalance($uid, $sum) {
        $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();
            if(bccomp($row['add_amount_btc'], $sum, 8) >= 0) {

                @$sum = $sum + 0;

                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc-".$sum.", amount_btc=amount_btc+".$sum." WHERE id=".$uid);

                // $this->db->query("UPDATE new_stat_for_admin SET Transfered_from_main_to_add=Transfered_from_main_to_add+".$sum);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, 'PCT', ".$uid.", 1, ".$sum.", now())");

                $result = array('ads_bal' => rtrim(rtrim(number_format(bcadd($row['amount_btc'], $sum, 4), 4, '.', ''), "0"), "."), 'main_bal' => rtrim(rtrim(number_format(bcsub($row['add_amount_btc'], $sum, 4), 4, '.', ''), "0"), "."));
                $row_us = $row;

                return $result;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    public function getStatForMain() {
        $result = array();
        $result['count'] = 0;
        $result['price_all'] = 0;

        $query = $this->db->query("SELECT max(Perc_click) as max, min(Perc_click) as min FROM tarifs");
        $row = $query->row();
        $max = $row->max;
        $min = $row->min;

        $query = $this->db->query("SELECT * FROM compaign");

        foreach ($query->result_array() as $row) {

            $result['count']++;
            @$result['price_all'] = rtrim(rtrim(number_format($result['price_all'], 4, '.', ''), "0"), ".") + bcmul($time_ints[$row['Duration']], bcdiv($max, 100, 2), 4) + 0;
        }

        $result['max_satoshi_per_click'] = 0;

        $result['min_satoshi_per_click'] = 0;

        return $result;
    }
    public function get_fin_setts() {

        $query = $this->db->query("SELECT * FROM fin_sets");
        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        return $result;
    }
    public function get_setts() {
        $result[1] = array();
        $result[2] = array();
        $result[3] = array();
        $result[4] = array();
        $result[5] = array();

        $query = $this->db->query("SELECT * FROM ads_setts");
        foreach ($query->result_array() as $row) {
            $result[1] = $row;
        }

        //рефские за клики по компаниям
        $query = $this->db->query("SELECT * FROM refs_refills ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[2][] = $row;
        }

        //рефские за клики по письмам
        $query = $this->db->query("SELECT * FROM refs_refills2 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[222][] = $row;
        }

        //рефские за оплату компаний
        $query = $this->db->query("SELECT * FROM refs_refills3 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[223][] = $row;
        }

        //рефские за оплату писем
        $query = $this->db->query("SELECT * FROM refs_refills4 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[224][] = $row;
        }

        //рефские за покупку показов
        $query = $this->db->query("SELECT * FROM refs_refills5 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[225][] = $row;
        }

        $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[23][] = $row;
        }

        return $result;
    }
    public function getFinStat($uid) {
        $result[1] = array();
        $result[2] = array();
        $result[3] = array();
        $result[4] = array();
        $result[5] = array();

        //всего заработано
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE (type=33 OR type=38) AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[1] = $row;
        }
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=38 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[2] = $row;
        }
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=33 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[3] = $row;
        }
        $query = $this->db->query("SELECT COUNT(*) as count FROM payments WHERE type=33 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[4] = $row;
        }
        $query = $this->db->query("SELECT COUNT(*) as count FROM compaign WHERE Clicked_by LIKE '%|".$uid."|%'");
        foreach ($query->result_array() as $row) {
            $result[5] = $row;
        }

        return $result;
    }
    public function update_setts($arr) {
        $this->db->query("UPDATE `ads_setts` SET `Perc`=".$arr['Perc']);
    }
    public function update_setts_clink($arr) {
        $this->db->query("UPDATE `ads_setts` SET `PriceShowclinks`=".$arr['PriceShowclinks']);
    }
    public function update_time($arr) {
        $ids = json_decode($arr['arr_ids2']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM time_ints WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `time_ints` SET `Count`=".$_POST['Count_'.$ids[$i]].", `Price`=".$_POST['Price_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Count_'.$y]) ) {
            $this->db->query("INSERT INTO `time_ints` (ID, Count, Price) VALUES(".$y.", ".$_POST['Count_'.$y].", ".$_POST['Price_'.$y].")");
            $y++;
        }
    }
    public function update_refs($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }

    public function update_refs2($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills2 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills2` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills2` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs3($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills3 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills3` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills3` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs4($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills4 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills4` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills4` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs5($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills5 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills5` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills5` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }

    public function update_refs_cs($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills_buy_c_and_s` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills_buy_c_and_s` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            // echo "INSERT INTO `refs_refills` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")";exit();
            $y++;
        }
    }
    public function delete_refs($id) {
        $this->db->query("DELETE FROM `refs_refills` WHERE ID=".$id);
    }
    public function delete_refs_cs($id) {
        $this->db->query("DELETE FROM `refs_refills_buy_c_and_s` WHERE ID=".$id);
    }
    public function delete_time($id) {
        $this->db->query("DELETE FROM `time_ints` WHERE ID=".$id);
    }
    public function take_ads_sett() {
        $query = $this->db->query("SELECT * FROM ads_setts");

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end fin and setts operations operations
    */


    
    public function cr_mail_files() {
        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='english'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_eng.txt', 'a+');
        fwrite($f, $str_to);

        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='german'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_ger.txt', 'a+');
        fwrite($f, $str_to);

        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='russian'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_rus.txt', 'a+');
        fwrite($f, $str_to);
    }
    public function add_sup_mess($em, $sub, $mess) {
        $this->db->query("INSERT INTO supp_mess(email, subject, mess, date) VALUES('".json_encode($em, JSON_UNESCAPED_UNICODE)."', '".json_encode($sub, JSON_UNESCAPED_UNICODE)."', '".json_encode($mess, JSON_UNESCAPED_UNICODE)."', ".time().")");
    }


}
?>