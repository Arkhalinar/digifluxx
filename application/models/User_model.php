<?php
class User_model extends CI_Model {

    private $table_name = 'users';

    public $login;
    public $password;
    public $fin_password;
    public $email;
    public $btc_address;
    public $skype;
    public $last_ip;
    public $mobile_num;
    public $name;
    public $lastname;
    public $country;
    public $status = 1; //1 - неактивен, т.е. не подтвердил емейл, 2 - активен, 3 - проплачен, 4 - заблокирован
    public $idsponsor = 1;
    public $amount_btc = 0;
	public $u_lang = '';
	public $visited_reflink = '';
    public $special_ref_string = '[]';

    public function __construct() {
        parent::__construct();
    }
    public function SetCustomerId($uid, $cusid) {
        $this->db->query("UPDATE users SET customer_id='".$cusid."' WHERE id=".$uid);
    }
    public function ChStatus($id) {
        $this->db->query("UPDATE users SET is_looked_news=1 WHERE id=".$id);
    }
    public function ChStatus2($id) {
        $this->db->query("UPDATE users SET is_looked_news_2=1 WHERE id=".$id);
    }
    public function ChBonusStatus($uid, $bon_numb) {
        $this->db->query("UPDATE users SET bonus".$bon_numb."_status=1 WHERE id=".$uid);
    }
    public function add_to_pekunjia($uid) {
        $this->db->query("UPDATE users SET is_pekunjia=1 WHERE id=".$uid);
    }

    public function get_ad_stat() {
        $arr01['c'] = 0;
        $query = $this->db->query("SELECT * FROM traffic_projects WHERE Status=0");
        foreach ($query->result_array() as $row) {
            $info_arr = json_decode($row['stats'], true);
            foreach ($info_arr as $key => $value) {
                if($value['have'] > $value['done']) {
                    $arr01['c']++;
                }
            }
        }

        $res = $this->db->query("SELECT COUNT(*) as c FROM traffic_projects WHERE Status=1");
        $arr02 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM traffic_projects WHERE Status=2");
        $arr03 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM banners WHERE Status=0");
        $arr11 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM banners WHERE Status=1");
        $arr12 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM banners WHERE Status=2");
        $arr13 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM text_ad WHERE Status=0");
        $arr21 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM text_ad WHERE Status=1");
        $arr22 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM text_ad WHERE Status=2");
        $arr23 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM vid_ad WHERE Status=0");
        $arr31 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM vid_ad WHERE Status=1");
        $arr32 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as c FROM vid_ad WHERE Status=2");
        $arr33 = $res->row_array();

        return array('traf' => array($arr01['c'], $arr02['c'], $arr03['c']), 'banner' => array($arr11['c'], $arr12['c'], $arr13['c']), 'text' => array($arr21['c'], $arr22['c'], $arr23['c']), 'vid' => array($arr31['c'], $arr32['c'], $arr33['c']));
    }

    public function BuyToks($id, $Count_tokens, $Price, $currency, $bonuscount = 0) {
        //снять с пользователя средства
        //распределить реферальные
        //записать транзакцию
        //снять доступные в раунде коины

        switch ($currency) {
            case 'BTC':
                $name_bal = 'amount_btc';
                break;
            case 'LTC':
                $name_bal = 'amount_ltc';
                break;
            case 'BCH':
                $name_bal = 'amount_bth';
                break;
            case 'ETH':
                $name_bal = 'amount_eth';
                break;
            case 'DASH':
                $name_bal = 'amount_dh';
                break;
        }

        $this->db->query("UPDATE users SET ".$name_bal."=".$name_bal."-".$Price.", amount_t=amount_t+".$Count_tokens." WHERE id=".$id);
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, comission, hash_pe, actiondate, idinitiator) VALUES(10, '".$currency."', ".$id.", 1, ".$Price.", ".$bonuscount.", '".$Count_tokens."', now(), ".$id.")");

        $id_sp = $id;

        for ($i = 1; $i <= 7; $i++) { 
            if($id == 1) {
                break;
            }
            
            $info = $this->users->getUserById($id_sp);
            $id_sp = $info['idsponsor'];
            if($i == 1) {
                $Up = bcmul($Price, 0.4, 8);
            }elseif($i == 2){
                $Up = bcmul($Price, 0.05, 8);
            }elseif($i == 3){
                $Up = bcmul($Price, 0.05, 8);
            }elseif($i == 4){
                $Up = bcmul($Price, 0.03, 8);
            }elseif($i == 5){
                $Up = bcmul($Price, 0.03, 8);
            }elseif($i == 6){
                $Up = bcmul($Price, 0.02, 8);
            }elseif($i == 7){
                $Up = bcmul($Price, 0.02, 8);
            }
            
            
            $this->db->query("UPDATE users SET ".$name_bal."=".$name_bal."+".$Up." WHERE id=".$id_sp);
            $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate, idinitiator) VALUES(6".$i.", '".$currency."', ".$id_sp.", 1, ".$Up.", now(), ".$id.")");

            if($id_sp == 1) {
                break;
            }
        }

        $this->db->query("UPDATE settings SET RemCoins=RemCoins-".$Count_tokens);
    }
    public function GetAllRefsRefills($id) {
        $arr = array("sum_btc" => 0, "sum_bch" => 0, "sum_ltc" => 0, "sum_eth" => 0, "sum_dash" => 0);

        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE currency='BTC' AND idreceiver=$id AND (type=61 OR type=62 OR type=63 OR type=64 OR type=65 OR type=66 OR type=67)");
        $row = $query->row_array();
        if($row['sum'] != NULL) {
            $arr['sum_btc'] = $row['sum'];
        }

        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE currency='BCH' AND idreceiver=$id AND (type=61 OR type=62 OR type=63 OR type=64 OR type=65 OR type=66 OR type=67)");
        $row = $query->row_array();
        if($row['sum'] != NULL) {
            $arr['sum_bch'] = $row['sum'];
        }

        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE currency='LTC' AND idreceiver=$id AND (type=61 OR type=62 OR type=63 OR type=64 OR type=65 OR type=66 OR type=67)");
        $row = $query->row_array();
        if($row['sum'] != NULL) {
            $arr['sum_ltc'] = $row['sum'];
        }

        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE currency='ETH' AND idreceiver=$id AND (type=61 OR type=62 OR type=63 OR type=64 OR type=65 OR type=66 OR type=67)");
        $row = $query->row_array();
        if($row['sum'] != NULL) {
            $arr['sum_eth'] = $row['sum'];
        }

        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE currency='DASH' AND idreceiver=$id AND (type=61 OR type=62 OR type=63 OR type=64 OR type=65 OR type=66 OR type=67)");
        $row = $query->row_array();
        if($row['sum'] != NULL) {
            $arr['sum_dash'] = $row['sum'];
        }
        return $arr;
    }

    public function getUsersCount2($col, $val) {
        if($col == 'amount') {
            $arr = explode('_', $val);
            $query = $this->db->query("SELECT * FROM users WHERE add_amount_btc>=".$arr[0]." AND add_amount_btc<=".$arr[1]);
            return $query->num_rows();
        }elseif($col == 'isonline') {
            if($val == 'on') {
                $query = $this->db->query("SELECT * FROM users as u1 LEFT OUTER JOIN isonline as ison ON u1.id=ison.uid WHERE ison.id IS NOT NULL");
                return $query->num_rows();
            }else {
                $query = $this->db->query("SELECT * FROM users as u1 LEFT OUTER JOIN isonline as ison ON u1.id=ison.uid WHERE ison.id IS NULL");
                return $query->num_rows();
            }
        }elseif($col == 'amount2') {
            $arr = explode('_', $val);
            $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$arr[0]." AND amount_btc<=".$arr[1]);
            return $query->num_rows();
        }elseif($col == 'regdate') {
            return $this->db->where('DATE_FORMAT('.$col.', "%Y-%m-%d")=', $val)->get($this->table_name)->num_rows();
        }elseif($col == 'login2') {
            $query = $this->db->query("SELECT * FROM users WHERE login LIKE '%".$val."%'");
            return $query->num_rows();
        }else {
            return $this->db->where($col, $val)->get($this->table_name)->num_rows();
        }
    }
    public function getMyUsers2($limit, $start, $col, $val) {
        if($col == 'regdate') {
            return $this->db->limit($limit, $start)
                ->select('u1.login as sponsor_login, m.* FROM users as m', false)
                ->join('users as u1', 'm.idsponsor = u1.id', 'left')
                ->where('DATE_FORMAT(m.'.$col.', "%Y-%m-%d")=', $val)
                ->order_by('m.id', 'DESC')
                ->get()->result_array();
        }elseif($col == 'payment_system' && $val == 'Null') {
            return $this->db->limit($limit, $start)
                ->select('u1.login as sponsor_login, m.* FROM users as m', false)
                ->join('users as u1', 'm.idsponsor = u1.id', 'left')
                ->where('m.'.$col, Null)
                ->order_by('m.id', 'DESC')
                ->get()->result_array();
        }elseif($col == 'login') {
            return $this->db->limit($limit, $start)
                ->select('u1.login as sponsor_login, m.* FROM users as m', false)
                ->join('users as u1', 'm.idsponsor = u1.id', 'left')
                ->where('m.id', $val)
                ->order_by('m.id', 'DESC')
                ->get()->result_array();
        }elseif($col == 'isonline') {
            if($val == 'on') {
                $query = $this->db->query("SELECT u1.login as sponsor_login, m.*, ison.id as isonid FROM users as m LEFT JOIN users as u1 ON u1.id=m.idsponsor LEFT OUTER JOIN isonline as ison ON m.id = ison.uid WHERE ison.id IS NOT NULL");
                $result = array();
                foreach ($query->result_array() as $row)
                {
                        $result[] = $row;
                }
                return $result;
            }else {
                $query = $this->db->query("SELECT u1.login as sponsor_login, m.*, ison.id as isonid FROM users as m LEFT JOIN users as u1 ON u1.id=m.idsponsor LEFT OUTER JOIN isonline as ison ON m.id = ison.uid WHERE ison.id IS NULL");
                $result = array();
                foreach ($query->result_array() as $row)
                {
                        $result[] = $row;
                }
                return $result;
            }

        }elseif($col == 'amount') {
            $arr = explode('_', $val);
            $result = array();
            $query = $this->db->query("SELECT u1.login as sponsor_login, m.*, ison.id as isonid FROM users as m INNER JOIN users as u1 ON m.idsponsor=u1.id LEFT OUTER JOIN isonline as ison ON m.id = ison.uid WHERE m.add_amount_btc>=".$arr[0]." AND m.add_amount_btc<=".$arr[1]." LIMIT $start, $limit");
            foreach ($query->result_array() as $row) {
                $result[] = $row;
            }
            return $result;
        }elseif($col == 'amount2') {
            $arr = explode('_', $val);
            $result = array();
            $query = $this->db->query("SELECT u1.login as sponsor_login, m.* FROM users as m INNER JOIN users as u1 ON m.idsponsor=u1.id LEFT OUTER JOIN isonline as ison ON m.id = ison.uid WHERE m.amount_btc>=".$arr[0]." AND m.amount_btc<=".$arr[1]." LIMIT $start, $limit");
            foreach ($query->result_array() as $row) {
                $result[] = $row;
            }
            return $result;
        }elseif($col == 'login2') {
            $result = array();
            $query = $this->db->query("SELECT u1.login as sponsor_login, m.* FROM users as m INNER JOIN users as u1 ON m.idsponsor=u1.id LEFT OUTER JOIN isonline as ison ON m.id = ison.uid WHERE m.login LIKE '%".$val."%' LIMIT $start, $limit");
            foreach ($query->result_array() as $row) {
                $result[] = $row;
            }
            return $result;
        }else {
            return $this->db->limit($limit, $start)
                ->select('u1.login as sponsor_login, m.* FROM users as m', false)
                ->join('users as u1', 'm.idsponsor = u1.id', 'left')
                ->where('m.'.$col, $val)
                ->order_by('m.id', 'DESC')
                ->get()->result_array();
        }
    }

    public function getUsAv($login) {
        return $this->db->select('ava FROM users as m', false)
                ->where('login', $login)
                ->get()->result_array();
    }
    public function updateAvUs($log, $path) {
        $data = array(
                'ava' => $path
            );
        $this->db->where('login', $log)->update($this->table_name, $data);
    }

    public function checkUserAutologin($uid, $signed_info) {
        if (is_null($uid) || is_null($signed_info)) {
            return false;
        }

        $user = $this->getUserById($uid);

        $this->load->library('authentication');
        if ($signed_info == $this->authentication->getAuthString($user['id'], $user['email'], $user['password'])) {
            return true;
        }

        return false;
    }

    public function user_verified($uid) {
        $user = $this->getUserById($uid);
        if($user['status'] > 1)
            return true;
        return false;
    }

    public function get_last_regs()
    {
        $query = $this->db->query("SELECT login, country, regdate FROM `users` ORDER BY id DESC LIMIT 10");

        $result = [];

        foreach ($query->result_array() as $row) {

            $result[] = $row;
            
        }

        return $result;
    }

    public function updateUserInfo($uid) {

        $result = $this->db->limit(1, 0)
                ->select('* FROM users', false)
                ->where('id', $uid)
                ->get()->result_array();

        foreach ($result as $us) {
            $us_info = $us;
        }

        $data = array(
            'skype' => $this->input->post('skype'),
            'mobile_num' => $this->input->post('mobilenum'),
            'name' => $this->input->post('name'),
            'lastname' => $this->input->post('lastname'),
            'country' => $this->input->post('country')
        );
        $this->db->where('id', $uid)->update($this->table_name, $data);

        $this->session->skype = $data['skype'];
        $this->session->mobile_num = $data['mobile_num'];
        $this->session->name = $data['name'];
        $this->session->lastname = $data['lastname'];
        $this->session->country = $data['country'];

    }

    public function updateUserIp($uid) {

        if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] != NULL) {
            $last_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }else {
            $last_ip = $this->input->ip_address();
        }

        $this->db->where('id', $uid)->update($this->table_name, array('last_ip' => $last_ip ) );
    }

    public function check_password($password) {
        if(strlen($password) == 0) {
            $this->form_validation->set_message('password_check', $this->lang->line('empty_field'));
            return false;
        }
        if(!$this->checkUserByCredentials($_SESSION['username'], $password)) {
            $this->form_validation->set_message('password_check', $this->lang->line('incorrect_password'));
            return false;
        }
        return true;
    }

    public function update_login($uid, $login) {
        $data['login'] = $login;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function check_identity($password) {
        if($this->checkUserByCredentials($this->session->username, $password)) {
            $this->form_validation->set_message('password_identity', $this->lang->line('identicall_password'));
            return false;
        }
        return true;
    }

    public function getStatusInfo($uid) {
        $this->db->select('amount_btc, current_level, (select count(id) from users where idsponsor=' . $uid . ') as cnt');
        $this->db->where('id', $uid);
        return $this->db->get($this->table_name)->row_array();
    }

    public function setNewPassword($uid) {
        $data = array('password' => password_hash($this->input->post('newpassword'), PASSWORD_BCRYPT));
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function clean_confirmations($uid) {
        $this->db->delete('confirmations', array('iduser' => $uid));
    }

    public function name_check($str) {
        if(strlen($str) == 0) {
            $this->form_validation->set_message('name_callable', $this->lang->line('empty_field'));
            return false;
        }
        $pattern = '~^[a-zа-яäüßö]+$~iu';
        if(preg_match($pattern, $str, $match))
            return true;
        $this->form_validation->set_message('name_callable', $this->lang->line('name_check'));
        return false;
    }

    public function is_blocked($username) {
        $id = $this->getIdByLogin($username);
        $user = $this->getUserById($id['id']);
        if($user == null || $user['status'] != 4)
            return false;
        return true;
    }

    public function get_last_ip($username) {
        $id = $this->getIdByLogin($username);
        return $this->db->select('last_ip')->get_where($this->table_name, array('id' => $id['id']))->row_array();
    }
    
    public function make_ip_confirmation($str, $uid) {
        $data['iduser'] = $uid;
        $data['ip_confirm_token'] = $str;
        $this->db->set('date_request', "NOW()", false);
        $this->db->insert('confirmations', $data);
    }

    public function check_password_token($str) {
        return $this->db->select('NOW() < dateto_token_valid as res, iduser', false)->where('pass_reset_token', $str)->from('confirmations')->get()->row_array();
    }

    public function make_pass_confirmation($str, $uid) {
        $data['iduser'] = $uid;
        $data['pass_reset_token'] = $str;
        $this->db->set('dateto_token_valid', "NOW() + INTERVAL 1 DAY", false);
        $this->db->insert('confirmations', $data);
    }

	public function get_24h_users() {
		return $this->db->select('id')->where('STR_TO_DATE(regdate,"%Y-%m-%d") > CURDATE() - INTERVAL 1 day')->count_all_results($this->table_name);
	}
	
	public function get_engl_count() {
		return $this->db->select('id')->where('u_lang', 'english')->count_all_results($this->table_name);
	}
	
	public function get_rus_count() {
		return $this->db->select('id')->where('u_lang', 'russian')->count_all_results($this->table_name);
	}
	
	public function get_ger_count() {
		return $this->db->select('id')->where('u_lang', 'german')->count_all_results($this->table_name);
	}
	
    public function confirm_ip($str) {
        $data = $this->db->select('iduser')->get_where('confirmations', array('ip_confirm_token' => $str))->row_array();
        $this->updateUserIp($data['iduser']);
        $this->db->delete('confirmations', array('iduser' => $data['iduser']));
    }



    public function user_check($str) {
        if(strlen($str) == 0) {
            $this->form_validation->set_message('user_callable', $this->lang->line('empty_field'));
            return false;
        }
        $user = $this->getIdByLogin($str);
        if($user == false || $user == null) {
            $this->form_validation->set_message('user_callable', $this->lang->line('incorrect_user'));
            return false;
        }
        return true;
    }

    public function getUserByEmail($email) {
        return $this->db->where('email', $email)->get($this->table_name)->row_array();
    }

    public function getUserById($id) {
        return $this->db->where('id', $id)->get($this->table_name)->row_array();
    }
    public function getUserStatById($id) {
        return $this->db->where('uid', $id)->get('user_statistics')->row_array();
    }
    public function getAdUserStatById($id) {
        $res = $this->db->query("SELECT COUNT(*) as count FROM banners WHERE format='125x125' AND uid=".$id);
        $arr1 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count FROM banners WHERE format='300x250' AND uid=".$id);
        $arr2 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count FROM banners WHERE format='468x60' AND uid=".$id);
        $arr3 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count FROM banners WHERE format='728x90' AND uid=".$id);
        $arr4 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count FROM vid_ad WHERE uid=".$id);
        $arr5 = $res->row_array();

        $res = $this->db->query("SELECT COUNT(*) as count FROM text_ad WHERE uid=".$id);
        $arr6 = $res->row_array();

        return array('ban125' => $arr1['count'], 'ban300' => $arr2['count'], 'ban468' => $arr3['count'], 'ban728' => $arr4['count'], 'vid' => $arr5['count'], 'mail' => $arr6['count'], 'all' => $arr1['count']+$arr2['count']+$arr3['count']+$arr4['count']+$arr5['count']+$arr6['count']);
    }

    public function getIdByUser($login) {
        return $this->db->where('login', $login)->get($this->table_name)->row_array();
    }

    public function get_user_login_by_reflink($link) {
        $query = $this->db->select('login')->get_where($this->table_name, array('reflink' => $link));
        if($query->num_rows()) {
            $query = $query->row_array();
            return $query['login'];
        }
        return -1;
    }

    public function get_user_id_by_reflink($link) {
        $query = $this->db->select('id')->get_where($this->table_name, array('reflink' => $link));
        if($query->num_rows()) {
            $query = $query->row_array();
            return $query['id'];
        }
        return -1;
    }

    public function get_latest_users($limit) {
        return $this->db->select('concat_ws(" ", name, lastname) as name, regdate')
                    ->order_by('regdate', 'DESC')
                    ->limit($limit)
                    ->get($this->table_name)->result_array();
    }

    public function addUser($sponsor = -1, $spec_ref_code = '[]') {
        $this->login = $this->input->post('username');

        $this->name = $this->input->post('firstname');
        $this->lastname = $this->input->post('lastname');

        $this->country = $this->input->post('country');

        $this->password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $this->email = $this->input->post('email');
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] != NULL) {
            $this->last_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }else {
            $this->last_ip = $this->input->ip_address();
        }
        $this->status = 3;
        if($sponsor != -1) {
			$this->visited_reflink = $sponsor;
            $sponsor = $this->get_user_id_by_reflink($sponsor);
        } else {
            $sponsor = 2;
        }

        if($sponsor == -1) {
            $sponsor = 2;
        }

		if($this->input->post('choose_lang') == 'english')
			$this->u_lang = 'english';
		elseif($this->input->post('choose_lang') == 'russian')
			$this->u_lang = 'russian';
		elseif($this->input->post('choose_lang') == 'german')
			$this->u_lang = 'german';
		else
			$this->u_lang = 'english';
		
        $this->idsponsor = $sponsor;
        $this->special_ref_string = $spec_ref_code;
        $this->fin_password = null;
        $this->db->set('regdate', 'NOW()', false);
        $this->db->insert('users', $this);
        // var_dump($this->db->error());
        // exit();

        $inserted = $this->db->insert_id();

        $query = $this->db->query("SELECT * FROM refferal_structure WHERE uid=".$sponsor);
        $res = $query->row_array();
        $sponsors_str = $sponsor.', '.$res['id1'].', '.$res['id2'].', '.$res['id3'].', '.$res['id4'].', '.$res['id5'].', '.$res['id6'].', '.$res['id7'].', '.$res['id8'].', '.$res['id9'].', '.$res['id10'].', '.$res['id11'].', '.$res['id12'].', '.$res['id13'].', '.$res['id14'];

        $this->db->query("INSERT INTO `refferal_structure`(`uid`, `id1`, `id2`, `id3`, `id4`, `id5`, `id6`, `id7`, `id8`, `id9`, `id10`, `id11`, `id12`, `id13`, `id14`, `id15`) VALUES ($inserted, $sponsors_str)");

        $this->db->query("INSERT INTO `user_statistics`(`uid`) VALUES ($inserted)");

        return $inserted;
    }

    public function validate_user($uid) {
        $this->db->where('id', $uid)->update($this->table_name, array('status' => 2));
    }

    public function validated($uid) {
        $query = $this->db->select('status')->get_where($this->table_name, array('id' => $uid));
        if($query->num_rows() < 1)
            return true;
        $query = $query->result_array();
        if($query[0]['status'] > 1)
            return true;
        return false;
    }

    public function check_fin_pass($fin_password, $uid) {
        $query = $this->db->select('fin_password')->get_where($this->table_name, array('id' => $uid))->row_array();

        if(password_verify($fin_password, $query['fin_password'])) {
            return true;
        }
        return false;
    }

    public function getSponsor($uid) {
        $me = $this->getUserById($uid);
        return $this->getUserById($me['idsponsor']);
    }
    public function get_total_count() {
        return $this->db->where('login !=', 'admin')->count_all_results($this->table_name);
    }
    public function get_stat_info() {
        $query = $this->db->query('SELECT COUNT(*) as count FROM `users`');
        $res = $query->row_array();
        $result['count_us'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `users` WHERE UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`regdate`)<=86400');
        $res = $query->row_array();
        $result['count_us_24'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `users` WHERE UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`regdate`)<=2592000');
        $res = $query->row_array();
        $result['count_us_30'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE (type=1999 OR type=2999 OR type=3999 OR type=4999)');
        $res = $query->row_array();
        $result['count_tar']['all'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE (type=1999 OR type=2999 OR type=3999 OR type=4999) AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400');
        $res = $query->row_array();
        $result['count_24']['all'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE (type=1999 OR type=2999 OR type=3999 OR type=4999) AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000');
        $res = $query->row_array();
        $result['count_30']['all'] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=1999');
        $res = $query->row_array();
        $result['count_tar'][1] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=1999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400');
        $res = $query->row_array();
        $result['count_24'][1] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=1999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000');
        $res = $query->row_array();
        $result['count_30'][1] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=2999');
        $res = $query->row_array();
        $result['count_tar'][2] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=2999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400');
        $res = $query->row_array();
        $result['count_24'][2] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=2999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000');
        $res = $query->row_array();
        $result['count_30'][2] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=3999');
        $res = $query->row_array();
        $result['count_tar'][3] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=3999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400');
        $res = $query->row_array();
        $result['count_24'][3] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=3999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000');
        $res = $query->row_array();
        $result['count_30'][3] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=4999');
        $res = $query->row_array();
        $result['count_tar'][4] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=4999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400');
        $res = $query->row_array();
        $result['count_24'][4] = $res['count'];

        $query = $this->db->query('SELECT COUNT(*) as count FROM `payments` WHERE type=4999 AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000');
        $res = $query->row_array();
        $result['count_30'][4] = $res['count'];

        return $result;
    }

    public function update_level($uid, $level) {
        $user = $this->getUserById($uid);
        $data['current_level'] = $level;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function user_has_reflink($uid) {
        $query = $this->db->select('reflink')->get_where($this->table_name, array('id' => $uid));
        if($query->num_rows())
            return true;
        return false;
    }

    public function get_user_by_reflink($str) {
        $query = $this->db->query('SELECT id FROM '.$this->table_name.' WHERE reflink="'.$str.'"'); 

        // $this->db->get_where($this->table_name, array('reflink', ));

        //выполненные запросы:
        // print_r($this->db->queries);
        // exit();
 
        if($query->num_rows()) {
            return $query->row_array();
        }
        return false;
    }

    public function set_reflink($uid, $str) {
        $data['reflink'] = $str;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    /*
     * Функция вовзаращает id спонсора пользователя
     */
    public function get_sponsor_by_id($uid) {
        $query = $this->db->select('idsponsor')->get_where($this->table_name, array('id' => $uid));
        if($query->num_rows()) {
            $query = $query->row_array();
            return $query['idsponsor'];
        }
        return false;
    }

    public function getUser($login, $password) {
        $query = $this->db->where(array(
            'login' => $login
        ))->get($this->table_name)->row_array();

        if(password_verify($password, $query['password'])) {
            return true;
        }
        return false;
    }

    public function getAdmin($login, $password) {
        $query = $this->db->where(array(
            'login' => $login, 'id' => 1
        ))->get($this->table_name)->row_array();

        if(password_verify($password, $query['password'])) {
            return true;
        }
        return false;
    }

    public function checkUserByCredentials($login, $password, $id = 0) {
        if($id != 0)
            return $this->getAdmin($login, $password);
        return $this->getUser($login, $password);
    }

    public function getUserCreds($login) {
        return $this->db->get_where($this->table_name, array('login' => $login))->row_array();
    }

    public function hasEnoughFunds($sum) {
        $query = $this->db->select('amount')->where('id', $this->session->uid)->get($this->table_name)->row_array();
        if($query['amount'] >= $sum)
            return true;
        return false;
    }

    public function subFunds($cur, $sum, $uid = 0, $wallet = '') {
		if($uid != 0)
			$user = $uid;
		else
			$user = $this->session->uid;

        $name = '_'.$cur;
            

        $query = $this->db->select('add_amount'.$name)->where('id', $user)->get($this->table_name)->row_array();
        $data['add_amount'.$name] = $query['add_amount'.$name] - $sum;

        $this->db->where('id', $user)->update($this->table_name, $data);

        $query = $this->db->query("UPDATE users SET wallet_to_out='".$wallet."' WHERE id=".$user);
    }

    

    public function addFunds_ads($uid, $sum, $currency) {
        $currency = 'BTC';
        switch ($currency) {
            case 'BTC':
                $curr = '_btc';
                break;
            case 'BCH':
                $curr = '_bth';
                break;
            case 'ETH':
                $curr = '_eth';
                break;
            case 'LTC':
                $curr = '_ltc';
                break;
            case 'DASH':
                $curr = '_dh';
                break;
            default:
                EXIT();
                break;
        }
        $query = $this->db->select('add_amount'.$curr)->where('id', $uid)->get($this->table_name)->row_array();
        
        $data['add_amount'.$curr] = bcadd($query['add_amount'.$curr], $sum, 4);

        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function addFunds($uid, $sum, $currency) {
        switch ($currency) {
            case 'BTC':
                $curr = '_btc';
                break;
            case 'BCH':
                $curr = '_bth';
                break;
            case 'ETH':
                $curr = '_eth';
                break;
            case 'LTC':
                $curr = '_ltc';
                break;
            case 'DASH':
                $curr = '_dh';
                break;
            default:
                EXIT();
                break;
        }
        $query = $this->db->select('amount'.$curr)->where('id', $uid)->get($this->table_name)->row_array();
        
        $data['amount'.$curr] = bcadd($query['amount'.$curr], $sum, 4);

        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function get_level($uid) {
        $query = $this->db->select('current_level')->get_where($this->table_name, array('id' => $uid))->row_array();
        return $query['current_level'];
    }

    public function transfer_money($login, $sum, $my_uid) {
        $me = $this->getLoginById($my_uid);
        if($me['login'] == $login) {
            return false;
        }
        $query = $this->db->select('amount')->get_where($this->table_name, array('login' => $login))->row_array();
        $data = array('amount' => $query['amount'] + $sum);
        $this->db->where('login', $login)->update($this->table_name, $data);

        $query = $this->db->select('amount')->get_where($this->table_name, array('id' => $this->session->uid))->row_array();
        $data = array('amount' => $query['amount'] - $sum);
        $this->db->where('id', $this->session->uid)->update($this->table_name, $data);

        return true;
    }

    public function getLoginById($uid) {
        return $this->db->select('login')->get_where($this->table_name, array('id' => $uid))->row_array();
    }

    public function getIdByLogin($login) {
        return $this->db->select('id')->get_where($this->table_name, array('login' => $login))->row_array();
    }

    public function changeLevel($level) {
        $this->db->where('id', $this->session->uid)->update($this->table_name, array('current_level' => $level));
    }

    public function UpdateVisitDate($uid) {
        $this->db->query("UPDATE users SET DateLastVisit='".time()."' WHERE id=".$uid);
    }

    public function get_referals($uid) {

        $query = $this->db->query("SELECT COUNT(*) as count, sum((SELECT sum(p.amount) FROM `payments` as p WHERE p.type=38 AND p.idsender=u1.id AND p.idreceiver=".$uid.")) as sum_refs FROM `users` as u1
            WHERE u1.idsponsor=".$uid);
        $res = $query->row_array();
        $result['sum_first_lvl'] = $res['sum_refs'];
        $result['count_first_lvl'] = $res['count'];

        $query = $this->db->query("SELECT COUNT(*) as count, sum((SELECT sum(p.amount) FROM `payments` as p WHERE p.type=38 AND p.idsender=u2.id AND p.idreceiver=".$uid.")) as sum_refs FROM `users` as u1
            INNER JOIN `users` as u2 ON u1.id=u2.idsponsor
            WHERE u1.idsponsor=".$uid);
        $res = $query->row_array();
        $result['sum_second_lvl'] = $res['sum_refs'];
        $result['count_second_lvl'] = $res['count'];

        $query = $this->db->query("SELECT COUNT(*) as count, sum((SELECT sum(p.amount) FROM `payments` as p WHERE p.type=38 AND p.idsender=u3.id AND p.idreceiver=".$uid.")) as sum_refs FROM `users` as u1
            INNER JOIN `users` as u2 ON u1.id=u2.idsponsor
            INNER JOIN `users` as u3 ON u2.id=u3.idsponsor
            WHERE u1.idsponsor=".$uid);
        $res = $query->row_array();
        $result['sum_third_lvl'] = $res['sum_refs'];
        $result['count_third_lvl'] = $res['count'];

        return $result;
    }

    public function get_refs($uid, $lvl, $page) {

        $result['refs'] = array();

        $query = $this->db->query("SELECT COUNT(*) as count FROM `users` as u1 INNER JOIN refferal_structure AS r ON u1.id=r.uid WHERE r.id".$lvl."=".$uid."");
        $res = $query->row_array();
        $result['count'] = $res['count'];

        if($lvl != 1) {

            $query = $this->db->query("SELECT u1.login, u1.packet_status, (SELECT u2.login FROM users AS u2 WHERE u2.id=u1.idsponsor) as value FROM `users` as u1 INNER JOIN refferal_structure AS r ON u1.id=r.uid WHERE r.id".$lvl."=".$uid." LIMIT ".($page*10-10).", 10");

        }else {

            $query = $this->db->query("SELECT u1.login, u1.reflink, u1.packet_status, u1.email as value FROM `users` as u1 INNER JOIN refferal_structure AS r ON u1.id=r.uid WHERE r.id".$lvl."=".$uid." LIMIT ".($page*10-10).", 10");

        }
        foreach ($query->result_array() as $row) {

            $user_packet_info = json_decode($row['packet_status'], true);

            $packet1 = $user_packet_info['packet_1'];
            $packet2 = $user_packet_info['packet_2'];
            $packet3 = $user_packet_info['packet_3'];
            $packet4 = $user_packet_info['packet_4'];

            switch (true) {
              case ($packet4 == 1):
                $row['packet'] = 4;
                break;
              case ($packet3 == 1):
                $row['packet'] = 3;
                break;
              case ($packet2 == 1):
                $row['packet'] = 2;
                break;
              case ($packet1 == 1):
                $row['packet'] = 1;
                break;
              default:
                $row['packet'] = 0;
                break;
            }

            $result['refs'][] = $row;
        }

        if($result['count'] <= 10) {
            $result['page_type'] = '1';//отсутствие
        }elseif($page == 1) {
            $result['page_type'] = '2';//2-я страница с первой
        }elseif($page*10 >= $result['count']) {
            $result['page_type'] = '3';//последняя страница с предпоследней
        }else {
            $result['page_type'] = '4';//актуальная страница +1 спереди и сзади
        }

        return $result;
    }

    public function get_partners_count($uid) {
        return $this->db->where('idsponsor', $uid)->count_all_results($this->table_name);
    }

    public function fin_pass_exists($uid) {
        return $this->db->select('fin_password')->where(array('id' => $uid, 'fin_password != ' => ''))->count_all_results($this->table_name);
    }

    public function get_partners_period_count($period, $uid) {
        return $this->db->select('id')->where('STR_TO_DATE(regdate,"%Y-%m-%d") > CURDATE() - INTERVAL ' . $period . ' day and idsponsor = ' . $uid)->count_all_results($this->table_name);
    }

    public function find() {
        // if($this->input->post('username') == null && (isset($_SESSION['searchid']) && $_SESSION['searchid']) != null) {
            // $query = $this->db->get_where($this->table_name, array('id' => $_SESSION['searchid']))->row_array();
            // $q =  $this->db->select('login as sponsor_login')->get_where($this->table_name, array('id' => $query['idsponsor']))->row_array();
            // $query['sponsor_login'] = $q['sponsor_login'];
            // return $query;
        // }

        if($this->input->post('username') != null) {
            $this->db->where('login', $_POST['username']);
        }
        // if($this->input->post('skype') != null) {
        //     $this->db->where('skype', $_POST['skype']);
        // }
        // if($this->input->post('email') != null) {
        //     $this->db->where('email', $_POST['email']);
        // }
        // if($this->input->post('balance') != null) {
        //     if($this->input->post('balCompar') == 'less') {
        //         $sign = '<';
        //     } else if($this->input->post('balCompar') == 'more') {
        //         $sign = '>';
        //     } else {
        //         $sign = '=';
        //     }
        //     $this->db->where('amount ' . $sign, $this->input->post('balance'));
        // }

        $query = $this->db->get($this->table_name)->row_array();
        $q =  $this->db->select('login as sponsor_login')->get_where($this->table_name, array('id' => $query['idsponsor']))->row_array();
        if(!is_null($query)) {
            $query['sponsor_login'] = $q['sponsor_login'];
            $_SESSION['searchid'] = $query['id'];
        }
        return $query;
    }

    public function find2($uid) {
        $query = $this->db->query('SELECT * FROM users WHERE id='.$uid);
        $row = $query->row_array();

        $query = $this->db->query('SELECT * FROM users WHERE id='.$row['idsponsor']);
        $row2 = $query->row_array();
        $row['sponsor_login'] = $row2['login'];

        return $row;
    }

    public function delete($uid) {
        $this->db->delete($this->table_name, array('id' => $uid));
    }

    public function getUserQueueNumber($uid) {
        $query = $this->db->query('SELECT * FROM queue WHERE uid='.$uid.' ORDER BY id ASC');
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function getCountQueue() {
        $query = $this->db->query('SELECT max(id) as count FROM queue');
        $row = $query->row_array();
        return $row['count'];
    }

    public function update_user($uid) {

        $data = array();

        if($this->input->post('save_skype') != null) {
            $data['skype'] = $this->input->post('save_skype');
        }
        if($this->input->post('save_email') != null) {
            $data['email'] = $this->input->post('save_email');
        }
        
        if($this->input->post('save_balance_btc') != null) {
            $data['amount_btc'] = $this->input->post('save_balance_btc');
        }
        if($this->input->post('save_balance_btc2') != null) {
            $data['add_amount_btc'] = $this->input->post('save_balance_btc2');
        }

        if($this->input->post('save_name') != null) {
            $data['name'] = $this->input->post('save_name');
        }

        if(false && $this->input->post('save_tarif') != '-' && $this->input->post('save_number_queue') != '-') {
            $this->db->query('UPDATE users SET tarif="'.$this->input->post('save_tarif').'" WHERE id='.$uid);

            if($this->input->post('save_number_queue') != 'actual') {
                $this->db->query('UPDATE `queue` SET qid=qid+1 WHERE qid>='.$this->input->post('save_number_queue'));    
                $this->db->query("INSERT INTO `queue`(`qid`, `uid`, `packet`, `date`) VALUES (".$this->input->post('save_number_queue').", ".$uid.",'".$this->input->post('save_tarif')."','".time()."')");
            }else {

                $query = $this->db->query('SELECT max(qid) as max FROM queue');
                $row = $query->row_array();

                $this->db->query("INSERT INTO `queue`(`uid`, `qid`, `packet`, `date`) VALUES (".$uid.", ".($row['max']+1).", '".$this->input->post('save_tarif')."','".time()."')");
            }
            
        }

        if($this->input->post('save_sponsor_login') != null) {
            // echo $this->input->post('save_sponsor_login').'  |';
            $query = $this->db->query('SELECT id FROM users WHERE login="'.$this->input->post('save_sponsor_login').'"');
            
            if($query->num_rows() > 0) {
                $row = $query->row_array();
                $data['idsponsor'] = $row['id'];

                //взяли всю цепочку спонсоров нового спонсора
                $query = $this->db->query('SELECT * FROM refferal_structure WHERE uid='.$data['idsponsor']);
                $new_sponsor_info = $query->row_array();

                //обновили её себе
                $this->db->query('UPDATE refferal_structure SET id1='.$new_sponsor_info['uid'].', id2='.$new_sponsor_info['id1'].', id3='.$new_sponsor_info['id2'].', id4='.$new_sponsor_info['id3'].', id5='.$new_sponsor_info['id4'].', id6='.$new_sponsor_info['id5'].', id7='.$new_sponsor_info['id6'].', id8='.$new_sponsor_info['id7'].', id9='.$new_sponsor_info['id8'].', id10='.$new_sponsor_info['id9'].', id11='.$new_sponsor_info['id10'].', id12='.$new_sponsor_info['id11'].', id13='.$new_sponsor_info['id12'].', id14='.$new_sponsor_info['id13'].', id15='.$new_sponsor_info['id14'].' WHERE uid='.$uid);

                //обновили рефам 1-го уровня
                $this->db->query('UPDATE refferal_structure SET id2='.$new_sponsor_info['uid'].', id3='.$new_sponsor_info['id1'].', id4='.$new_sponsor_info['id2'].', id5='.$new_sponsor_info['id3'].', id6='.$new_sponsor_info['id4'].', id7='.$new_sponsor_info['id5'].', id8='.$new_sponsor_info['id6'].', id9='.$new_sponsor_info['id7'].', id10='.$new_sponsor_info['id8'].', id11='.$new_sponsor_info['id9'].', id12='.$new_sponsor_info['id10'].', id13='.$new_sponsor_info['id11'].', id14='.$new_sponsor_info['id12'].', id15='.$new_sponsor_info['id13'].' WHERE id1='.$uid);

                //обновили рефам 2-го уровня
                $this->db->query('UPDATE refferal_structure SET id3='.$new_sponsor_info['uid'].', id4='.$new_sponsor_info['id1'].', id5='.$new_sponsor_info['id2'].', id6='.$new_sponsor_info['id3'].', id7='.$new_sponsor_info['id4'].', id8='.$new_sponsor_info['id5'].', id9='.$new_sponsor_info['id6'].', id10='.$new_sponsor_info['id7'].', id11='.$new_sponsor_info['id8'].', id12='.$new_sponsor_info['id9'].', id13='.$new_sponsor_info['id10'].', id14='.$new_sponsor_info['id11'].', id15='.$new_sponsor_info['id12'].' WHERE id2='.$uid);

                //обновили рефам 3-го уровня
                $this->db->query('UPDATE refferal_structure SET id4='.$new_sponsor_info['uid'].', id5='.$new_sponsor_info['id1'].', id6='.$new_sponsor_info['id2'].', id7='.$new_sponsor_info['id3'].', id8='.$new_sponsor_info['id4'].', id9='.$new_sponsor_info['id5'].', id10='.$new_sponsor_info['id6'].', id11='.$new_sponsor_info['id7'].', id12='.$new_sponsor_info['id8'].', id13='.$new_sponsor_info['id9'].', id14='.$new_sponsor_info['id10'].', id15='.$new_sponsor_info['id11'].' WHERE id3='.$uid);

                //обновили рефам 4-го уровня
                $this->db->query('UPDATE refferal_structure SET id5='.$new_sponsor_info['uid'].', id6='.$new_sponsor_info['id1'].', id7='.$new_sponsor_info['id2'].', id8='.$new_sponsor_info['id3'].', id9='.$new_sponsor_info['id4'].', id10='.$new_sponsor_info['id5'].', id11='.$new_sponsor_info['id6'].', id12='.$new_sponsor_info['id7'].', id13='.$new_sponsor_info['id8'].', id14='.$new_sponsor_info['id9'].', id15='.$new_sponsor_info['id10'].' WHERE id4='.$uid);

                //обновили рефам 5-го уровня
                $this->db->query('UPDATE refferal_structure SET id6='.$new_sponsor_info['uid'].', id7='.$new_sponsor_info['id1'].', id8='.$new_sponsor_info['id2'].', id9='.$new_sponsor_info['id3'].', id10='.$new_sponsor_info['id4'].', id11='.$new_sponsor_info['id5'].', id12='.$new_sponsor_info['id6'].', id13='.$new_sponsor_info['id7'].', id14='.$new_sponsor_info['id8'].', id15='.$new_sponsor_info['id9'].' WHERE id5='.$uid);

                //обновили рефам 6-го уровня
                $this->db->query('UPDATE refferal_structure SET id7='.$new_sponsor_info['uid'].', id8='.$new_sponsor_info['id1'].', id9='.$new_sponsor_info['id2'].', id10='.$new_sponsor_info['id3'].', id11='.$new_sponsor_info['id4'].', id12='.$new_sponsor_info['id5'].', id13='.$new_sponsor_info['id6'].', id14='.$new_sponsor_info['id7'].', id15='.$new_sponsor_info['id8'].' WHERE id6='.$uid);

                //обновили рефам 7-го уровня
                $this->db->query('UPDATE refferal_structure SET id8='.$new_sponsor_info['uid'].', id9='.$new_sponsor_info['id1'].', id10='.$new_sponsor_info['id2'].', id11='.$new_sponsor_info['id3'].', id12='.$new_sponsor_info['id4'].', id13='.$new_sponsor_info['id5'].', id14='.$new_sponsor_info['id6'].', id15='.$new_sponsor_info['id7'].' WHERE id7='.$uid);

                //обновили рефам 8-го уровня
                $this->db->query('UPDATE refferal_structure SET id9='.$new_sponsor_info['uid'].', id10='.$new_sponsor_info['id1'].', id11='.$new_sponsor_info['id2'].', id12='.$new_sponsor_info['id3'].', id13='.$new_sponsor_info['id4'].', id14='.$new_sponsor_info['id5'].', id15='.$new_sponsor_info['id6'].' WHERE id8='.$uid);

                //обновили рефам 9-го уровня
                $this->db->query('UPDATE refferal_structure SET id10='.$new_sponsor_info['uid'].', id11='.$new_sponsor_info['id1'].', id12='.$new_sponsor_info['id2'].', id13='.$new_sponsor_info['id3'].', id14='.$new_sponsor_info['id4'].', id15='.$new_sponsor_info['id5'].' WHERE id9='.$uid);

                //обновили рефам 10-го уровня
                $this->db->query('UPDATE refferal_structure SET id11='.$new_sponsor_info['uid'].', id12='.$new_sponsor_info['id1'].', id13='.$new_sponsor_info['id2'].', id14='.$new_sponsor_info['id3'].', id15='.$new_sponsor_info['id4'].' WHERE id10='.$uid);

                //обновили рефам 11-го уровня
                $this->db->query('UPDATE refferal_structure SET id12='.$new_sponsor_info['uid'].', id13='.$new_sponsor_info['id1'].', id14='.$new_sponsor_info['id2'].', id15='.$new_sponsor_info['id3'].' WHERE id11='.$uid);

                //обновили рефам 12-го уровня
                $this->db->query('UPDATE refferal_structure SET id13='.$new_sponsor_info['uid'].', id14='.$new_sponsor_info['id1'].', id15='.$new_sponsor_info['id2'].' WHERE id12='.$uid);

                //обновили рефам 13-го уровня
                $this->db->query('UPDATE refferal_structure SET id14='.$new_sponsor_info['uid'].', id15='.$new_sponsor_info['id1'].' WHERE id13='.$uid);

                //обновили рефам 14-го уровня
                $this->db->query('UPDATE refferal_structure SET id15='.$new_sponsor_info['uid'].' WHERE id14='.$uid);
            }
        }
        if($this->input->post('newpassword') != null) {
            $data['password'] = password_hash($this->input->post('newpassword'), PASSWORD_BCRYPT);
        }

        if($this->input->post('save_lastname') != null) {
            $data['lastname'] = $this->input->post('save_lastname');
        }
        
        if($this->input->post('save_mobilenum') != null) {
            $data['mobile_num'] = $this->input->post('save_mobilenum');
        }
        
        if($this->input->post('save_status') != null) {
            $data['status'] = $this->input->post('save_status');
        }

        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        

        // error_reporting(-1);
        // ini_set('display_errors', 1);



        $this->db->where('id', $uid)->update($this->table_name, $data);
        
        // echo '<pre>';
        // var_dump($this->db->queries);
        // echo '</pre>';
        // exit();

        // echo $this->db->last_query();exit();

    }

    public function set_status($uid, $status) {
        $data['status'] = $status;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }

    public function get_all_users($order = '', $offset) {
		// if($order != '') {
		// 	$this->db->order_by('u1.regdate', $order);
		// }
        $query = $this->db->query("SELECT u1.*, u2.login as sponsor_login, ison.id as isonid FROM users as u1 LEFT OUTER JOIN users as u2 ON u2.id=u1.idsponsor LEFT OUTER JOIN isonline as ison ON u1.id = ison.uid LIMIT 30 OFFSET ".$offset);
        $result = array();
        foreach ($query->result_array() as $row)
        {
                $result[] = $row;
        }
        return $result;
     //    return $this->db->limit(50, $offset)
					// ->select('u1.*, u2.login as sponsor_login FROM users u1', false)
					// ->join('users u2', 'u1.idsponsor = u2.id')
     //                ->join('isonline ison', 'u1.id = ison.uid', 'left')
					// ->where('u1.login !=', 'admin')
					// ->get()
					// ->result_array();
    }

    public function add_lang($str, $id) {
        $this->db->query('UPDATE users SET u_lang="'.$str.'" WHERE id='.$id);
    }

    public function add_to_blacklist($owner, $blacklisted) {
        $data['iduser_owner'] = $owner;
        $data['iduser_listed'] = $blacklisted;
        $this->db->insert('blacklisted', $data);
    }

    public function update_fin_pass($hash, $uid) {
        $this->db->where('id', $uid)->update($this->table_name, array('fin_password' => $hash));
    }

    public function remove_from_blacklist($owner, $blacklisted) {
        $this->db->where(array('iduser_owner' => $owner, 'iduser_listed' => $blacklisted))->delete('blacklisted');
    }

    public function get_blacklisted($owner, $blacklisted) {
        return $this->db->where(array('iduser_owner' => $owner, 'iduser_listed' => $blacklisted))
                 ->count_all_results('blacklisted');
    }

    public function set_psystem($uid, $system) {
        $data['payment_system'] = $system;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }
	
	public function activate_user($uid) {
        $data['is_active'] = 1;
        $this->db->where('id', $uid)->update($this->table_name, $data);
    }





    public function check_trying($ip) {

        $this->db->query("DELETE FROM block_ip_trying WHERE count >= 5 AND time+600<".time());

        $query = $this->db->query("SELECT COUNT(*) as count FROM block_ip_trying WHERE ip='".$ip."' AND count >= 5 AND time+600>".time());
        $row = $query->row_array();

        if($row['count'] != NULL) {
            if($row['count'] > 0) {
                return false;
            }else {
                return true;
            }
        }else {
            return true;
        }
        
    }
    public function add_trying($ip) {
        $query = $this->db->query("SELECT COUNT(*) as count FROM block_ip_trying WHERE ip='".$ip."'");
        $row = $query->row_array();

        if($row['count'] != NULL) {
            if($row['count'] > 0) {
                $this->db->query("UPDATE block_ip_trying SET count=count+1 WHERE ip='".$ip."'");
            }else {
                $this->db->query("INSERT INTO block_ip_trying(ip, count, time) VALUES('".$ip."', 1, ".time().")");
            }
        }

    }
}