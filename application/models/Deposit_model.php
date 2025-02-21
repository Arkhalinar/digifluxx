<?php
class Deposit_model extends CI_Model {

	private $table_plans = "depositplans";
	private $table_deposits = "deposits";

	public $iduser;
	public $iddepo_plan;
	public $start_date;
	public $end_date;
	public $deposit_sum;
	public $last_update;

	public function __construct() {
		parent::__construct();
	}

	public function get_deposit_info($dep_id) {
		return $this->db->where('id', $dep_id)->get($this->table_plans)->row_array();
	}

	public function getDepoCount2($col, $val) {
		if($col == 'login') {
			return $this->db->where('iduser', $val)->get($this->table_deposits)->num_rows();
		}elseif($col == 'start_date' || $col == 'end_date') {
			return $this->db->where('DATE_FORMAT('.$col.', "%Y-%m-%d")=', $val)->get($this->table_deposits)->num_rows();
		}else {
			return $this->db->where($col, $val)->get($this->table_deposits)->num_rows();
		}
	}

	public function getMyDepo2($limit, $start, $col, $val) {
		// echo $val; exit;
		if($col == 'login') {
			return $this->db->limit($limit, $start)
				->select('u1.login as login, p.* FROM deposits p', false)
				->join('users u1', 'p.iduser = u1.id', 'left')
				->where('iduser', $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}elseif($col == 'start_date' || $col == 'end_date') {
			return $this->db->limit($limit, $start)
				->select('u1.login as login, p.* FROM deposits p', false)
				->join('users u1', 'p.iduser = u1.id', 'left')
				->where('DATE_FORMAT(p.'.$col.', "%Y-%m-%d")=', $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}else {
			return $this->db->limit($limit, $start)
				->select('u1.login as login, p.* FROM deposits p', false)
				->join('users u1', 'p.iduser = u1.id', 'left')
				->where('p.'.$col, $val)
				->order_by('id', 'DESC')
				->get()->result_array();
		}
	}

	public function getRefillsPerDay() {
		$day[1][1] = $this->db->select('sum(deposit_sum*0.03) FROM deposits', false)
				->where('iddepo_plan', 1)
				->where('total_iterations<=', 39)
				->get()->result_array();

		$day[1][2] = $this->db->select('sum(deposit_sum*0.035) FROM deposits', false)
				->where('iddepo_plan', 2)
				->where('total_iterations<=', 37)
				->get()->result_array();

		$day[1][3] = $this->db->select('sum(deposit_sum*0.04) FROM deposits', false)
				->where('iddepo_plan', 3)
				->where('total_iterations<=', 34)
				->get()->result_array();
		$day[2][1] = $this->db->select('sum(deposit_sum*0.03) FROM deposits', false)
				->where('iddepo_plan', 1)
				->where('total_iterations<=', 38)
				->get()->result_array();

		$day[2][2] = $this->db->select('sum(deposit_sum*0.035) FROM deposits', false)
				->where('iddepo_plan', 2)
				->where('total_iterations<=', 36)
				->get()->result_array();

		$day[2][3] = $this->db->select('sum(deposit_sum*0.04) FROM deposits', false)
				->where('iddepo_plan', 3)
				->where('total_iterations<=', 33)
				->get()->result_array();
		$day[3][1] = $this->db->select('sum(deposit_sum*0.03) FROM deposits', false)
				->where('iddepo_plan', 1)
				->where('total_iterations<=', 37)
				->get()->result_array();

		$day[3][2] = $this->db->select('sum(deposit_sum*0.035) FROM deposits', false)
				->where('iddepo_plan', 2)
				->where('total_iterations<=', 35)
				->get()->result_array();

		$day[3][3] = $this->db->select('sum(deposit_sum*0.04) FROM deposits', false)
				->where('iddepo_plan', 3)
				->where('total_iterations<=', 32)
				->get()->result_array();

		return $day;
	}

	public function add_deposit($dep) {
		$this->iduser = $dep['uid'];
		$this->iddepo_plan = $dep['plan_id'];
		$tomorrow = $this->get_interval_date(1);
		$this->start_date = $tomorrow['intdate'];
		$end_date = $this->get_interval_date($dep['investment_term']);
		$this->end_date = $end_date['intdate'];
		$this->deposit_sum = $dep['dep_sum'];

		$this->db->insert($this->table_deposits, $this);
	}

	public function get_interval_date($interval) {
		return $this->db->select('DISTINCT NOW() + INTERVAL ' . $interval . ' day as intdate')->from($this->table_plans)->get()->row_array();
	}

	public function get_user_deposits($uid) {
		return $this->db->select('dp.title, dp.id, dp.daily_percent, dp.investment_term, d.*')->from($this->table_plans . ' dp')->join($this->table_deposits . ' d', 'dp.id = d.iddepo_plan')->where('d.iduser', $uid)->order_by('d.status', 'DESC')->order_by('d.id', 'DESC')->get()->result_array();
	}
	
	public function get_all_deposits() {
		return $this->db->where('status', '1')->get($this->table_deposits)->result_array();
	}

	public function update_deposit($id, $data) {
		$this->db->where('id', $id)->update($this->table_deposits, $data);
	}
	
	public function get_total_deposits($plan = 0) {
		if($plan != 0) {
			$this->db->where('iddepo_plan', $plan);
		}
		return $this->db->count_all_results($this->table_deposits);
	}
	
	public function get_active_deposits() {
		return $this->db->where('status', 1)->count_all_results($this->table_deposits);
	}
	
	public function get_total_depo_sum() {
		return $this->db->select_sum('income')->get($this->table_deposits)->row_array();
	}

	public function getDepoCount() {
		return $this->db->where('status', 1)->get($this->table_deposits)->num_rows();
	}

	public function getDepo($limit, $offset){
		return $this->db->limit($limit, $offset)
			->select('u1.login as login, p.* FROM deposits p', false)
			->join('users u1', 'p.iduser = u1.id', 'left')
			->order_by('id', 'DESC')
			->get()->result_array();
	}

}
