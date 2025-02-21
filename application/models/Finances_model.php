<?php
class Finances_model extends CI_Model {

	private $table_name = "payments";

	public $type; //1 - Внутренний перевод, 2 - пополнение счета, 3 - вывод, 4 - покупка места, 5 - бонус за закрытие стурктуры, 6 - реферальный бонус, 7 - активация депозита, 8 - депозитные начисления, 9 - возврат депозитных средств
	public $idreceiver;
	public $idsender;
	public $status; //1 - транзакция завершена, 2 - pending (ожидание), 3 - отклонена, 4 - ожидание оплаты
	public $sitekey; //флаг безопасности
	public $btc_address;
	public $comission;
	public $iddepo_plan;
	public $idinitiator;
	public $hash_pe;

	public function __construct() {
		parent::__construct();
	}

	public function get_last_buying()
    {
        $query = $this->db->query("SELECT p.type, p.actiondate, u.login FROM `payments` as p INNER JOIN `users` as u ON u.id=p.idsender WHERE (p.type=1999 || p.type=2999 || p.type=3999 || p.type=4999) ORDER BY p.id DESC LIMIT 10");

        // || p.type=11999 || p.type=12999 || p.type=13999 || p.type=14999 || p.type=15999

        $result = [];

        foreach ($query->result_array() as $row) {

            $result[] = $row;
            
        }

        return $result;
    }

	public function convert_to_btc($amount) {
		$res = $this->db->query("SELECT Credits FROM curs_btc WHERE Cur='BTC_out'");
    	$ArrayOfCurses = $res->row_array();

    	// 1 BTC = 8023 CDT
    	// ? BTC = $amount CDT

    	// $RealSum = $data->currency_received->amount;
    	// $sum = round($ArrayOfCurses['Credits']/(1/$RealSum), 0);

    	return bcdiv($amount, $ArrayOfCurses['Credits'], 8);

    	//$this->db->query("UPDATE users SET amount_btc=amount_btc+".$sum." WHERE id=".$uid);
	}
	public function save_full_deposit_log($type, $head, $body) {
		$this->db->query("INSERT INTO `btc_logs`(`type`, `info_head`, `info_body`, `date`) VALUES ('".$type."', '".json_encode($head)."','".json_encode($body)."',now())");
	}
	public function save_full_transaction_info($uid, $FullInfoAtJson) {
		$this->db->query("INSERT INTO `full_transaction_info`(`uid`, `full_json_info`, `date`) VALUES (".$uid.", '".$FullInfoAtJson."', now())");
	}
	public function up_balance_by_stripe($CustomerId, $SumAtEuro, $TransactionId, $FullInfoAtJson) {
		//take user id by customer_id
		$res = $this->db->query("SELECT id FROM users WHERE customer_id='".$CustomerId."'");
    	$ArrayOfUserId = $res->row_array();
    	
    	$uid = $ArrayOfUserId['id'];
    	$hash = $TransactionId;

		$res = $this->db->query("SELECT id FROM payments WHERE type=2 AND idreceiver=".$uid." AND hash_pe='".$hash."'");
        if($res->num_rows() < 1) {
        	//if payment didnt exist
        	//save full information
    		$this->save_full_transaction_info($uid, $FullInfoAtJson);

    		//get curs for calculate sum at Credits
        	$res = $this->db->query("SELECT Credits FROM curs_btc WHERE Cur='EUR'");
        	$ArrayOfCurses = $res->row_array();

        	$RealSum = $SumAtEuro;
        	$sum = round($ArrayOfCurses['Credits']/(1/$RealSum), 2);//cents
        	$sum = round($sum/100, 2);//cents

        	$this->db->query("UPDATE users SET amount_btc=amount_btc+".$sum." WHERE id=".$uid);
            $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, hash_pe, actiondate) VALUES(2, 'EUR', ".$uid.", 1, ".$sum.", 'real sum = ".$RealSum."', '".$hash."', now())");
        }
	}
	public function up_balance_by_sofort($uid, $SumAtEuro, $TransactionId, $FullInfoAtJson) {

		//take user id by customer_id
    	$hash = $TransactionId;

		$res = $this->db->query("SELECT id FROM payments WHERE type=2 AND idreceiver=".$uid." AND hash_pe='sofort - ".$hash."'");
        if($res->num_rows() < 1) {
        	//if payment didnt exist
        	//save full information
    		$this->save_full_transaction_info($uid, $FullInfoAtJson);

    		//get curs for calculate sum at Credits
        	$res = $this->db->query("SELECT Credits FROM curs_btc WHERE Cur='EUR'");
        	$ArrayOfCurses = $res->row_array();

        	$RealSum = $SumAtEuro;
        	$sum = round($ArrayOfCurses['Credits']/(1/$RealSum), 2);//cents
        	$sum = round($sum/100, 2);//cents

        	$this->db->query("UPDATE users SET amount_btc=amount_btc+".$sum." WHERE id=".$uid);
            $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, hash_pe, actiondate) VALUES(2, 'EUR', ".$uid.", 1, ".$sum.", 'real sum = ".$RealSum."', 'sofort - ".$hash."', now())");
        }
	}
	public function get_all_click() {
		$query = $this->db->query("SELECT sum(`click_for_stat`) FROM `banners` WHERE 1");
		$row = $query->row_array();

		return $row['sum(`click_for_stat`)'];
	}
	public function get_all_show() {
		$query = $this->db->query("SELECT sum(`show_for_stat`) FROM `banners` WHERE 1");
		$row = $query->row_array();

		return $row['sum(`show_for_stat`)'];
	}


	public function get_curs_btc() {
		$query = $this->db->query("SELECT * FROM curs_btc");
		$row = $query->row_array();

		return $row;
	}

	public function get_spec_stat() {
		$query = $this->db->query("SELECT * FROM new_stat_for_admin");
		$row = $query->row_array();

		return $row;
	}

	public function get_us_bals() {
		$query = $this->db->query("SELECT sum(amount_btc), sum(add_amount_btc) FROM users WHERE id!=1");
		$row = $query->row_array();

		return array('main' => $row['sum(add_amount_btc)'], 'add' => $row['sum(amount_btc)']);
	}


	public function get_total_income_without_refs() {
		$query = $this->db->query("SELECT sum(amount) FROM payments WHERE type=2 AND currency='BTC'");
		$row = $query->row_array();

		return $row['sum(amount)'];
	}

	public function getTransactionsCount($uid, $currency = 'all') {
		if($currency == 'all') {
			return $this->db->where('idreceiver', $uid)->or_where('idsender', $uid)->get($this->table_name)->num_rows();
		}else {
			$query = $this->db->query("SELECT * FROM payments WHERE currency='".$currency."' AND (idreceiver=$uid OR idsender=$uid)");
			return $query->num_rows();
			// $arr = array();
			// foreach ($query->result as $row) {
			// 	$arr[] = $row;
			// }
			// return $arr;
		}
	}

	public function getFullTransactionsCount() {
		// var_dump($this->db->get($this->table_name)->num_rows());
		// exit();
		// return $this->db->get($this->table_name)->num_rows();

		$query = $this->db->query("SELECT COUNT(*) FROM payments");
		$row = $query->row_array();

		return $row['COUNT(*)'];
	}

	public function getPendingTransactionsCount(){
		return $this->db->where('status', 2)->get($this->table_name)->num_rows();
	}

	public function getPendingTransactions($limit, $start) {
		// if($uid == -1)
		// 	$uid = $this->session->uid;

		return $this->db->limit($limit, $start)
			->select('u1.login as sendername, u1.u_lang as userlang, p.* FROM payments p', false)
			->join('users u1', 'p.idsender = u1.id', 'left')
			->join('users u2', 'p.idreceiver = u2.id', 'left')
			->join('users u3', 'p.idinitiator = u3.id', 'left')
			->where('p.status', 2)
			->where('p.hash_pe', "")
			->order_by('actiondate', 'DESC')
			->get()->result_array();

	}

	public function getPendingTransactionsCount2(){
		$res = $this->db->query("SELECT COUNT(*) FROM payments WHERE type=3 AND status=1");
		$arr = $res->row_array();
		return $arr['COUNT(*)'];
	}

	public function getPendingTransactions2($limit, $start) {
		// if($uid == -1)
		// 	$uid = $this->session->uid;

		return $this->db->limit($limit, $start)
			->select('u1.login as sendername, u1.u_lang as userlang, p.* FROM payments p', false)
			->join('users u1', 'p.idsender = u1.id', 'left')
			->join('users u2', 'p.idreceiver = u2.id', 'left')
			->join('users u3', 'p.idinitiator = u3.id', 'left')
			->where('p.status', 1)
			->where('p.type', 3)
			->order_by('actiondate', 'DESC')
			->get()->result_array();

	}

	public function getPendingTransactionsCount3(){
		$res = $this->db->query("SELECT COUNT(*) FROM payments WHERE type=3 AND status=3");
		$arr = $res->row_array();
		return $arr['COUNT(*)'];
	}

	public function getPendingTransactions3($limit, $start) {
		// if($uid == -1)
		// 	$uid = $this->session->uid;

		return $this->db->limit($limit, $start)
			->select('p.riason as riason, u1.login as sendername, u1.u_lang as userlang, p.* FROM payments p', false)
			->join('users u1', 'p.idsender = u1.id', 'left')
			->join('users u2', 'p.idreceiver = u2.id', 'left')
			->join('users u3', 'p.idinitiator = u3.id', 'left')
			->where('p.status', 3)
			->where('p.type', 3)
			->where('p.hash_pe', "")
			->order_by('actiondate', 'DESC')
			->get()->result_array();

	}

	public function cancel_payment($payment_id, $riason) {
		$data['status'] = 3;
		$data['riason'] = $riason;
		$this->db->where('id', $payment_id)->update($this->table_name, $data);
	}

	public function add_id_payment($is_confirmation, $id){
		$data['hash_pe'] = $id;
		$this->db->where('id', $is_confirmation)->update($this->table_name, $data);
	}

	public function confirm_payment($payment_id) {
		$data['status'] = 1;
		$this->db->where('id', $payment_id)->update($this->table_name, $data);

		// $res = $this->db->query("UPDATE new_stat_for_admin SET Transfered_from_main_to_add=Transfered_from_main_to_add+".$sum);

		// $this->db->query("UPDATE new_stat_for_admin SET Transfered_from_main_to_add=Transfered_from_main_to_add+".$sum);
	}


	public function getTransactions($limit, $offset){
		return $this->db->limit($limit, $offset)
			->select('u1.login as sendername, u3.login as initiator, u2.login as receivername, p.* FROM payments p', false)
			->join('users u1', 'p.idsender = u1.id', 'left')
			->join('users u2', 'p.idreceiver = u2.id', 'left')
			->join('users u3', 'p.idinitiator = u3.id', 'left')
			->order_by('id', 'DESC')
			->get()->result_array();
	}

	public function getMyTransactions($limit, $start, $uid = -1, $currency = 'all') {
		if($uid == -1)
			$uid = $this->session->uid;

		$query = $this->db->query("SELECT u1.login as sendername, u3.login as initiator, u2.login as receivername, p.* FROM payments p
		LEFT JOIN users u1 ON p.idsender = u1.id
		LEFT JOIN users u2 ON p.idreceiver = u2.id
		LEFT JOIN users u3 ON p.idinitiator = u3.id
	 	WHERE (p.idreceiver=$uid OR p.idsender=$uid) ORDER BY id DESC LIMIT $start, $limit");

		 // p.currency='".$currency."' AND

		$arr = array();
		foreach ($query->result_array() as $row) {
			// var_dump($row);
			// exit();

			if(is_numeric($row['hash_pe']) && ($row['type'] == 99873 || $row['type'] == 98873)) {
				$query_in = $this->db->query("SELECT login FROM users WHERE id=".$row['hash_pe']);
				if($query_in->num_rows() > 0) {
					$row_in = $query_in->row_array();
					$row['hash_pe'] = $row_in['login'];
				}
			}

			$arr[] = $row;
		}
		return $arr;

	}

	public function getTransactionsCount2($col, $val) {
		if($col == 'login') {
			return $this->db->where('idsender', $val)->or_where('idreceiver', $val)->get($this->table_name)->num_rows();
		}elseif($col == 'actiondate') {
			return $this->db->where('DATE_FORMAT('.$col.', "%Y-%m-%d")=', $val)->get($this->table_name)->num_rows();
		}else {
			return $this->db->where($col, $val)->get($this->table_name)->num_rows();
		}
	}
	public function getMyTransactions2($limit, $start, $col, $val) {
		// echo $val; exit;
		if($col == 'login') {
			return $this->db->limit($limit, $start)
				->select('u1.login as sendername, u3.login as initiator, u2.login as receivername, p.* FROM payments p', false)
				->join('users u1', 'p.idsender = u1.id', 'left')
				->join('users u2', 'p.idreceiver = u2.id', 'left')
				->join('users u3', 'p.idinitiator = u3.id', 'left')
				->where('idreceiver', $val)
				->or_where('idsender', $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}elseif($col == 'actiondate') {
			return $this->db->limit($limit, $start)
				->select('u1.login as sendername, u3.login as initiator, u2.login as receivername, p.* FROM payments p', false)
				->join('users u1', 'p.idsender = u1.id', 'left')
				->join('users u2', 'p.idreceiver = u2.id', 'left')
				->join('users u3', 'p.idinitiator = u3.id', 'left')
				->where('DATE_FORMAT(p.'.$col.', "%Y-%m-%d")=', $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}else {
			return $this->db->limit($limit, $start)
				->select('u1.login as sendername, u3.login as initiator, u2.login as receivername, p.* FROM payments p', false)
				->join('users u1', 'p.idsender = u1.id', 'left')
				->join('users u2', 'p.idreceiver = u2.id', 'left')
				->join('users u3', 'p.idinitiator = u3.id', 'left')
				->where('p.'.$col, $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}
	}

	public function getMyWithdraws($uid = -1) {
		if($uid == -1)
			$uid = $this->session->uid;

		return $this->db->select('p.amount as sum, p.status as status, p.riason as riason, p.actiondate as date, p.* FROM payments p', false)
			->join('users u1', 'p.idsender = u1.id')
			->where('p.idsender', $uid)
			->where('p.type', 3)
			->order_by('p.actiondate', 'DESC')
			->get()->result_array();

	}

	public function getMyRefills($uid = -1, $currency = 'BTC') {
		if($uid == -1)
			$uid = $this->session->uid;

		if($currency == 'CP') {
			$query = $this->db->query("SELECT p.* FROM btc_invoices p
			 	WHERE p.iduser=$uid AND p.currency LIKE 'CP%' AND (p.status=0 OR p.status=100) ORDER BY id DESC");
		}else {
			$query = $this->db->query("SELECT p.* FROM btc_invoices p
			 	WHERE p.iduser=$uid AND p.currency='".$currency."' AND (p.status=0 OR p.status=100) ORDER BY id DESC");
		}

		$arr = array();
		foreach ($query->result_array() as $row) {
			$arr[] = $row;
		}
		return $arr;

	}

	public function getMyTransactionsByDate($start_date, $end_date) {
		$uid = $this->session->uid;

		return $this->db->select('concat_ws(" ", u1.name, u1.lastname) as sendername,  concat_ws(" ", u2.name, u2.lastname) as receivername, p.* FROM payments p', false)
			->from('users u, payments p')
			->join('users u1', 'p.idsender = u1.id')
			->join('users u2', 'p.idreceiver = u2.id')
			->where("(date(actiondate) >= '" . $start_date . "' AND date(actiondate) <= '" . $end_date . "')")
			->where('p.idreceiver', $uid)
			->or_where('p.idsender', $uid)
			->get()->result_array();

	}

	public function get_total_income(){
		$query = $this->db->query("SELECT sum(amount) FROM payments WHERE type=2 AND currency='BTC'");
		$row = $query->row_array();
		$result['all'] = $row['sum(amount)'];

		$query = $this->db->query("SELECT sum(amount) FROM payments WHERE type=2 AND currency='BTC' AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=86400");
		$row = $query->row_array();
		$result['all_24'] = $row['sum(amount)'];

		$query = $this->db->query("SELECT sum(amount) FROM payments WHERE type=2 AND currency='BTC' AND UNIX_TIMESTAMP()-UNIX_TIMESTAMP(`actiondate`)<=2592000");
		$row = $query->row_array();
		$result['all_30'] = $row['sum(amount)'];

		return $result;
	}

	public function get_total_comission() {
		return $this->db->select_sum('comission', 'comission_total')->get($this->table_name)->row_array();
	}

	public function get_total_withdrew($uid) {
		return $this->db->where(array('idsender' => $uid, 'type' => 3, 'status' => 1))->select_sum('amount', 'widthrew_total')->get($this->table_name)->row_array();
	}
	
	public function get_withdrew() {
		return $this->db->where(array('type' => 3, 'status' => 1))->select_sum('amount')->get($this->table_name)->row_array();
	}
	
	public function get_total_invested() {
		return $this->db->where(array('type' => 2))->select_sum('amount')->get($this->table_name)->row_array();
	}

	public function get_total_user_income($uid) {
		return $this->db->where('idreceiver', $uid)
						->group_start()
						->where('type', 2)
						->or_where('type', 6)
						->or_where('type', 8)
						->group_end()
						->select_sum('amount', 'total_income')->get($this->table_name)->row_array();
	}

	public function get_total_payed(){
		return $this->db->select_sum('amount')->where('type', 3)->get($this->table_name)->row_array();
	}

	public function addTransaction($currency, $senderid, $receiverid, $sum, $type, $status, $comission = 0, $iddepo_plan = null, $initiator = null, $btc_address = null, $hash_pe = '', $actiondate = '') {
		$this->type = $type;
		$this->idreceiver = $receiverid;
		$this->currency = $currency;
		$this->idsender = $senderid;
		$this->status = $status;
		$this->sitekey = $this->make_sitekey();
		$this->amount = $sum;
		$this->btc_address = $btc_address;
		$this->hash_pe = $hash_pe;
		$this->comission = $comission;
		$this->iddepo_plan = $iddepo_plan;
		$this->idinitiator = $initiator;

		if($actiondate == '') {
			$this->db->set('actiondate', "NOW()", false); //поскольку вызываем встроенную функцию mysql, обрамлять кавычками не нужно. хотя можно попробовать $this->db->call_function('now');
		}else {
			$this->db->set('actiondate', "'".$actiondate."'", false); //поскольку вызываем встроенную функцию mysql, обрамлять кавычками не нужно. хотя можно попробовать $this->db->call_function('now');
		}
		$this->db->insert($this->table_name, $this);

		return $this->db->insert_id();
	}
	public function CheckPE($Hash) {
		if($this->db->where('hash_pe', $Hash)->get($this->table_name)->num_rows() > 0) {
			return false;
		}else {
			return true;
		}
	}

	public function make_sitekey() {
		$string = bin2hex(base64_encode(str_replace('==', '', base64_encode(strrev($this->session->uid . '/' . current_url() . '/' . date('Y-m-d H:i:s'))))));
		return str_replace('5', '/', str_replace('b', '_', $string));
	}

	public function get_transaction1($id){
		return $this->db->get_where($this->table_name, array('id' => $id))->row_array();
	}
	
	public function check_sum($uid) {
		$this->db->select_sum('amount', 'total_sum');
		$this->db->group_start();
			$this->db->where('idsender', $uid);
			$this->db->or_where('idreceiver', $uid);
		$this->db->group_end();
		$this->db->group_start();
			$this->db->where('type', 2);
			$this->db->or_where('type', 6);
			$this->db->or_where('type', 8);
			$this->db->or_where('type', 9);
		$this->db->group_end();
		$sum = $this->db->get($this->table_name)->row_array();
		
		$sum = $sum['total_sum'];
		
		$this->db->select_sum('amount', 'total_min');
		$this->db->group_start();
			$this->db->where('idsender', $uid);
			$this->db->or_where('idreceiver', $uid);
			$this->db->or_where('idinitiator', $uid);
		$this->db->group_end();
		$this->db->where('type', 3);
		$min = $this->db->get($this->table_name)->row_array();
		
		$result = $sum - $min['total_min'];
		return $result;
	}
	
	public function get_tx_by_wallet($address) {
		$q = $this->db->order_by('actiondate', 'desc')->where(array('btc_address' => $address, 'type' => 3))->get($this->table_name)->result_array();
		return $q[0];
	}
	
	public function get_tx_by_hesh_pe($id) {
		$q = $this->db->where(array('hash_pe' => $id, 'type' => 3))->get($this->table_name)->result_array();
		return $q[0];
	}

	public function update_crypto_tx_withdraw($id, $status) {
		$data['status'] = $status;
		$this->db->where('id', $id)->update($this->table_name, $data);
	}
	
	//всего начислено юзерам по депохзитам
	public function get_total_depo_income() {
		return $this->db->select_sum('amount')->where('type', 8)->or_where('type', 9)->get($this->table_name)->row_array();
	}
	
	//общая сумма вложенных во все депозиты денег
	public function get_total_deposited() {
		return $this->db->select_sum('amount')->where('type', 7)->get($this->table_name)->row_array();
	}
	
	//всего реф.отчислений
	public function get_total_refbonus() {
		return $this->db->select_sum('amount')->where('type', 6)->get($this->table_name)->row_array();
	}
	
	//метод возвращает общую сумму выведенных средств за сегодня для конкретного пользователя
	public function get_todays_wd($uid) {
		return $this->db->select_sum('amount')->where(array('type' => 3, 'idsender' => $uid, 'DATE_FORMAT(actiondate, "%Y-%m-%d") = ' => 'CURDATE()'), NULL, false)->get($this->table_name)->row_array();
	}
	
	public function get_transaction($id) {
		return $this->db->where('id', $id)->get($this->table_name)->row_array();
	}
}
