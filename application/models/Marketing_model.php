<?php
/*

    for ($i=1; $i <= 13; $i++) { 
        $arr_f_lvls[1] = $i;
    }

    for ($i=14; $i <= 24; $i++) { 
        $arr_f_lvls[2] = $i;
    }

    for ($i=25; $i <= 33; $i++) { 
        $arr_f_lvls[3] = $i;
    }

    for ($i=34; $i <= 42; $i++) { 
        $arr_f_lvls[4] = $i;
    }

    users
        amount_btc (доп евро счет)
        add_amount_btc (основной евро счет)
        rest_amount_btc (счет, куда падают средства, оставшиеся после закрытия шкалы в 7, 60, 500 уровнях при выключенном соответственном реинвесте)
        bonus_active_status (статус участия в программах)
        activation_status (активация)
        reinv_1 (статус реинвеста со стола 7)
        reinv_10  (статус реинвеста со стола 60)
        reinv_100  (статус реинвеста со стола 500)

    bonus_prog_mark_settings
        id
        system_bill_kosten
        system_bill_sp
        system_bill_rest
        system_bill_tax
        system_bill_sponsor_excess
        community_baklen
        last_community_baklen_pay
        invest_pool
        last_invest_pool_pay
        liga_pool
        last_liga_pool_pay
        grunder_pool
        last_grunder_pool_pay
        
    scale_ids
        id
        scid
    
    spec_scales_hystory
        id
        uid
        scid
        iscid(scid инициатора)
        sum
        type
        date

    prog_lvl1
        id
        uid
        scid
        current_sum
        max_sum
        date_in
        date_last_up
        status (1 - active | 2 - closed)
        status_pool (1 - active | 2 - closed)
    prog_lvl2
    prog_lvl3
    prog_lvl4
    prog_lvl5
    prog_lvl6
    prog_lvl7
    prog_lvl8
    prog_lvl9

    prog_lvl10
    prog_lvl20
    prog_lvl30
    prog_lvl40
    prog_lvl50
    prog_lvl60
    prog_lvl70

    prog_lvl100
    prog_lvl200
    prog_lvl300
    prog_lvl400
    prog_lvl500
    prog_lvl600

    prog_lvl1000
    prog_lvl2000
    prog_lvl3000
    prog_lvl4000
    prog_lvl5000
*/

class Marketing_model extends CI_Model {

    private $settings_of_mark;

    public function __construct() {
        parent::__construct();

        $this->settings_of_mark = $this->get_all_mark_setts();
    }




    public function change_table() {

        $number = 38;
        $actual_max_sum = 76500.0000;
        $need_max_sum = 47304;

        $query = $this->db->query("SELECT * FROM prog_lvl_".$number);
        
        foreach ($query->result_array() as $row) {
            $this->db->query("UPDATE prog_lvl_".$number." SET current_sum=".bcmul(bcdiv($row['current_sum'], $actual_max_sum, 4), $need_max_sum, 4)." WHERE id=".$row['id']);
        }

        $this->db->query("UPDATE prog_lvl_".$number." SET max_sum=".$need_max_sum);
        $this->db->query("ALTER TABLE `prog_lvl_".$number."` CHANGE `max_sum` `max_sum` DECIMAL(10,4) NOT NULL DEFAULT '".$need_max_sum."'");

    }











    public function get_pool_mess() {
        $query = $this->db->query("SELECT * FROM comm_pool_mess WHERE id=1");
        $arr_info = $query->row_array();
        return $arr_info;
    }
    public function edit_pool_mess($eng, $rus, $ger) {
        $this->db->query("UPDATE comm_pool_mess SET russian='".$rus."', english='".$eng."', german='".$ger."' WHERE id=1");
    }


    public function get_count_active_scales() {
        $active_scales = 0;
        for ($i=1; $i <= 42; $i++) { 
            $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$i." as p INNER JOIN users as u ON p.uid=u.id WHERE p.status=1 AND u.date_end_activation>".time());
            $arr_info = $query->row_array();
            $active_scales += $arr_info['count'];
        }
        return $active_scales;
    }
    public function com_pool_change($oper, $sum) {
        $this->db->query("UPDATE bonus_prog_mark_settings SET community_baklen=community_baklen".$oper.$sum." WHERE id=1");
        $this->db->query("INSERT INTO pool_changing(info, date) VALUES('".json_encode([$oper, $sum])."', now())");
    }
    public function com_perc_pool_change($oper, $sum) {
        $this->db->query("UPDATE bonus_prog_mark_settings SET community_baklen_perc=community_baklen_perc".$oper.$sum." WHERE id=1");
        $this->db->query("INSERT INTO pool_changing(info, date) VALUES('".json_encode(['perc', $oper, $sum])."', now())");
    }
    public function com_distr_part_pool_change($oper, $sum) {
        if($oper == '-') {
            $this->db->query("UPDATE bonus_prog_mark_settings SET comm_bakl_for_distr=comm_bakl_for_distr-".$sum.", community_baklen=community_baklen+".$sum." WHERE id=1");
        }else{
            $this->db->query("UPDATE bonus_prog_mark_settings SET comm_bakl_for_distr=comm_bakl_for_distr+".$sum.", community_baklen=community_baklen-".$sum." WHERE id=1");
        }
        $this->db->query("INSERT INTO pool_changing(info, date) VALUES('".json_encode(['distr', $oper, $sum])."', now())");
    }
    public function SaveTempAdvPay($wotid, $uid) {
        $this->db->query("INSERT INTO `temp_adv_pay`(`uid`, `wotid`, `date`) VALUES ($uid, '".json_encode($wotid)."', '".time()."')");
        return $this->db->insert_id();
    }
    public function CheckTempAdvPay($wotid) {
        $query = $this->db->query("SELECT status FROM `temp_adv_pay` WHERE `wotid`='".json_encode($wotid)."'");
        if($query->num_rows() > 0) {
            return false;
        }else {
            return true;
        }
    }
    public function save_curr_sum($curr_value, $curr_sum) {
        $arr = explode('_', $curr_value);

        $arr_story_info = array(
            'type' => 'spec_scale_reffs',
            'uid'  => $arr[2]
        );

        $this->to_use_rest($arr[0]+0, $arr[1], $curr_sum, $arr_story_info);

    }
    public function save_percent($uid, $sum, $type) {

        if($type == '#bl-2') {
            $field_name = 'percent_team_cashback';
        }elseif($type == '#bl-1') {
            $field_name = 'percent_sponsor_cashback';
        }

        $this->db->query("UPDATE users SET ".$field_name."=".$sum." WHERE id=".$uid);
        return true;
    }
    public function temp_ad_money($uid, $sum, $type) {
        $this->db->query("INSERT INTO btc_invoices(`iduser`, `currency`, `addr`, `pay_sum`, `status`, `conf`, `payment_code`, `pay_date`) VALUES(".$uid.", '".$type."', '-', ".$sum.", 100, 0, '".time()."', now())");
        $this->db->query("UPDATE users SET amount_btc=amount_btc+".$sum." WHERE id=".$uid);
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, '".$type."', ".$uid.", 1, ".$sum.", now())");
    }
    public function get_all_users() {

        $query = $this->db->query('SELECT id, login FROM users ORDER BY id ASC');
        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;

    }
    public function create_user($login, $idsponsor, $balance) {

        $this->db->query('INSERT INTO `users`(`login`, `idsponsor`, `email`, `add_amount_btc`) VALUES ("'.$login.'", '.$idsponsor.', "'.$login.'@gmail.com", '.$balance.')');

    }
    public function re_save_user($uid, $idsponsor, $balance) {
        if($idsponsor != '') {
            $this->db->query('UPDATE `users` SET idsponsor='.$idsponsor.' WHERE id='.$uid);
        }

        if($balance != '') {
            $this->db->query('UPDATE `users` SET add_amount_btc='.$balance.' WHERE id='.$uid);
        }
    }
    public function create_many_users() {

        $this->db->query('DELETE FROM `users` WHERE id>1');
        $this->db->query('ALTER TABLE `users` AUTO_INCREMENT=2');

        for($i = 2; $i <= 1000; $i++) {
            $this->db->query('INSERT INTO `users`(`login`, `idsponsor`, `email`, `add_amount_btc`) VALUES ("user'.$i.'", '.($i-1).', "user'.$i.'@gmail.com", 0)');
        }
    }
    public function get_hyst($type, $val) {
        $result_array = array();

        if($type == '1') {
            $add_str = ' WHERE idsender=(SELECT id FROM users WHERE login="'.$val.'") OR idreciever=(SELECT id FROM users WHERE login="'.$val.'")';
        }elseif($type == '2') {
            $add_str = ' WHERE amount='.$val;
        }elseif($type == '3') {
            $add_str = ' WHERE type='.$val;
        }elseif($type == 'empty') {
            $add_str = '';
        }

        $query = $this->db->query('SELECT * FROM payments '.$add_str);
        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;
    }
    public function get_spec_hyst($type, $val) {
        $result_array = array();

        if($type == '1') {
            $add_str = ' WHERE uid=(SELECT login FROM users WHERE id='.$val.')';
        }elseif($type == '2') {
            $add_str = ' WHERE uid='.$val;
        }elseif($type == '3') {
            $add_str = ' WHERE scid='.$val;
        }elseif($type == '4') {
            $add_str = ' WHERE sum='.$val;
        }elseif($type == '5') {
            $add_str = ' WHERE type='.$val;
        }elseif($type == 'empty') {
            $add_str = '';
        }

        $query = $this->db->query('SELECT * FROM spec_scales_hystory '.$add_str);
        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;
    }
    public function get_all_spec_hyst($str) {
        $real_arr = explode('_', $str);
        $query = $this->db->query("SELECT p.*, (SELECT login FROM users as u WHERE u.id=(JSON_EXTRACT(p.reason, '$.uid')+0)) as login FROM spec_scales_hystory as p WHERE p.reason LIKE '%lvl\":".$real_arr[0].",\"scid\":\"".$real_arr[1]."\"}' ORDER BY p.id DESC");

        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;
    }
    public function get_us_info($type, $val) {
        $result_array = array();

        if($type == 'login') {
            $add_str = ' WHERE login="'.$val.'"';
        }elseif($type == 'id') {
            $add_str = ' WHERE id='.$val;
        }elseif($type == 'empty') {
            $add_str = '';
        }

        $query = $this->db->query('SELECT * FROM users '.$add_str);
        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;        
    }
    public function get_setts() {

        $query = $this->db->query("SELECT * FROM bonus_prog_mark_settings WHERE id=1");
        $arr_info = $query->row_array();

        return $arr_info;
    }
    public function get_uid_by_login($login) {

        $query = $this->db->query("SELECT * FROM users WHERE login='".$login."'");
        $arr_info = $query->row_array();

        return $arr_info;
    }
    public function get_level($n, $status) {

        $result_array = array();

        if($status == 'all') {
            $add_str = '';
        }elseif($status == '1') {
            $add_str = ' WHERE t.status=1';
        }elseif($status == '2') {
            $add_str = ' WHERE t.status=2';
        }

        $query = $this->db->query("SELECT t.*, u.idsponsor FROM prog_lvl_".$n." as t INNER JOIN users AS u ON t.uid=u.id".$add_str);

        foreach ($query->result_array() as $row) {
            $result_array[] = $row;
        }

        return $result_array;
    }
    public function get_all_levels($arr_of_status) {
        $arr_f_lvls = [];

        for ($i=1; $i <= 42; $i++) { 
            $arr_f_lvls[] = $i;
        }

        $result_array = array('all' => 0, 'closed' => 0, 'active' => 0);

        foreach ($arr_f_lvls as $key => $value) {
            if($arr_of_status[$value] == 'all') {
                $add_str = '';
            }elseif($arr_of_status[$value] == '1') {
                $add_str = ' WHERE t.status=1';
            }elseif($arr_of_status[$value] == '2') {
                $add_str = ' WHERE t.status=2';
            }

            $query = $this->db->query("SELECT t.*, u.idsponsor FROM prog_lvl_".$value." as t INNER JOIN users AS u ON t.uid=u.id".$add_str);

            foreach ($query->result_array() as $row) {
                $result_array[$value][] = $row;
            }

            $query2 = $this->db->query("SELECT status, COUNT(*) as count FROM prog_lvl_".$value." GROUP BY status");

            foreach ($query2->result_array() as $row2) {
                $result_array[$value.'_statuses'][$row2['status']] = $row2['count'];
            }

            $result_array['all'] += $result_array[$value.'_statuses'][1];
            $result_array['all'] += $result_array[$value.'_statuses'][2];
            $result_array['active'] += $result_array[$value.'_statuses'][1];
            $result_array['closed'] += $result_array[$value.'_statuses'][2];

        }

        return $result_array;
    }
    public function system_zero() {
        //почистили все программы от шкал

        for ($i=1; $i <= 42; $i++) { 
            $this->db->query("DELETE FROM prog_lvl_".$i." WHERE id>1");
            $this->db->query("UPDATE prog_lvl_".$i." SET current_sum=0, status=1 WHERE id=1");
        }

        //сбросили баллансы, активации, вернули админу
        // $this->db->query("UPDATE users SET add_amount_btc=0, amount_btc=100000, rest_amount_btc=0, bonus_active_status=0, activation_status=0");
        // $this->db->query("UPDATE users SET bonus_active_status=1, date_end_activation='".(time()+2592000)."' WHERE id=1");
        $this->db->query("UPDATE users SET add_amount_btc=0, amount_btc=1000000, rest_amount_btc=0, bonus_active_status=1, activation_status=1, date_end_activation='".(time()+10000000)."'");
        $this->db->query("UPDATE users SET bonus_active_status=1, date_end_activation='".(time()+2592000)."'");

        $this->db->query("DELETE FROM `queue`");

        //почистили истории
        $this->db->query("DELETE FROM payments");
        $this->db->query("DELETE FROM spec_scales_hystory");

        //обнулили статистическую инфу
        $this->db->query("UPDATE `bonus_prog_mark_settings` SET `system_bill_kosten`=0, `system_bill_sp`=0, `system_bill_rest`=0, `system_bill_tax`=0, `system_bill_sponsor_excess`=0, `community_baklen`=0, `last_community_baklen_pay`=0, `invest_pool`=0, `last_invest_pool_pay`=0, `liga_pool`=0, `last_liga_pool_pay`=0, `grunder_pool`=0, `last_grunder_pool_pay`=0");
    }
    public function get_all_mark_setts() {
        $query = $this->db->query("SELECT * FROM settings_of_mark");

        foreach ($query->result_array() as $row) {
            $result_array[$row['type']] = $row['value'];
        }

        return $result_array;
    }
    public function get_mark_setts($type) {
        $query = $this->db->query("SELECT * FROM settings_of_mark WHERE type='".$type."'");

        if($query->num_rows() > 0) {
            $arr = $query->row_array();
            return $arr;
        }else {
            return false;
        }

    }
    public function try_add_to_queue($uid, $type) {
        $packet_info_json = $this->get_mark_setts($type);
        $packet_info = json_decode($packet_info_json['value'], true);

        $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$packet_info['all_sum']." AND id='".$uid."'");

        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function add_to_queue($uid, $type) {
        $packet_info_json = $this->get_mark_setts($type);
        $packet_info = json_decode($packet_info_json['value'], true);
        $this->db->query("UPDATE users SET amount_btc=amount_btc-".$packet_info['all_sum']." WHERE id='".$uid."'");


        $query = $this->db->query('SELECT max(qid) as max FROM queue');
        $row = $query->row_array();

        //ОЧЕРЕДЬ!
        $this->db->query("INSERT INTO `queue`(`uid`, `qid`, `packet`, `date`) VALUES (".$uid.", ".($row['max']+1).", '".$type."','".time()."')");

        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2091, 'CDT', ".$uid.", 1, ".$packet_info['all_sum'].", now())");
    }

    public function save_mark_setts($arr) {

        $type = $arr['type'];

        if($arr['type_of_save'] == 'as_input') {
            $sum = 0;

            for ($i=1; $i <= 42; $i++) { 
                $sum += $arr['lvl_'.$i];
            }


            $sum += $arr['comm_back_pool']+$arr['grunder_pool']+$arr['liga_pool']+$arr['invest_pool']+$arr['sh_konto']+$arr['system']+$arr['sponsor']+$arr['team']+$arr['cashback']+$arr['tax']+$arr['rest']+$arr['stripes_payment'];
            $vals = array(
                        'scales_for_up'   => array(
                                                    '1' => $arr['lvl_1'],
                                                    '2' => $arr['lvl_2'],
                                                    '3' => $arr['lvl_3'],
                                                    '4' => $arr['lvl_4'],
                                                    '5' => $arr['lvl_5'],
                                                    '6' => $arr['lvl_6'],
                                                    '7' => $arr['lvl_7'],
                                                    '8' => $arr['lvl_8'],
                                                    '9' => $arr['lvl_9'],
                                                    '10' => $arr['lvl_10'],
                                                    '11' => $arr['lvl_11'],
                                                    '12' => $arr['lvl_12'],
                                                    '13' => $arr['lvl_13'],
                                                    '14' => $arr['lvl_14'],
                                                    '15' => $arr['lvl_15'],
                                                    '16' => $arr['lvl_16'],
                                                    '17' => $arr['lvl_17'],
                                                    '18' => $arr['lvl_18'],
                                                    '19' => $arr['lvl_19'],
                                                    '20' => $arr['lvl_20'],
                                                    '21' => $arr['lvl_21'],
                                                    '22' => $arr['lvl_22'],
                                                    '23' => $arr['lvl_23'],
                                                    '24' => $arr['lvl_24'],
                                                    '25' => $arr['lvl_25'],
                                                    '26' => $arr['lvl_26'],
                                                    '27' => $arr['lvl_27'],
                                                    '28' => $arr['lvl_28'],
                                                    '29' => $arr['lvl_29'],
                                                    '30' => $arr['lvl_30'],
                                                    '31' => $arr['lvl_31'],
                                                    '32' => $arr['lvl_32'],
                                                    '33' => $arr['lvl_33'],
                                                    '34' => $arr['lvl_34'],
                                                    '35' => $arr['lvl_35'],
                                                    '36' => $arr['lvl_36'],
                                                    '37' => $arr['lvl_37'],
                                                    '38' => $arr['lvl_38'],
                                                    '39' => $arr['lvl_39'],
                                                    '40' => $arr['lvl_40'],
                                                    '41' => $arr['lvl_41'],
                                                    '42' => $arr['lvl_42']
                                                ),
                        'comm_back_pool'  => $arr['comm_back_pool'],
                        'grunder_pool'    => $arr['grunder_pool'],
                        'liga_pool'       => $arr['liga_pool'],
                        'invest_pool'     => $arr['invest_pool'],
                        'sh_konto'        => $arr['sh_konto'],
                        'system'          => $arr['system'],
                        'sponsor'         => $arr['sponsor'],
                        'team'            => $arr['team'],
                        'cashback'        => $arr['cashback'],
                        'tax'             => $arr['tax'],
                        'rest'            => $arr['rest'],
                        'stripes_payment' => $arr['stripes_payment'],

                        'all_sum'         => $sum
                    );

            if(isset($arr['adding_count'])) {
                $vals['adding_count'] = $arr['adding_count'];
            }

            $this->db->query("UPDATE settings_of_mark SET value='".json_encode($vals)."' WHERE type='".$type."'");

            if($arr['type'] == 'lvl_1' || $arr['type'] == 'lvl_2' || $arr['type'] == 'lvl_3' || $arr['type'] == 'lvl_4' || $arr['type'] == 'lvl_5' || $arr['type'] == 'lvl_6' || $arr['type'] == 'lvl_7' || $arr['type'] == 'lvl_8' || $arr['type'] == 'lvl_9' || $arr['type'] == 'lvl_10' || $arr['type'] == 'lvl_11' || $arr['type'] == 'lvl_12' || $arr['type'] == 'lvl_13' || $arr['type'] == 'lvl_14' || $arr['type'] == 'lvl_15' || $arr['type'] == 'lvl_16' || $arr['type'] == 'lvl_17' || $arr['type'] == 'lvl_18' || $arr['type'] == 'lvl_19' || $arr['type'] == 'lvl_20' || $arr['type'] == 'lvl_21' || $arr['type'] == 'lvl_22' || $arr['type'] == 'lvl_23' || $arr['type'] == 'lvl_24' || $arr['type'] == 'lvl_25' || $arr['type'] == 'lvl_26' || $arr['type'] == 'lvl_27' || $arr['type'] == 'lvl_28' || $arr['type'] == 'lvl_29' || $arr['type'] == 'lvl_30' || $arr['type'] == 'lvl_31' || $arr['type'] == 'lvl_32' || $arr['type'] == 'lvl_33' || $arr['type'] == 'lvl_34' || $arr['type'] == 'lvl_35' || $arr['type'] == 'lvl_36' || $arr['type'] == 'lvl_37' || $arr['type'] == 'lvl_38' || $arr['type'] == 'lvl_39' || $arr['type'] == 'lvl_40' || $arr['type'] == 'lvl_41' || $arr['type'] == 'lvl_42') {
                $this->db->query("ALTER TABLE `prog_".$arr['type']."` CHANGE `max_sum` `max_sum` DECIMAL(10,4) NOT NULL DEFAULT '".$sum."'");
                $this->db->query("UPDATE `prog_".$arr['type']."` SET `max_sum`=".$sum);
            }
        }else{
            $query = $this->db->query("SELECT * FROM settings_of_mark WHERE type='".$arr['copy_as']."'");
            $row = $query->row_array();

            $this->db->query("UPDATE settings_of_mark SET value='".$row['value']."' WHERE type='".$type."'");
            $arr_from_vals = json_decode($row['value'], true);

            $sum = $arr_from_vals['all_sum'];

            if($arr['type'] == 'lvl_1' || $arr['type'] == 'lvl_2' || $arr['type'] == 'lvl_3' || $arr['type'] == 'lvl_4' || $arr['type'] == 'lvl_5' || $arr['type'] == 'lvl_6' || $arr['type'] == 'lvl_7' || $arr['type'] == 'lvl_8' || $arr['type'] == 'lvl_9' || $arr['type'] == 'lvl_10' || $arr['type'] == 'lvl_11' || $arr['type'] == 'lvl_12' || $arr['type'] == 'lvl_13' || $arr['type'] == 'lvl_14' || $arr['type'] == 'lvl_15' || $arr['type'] == 'lvl_16' || $arr['type'] == 'lvl_17' || $arr['type'] == 'lvl_18' || $arr['type'] == 'lvl_19' || $arr['type'] == 'lvl_20' || $arr['type'] == 'lvl_21' || $arr['type'] == 'lvl_22' || $arr['type'] == 'lvl_23' || $arr['type'] == 'lvl_24' || $arr['type'] == 'lvl_25' || $arr['type'] == 'lvl_26' || $arr['type'] == 'lvl_27' || $arr['type'] == 'lvl_28' || $arr['type'] == 'lvl_29' || $arr['type'] == 'lvl_30' || $arr['type'] == 'lvl_31' || $arr['type'] == 'lvl_32' || $arr['type'] == 'lvl_33' || $arr['type'] == 'lvl_34' || $arr['type'] == 'lvl_35' || $arr['type'] == 'lvl_36' || $arr['type'] == 'lvl_37' || $arr['type'] == 'lvl_38' || $arr['type'] == 'lvl_39' || $arr['type'] == 'lvl_40' || $arr['type'] == 'lvl_41' || $arr['type'] == 'lvl_42') {
                $this->db->query("ALTER TABLE `prog_".$arr['type']."` CHANGE `max_sum` `max_sum` DECIMAL(10,4) NOT NULL DEFAULT '".$sum."'");
                $this->db->query("UPDATE `prog_".$arr['type']."` SET `max_sum`=".$sum);
            }
        }
    }
    public function create_mark_setts() {

        /*
            type:
                lvl_1
                lvl_2
                lvl_3
                lvl_4
                lvl_5
                lvl_6
                lvl_7
                lvl_10
                lvl_20
                lvl_30
                lvl_40
                lvl_50
                lvl_60
                lvl_100
                lvl_200
                lvl_300
                lvl_400
                lvl_500
                packet_1
                packet_2
                packet_3
                active_1
                active_2
                active_3
                active_4
                active_5
            value:
                array(
                    scales_for_up   => array(
                                            (int)lvl => sum,
                                            ...
                                        )
                    comm_back_pool  => (float)sum,
                    grunder_pool    => (float)sum,
                    liga_pool       => (float)sum,
                    invest_pool     => (float)sum,
                    sh_konto        => (float)sum,
                    system          => (float)sum,
                    sponsor         => (float)sum,
                    team            => (float)sum,
                    cashback        => (float)sum,
                    tax             => (float)sum,
                    rest            => (float)sum,
                    stripes payment => (float)sum,

                    all_sum         => (float)sum
                )
        */

        $type = 'lvl_1';
        $vals = array(
                    'scales_for_up'   => array(
                                                '2' => 40
                                            ),
                    'comm_back_pool'  => 3,
                    'grunder_pool'    => 3,
                    'liga_pool'       => 3,
                    'invest_pool'     => 6,
                    'sh_konto'        => 1,
                    'system'          => 1,
                    'sponsor'         => 1,
                    'team'            => 1,
                    'cashback'        => 1,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 60
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_2';
        $vals = array(
                    'scales_for_up'   => array(
                                                '3' => '116', '1' => '15'
                                            ),
                    'comm_back_pool'  => 6,
                    'grunder_pool'    => 10,
                    'liga_pool'       => 5,
                    'invest_pool'     => 10,
                    'sh_konto'        => 20,
                    'system'          => 5,
                    'sponsor'         => 5,
                    'team'            => 5,
                    'cashback'        => 3,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 200
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_3';
        $vals = array(
                    'scales_for_up'   => array(
                                                '4' => '306', '1' => '15', '2' => '60'
                                            ),
                    'comm_back_pool'  => 20,
                    'grunder_pool'    => 20,
                    'liga_pool'       => 10,
                    'invest_pool'     => 20,
                    'sh_konto'        => 40,
                    'system'          => 5,
                    'sponsor'         => 10,
                    'team'            => 10,
                    'cashback'        => 6,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 522
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_4';
        $vals = array(
                    'scales_for_up'   => array(
                                                '5' => '840', '1' => '30', '2' => '60', '3' => '116'
                                            ),
                    'comm_back_pool'  => 30,
                    'grunder_pool'    => 60,
                    'liga_pool'       => 20,
                    'invest_pool'     => 61,
                    'sh_konto'        => 100,
                    'system'          => 10,
                    'sponsor'         => 20,
                    'team'            => 20,
                    'cashback'        => 10,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 1377
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_5';
        $vals = array(
                    'scales_for_up'   => array(
                                                '6' => '2160', '1' => '30', '2' => '100', '3' => '174', '4' => '306'
                                            ),
                    'comm_back_pool'  => 80,
                    'grunder_pool'    => 120,
                    'liga_pool'       => 60,
                    'invest_pool'     => 120,
                    'sh_konto'        => 500,
                    'system'          => 30,
                    'sponsor'         => 40,
                    'team'            => 30,
                    'cashback'        => 30,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 3780
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_6';
        $vals = array(
                    'scales_for_up'   => array(
                                                '7' => '5700', '1' => '30', '2' => '100', '3' => '174', '4' => '459', '5' => '840'
                                            ),
                    'comm_back_pool'  => 150,
                    'grunder_pool'    => 400,
                    'liga_pool'       => 317,
                    'invest_pool'     => 300,
                    'sh_konto'        => 1000,
                    'system'          => 60,
                    'sponsor'         => 80,
                    'team'            => 60,
                    'cashback'        => 50,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 9720
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_7';
        $vals = array(
                    'scales_for_up'   => array(
                                                '10' => '360', '1' => '30', '2' => '100', '3' => '290', '4' => '459', '5' => '1260', '6' => '2160'
                                            ),
                    'comm_back_pool'  => 300,
                    'grunder_pool'    => 700,
                    'liga_pool'       => 500,
                    'invest_pool'     => 691,
                    'sh_konto'        => 7000,
                    'system'          => 100,
                    'sponsor'         => 100,
                    'team'            => 100,
                    'cashback'        => 100,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 14250
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_8';
        $vals = array(
                    'scales_for_up'   => array(
                                                '10' => '360', '1' => '30', '2' => '100', '3' => '290', '4' => '459', '5' => '1260', '6' => '2160'
                                            ),
                    'comm_back_pool'  => 300,
                    'grunder_pool'    => 700,
                    'liga_pool'       => 500,
                    'invest_pool'     => 691,
                    'sh_konto'        => 7000,
                    'system'          => 100,
                    'sponsor'         => 100,
                    'team'            => 100,
                    'cashback'        => 100,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 14250
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_9';
        $vals = array(
                    'scales_for_up'   => array(
                                                '10' => '360', '1' => '30', '2' => '100', '3' => '290', '4' => '459', '5' => '1260', '6' => '2160'
                                            ),
                    'comm_back_pool'  => 300,
                    'grunder_pool'    => 700,
                    'liga_pool'       => 500,
                    'invest_pool'     => 691,
                    'sh_konto'        => 7000,
                    'system'          => 100,
                    'sponsor'         => 100,
                    'team'            => 100,
                    'cashback'        => 100,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 14250
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_10';
        $vals = array(
                    'scales_for_up'   => array(
                                                '20' => '136', '1' => '15'
                                            ),
                    'comm_back_pool'  => 5,
                    'grunder_pool'    => 10,
                    'liga_pool'       => 5,
                    'invest_pool'     => 10,
                    'sh_konto'        => 5,
                    'system'          => 3,
                    'sponsor'         => 5,
                    'team'            => 3,
                    'cashback'        => 3,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 200
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_20';
        $vals = array(
                    'scales_for_up'   => array(
                                                '30' => '392', '1' => '15', '10' => '60'
                                            ),
                    'comm_back_pool'  => 12,
                    'grunder_pool'    => 20,
                    'liga_pool'       => 10,
                    'invest_pool'     => 20,
                    'sh_konto'        => 50,
                    'system'          => 8,
                    'sponsor'         => 10,
                    'team'            => 10,
                    'cashback'        => 5,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 612
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_30';
        $vals = array(
                    'scales_for_up'   => array(
                                                '40' => '1084', '1' => '30', '2' => '20', '10' => '100', '20' => '136'
                                            ),
                    'comm_back_pool'  => 20,
                    'grunder_pool'    => 50,
                    'liga_pool'       => 20,
                    'invest_pool'     => 40,
                    'sh_konto'        => 200,
                    'system'          => 19,
                    'sponsor'         => 20,
                    'team'            => 15,
                    'cashback'        => 10,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 1764
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_40';
        $vals = array(
                    'scales_for_up'   => array(
                                                '50' => '3420', '1' => '30', '2' => '60', '10' => '100', '20' => '136', '30' => '196'
                                            ),
                    'comm_back_pool'  => 50,
                    'grunder_pool'    => 100,
                    'liga_pool'       => 50,
                    'invest_pool'     => 106,
                    'sh_konto'        => 500,
                    'system'          => 50,
                    'sponsor'         => 30,
                    'team'            => 30,
                    'cashback'        => 20,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 4878
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_50';
        $vals = array(
                    'scales_for_up'   => array(
                                                '60' => '7984', '1' => '30', '2' => '80', '3' => '174', '10' => '200', '20' => '136', '30' => '588', '40' => '1084'
                                            ),
                    'comm_back_pool'  => 300,
                    'grunder_pool'    => 1000,
                    'liga_pool'       => 600,
                    'invest_pool'     => 714,
                    'sh_konto'        => 2000,
                    'system'          => 100,
                    'sponsor'         => 200,
                    'team'            => 100,
                    'cashback'        => 100,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 15390
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_60';
        $vals = array(
                    'scales_for_up'   => array(
                                                '70' => '3000', '1' => '39', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 2515,
                    'liga_pool'       => 2000,
                    'invest_pool'     => 6000,
                    'sh_konto'        => 15000,
                    'system'          => 300,
                    'sponsor'         => 400,
                    'team'            => 200,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 35928
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_70';
        $vals = array(
                    'scales_for_up'   => array(
                                                '70' => '3000', '1' => '39', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 2515,
                    'liga_pool'       => 2000,
                    'invest_pool'     => 6000,
                    'sh_konto'        => 15000,
                    'system'          => 300,
                    'sponsor'         => 400,
                    'team'            => 200,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 35928
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_100';
        $vals = array(
                    'scales_for_up'   => array(
                                                '200' => '730', '1' => '30', '10' => '100'
                                            ),
                    'comm_back_pool'  => 25,
                    'grunder_pool'    => 50,
                    'liga_pool'       => 50,
                    'invest_pool'     => 50,
                    'sh_konto'        => 10,
                    'system'          => 10,
                    'sponsor'         => 10,
                    'team'            => 10,
                    'cashback'        => 5,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 1080
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_200';
        $vals = array(
                    'scales_for_up'   => array(
                                                '300' => '2200', '1' => '30', '10' => '120', '10' => '360'
                                            ),
                    'comm_back_pool'  => 30,
                    'grunder_pool'    => 70,
                    'liga_pool'       => 60,
                    'invest_pool'     => 100,
                    'sh_konto'        => 250,
                    'system'          => 15,
                    'sponsor'         => 20,
                    'team'            => 20,
                    'cashback'        => 10,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 3285
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_300';
        $vals = array(
                    'scales_for_up'   => array(
                                                '400' => '5500', '1' => '30', '2' => '60', '10' => '100', '20' => '204', '100' => '720', '200' => '1095'
                                            ),
                    'comm_back_pool'  => 100,
                    'grunder_pool'    => 300,
                    'liga_pool'       => 200,
                    'invest_pool'     => 331,
                    'sh_konto'        => 1000,
                    'system'          => 30,
                    'sponsor'         => 100,
                    'team'            => 100,
                    'cashback'        => 30,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 9900
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_400';
        $vals = array(
                    'scales_for_up'   => array(
                                                '500' => '12292', '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '542', '100' => '960', '200' => '1095', '300' => '2200'
                                            ),
                    'comm_back_pool'  => 300,
                    'grunder_pool'    => 750,
                    'liga_pool'       => 500,
                    'invest_pool'     => 1001,
                    'sh_konto'        => 2000,
                    'system'          => 100,
                    'sponsor'         => 200,
                    'team'            => 200,
                    'cashback'        => 100,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 24750
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_500';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_600';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_1000';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_2000';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_3000';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_4000';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'lvl_5000';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '2' => '100', '3' => '174', '4' => '306', '5' => '840', '10' => '200', '20' => '272', '30' => '588', '40' => '1084', '50' => '1710', '100' => '1200', '200' => '1095', '300' => '3300', '400' => '2750'
                                            ),
                    'comm_back_pool'  => 1000,
                    'grunder_pool'    => 3000,
                    'liga_pool'       => 2264,
                    'invest_pool'     => 10001,
                    'sh_konto'        => 24000,
                    'system'          => 200,
                    'sponsor'         => 500,
                    'team'            => 500,
                    'cashback'        => 200,
                    'tax'             => 0,
                    'rest'            => 0,
                    'stripes_payment' => 0,

                    'all_sum'         => 55314
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'packet_1';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '18'
                                            ),
                    'comm_back_pool'  => 1.1,
                    'grunder_pool'    => 6.25,
                    'liga_pool'       => 1.3,
                    'invest_pool'     => 17.29,
                    'sh_konto'        => 0,
                    'system'          => 0.6,
                    'sponsor'         => 10,
                    'team'            => 2,
                    'cashback'        => 0,
                    'tax'             => 11.18,
                    'rest'            => 0.25,
                    'stripes_payment' => 2.03,

                    'all_sum'         => 70
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'packet_2';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '18', '10' => '80'
                                            ),
                    'comm_back_pool'  => 5.5,
                    'grunder_pool'    => 27.41,
                    'liga_pool'       => 7,
                    'invest_pool'     => 78.47,
                    'sh_konto'        => 0,
                    'system'          => 3,
                    'sponsor'         => 30,
                    'team'            => 10,
                    'cashback'        => 0,
                    'tax'             => 51.09,
                    'rest'            => 0.25,
                    'stripes_payment' => 9.28,

                    'all_sum'         => 320
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'packet_3';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '10' => '120', '100' => '600'
                                            ),
                    'comm_back_pool'  => 74,
                    'grunder_pool'    => 362.16,
                    'liga_pool'       => 90,
                    'invest_pool'     => 762.6,
                    'sh_konto'        => 0,
                    'system'          => 45,
                    'sponsor'         => 210,
                    'team'            => 140,
                    'cashback'        => 0,
                    'tax'             => 478.99,
                    'rest'            => 0.25,
                    'stripes_payment' => 87,

                    'all_sum'         => 3000
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'packet_4';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '30', '10' => '120', '100' => '600'
                                            ),
                    'comm_back_pool'  => 74,
                    'grunder_pool'    => 362.16,
                    'liga_pool'       => 90,
                    'invest_pool'     => 762.6,
                    'sh_konto'        => 0,
                    'system'          => 45,
                    'sponsor'         => 210,
                    'team'            => 140,
                    'cashback'        => 0,
                    'tax'             => 478.99,
                    'rest'            => 0.25,
                    'stripes_payment' => 87,

                    'all_sum'         => 3000
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'active_1';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '3'
                                            ),
                    'comm_back_pool'  => 0.1,
                    'grunder_pool'    => 0.42,
                    'liga_pool'       => 0.1,
                    'invest_pool'     => 3.5,
                    'sh_konto'        => 0,
                    'system'          => 0.05,
                    'sponsor'         => 1,
                    'team'            => 0.5,
                    'cashback'        => 0,
                    'tax'             => 1.76,
                    'rest'            => 0.25,
                    'stripes_payment' => 0.32,

                    'all_sum'         => 11
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'active_2';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '3'
                                            ),
                    'comm_back_pool'  => 0.1,
                    'grunder_pool'    => 0.42,
                    'liga_pool'       => 0.1,
                    'invest_pool'     => 3.5,
                    'sh_konto'        => 0,
                    'system'          => 0.05,
                    'sponsor'         => 1,
                    'team'            => 0.5,
                    'cashback'        => 0,
                    'tax'             => 1.76,
                    'rest'            => 0.25,
                    'stripes_payment' => 0.32,

                    'all_sum'         => 11
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'active_3';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '3'
                                            ),
                    'comm_back_pool'  => 0.1,
                    'grunder_pool'    => 0.42,
                    'liga_pool'       => 0.1,
                    'invest_pool'     => 3.5,
                    'sh_konto'        => 0,
                    'system'          => 0.05,
                    'sponsor'         => 1,
                    'team'            => 0.5,
                    'cashback'        => 0,
                    'tax'             => 1.76,
                    'rest'            => 0.25,
                    'stripes_payment' => 0.32,

                    'all_sum'         => 11
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'active_4';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '3'
                                            ),
                    'comm_back_pool'  => 0.1,
                    'grunder_pool'    => 0.42,
                    'liga_pool'       => 0.1,
                    'invest_pool'     => 3.5,
                    'sh_konto'        => 0,
                    'system'          => 0.05,
                    'sponsor'         => 1,
                    'team'            => 0.5,
                    'cashback'        => 0,
                    'tax'             => 1.76,
                    'rest'            => 0.25,
                    'stripes_payment' => 0.32,

                    'all_sum'         => 11
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'active_5';
        $vals = array(
                    'scales_for_up'   => array(
                                                '1' => '3'
                                            ),
                    'comm_back_pool'  => 0.1,
                    'grunder_pool'    => 0.42,
                    'liga_pool'       => 0.1,
                    'invest_pool'     => 3.5,
                    'sh_konto'        => 0,
                    'system'          => 0.05,
                    'sponsor'         => 1,
                    'team'            => 0.5,
                    'cashback'        => 0,
                    'tax'             => 1.76,
                    'rest'            => 0.25,
                    'stripes_payment' => 0.32,

                    'all_sum'         => 11
                );
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".json_encode($vals)."')");

        $type = 'bonus_1';
        $vals = 5;
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".$vals."')");

        $type = 'bonus_2';
        $vals = 10;
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".$vals."')");

        $type = 'bonus_3';
        $vals = 50;
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".$vals."')");

        $type = 'bonus_4';
        $vals = 100;
        $this->db->query("INSERT INTO settings_of_mark(type, value) VALUES('".$type."', '".$vals."')");



    }
    public function create_logs($content) {
        // $f = fopen('AAAMrEkl.txt', 'a+');
        // fwrite($f, "\n\r\n\r || ".$content." || \n\r\n\r");
    }






    //вспомогательная функция, ищет все шкалы пользователя(возвращает array(1 => accs 1-7, 10 => accs 10-60, 100 => accs 100-500))
    public function get_accs_array($uid) {

        //массив под 1-3 шкалы
        $arr_info = array();

        if($uid != 1) {


            for ($i=1; $i <= 13; $i++) {
                $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_1->num_rows() > 0) {
                    $row = $query_1->row_array();
                    $arr_info[1] = $row;
                    $arr_info[1]['table'] = $i;
                    break;
                }
            }

            for ($i=14; $i <= 24; $i++) {
                $query_10 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_10->num_rows() > 0) {
                    $row = $query_10->row_array();
                    $arr_info[10] = $row;
                    $arr_info[10]['table'] = $i;
                    break;
                }
            }

            for ($i=25; $i <= 33; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_100->num_rows() > 0) {
                    $row = $query_100->row_array();
                    $arr_info[100] = $row;
                    $arr_info[100]['table'] = $i;
                    break;
                }
            }

            for ($i=34; $i <= 42; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_100->num_rows() > 0) {
                    $row = $query_100->row_array();
                    $arr_info[1000] = $row;
                    $arr_info[1000]['table'] = $i;
                    break;
                }
            }


        }else {
            //ищем в уровнях 1-7
            for ($i=1; $i <= 13; $i++) {
                $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_1->num_rows() > 0) {
                    $row = $query_1->row_array();
                    $arr_info[$i] = $row;
                    $arr_info[$i]['table'] = $i;
                }
            }

            //ищем в уровнях 10-60
            for ($i=14; $i <= 24; $i++) {
                $query_10 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_10->num_rows() > 0) {
                    $row = $query_10->row_array();
                    $arr_info[$i] = $row;
                    $arr_info[$i]['table'] = $i;
                }
            }

            //ищем в уровнях 100-500
            for ($i=25; $i <= 33; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_100->num_rows() > 0) {
                    $row = $query_100->row_array();
                    $arr_info[$i] = $row;
                    $arr_info[$i]['table'] = $i;
                }
            }

            //ищем в уровнях 100-500
            for ($i=34; $i <= 42; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=".$uid." AND status=1");
                if($query_100->num_rows() > 0) {
                    $row = $query_100->row_array();
                    $arr_info[$i] = $row;
                    $arr_info[$i]['table'] = $i;
                }
            }
        }

        return $arr_info;

    }
    //вспомогательная функция, ищет все шкалы пользователя(возвращает array(1 => accs 1-7, 10 => accs 10-60, 100 => accs 100-500))
    public function get_all_accs_array($uid, $number, $type = 'all') {

        switch ($type) {
            case 'all':
                $str = '';
                break;
            case 'active':
                $str = ' AND status=1';
                break;
            case 'closed':
                $str = ' AND status=2';
                break;
        }

        //массив под 1-3 шкалы
        $arr_info = array();

        if($number == 1) {
            //ищем в уровнях 1-7
            for ($i=1; $i <= 13; $i++) {
                $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum, status, (SELECT COUNT(*) FROM prog_lvl_".$i." as p2 INNER JOIN users as u1 ON p2.uid=u1.id WHERE u1.date_end_activation>".time()." AND p2.id<p1.id AND p2.status=1) AS num_in_row, (SELECT COUNT(*) FROM prog_lvl_".$i." as p3 WHERE p3.id<p1.id AND p3.status=1) AS num_in_row_at_all FROM prog_lvl_".$i." as p1 WHERE uid=".$uid.$str);
                if($query_1->num_rows() > 0) {
                    foreach ($query_1->result_array() as $row) {
                        $arr_info[$i]['scales'][] = $row;
                        $arr_info[$i]['max_sum'] = $row['max_sum'];
                    }
                }
            }
        }elseif($number == 2) {
            //ищем в уровнях 10-60
            for ($i=14; $i <= 24; $i++) {
                $query_10 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum, status, (SELECT COUNT(*) FROM prog_lvl_".$i." as p2 INNER JOIN users as u1 ON p2.uid=u1.id WHERE u1.date_end_activation>".time()." AND p2.id<p1.id AND p2.status=1) AS num_in_row, (SELECT COUNT(*) FROM prog_lvl_".$i." as p3 WHERE p3.id<p1.id AND p3.status=1) AS num_in_row_at_all FROM prog_lvl_".$i." as p1 WHERE uid=".$uid.$str);
                if($query_10->num_rows() > 0) {
                    foreach ($query_10->result_array() as $row) {
                        $arr_info[$i]['scales'][] = $row;
                        $arr_info[$i]['max_sum'] = $row['max_sum'];
                    }
                }
            }
        }elseif($number == 3) {
            //ищем в уровнях 100-500
            for ($i=25; $i <= 33; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum, status, (SELECT COUNT(*) FROM prog_lvl_".$i." as p2 INNER JOIN users as u1 ON p2.uid=u1.id WHERE u1.date_end_activation>".time()." AND p2.id<p1.id AND p2.status=1) AS num_in_row, (SELECT COUNT(*) FROM prog_lvl_".$i." as p3 WHERE p3.id<p1.id AND p3.status=1) AS num_in_row_at_all FROM prog_lvl_".$i." as p1 WHERE uid=".$uid.$str);
                if($query_100->num_rows() > 0) {
                    foreach ($query_100->result_array() as $row) {
                        $arr_info[$i]['scales'][] = $row;
                        $arr_info[$i]['max_sum'] = $row['max_sum'];
                    }
                }
            }
        }elseif($number == 4) {
            //ищем в уровнях 100-500
            for ($i=34; $i <= 42; $i++) {
                $query_100 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum, status, (SELECT COUNT(*) FROM prog_lvl_".$i." as p2 INNER JOIN users as u1 ON p2.uid=u1.id WHERE u1.date_end_activation>".time()." AND p2.id<p1.id AND p2.status=1) AS num_in_row, (SELECT COUNT(*) FROM prog_lvl_".$i." as p3 WHERE p3.id<p1.id AND p3.status=1) AS num_in_row_at_all FROM prog_lvl_".$i." as p1 WHERE uid=".$uid.$str);
                if($query_100->num_rows() > 0) {
                    foreach ($query_100->result_array() as $row) {
                        $arr_info[$i]['scales'][] = $row;
                        $arr_info[$i]['max_sum'] = $row['max_sum'];
                    }
                }
            }
        }

        return $arr_info;

    }
    public function update_re_status($uid, $type, $val) {
        // reinv_1 (статус реинвеста со стола 7)
        // reinv_10  (статус реинвеста со стола 60)
        // reinv_100  (статус реинвеста со стола 500)
        $this->db->query("UPDATE users SET reinv_".$type."=".$val." WHERE id=".$uid);
        // echo "UPDATE users SET reinv_".$type."=".$val." WHERE id=".$uid;
    }


    //взятие курса
    public function get_curs() {

        $curr_arr = array();
        $query = $this->db->query("SELECT * FROM curs_btc");
        foreach ($query->result_array() as $row) {
            $curr_arr[$row['Cur']] = $row['Credits'];
        }
        return $curr_arr;

    }
    //функция начисления средств по курсу и создание оборота, начисление времени за него(время в бд в днях)
    public function create_activation($sum, $type, $user) {
        // $curr_arr = $this->get_curs();
        //$sum = bcmul($sum, $curr_arr[$type], 2);

        //time()+bcmul(bcmul($sum, $curr_arr['CRT'], 2), 86400, 2)

        // echo 'Кредитов начислять - '.$sum.'. В соответствии с курсом такое количество кредитов равно - '.bcmul($sum, $curr_arr['CRT'], 2).' дням.'.' Что в свою очередь равно '.bcmul(bcmul($sum, $curr_arr['CRT'], 2), 86400, 2).' секунд';

        // exit();

        // if((time()+bcmul(bcmul($sum, $curr_arr['CRT'], 2),86400, 2)) > 2592000) {
        //     $new_time = time()+2592000;
        // }else {
        //     $new_time = time()+bcmul(bcmul($sum, $curr_arr['CRT'], 2),86400, 2);
        // }

        if($type == 'MB') {
            $add_str = ', add_amount_btc=add_amount_btc-"'.$sum.'"';
        }else {
            $add_str = '';
        }

        // date_end_activation=date_end_activation+'".$new_time."'

        $this->db->query("UPDATE users SET amount_btc=amount_btc+".$sum.$add_str." WHERE id=".$user);

        // echo "UPDATE users SET amount_btc=amount_btc+".$sum.", date_end_activation=date_end_activation+'".$new_time."'".$add_str." WHERE id=".$user;exit();

        $this->db->query("INSERT INTO btc_invoices(`iduser`, `currency`, `addr`, `pay_sum`, `status`, `conf`, `payment_code`, `pay_date`) VALUES(".$user.", '".$type."', '-', ".$sum.", 100, 0, '".time()."', now())");
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, '".$type."', ".$user.", 1, ".$sum.", now())");
    }

    //пользователь оплачивает 1-н из 3-х пакетов и получает себе соответственное количество шкал
    public function buy_scale($package, $user) {

        //записываем в историю и снимаем деньги
        if(!$this->start_buying($package, $user)) {
            return false;
        }

        $query = $this->db->query('SELECT max(qid) as max FROM queue');
        $row = $query->row_array();

        //ОЧЕРЕДЬ!
        $this->db->query("INSERT INTO `queue`(`uid`, `qid`, `packet`, `date`) VALUES (".$user.", ".($row['max']+1).", '".$package."','".time()."')");
        return true;

    }
    public function manual_buy($package, $user) {
        $query = $this->db->query('SELECT * FROM manual_packets WHERE id='.$package);

        if($query->num_rows() > 0) {

            $arr = $query->row_array();

            $type = $arr['hystory_code'];

            $query = $this->db->query("SELECT amount_btc, packet_status FROM users WHERE id=".$user);
            $user_info = $query->row_array();

            $lvls_info = json_decode($arr['product'], true);
            $user_packet_info = json_decode($user_info['packet_status'], true);

            $packet1 = $user_packet_info['packet_1'];
            $packet2 = $user_packet_info['packet_2'];
            $packet3 = $user_packet_info['packet_3'];
            $packet4 = $user_packet_info['packet_4'];

            if(count($lvls_info[1]) > 0) {

                for($a=1; $a <= 13; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                $packet1 = "1";

                $scale_lvl[1] = $lvls_info[1]['lvl'];
                $insta_balance[1] = $lvls_info[1]['insta_balance'];

                $query_sc = $this->db->query("SELECT max(scid) as max FROM scale_ids");
                $row_sc = $query_sc->row_array();

                $scid_scale = $row_sc['max']+1;

                $this->db->query("INSERT INTO scale_ids(scid) VALUES(".$scid.")");

            }

            if(count($lvls_info[2]) > 0) {

                for($a=14; $a <= 24; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                $packet2 = "1";

                $scale_lvl[2] = $lvls_info[2]['lvl'];
                $insta_balance[2] = $lvls_info[2]['insta_balance'];

                if(!isset($scid_scale)) {

                    $query_sc = $this->db->query("SELECT max(scid) as max FROM scale_ids");
                    $row_sc = $query_sc->row_array();

                    $scid_scale = $row_sc['max']+1;

                    $this->db->query("INSERT INTO scale_ids(scid) VALUES(".$scid.")");

                }
                
            }

            if(count($lvls_info[3]) > 0) {

                for($a=25; $a <= 33; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                $packet3 = "1";

                $scale_lvl[3] = $lvls_info[3]['lvl'];
                $insta_balance[3] = $lvls_info[3]['insta_balance'];

                if(!isset($scid_scale)) {

                    $query_sc = $this->db->query("SELECT max(scid) as max FROM scale_ids");
                    $row_sc = $query_sc->row_array();

                    $scid_scale = $row_sc['max']+1;

                    $this->db->query("INSERT INTO scale_ids(scid) VALUES(".$scid.")");
                    
                }
                
            }

            if(count($lvls_info[4]) > 0) {

                for($a=34; $a <= 42; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                $packet4 = "1";

                $scale_lvl[4] = $lvls_info[4]['lvl'];
                $insta_balance[4] = $lvls_info[4]['insta_balance'];

                if(!isset($scid_scale)) {

                    $query_sc = $this->db->query("SELECT max(scid) as max FROM scale_ids");
                    $row_sc = $query_sc->row_array();

                    $scid_scale = $row_sc['max']+1;

                    $this->db->query("INSERT INTO scale_ids(scid) VALUES(".$scid.")");
                    
                }
                
            }

            if($user_info['amount_btc'] >= $arr['price']) {

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$arr['price'].", packet_status='".json_encode(array(
                    "packet_1" => $packet1,
                    "packet_2" => $packet2,
                    "packet_3" => $packet3,
                    "packet_4" => $packet4
                ))."' WHERE id=".$user);
                $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES($type, 'PCT', $user, ".$arr['price'].", now())");

                foreach ($scale_lvl as $key => $value) {
                    $this->db->query("INSERT INTO prog_lvl_".$key."_".$value."(uid, scid, current_sum, date_in) VALUES($user, $scid_scale, ".$insta_balance[$key].", '".time()."')");
                }

            }else {
                return false;
            }

        }
    }
    public function re_save_system() {
        $query = $this->db->query("SELECT t1.uid, t1.packet, t2.packet_status FROM queue as t1 INNER JOIN users as t2 ON t1.uid=t2.id");

        foreach ($query->result_array() as $row) {

            $user_packet_info = json_decode($row['packet_status'], true);

            $packet1 = $user_packet_info['packet_1'];
            $packet2 = $user_packet_info['packet_2'];
            $packet3 = $user_packet_info['packet_3'];
            $packet4 = $user_packet_info['packet_4'];

            switch ($row['packet']) {
                case 'packet_1':
                    $packet1 = "1";
                    break;
                case 'packet_2':
                    $packet2 = "1";
                    break;
                case 'packet_3':
                    $packet3 = "1";
                    break;
                case 'packet_4':
                    $packet4 = "1";
                    break;
            }

            $this->db->query("UPDATE users SET packet_status='".json_encode(array(
                    "packet_1" => $packet1,
                    "packet_2" => $packet2,
                    "packet_3" => $packet3,
                    "packet_4" => $packet4
                ))."' WHERE id=".$row['uid']);
        }

    }
    public function queue_take() {
        $query_1 = $this->db->query("SELECT * FROM queue WHERE status=0 ORDER BY id ASC LIMIT 50");
        if($query_1->num_rows() > 0) {
            foreach ($query_1->result_array() as $row) {
                if($this->start($row['packet'], $row['uid'])){
                    $this->db->query("UPDATE queue SET status=1 WHERE id=".$row['id']);
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function start($package, $user) {
        //в зависимости от пакета создаем пользователю 1\2\3 шкалы
        switch ($package) {
            case 'packet_1':
                $scid = $this->create_new_scale(1, $user);
                break;
            case 'packet_2':
                $scid = $this->create_new_scale(1, $user);
                $this->create_new_scale(14, $user, $scid);
                break;
            case 'packet_3':
                $scid = $this->create_new_scale(1, $user);
                $this->create_new_scale(14, $user, $scid);
                $this->create_new_scale(25, $user, $scid);
                break;
            case 'packet_4':
                $scid = $this->create_new_scale(1, $user);
                $this->create_new_scale(14, $user, $scid);
                $this->create_new_scale(25, $user, $scid);
                $this->create_new_scale(34, $user, $scid);
                break;
            default:
                break;
        }

        //начинаем распределение, синициированное созданием пакета
        $this->start_distribution($package, $user);

        return true;
    }

    //функция снятия денег с пользователя + запись в историю
    public function start_buying($package, $user) {

        $query = $this->db->query("SELECT amount_btc, packet_status, tags, date_end_activation FROM users WHERE id=".$user);
        $user_info = $query->row_array();

        $user_packet_info = json_decode($user_info['packet_status'], true);
        $arr_of_user_tags = explode('#', $user_info['tags']);

        $packet1 = $user_packet_info['packet_1'];
        $packet2 = $user_packet_info['packet_2'];
        $packet3 = $user_packet_info['packet_3'];
        $packet4 = $user_packet_info['packet_4'];

        //в зависимости от пакета берем цену и тип записи в историю
        switch ($package) {
            case 'packet_1':
                $info = json_decode($this->settings_of_mark['packet_1']);

                $sum = $info->all_sum;
                $type = 1999;
                $add_str = ", date_end_activation='".(time()+2592000)."'";

                for ($a=1; $a <= 13; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                break;
            case 'packet_2':
                $info = json_decode($this->settings_of_mark['packet_2']);

                $sum = $info->all_sum;
                $type = 2999;
                $add_str = ", date_end_activation='".(time()+2592000)."'";

                for ($a=14; $a <= 24; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                break;
            case 'packet_3':
                $info = json_decode($this->settings_of_mark['packet_3']);

                $sum = $info->all_sum;
                $type = 3999;
                $add_str = ", date_end_activation='".(time()+2592000)."'";

                for ($a=25; $a <= 33; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                break;
            case 'packet_4':
                $info = json_decode($this->settings_of_mark['packet_4']);

                $sum = $info->all_sum;
                $type = 4999;
                $add_str = ", date_end_activation='".(time()+2592000)."'";

                for ($a=34; $a <= 42; $a++) {
                    $query = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$a." WHERE uid=".$user." AND status=1");
                    $arr_user = $query->row_array();
                    if($arr_user['count'] > 0) {
                        return false;
                    }
                }

                break;
            case 'active_1':
                $info = json_decode($this->settings_of_mark['active_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    if($user_info['date_end_activation']+(360*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+360*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+360*3600)."'";
                        }
                    }
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags) && ($packet4 == 1 || $packet3 == 1)):
                    if($user_info['date_end_activation']+(180*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+180*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+180*3600)."'";
                        }
                    }
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(72*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+72*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+72*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    if($user_info['date_end_activation']+(90*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+90*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+90*3600)."'";
                        }
                    }
                    break;
                  case ($packet2 == 1):
                    if($user_info['date_end_activation']+(180*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+180*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+180*3600)."'";
                        }
                    }
                    break;
                  case ($packet1 == 1):
                    if($user_info['date_end_activation']+(360*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+360*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+360*3600)."'";
                        }
                    }
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 11999;
                break;
            case 'active_2':
                $info = json_decode($this->settings_of_mark['active_2']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags) && ($packet4 == 1 || $packet3 == 1)):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(240*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+240*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+240*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    if($user_info['date_end_activation']+(300*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+300*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+300*3600)."'";
                        }
                    }
                    break;
                  case ($packet2 == 1):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 12999;
                break;
            case 'active_3':
                $info = json_decode($this->settings_of_mark['active_3']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 13999;
                break;
            case 'active_4':
                $info = json_decode($this->settings_of_mark['active_4']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 14999;
                break;
            case 'active_5':
                $info = json_decode($this->settings_of_mark['active_5']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 15999;
                break;
            case 'active_1_1':
                $info = json_decode($this->settings_of_mark['active_1_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    if($user_info['date_end_activation']+(360*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+360*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+360*3600)."'";
                        }
                    }
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags) && ($packet4 == 1 || $packet3 == 1)):
                    if($user_info['date_end_activation']+(180*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+180*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+180*3600)."'";
                        }
                    }
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(72*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+72*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+72*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    if($user_info['date_end_activation']+(90*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+90*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+90*3600)."'";
                        }
                    }
                    break;
                  case ($packet2 == 1):
                    if($user_info['date_end_activation']+(180*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+180*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+180*3600)."'";
                        }
                    }
                    break;
                  case ($packet1 == 1):
                    if($user_info['date_end_activation']+(360*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+360*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+360*3600)."'";
                        }
                    }
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 99111;
                break;
            case 'active_2_1':
                $info = json_decode($this->settings_of_mark['active_2_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags) && ($packet4 == 1 || $packet3 == 1)):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(240*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+240*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+240*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    if($user_info['date_end_activation']+(300*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+300*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+300*3600)."'";
                        }
                    }
                    break;
                  case ($packet2 == 1):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 99222;
                break;
            case 'active_3_1':
                $info = json_decode($this->settings_of_mark['active_3_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    if($user_info['date_end_activation']+(600*3600)-time() > 2592000) {
                        $add_str = ", date_end_activation='".(time()+2592000)."'";
                    }else {
                        if($user_info['date_end_activation'] < time()) {
                            $add_str = ", date_end_activation='".(time()+600*3600)."'";
                        }else{
                            $add_str = ", date_end_activation='".($user_info['date_end_activation']+600*3600)."'";
                        }
                    }
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 99333;
                break;
            case 'active_4_1':
                $info = json_decode($this->settings_of_mark['active_4_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 99444;
                break;
            case 'active_5_1':
                $info = json_decode($this->settings_of_mark['active_5_1']);

                switch (true) {
                  case (array_search('beta_tester', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case (array_search('pre_launch', $arr_of_user_tags)):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet4 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet3 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet2 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  case ($packet1 == 1):
                    $add_str = ", date_end_activation='".(time()+2592000)."'";
                    break;
                  default:
                    $add_str = "";
                    break;
                }

                $sum = $info->all_sum;
                $type = 99555;
                break;
        }

        if($user_info['amount_btc'] >= $sum) {

            if($package == 'packet_1' || $package == 'packet_2' || $package == 'packet_3' || $package == 'packet_4') {
                $add_str_tarif = "tarif='".$package."',";
            }

            switch ($package) {
                case 'packet_1':
                    $packet1 = "1";
                    break;
                case 'packet_2':
                    $packet2 = "1";
                    break;
                case 'packet_3':
                    $packet1 = "1";
                    $packet2 = "1";
                    $packet3 = "1";
                    break;
                case 'packet_4':
                    $packet1 = "1";
                    $packet2 = "1";
                    $packet3 = "1";
                    $packet4 = "1";
                    break;
            }

            $this->db->query("UPDATE users SET amount_btc=amount_btc-".$sum.", tags='".$user_info['tags'].'#pre_launch'."', packet_status='".json_encode(array(
                    "packet_1" => $packet1,
                    "packet_2" => $packet2,
                    "packet_3" => $packet3,
                    "packet_4" => $packet4
                ))."', ".$add_str_tarif." bonus_active_status=1".$add_str." WHERE id=".$user);
            $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES($type, 'PCT', $user, $sum, now())");

            return true;
        }else {
            return false;
        }

    }
    //функция распределения в соответствии с условиями
    public function start_distribution($type, $user) {

        /*
            типы распределения:
                Заполнение шкал уровней 1-7, 10, 20, 30, 40, 50, 60, 100, 200, 300, 400, 500 / type - "lvl_?"
                Покупка пакета шкал 1(70), 2(320), 3(3000) / type - "packet_?"
                Активация 30, 300 / type - "active_?_?" (active_30_1...)
        */

        $info = json_decode($this->settings_of_mark[$type]);

        $arr_of_scales_for_up = array();

        for($i = 1; $i <= 42; $i++) {
            if(isset($info->scales_for_up->$i) && $info->scales_for_up->$i != 0) {
                $arr_of_scales_for_up[$i] = $info->scales_for_up->$i;
            }
        }

        if(count($arr_of_scales_for_up) > 0) {
            $scales_for_up = true;
        }else {
            $scales_for_up = false;
        }

        if($info->sh_konto != 0) {
            $is_sh_konto = true;
            $shoping_konto_sum = $info->sh_konto;
        }else {
            $is_sh_konto = false;
        }

        if($info->system != 0) {
            $is_system = true;
            $system_bill_sum = $info->system;
        }else{
            $is_system = true;
        }

        if($info->comm_back_pool != 0) {
            $is_comm_back_pool = true;
            $community_baklen_sum = $info->comm_back_pool;
        }else{
            $is_comm_back_pool = true;
        }

        if($info->invest_pool != 0) {
            $is_invest_pool = true;
            $pool_investment_sum = $info->invest_pool;
        }else{
            $is_invest_pool = false;
        }

        if($info->liga_pool != 0) {
            $is_liga_pool = true;
            $pool_liga_sum = $info->liga_pool;
        }else{
            $is_liga_pool = false;
        }

        if($info->grunder_pool != 0) {
            $is_grunder_pool = true;
            $pool_grunder_sum = $info->grunder_pool;
        }else{
            $is_grunder_pool = false;
        }

        if($info->sponsor != 0) {
            $is_sponsor = true;
            $sponsor_sum = $info->sponsor;
        }else{
            $is_sponsor = false;
        }

        if($info->team != 0) {
            $is_team = true;
            $team_sum = $info->team;
        }else{
            $is_team = false;
        }

        if($info->cashback != 0) {
            $is_cashback = true;
            $cashback_sum = $info->cashback;
        }else{
            $is_cashback = false;
        }

        if($info->tax != 0) {
            $is_tax = true;
            $sum_tax = $info->tax;
        }else{
            $is_tax = false;
        }

        if($info->rest != 0) {
            $is_rest = true;
            $sum_rest = $info->rest;
        }else{
            $is_rest = false;
        }

        if($info->stripes_payment != 0) {
            $is_sp = true;
            $sum_sp = $info->stripes_payment;
        }else{
            $is_sp = false;
        }

        $arr_story_info = array(
            'type' => $type,
            'uid'  => $user
        );

        //kosten первый
        if($is_system) {
            $this->up_system_bill($system_bill_sum, $arr_story_info);
        }

        //отчисления на спец счет, откуда пользователь может тратить средства в кабинете
        if($is_sh_konto) {
            $this->up_shoping_konto($user, $shoping_konto_sum, $arr_story_info);
        }

        //после - идут все пулы
        if($is_comm_back_pool) {
            $this->up_pool_community_baklen($community_baklen_sum, $arr_story_info);
        }

        if($is_invest_pool) {
            $this->up_pool_investment($pool_investment_sum, $arr_story_info);
        }

        if($is_liga_pool) {
            $this->up_pool_liga($pool_liga_sum, $arr_story_info);
        }

        if($is_grunder_pool) {
            $this->up_pool_grunder($pool_grunder_sum, $arr_story_info);
        }

        //тут еще что-то!!!


        //Распределение в верхнюю шкалу уровня начиная с наименьшего, arr = lvl => sum, lvl => sum...
        if($scales_for_up) {
            $this->up_lvl_scale($arr_of_scales_for_up, $arr_story_info);
        }

        if($is_cashback) {
            $this->up_cashback($user, $cashback_sum, $arr_story_info);
        }

        if($is_sp) {
            $this->up_system_bill_sp($sum_sp, $arr_story_info);
        }
        
        if($is_rest) {
            $this->up_system_bill_rest($sum_rest, $arr_story_info);
        }

        if($is_tax) {
            $this->up_system_bill_tax($sum_tax, $arr_story_info);
        }

       

        //а в конце самая тяжелая двойка функций с важностью рекурсивной реализации
        if($is_sponsor) {
            $this->up_sponsor($user, $sponsor_sum, $arr_story_info);
        }

        if($is_team) {
            $this->up_team($user, $team_sum, $arr_story_info);
        }

    }
    //функция для начисления остатков соответствующему элементу, туда подается информация: lvl - уровнеь в котором шкала закрылась, scid - спец id шкалы, sum - сумма к начислению
    public function to_use_rest($lvl, $scid, $sum, $arr_story_info) {

        $query = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$lvl." WHERE scid=".$scid." AND status=1");
        if($query->num_rows() > 0) {
            $arr_info = $query->row_array();

            if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {
                //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                $this->db->query("UPDATE prog_lvl_".$lvl." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                $arr_story_info['event'] = 'up_rest';
                $arr_story_info['lvl'] = $lvl;
                $arr_story_info['scid'] = $arr_info['id'];

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 1, '".time()."')");
                
                //инициация создания шкал в результате закрытия
                $scale_for_rest = $this->creating_scales($arr_info, $lvl);
                    
                //инициируем распределение в следствии заполнения шкалы уровня
                $this->start_distribution('lvl_'.$lvl, $arr_info['uid']);

                //если деньги еще остались - они ложаться в новую шкалу
                if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                    $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                    if($scale_for_rest == 0) {
                        $this->up_user_ovebill($arr_info['uid'], $rest);
                    }else {
                        $this->to_use_rest($scale_for_rest, $arr_info['scid'], $rest, $arr_story_info);
                    }
                }

            }else {
                //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                $this->db->query("UPDATE prog_lvl_".$lvl." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);
                // echo "UPDATE prog_lvl$lvl SET current_sum=current_sum+$sum WHERE id=".$arr_info['id'];exit();

                $arr_story_info['event'] = 'up_rest';
                $arr_story_info['lvl'] = $lvl;
                $arr_story_info['scid'] = $arr_info['id'];

                // {"type":"packet_3","uid":"13","event":"up_sponsor","lvl":1,"scid":"152"}

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$sum.", 1, '".time()."')");
            }

        }

    }
    //функция для начисления community baklen пула
    public function up_scale_by_community_baklen_pool($lvl, $scid, $sum, $arr_story_info) {



        $query = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$lvl." WHERE scid=".$scid." AND status=1");

        // echo "SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl$lvl WHERE scid=".$scid." AND status=1";exit();

        if($query->num_rows() > 0) {



            $arr_info = $query->row_array();

            if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {
                //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                $this->db->query("UPDATE prog_lvl_".$lvl." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                $arr_story_info['event'] = 'up_by_community_baklen_pool';
                $arr_story_info['lvl'] = $lvl;
                $arr_story_info['scid'] = $arr_info['id'];

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 1, '".time()."')");
                
                //инициация создания шкал в результате закрытия
                $scale_for_rest = $this->creating_scales($arr_info, $lvl);
                
                //инициируем распределение в следствии заполнения шкалы уровня
                $this->start_distribution('lvl_'.$lvl, $arr_info['uid']);

                //если деньги еще остались - они ложаться в новую шкалу
                if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                    $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                    if($scale_for_rest == 0) {
                        $this->up_user_ovebill($arr_info['uid'], $rest);
                    }else {
                        $this->up_scale_by_community_baklen_pool($scale_for_rest, $arr_info['scid'], $rest, $arr_story_info);
                    }
                }

            }else {
                //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                $this->db->query("UPDATE prog_lvl_".$lvl." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);

                $arr_story_info['event'] = 'up_by_community_baklen_pool';
                $arr_story_info['lvl'] = $lvl;
                $arr_story_info['scid'] = $arr_info['id'];

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$sum.", 1, '".time()."')");
            }

        }

    }
    //функция начисления на счет для оставшихся средств от закрытых шкал в последних уровнях без реинвеста
    public function up_user_ovebill($user, $sum) {

        $this->db->query("UPDATE users SET rest_amount_btc=rest_amount_btc+".$sum." WHERE id=".$user);
        $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES(8228, 'PCT', $user, $sum, now())");

    }
    //функция определения уровня в котором необходимо создать шкалу + создание шкал
    public function creating_scales($arr_info, $lvl) {


        // for ($i=1; $i <= 13; $i++) { 
        //     $arr_f_lvls[1] = $i;
        // }

        // for ($i=14; $i <= 24; $i++) { 
        //     $arr_f_lvls[2] = $i;
        // }

        // for ($i=25; $i <= 33; $i++) { 
        //     $arr_f_lvls[3] = $i;
        // }

        // for ($i=34; $i <= 42; $i++) { 
        //     $arr_f_lvls[4] = $i;
        // }


        //если системная шкала, пересоздаем в уровне
        if($arr_info['id'] != 1) {
            //если уровни предусматривают создание шкалы в новом уровне - создаем   
            if($lvl >= 1 && $lvl <= 12) {
                $lvl = $lvl+1;
            }elseif($lvl >= 14 && $lvl <= 23){
                $lvl = $lvl+1;
            }elseif($lvl >= 25 && $lvl <= 32){
                $lvl = $lvl+1;
            }elseif($lvl >= 34 && $lvl <= 41){
                $lvl = $lvl+1;
            }elseif($lvl == 13) {
                $lvl['field_name'] = 'reinv_1';
                $lvl['lvl_for_r'] = 1;
            }elseif($lvl == 24) {
                $lvl['field_name'] = 'reinv_10';
                $lvl['lvl_for_r'] = 10;
            }elseif($lvl == 44) {
                $lvl['field_name'] = 'reinv_100';
                $lvl['lvl_for_r'] = 100;
            }elseif($lvl == 42) {
                $lvl['field_name'] = 'reinv_1000';
                $lvl['lvl_for_r'] = 1000;
            }

            if(!is_array($lvl)) {
                $this->create_new_scale($lvl, $arr_info['uid'], $arr_info['scid']);
            }else{
                //раз мы выключили реинвест, нужно изменять статус при закрытии последней шкалы
                $ArrayOfUserScales = $this->get_accs_array($arr_inf['uid']);
                if(count($ArrayOfUserScales) == 0) {
                    $this->db->query("UPDATE users SET bonus_active_status=0 WHERE id=".$arr_inf['uid']);
                }
                // $query = $this->db->query("SELECT ".$lvl['field_name']." FROM users WHERE id=".$arr_inf['uid']);
                // $arr_user = $query->row_array();
                // //если реинвест включен
                // if($arr_user[$lvl['field_name']] == 1) {
                //     $this->create_new_scale($lvl['lvl_for_r'], $arr_info['uid'], $arr_info['scid']);
                //     $lvl = $lvl['lvl_for_r'];
                // }else {
                //     $lvl = 0;
                // }
            }
        }else{
            $this->re_create_system_scale($lvl);
        }
        return $lvl;

    }
    //Начисления в верхнюю шкалу уровня
    public function up_lvl_scale($arr, $arr_story_info) {

        foreach ($arr as $key => $value) {

            // for ($i=1; $i <= 13; $i++) { 
            //     $arr_f_lvls[1] = $i;
            // }

            // for ($i=14; $i <= 24; $i++) { 
            //     $arr_f_lvls[2] = $i;
            // }

            // for ($i=25; $i <= 33; $i++) { 
            //     $arr_f_lvls[3] = $i;
            // }

            // for ($i=34; $i <= 42; $i++) { 
            //     $arr_f_lvls[4] = $i;
            // }

            //ищем самую верхнюю шкалу текущего уровня
            $query_1 = $this->db->query("SELECT t1.id, t1.uid, t1.scid, t1.current_sum, t1.max_sum FROM prog_lvl_".$key." as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t2.date_end_activation>".time()." AND t1.status=1 ORDER BY t1.id ASC LIMIT 1");
            $arr_info = $query_1->row_array();

            if($arr_info['current_sum']+$value >= $arr_info['max_sum']) {
                //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                $this->db->query("UPDATE prog_lvl_".$key." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                $arr_story_info['event'] = 'up_lvl_scale';
                $arr_story_info['lvl'] = $key;
                $arr_story_info['scid'] = $arr_info['id'];

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 2, '".time()."')");

                //инициация создания шкал в результате закрытия
                $this->creating_scales($arr_info, $key);

                //инициируем распределение в следствии заполнения шкалы уровня
                $this->start_distribution('lvl_'.$key, $arr_info['uid']);

                //если деньги еще остались - они ложаться в новую верхнюю шкалу этого уровня
                if($arr_info['current_sum']+$value > $arr_info['max_sum']) {
                    $rest = $arr_info['current_sum']+$value-$arr_info['max_sum'];
                    $this->up_lvl_scale(array($key => $rest), $arr_story_info);
                }

            }else {
                //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                $this->db->query("UPDATE prog_lvl_".$key." SET current_sum=current_sum+$value WHERE id=".$arr_info['id']);

                $arr_story_info['event'] = 'up_lvl_scale';
                $arr_story_info['lvl'] = $key;
                $arr_story_info['scid'] = $arr_info['id'];

                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$value.", 2, '".time()."')");
            }
        }

    }
    //Спонсорские отчисления
    public function up_sponsor($user, $sum, $arr_story_info, $after = 0) {

        $this->create_logs('user - '.$user.' sum - '.$sum);

        //если мы считаем от системы то нам нужно распределить все средства по всем аккаунтам системы, так как спонсора у нас нет
        if($user == 1) {

            //равная часть на каждый из аккаунтов всех 18-ти уровней 1-9 10-70 100-600 1000-5000 9+7+6+5
            if($after == 0) {
                $sum = bcdiv($sum, 42, 4);
            }

            //ситуация в случае остатка от заполнения шкалы какого-то уровня, остаток падает на пересозданную шкалу того уровня
            if($after != 0) {

                $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$after." WHERE uid=1 AND status=1");
                $row = $query_1->row_array();
                $arr_info = $row;

                if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {
                    //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                    $this->db->query("UPDATE prog_lvl_".$after." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                    $arr_story_info['event'] = 'up_sponsor';
                    $arr_story_info['lvl'] = $after;
                    $arr_story_info['scid'] = $arr_info['id'];

                    $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 33, '".time()."')");
                    $this->re_create_system_scale($after);

                    //инициируем распределение в следствии заполнения шкалы уровня
                    $this->start_distribution('lvl_'.$after, 1);

                    if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                        $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                        $this->up_sponsor(1, $rest, $arr_story_info, $after);
                    }

                }else {
                    //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                    $this->db->query("UPDATE prog_lvl_".$after." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);

                    $arr_story_info['event'] = 'up_sponsor';
                    $arr_story_info['lvl'] = $after;
                    $arr_story_info['scid'] = $arr_info['id'];

                    $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$sum.", 33, '".time()."')");
                }

            }else {

                // for ($i=1; $i <= 13; $i++) { 
                //     $arr_f_lvls[1] = $i;
                // }

                // for ($i=14; $i <= 24; $i++) { 
                //     $arr_f_lvls[2] = $i;
                // }

                // for ($i=25; $i <= 33; $i++) { 
                //     $arr_f_lvls[3] = $i;
                // }

                // for ($i=34; $i <= 42; $i++) { 
                //     $arr_f_lvls[4] = $i;
                // }

                //ищем в уровнях 1-7
                for($i = 1; $i <= 42; $i++) {
                    $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=1 AND status=1");
                    $row = $query_1->row_array();
                    $arr_info = $row;

                    if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {
                        //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в этом уровне + инициируем распределение
                        $this->db->query("UPDATE prog_lvl_".$i." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                        $arr_story_info['event'] = 'up_sponsor';
                        $arr_story_info['lvl'] = $i;
                        $arr_story_info['scid'] = $arr_info['id'];

                        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 31, '".time()."')");
                        $this->re_create_system_scale($i);

                        //инициируем распределение в следствии заполнения шкалы уровня
                        $this->start_distribution('lvl_'.$i, 1);

                        if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                            $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                            $this->up_sponsor(1, $rest, $arr_story_info, $i);
                        }

                    }else {
                        //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                        $this->db->query("UPDATE prog_lvl_".$i." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);

                        $arr_story_info['event'] = 'up_sponsor';
                        $arr_story_info['lvl'] = $i;
                        $arr_story_info['scid'] = $arr_info['id'];

                        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$sum.", 31, '".time()."')");
                    }
                }

            }
        }else {

            $this->create_logs('user не 1 ');

            //если же нет - мы ищем спонсора
            $query = $this->db->query("SELECT id, percent_sponsor_cashback, date_end_activation, bonus_active_status FROM users WHERE id=(SELECT idsponsor FROM users WHERE id=".$user.")");
            $row = $query->row_array();

            if($row['id'] == 2) {
                //если это спец акк без шкал то просто ложим ему на счет все 100%
                $this->up_shoping_konto($row['id'], $sum, $arr_story_info);
            }elseif($row['bonus_active_status'] == 1) {

                $this->create_logs('user активирован ');

                $SumForSponsorCashback = $sum;

                //если он имеет шкалы то
                if($row['date_end_activation'] > time()) {
                    $this->create_logs('user с активацией ');
                    //если у него есть активация то используя его настройки начисляем и в шкалы и на баланс

                    //получаем массив шкал пользователя
                    $arr_info = $this->get_accs_array($row['id']);

                    //определяем реальную сумму на основе количества найденных аккаунтов
                    $sum = bcdiv(bcmul($sum, bcdiv(100-$row['percent_sponsor_cashback'], 100, 2), 4), count($arr_info), 4);

                    //идя по всем таблицам распихиваем по шкалам
                    foreach ($arr_info as $key => $value) {

                        $table_number = $arr_info[$key]['table'];
                        
                        if($arr_info[$key]['current_sum']+$sum >= $arr_info[$key]['max_sum']) {
                            //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                            $this->db->query("UPDATE prog_lvl_".$table_number." SET current_sum=max_sum, status=2 WHERE id=".$arr_info[$key]['id']);

                            $arr_story_info['event'] = 'up_sponsor';
                            $arr_story_info['lvl'] = $table_number;
                            $arr_story_info['scid'] = $arr_info[$key]['id'];

                            $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info[$key]['uid'].", ".$arr_info[$key]['id'].", '".json_encode($arr_story_info)."', ".($arr_info[$key]['max_sum'] - $arr_info[$key]['current_sum']).", 32, '".time()."')");
        
                            //инициация создания шкал в результате закрытия
                            $lvl_for_rest = $this->creating_scales($arr_info[$key], $table_number);

                            //инициируем распределение в следствии заполнения шкалы уровня
                            $this->start_distribution('lvl_'.$table_number, $arr_info[$key]['uid']);

                            //если деньги еще остались - они ложаться в новую верхнюю шкалу этого уровня
                            if($arr_info[$key]['current_sum']+$sum > $arr_info[$key]['max_sum']) {
                                $rest = $arr_info[$key]['current_sum']+$sum-$arr_info[$key]['max_sum'];
                                if($lvl_for_rest == 0) {
                                    $this->up_user_ovebill($arr_info[$key]['uid'], $rest);
                                }else {
                                    $this->to_use_rest($lvl_for_rest, $arr_info[$key]['scid'], $rest, $arr_story_info);
                                }
                            }
                            
                        }else {
                            //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                            $this->db->query("UPDATE prog_lvl_".$table_number." SET current_sum=current_sum+$sum WHERE id=".$arr_info[$key]['id']);

                            $arr_story_info['event'] = 'up_sponsor';
                            $arr_story_info['lvl'] = $table_number;
                            $arr_story_info['scid'] = $arr_info[$key]['id'];

                            $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info[$key]['uid'].", ".$arr_info[$key]['id'].", '".json_encode($arr_story_info)."', ".$sum.", 32, '".time()."')");
                        }
                    }

                }else {
                    $this->create_logs('но без активации ');
                    //если у него нет активации то ложим на баланс 30% игнорируя настройки, а 70% идут в комьюнити
                    $row['percent_sponsor_cashback'] = 30;
                    $this->up_pool_community_baklen(bcmul($sum, 0.7, 2), $arr_story_info);
                }

                if($row['percent_sponsor_cashback'] != 0) {
                    $this->up_shoping_konto($row['id'], bcmul($SumForSponsorCashback, bcdiv($row['percent_sponsor_cashback'], 100, 2), 2), array('type' => 'sponsor', 'from_user' => $user));
                }

            }else {

                $this->up_shoping_konto($row['id'], bcmul($sum, 0.1, 2), array('type' => 'sponsor', 'from_user' => $user));

                //если нет активного спонсора - значит он бесплатный, значит он получает 10% суммы, остальные 90% в комьюнити пул
                // $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul($sum, 0.1, 2)." WHERE id=".$row['id']);
                // $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES(9167, 'PCT', ".$row['id'].", ".bcmul($sum, 0.1, 2).", now())");

                $this->up_pool_community_baklen(bcmul($sum, 0.9, 2), $arr_story_info);
            }
        }

    }
    //Командные отчисления
    public function up_team($user, $sum, $arr_story_info, $after = 0) {

        $first_user = $user;

        //если мы считаем от системы то нам нужно распределить все средства по всем аккаунтам системы, так как спонсора у нас нет
        if($user == 1) {

            //равная часть на каждый из аккаунтов всех 18-ти уровней 1-7 10-60 100-500
            if($after == 0) {
                $sum = bcdiv($sum, 42, 4);
            }

            //ситуация в случае остатка от заполнения шкалы какого-то уровня, остаток падает на пересозданную шкалу того уровня
            if($after != 0) {

                $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$after." WHERE uid=1 AND status=1");
                $row = $query_1->row_array();
                $arr_info = $row;

                if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {

                    //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                    $this->db->query("UPDATE prog_lvl_".$after." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                    $arr_story_info['event'] = 'up_team';
                    $arr_story_info['lvl'] = $after;
                    $arr_story_info['scid'] = $arr_info['id'];

                    $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 43, '".time()."')");
                    $this->re_create_system_scale($after);

                    //инициируем распределение в следствии заполнения шкалы уровня
                    $this->start_distribution('lvl_'.$after, 1);

                    if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                        $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                        $this->up_team(1, $rest, $arr_story_info, $after);
                    }

                }else {
                    // $this->create_logs('не заполнили шкалу, просто начисляем - '.$sum);
                    //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                    $this->db->query("UPDATE prog_lvl_".$after." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);

                    $arr_story_info['event'] = 'up_team';
                    $arr_story_info['lvl'] = $after;
                    $arr_story_info['scid'] = $arr_info['id'];

                    $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", ".$sum.", '".json_encode($arr_story_info)."', 43, '".time()."')");
                }

            }else {

                //ищем в уровнях 1-7
                for($i = 1; $i <= 42; $i++) {

                    $query_1 = $this->db->query("SELECT id, uid, scid, current_sum, max_sum FROM prog_lvl_".$i." WHERE uid=1 AND status=1");
                    $row = $query_1->row_array();
                    $arr_info = $row;

                    if($arr_info['current_sum']+$sum >= $arr_info['max_sum']) {

                        //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                        $this->db->query("UPDATE prog_lvl_".$i." SET current_sum=max_sum, status=2 WHERE id=".$arr_info['id']);

                        $arr_story_info['event'] = 'up_team';
                        $arr_story_info['lvl'] = $i;
                        $arr_story_info['scid'] = $arr_info['id'];

                        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".($arr_info['max_sum']-$arr_info['current_sum']).", 41, '".time()."')");

                        $this->re_create_system_scale($i);

                        //инициируем распределение в следствии заполнения шкалы уровня
                        $this->start_distribution('lvl_'.$i, 1);

                        if($arr_info['current_sum']+$sum > $arr_info['max_sum']) {
                            $rest = $arr_info['current_sum']+$sum-$arr_info['max_sum'];
                            
                            $this->up_team(1, $rest, $arr_story_info, $i);

                        }

                    }else {
                        //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                        $this->db->query("UPDATE prog_lvl_".$i." SET current_sum=current_sum+$sum WHERE id=".$arr_info['id']);

                        $arr_story_info['event'] = 'up_team';
                        $arr_story_info['lvl'] = $i;
                        $arr_story_info['scid'] = $arr_info['id'];

                        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info['uid'].", ".$arr_info['id'].", '".json_encode($arr_story_info)."', ".$sum.", 41, '".time()."')");

                    }
                }

            }
        }else {

            //сохранение суммы + разделение её на 10 аккаунтов команды
            $all_sum = $sum;
            $sum_one = bcdiv($sum, 10, 4);

            //взяли споносра изначально для того чтобы уйти на 11 лвлов вверх а не на 10, потому что первый вышестоящий(непосредственный спонсор) он получает спонсорские и не получает командные
            $query = $this->db->query("SELECT idsponsor, percent_team_cashback FROM users WHERE id=".$user);
            $row = $query->row_array();
            $user = $row['idsponsor'];

            //если же нет - мы ищем аккаунты команд во всех столах
            for($i = 1; $i <= 10; $i++) {
                

                if($user == 1) {
                    //если его нет - оставшиеся средства начисляем всем шкалам фирмы
                    $sum = bcmul($sum_one, 10-$i+1, 4);
                    $this->up_team(1, $sum, $arr_story_info);
                    break;
                }else{
                    //проверяем спонсора на активацию + посещение последние 3 дня
                    $query = $this->db->query("SELECT id, percent_team_cashback, date_end_activation, bonus_active_status, DateLastVisit FROM users WHERE id=(SELECT idsponsor FROM users WHERE id=".$user.")");
                    $row = $query->row_array();
                    $user = $row['id'];

                    if($user == 2) {
                        //если спец пользователь - все на баланс
                        $this->up_shoping_konto($row['id'], $sum_one, $arr_story_info);
                    }elseif($row['date_end_activation'] > time() && $row['bonus_active_status'] == 1 && time()-$row['DateLastVisit'] < 259200) {

                        //получаем массив шкал пользователя
                        $arr_info = $this->get_accs_array($row['id']);

                        //определяем реальную сумму на основе количества найденных аккаунтов
                        $sum = bcdiv(bcmul($sum_one, bcdiv(100-$row['percent_team_cashback'], 100, 2), 4), count($arr_info), 4);
                        
                        //идя по всем таблицам распихиваем по шкалам
                        foreach ($arr_info as $key => $value) {

                            $table_number = $arr_info[$key]['table'];
                                

                            if($row['percent_team_cashback'] != 0) {
                                $this->up_shoping_konto($user, bcdiv(bcmul($sum_one, bcdiv($row['percent_team_cashback'], 100, 2), 4), count($arr_info), 4), array('type' => 'team', 'from_user' => $first_user));
                            }

                            if($arr_info[$key]['current_sum']+$sum >= $arr_info[$key]['max_sum']) {


                                //если сумма, вкладываемая в шкалу заполняет её, то создаем шкалу в след уровне + инициируем распределение
                                $this->db->query("UPDATE prog_lvl_".$table_number." SET current_sum=max_sum, status=2 WHERE id=".$arr_info[$key]['id']);

                                $arr_story_info['event'] = 'up_team';
                                $arr_story_info['lvl'] = $table_number;
                                $arr_story_info['scid'] = $arr_info[$key]['id'];

                                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info[$key]['uid'].", ".$arr_info[$key]['id'].", '".json_encode($arr_story_info)."', ".($arr_info[$key]['max_sum']-$arr_info[$key]['current_sum']).", 42, '".time()."')");
            
                                //инициация создания шкал в результате закрытия
                                $scale_for_rest = $this->creating_scales($arr_info[$key], $table_number);

                                //инициируем распределение в следствии заполнения шкалы уровня
                                $this->start_distribution('lvl_'.$table_number, $arr_info[$key]['uid']);

                                //если деньги еще остались - они ложаться в новую верхнюю шкалу этого уровня
                                if($arr_info[$key]['current_sum']+$sum > $arr_info[$key]['max_sum']) {
                                    $rest = $arr_info[$key]['current_sum']+$sum-$arr_info[$key]['max_sum'];
                                    // $this->create_logs('остаток = '.$rest);
                                    if($scale_for_rest == 0) {
                                        $this->up_user_ovebill($arr_info[$key]['uid'], $rest);
                                    }else {
                                        $this->to_use_rest($scale_for_rest, $arr_info[$key]['scid'], $rest, $arr_story_info);
                                    }
                                }
                                
                            }else {
                                //если сумма, вкладываемая в шкалу НЕ заполняет её, то просто ложим туда средства и все
                                $this->db->query("UPDATE prog_lvl_".$table_number." SET current_sum=current_sum+$sum WHERE id=".$arr_info[$key]['id']);

                                $arr_story_info['event'] = 'up_team';
                                $arr_story_info['lvl'] = $table_number;
                                $arr_story_info['scid'] = $arr_info[$key]['id'];

                                $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(".$arr_info[$key]['uid'].", ".$arr_info[$key]['id'].", '".json_encode($arr_story_info)."', ".$sum.", 42, '".time()."')");
                            }
                        }
                    }else {
                        //если не выполнены условия - ложим в комьюнити пул
                        $this->up_pool_community_baklen($sum_one, $arr_story_info);

                    }
                }
            }
        }


    }
    //функция создания новой шкалы пользователя
    public function create_new_scale($number, $user, $scid = 0) {

        switch (true) {
            case ($number>=1 && $number<=13):
                for($i = 1; $i <= 13; $i++) {
                    $query_1 = $this->db->query("SELECT scid FROM prog_lvl_".$i." WHERE uid=".$user.' AND status=1');
                    if($query_1->num_rows() > 0) {
                        $res_arr = $query_1->row_array();
                        $isset_scid = $res_arr['scid'];
                    }
                }
                break;
            case ($number>=14 && $number<=24):
                for($i = 14; $i <= 24; $i++) {
                    $query_1 = $this->db->query("SELECT scid FROM prog_lvl_".$i." WHERE uid=".$user.' AND status=1');
                    if($query_1->num_rows() > 0) {
                        $res_arr = $query_1->row_array();
                        $isset_scid = $res_arr['scid'];
                    }
                }
                break;
            case ($number>=25 && $number<=33):
                for($i = 25; $i <= 33; $i++) {
                    $query_1 = $this->db->query("SELECT scid FROM prog_lvl_".$i." WHERE uid=".$user.' AND status=1');
                    if($query_1->num_rows() > 0) {
                        $res_arr = $query_1->row_array();
                        $isset_scid = $res_arr['scid'];
                    }
                }
                break;
            case ($number>=34 && $number<=42):
                for($i = 34; $i <= 42; $i++) {
                    $query_1 = $this->db->query("SELECT scid FROM prog_lvl_".$i." WHERE uid=".$user.' AND status=1');
                    if($query_1->num_rows() > 0) {
                        $res_arr = $query_1->row_array();
                        $isset_scid = $res_arr['scid'];
                    }
                }
                break;
        }

        if(!isset($isset_scid)) {

            if($scid == 0) {
                $query_sc = $this->db->query("SELECT max(scid) as max FROM scale_ids");
                $row_sc = $query_sc->row_array();

                $scid = $row_sc['max']+1;

                $this->db->query("INSERT INTO scale_ids(scid) VALUES(".$scid.")");
            }

            $this->db->query("INSERT INTO prog_lvl_".$number."(uid, scid, date_in) VALUES($user, $scid, '".time()."')");

        }else{
            $scid = $isset_scid;
        }

        return $scid;

    }
    //функция пересоздания новой шкалы системы
    public function re_create_system_scale($number) {

        $this->db->query("INSERT INTO prog_lvl_".$number."(uid, scid, date_in) VALUES(1, 1, '".time()."')");

    }

    //Пул "Community Baklen"
    public function up_pool_community_baklen($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET community_baklen=community_baklen+".$sum);

        $arr_story_info['event'] = 'up_cb_pool';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 731, '".time()."')");

    }
    //Пул "Investment Pool"
    public function up_pool_investment($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET invest_pool=invest_pool+".$sum);

        $arr_story_info['event'] = 'up_i_pool';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 732, '".time()."')");

    }
    //Пул "Liga Pool"
    public function up_pool_liga($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET liga_pool=liga_pool+".$sum);

        $arr_story_info['event'] = 'up_l_pool';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 733, '".time()."')");

    }
    //Пул "Grunder Pool"
    public function up_pool_grunder($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET grunder_pool=grunder_pool+".$sum);

        $arr_story_info['event'] = 'up_gr_pool';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 734, '".time()."')");

    }
    //Отложенные начисления, спец счет, с которого пользователь в будущем сможет средства использовать
    public function up_shoping_konto($user, $sum, $arr_story_info) {

        if(!empty($arr_story_info)) {

            if($arr_story_info['type'] == 'sponsor') {
                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$sum." WHERE id=".$user);
                $this->db->query("INSERT INTO payments(type, currency, idsender, amount, hash_pe, actiondate) VALUES(99873, 'PCT', $user, $sum, '".$arr_story_info['from_user']."', now())");
            }elseif($arr_story_info['type'] == 'team') {
                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$sum." WHERE id=".$user);
                $this->db->query("INSERT INTO payments(type, currency, idsender, amount, hash_pe, actiondate) VALUES(98873, 'PCT', $user, $sum, '".$arr_story_info['from_user']."', now())");
            }else {
                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$sum." WHERE id=".$user);
                $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES(9873, 'PCT', $user, $sum, now())");
            }

        }else {

            $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$sum." WHERE id=".$user);
            $this->db->query("INSERT INTO payments(type, currency, idsender, amount, actiondate) VALUES(9873, 'PCT', $user, $sum, now())");

        }

    }
    //Кешбек пользователю
    public function up_cashback($user, $sum, $arr_story_info) {

        $this->db->query("UPDATE users SET cashback=cashback+".$sum." WHERE id=".$user);
        $this->db->query("INSERT INTO payments(type, currency, idsender, amount, hash_pe, actiondate) VALUES(9874, 'PCT', 0, $sum, 'cashback for user ".$user."', now())");

    }
    //Системные средства (остаются в системе, как оплата платежек) kosten
    public function up_system_bill($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET system_bill_kosten=system_bill_kosten+".$sum);

        $arr_story_info['event'] = 'up_sysbill';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 735, '".time()."')");

    }
    //Системные средства (остаются в системе, как оплата платежек) stripes payment
    public function up_system_bill_sp($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET system_bill_sp=system_bill_sp+".$sum);

        $arr_story_info['event'] = 'up_stripes_payment';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 736, '".time()."')");

    }
    //Системные средства (остаются в системе, как оплата платежек) rest of packets and activations
    public function up_system_bill_rest($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET system_bill_rest=system_bill_rest+".$sum);

        $arr_story_info['event'] = 'up_rest';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 737, '".time()."')");

    }
    //Системные средства (остаются в системе, как оплата платежек) tax of packets and activations
    public function up_system_bill_tax($sum, $arr_story_info) {

        $this->db->query("UPDATE bonus_prog_mark_settings SET system_bill_tax=system_bill_tax+".$sum);

        $arr_story_info['event'] = 'up_tax';
        $arr_story_info['lvl'] = 0;
        $arr_story_info['scid'] = 0;

        $this->db->query("INSERT INTO spec_scales_hystory(uid, scid, reason, sum, type, date) VALUES(1, 0, '".json_encode($arr_story_info)."', ".$sum.", 738, '".time()."')");

    }
    //Функция распределения пула
    public function start_pool_distribution($type) {
        switch ($type) {
            case 'comm_bak':

                $query = $this->db->query("SELECT comm_bakl_for_distr FROM bonus_prog_mark_settings");
                $row = $query->row_array();
                $sum = $row['comm_bakl_for_distr'];
                $first_value = $row['comm_bakl_for_distr'];
                //разбили всю сумму на 18 уровней
                $sum_per_lvl = bcdiv($sum, 42, 4);
                //дальше для проверки взяли 75% от суммы каждого уровня
                $sum_per_lvl_for_upper = bcmul($sum_per_lvl, 0.25, 4);
                $sum_per_lvl_for_check = bcmul($sum_per_lvl, 0.75, 4);
                
                //инициировали массив уровней
                $arr_of_lvls = [];
                for ($c=1; $c <= 42; $c++) { 
                    $arr_of_lvls[] = $c;
                }

                $arr_of_counts = $arr_of_lvls;

                //проверяем, изменив все значения активных шкал в "проверяемые пулом", сколько таких шкал, и без первой, куда идет 25% считаем хватает ли нам средств чтобы на каждого пришлось больше 1 цента
                foreach ($arr_of_lvls as $key => $value) {

                    // INNER JOIN users as t2 ON t1.ID=t2.id SET t1.answer='Please indicate the correct format of the link.123' WHERE t2.login='firma'

                    // $this->db->query("UPDATE prog_lvl$value as t1 INNER JOIN users as t2 ON t1.uid=t2.id SET t1.status_pool=1 WHERE t1.status=1 AND t2.date_end_activation>".time());
                    $this->db->query("UPDATE prog_lvl_".$value." SET status_pool=1 WHERE status=1 AND (status_pool=1 OR status_pool=0)");

                    $resCount = $this->db->query("SELECT COUNT(*) as count FROM prog_lvl_".$value." as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.status=1 AND t1.status_pool=1 AND t2.date_end_activation>".time());
                    $arrCount = $resCount->row_array();

                    // $count_accs = $this->db->affected_rows;
                    $count_accs = $arrCount['count'];

                    if($count_accs == 0) {
                        $sum_per_scale = 0;
                    }elseif($count_accs == 1) {
                        $arr_of_counts[$value] = 1;
                        $first_value -= $sum_per_lvl_for_check;
                    }else {
                        $sum_per_scale = bcdiv($sum_per_lvl_for_check, $count_accs-1, 4);
                    }
                    if($sum_per_scale >= 0.01) {
                        $arr_of_counts[$value] = $sum_per_scale;
                    }else {
                        echo $count_accs."UPDATE prog_lvl_".$value." SET status_pool=1 WHERE status=1".'<br>Not enought money per scale('.$sum_per_scale.' | '.$sum_per_lvl_for_check.'). <a href="/marketing_test/panel_page">Back</a>';
                        //"UPDATE prog_lvl$value as t1 INNER JOIN users as t2 ON t1.uid=t2.id SET t1.status_pool=1 WHERE t1.status=1 AND t2.date_end_activation>".time().
                        exit();
                    }
                }

                //нужно для определения верхней шкалы уровня
                $i = 0;

                $arr_story_info = array(
                    'type' => 'comm_bakl_pool',
                    'uid'  => 0
                );

                //идем по всем уровням
                foreach ($arr_of_lvls as $key => $value) {
                    //берем все отмеченные нами шкалы
                    $res = $this->db->query("SELECT * FROM prog_lvl_".$value." WHERE status_pool=1 AND status=1 ORDER BY id ASC");
                    foreach ($res->result_array() as $row) {
                        //рассматривая каждую шкалу
                        if($i == 0) {
                            //если шкала первая начисляем 25%
                            $this->up_scale_by_community_baklen_pool($value, $row['scid'], $sum_per_lvl_for_upper, $arr_story_info);
                        }else {
                            //если шкала любая другая - тогда начисляем 75% на всех
                            $this->up_scale_by_community_baklen_pool($value, $row['scid'], $arr_of_counts[$value], $arr_story_info);
                        }
                        $i++;
                    }
                    $this->db->query("UPDATE prog_lvl_".$value." SET status_pool=0");
                    //в этом месте сбрасываем счетчик для обнаружения первого в новом уровне
                    $i = 0;
                }

                $this->db->query("UPDATE bonus_prog_mark_settings SET comm_bakl_for_distr=comm_bakl_for_distr-".$first_value);
                break;
            case 'invest':
                //вручную
                break;
            case 'liga':
                # code...
                break;
            case 'grunder':
                # code...
                break;
            default:
                # code...
                break;
        }
    }
}
