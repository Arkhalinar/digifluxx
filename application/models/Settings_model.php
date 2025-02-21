<?php
class Settings_model extends CI_Model {

    private $table_name = "settings";

    public $smtp_host;
    public $smtp_user;
    public $smtp_pass;
    public $smtp_port;
    public $blockchain_wallet_id;
    public $blockchain_password;
    public $blockchain_api_key;
    public $blockchain_xpub;
    public $withdraw_percentage;
    public $registered_opened;
    public $site_opened;
    public $start_date;
    public $site_name;

    public function __construct() {
        parent::__construct();
    }

    public function get_packets() {
        $query = $this->db->query('SELECT * FROM manual_packets');

        $arr = array();

        foreach ($query->result_array() as $row) {
                $arr[] = $row;
        }

        return $arr;
    }

    public function get_main_stat() {
        $res = $this->db->query("SELECT COUNT(*) as count1 FROM users");
        $arr = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count2 FROM users WHERE TO_DAYS(regdate) = TO_DAYS(now())");
        $arr2 = $res->row_array();

        $res = $this->db->query("SELECT sum(amount) as sum3 FROM payments WHERE type=3 AND status=1");
        $arr3 = $res->row_array();

        return array_merge($arr, $arr2, $arr3);
    }

     public function get_stat($uid) {
        // ВСЕГО ЗАРАБОТАНО
        // 0
        // ЗАРАБОТАНО РЕФФЕРАЛЬНЫХ
        // 0
        // ЗАРАБОТАНО НА КЛИКАХ
        // 0
        // ВСЕГО ВЫВЕДЕНО
        // 0
        // ПОСЛЕДНЯЯ ВЫПЛАТА
        // 0
        // ВСЕГО КЛИКОВ
        // 0
        // КЛИКОВ СЕГОДНЯ
        // 0

        // $query = $this->db->query('SELECT name FROM my_table LIMIT 1');
        // $row = $query->row();
        // echo $row->name;
    }

    public function update_settings() {
        if($this->input->post('site') != null)
            $this->site_opened = 1;
        else
            $this->site_opened = 0;

        if($this->input->post('reg') != null)
            $this->registered_opened = 1;
        else
            $this->registered_opened = 0;

        $this->smtp_host = $this->input->post('smtp_host');
        $this->smtp_user = $this->input->post('smtp_user');
        $this->smtp_pass = $this->input->post('smtp_pass');
        $this->smtp_port = $this->input->post('smtp_port');
        $this->blockchain_wallet_id = $this->input->post('bch_wallet_id');
        $this->blockchain_password = $this->input->post('bch_password');
        $this->blockchain_api_key = $this->input->post('api_key');
        $this->blockchain_xpub = $this->input->post('xpub');
        $this->start_date = $this->input->post('start_date');
        $this->withdraw_percentage = $this->input->post('percent');
        $this->site_name = $this->input->post('site_name');

        $this->db->update($this->table_name, $this);
    }

    public function update_coin_val($Val) {
        $this->db->query("UPDATE settings SET RemCoins=RemCoins-".$Val);
        $this->db->query("INSERT INTO take_out_coins(Amount, Type, Date) VALUES(".$Val.", 1, now())");
    }

    public function update_coin_val_cron($Val) {
        $this->db->query("UPDATE settings SET DateLastUpdate=now(), RemCoins=RemCoins-".$Val);
        $this->db->query("INSERT INTO take_out_coins(Amount, Type, Date) VALUES(".$Val.", 2, now())");
    }

    public function update_coin_cron_min_choose($Val) {
        $this->db->query("UPDATE settings SET Sel_Min_Count=".$Val);
    }

    public function check_cron_time($Val) {
        $query = $this->db->query("SELECT * FROM settings WHERE DateLastUpdate IS NULL");
        if(count($query->result_array()) > 0) {
            return true;
        }else {
            $query = $this->db->query("SELECT * FROM settings WHERE DateLastUpdate<=now() - INTERVAL ".$Val." MINUTE");
            if(count($query->result_array()) > 0) {
                return true;
            }else {
                return false;
            }
        }
    }
    
    public function get_hist() {
        $query = $this->db->query('SELECT * FROM take_out_coins ORDER BY DATE DESC');

        $arr = array();

        foreach ($query->result_array() as $row) {
                $arr[] = $row;
        }

        return $arr;
    }

    public function update_fake_active($status, $min_m, $max_m, $min_c, $max_c) {
        if($status) {
            $status = 1;
            $addstr = '';
        }else {
            $status = 0;
            $addstr = ', DateLastUpdate=NULL';
        }
        $this->db->query("UPDATE settings SET Active_Fake_Buying=".$status.", Min_time=".$min_m.", Max_time=".$max_m.", Min_coin=".$min_c.", Max_coin=".$max_c.$addstr);
    }

    public function UpCount($refuser) {
        // echo 1;
        if(is_numeric($refuser)) {
            // echo 2;
            $this->db->query("INSERT INTO refs_vis(reflink, date) VALUES('".$refuser."', now())");
            // echo "UPDATE users SET CountRefsStep=CountRefsStep+1 WHERE reflink='".$refuser."'";
        }
        // echo 3;
        // exit();
    }

    public function get_settings() {
        return $this->db->get($this->table_name)->row_array();
    }

    public function updateFake($fake_us, $fake_in, $fake_out) {
        $this->db->update($this->table_name, array('Fake_us' => $fake_us, 'Fake_in' => $fake_in, 'Fake_out' => $fake_out));
    }

    public function updateCur($BTC, $ETH, $LTC, $BCH, $DASH) {
        $f = fopen('AAA_LOGS_CRON_1.txt', 'a+');
        fwrite($f, time().' btc - '.$BTC.' eth - '.$ETH.' ltc - '.$LTC.' bch - '.$BCH.' dash - '.$DASH."\n\r");
        $this->db->query("UPDATE settings SET BTC=".$BTC.", ETH=".$ETH.", LTC=".$LTC.", BCH=".$BCH.", DASH=".$DASH);
        fwrite($f, "UPDATE settings SET BTC=".$BTC.", ETH=".$ETH.", LTC=".$LTC.", BCH=".$BCH.", DASH=".$DASH."\n\r");
    }

    public function updateCom($BTC, $ETH, $LTC, $BCH, $DASH) {
        $f = fopen('AAA_LOGS_CRON_2.txt', 'a+');
        fwrite($f, time().' btc - '.$BTC.' eth - '.$ETH.' ltc - '.$LTC.' bch - '.$BCH.' dash - '.$DASH."\n\r");
        $this->db->query("UPDATE settings SET com_BTC=".$BTC.", com_ETH=".$ETH.", com_LTC=".$LTC.", com_BCH=".$BCH.", com_DASH=".$DASH);
        fwrite($f, "UPDATE settings SET BTC=".$BTC.", ETH=".$ETH.", LTC=".$LTC.", BCH=".$BCH.", DASH=".$DASH."\n\r");
    }
}