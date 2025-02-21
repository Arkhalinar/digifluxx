<?php
class Tree_model extends CI_Model {

	private $table_name = "matrix_level_";

	public $iduser;
	public $place;
	public $has_children;

	public function __construct() {
		parent::__construct();
	}

	//возвращает инфо о пользователе из дерева по указанному месту: его ид, место, наличие потомков
	public function getUserByPlace($place, $level = 1) {
		$query = $this->db->get_where($this->table_name . $level, array('place' => $place));
		if($query->num_rows()) {
			return $query->result_array();
		}
		return false;
	}
	
	//возвращает ид пользователя по его месту
	public function getUidByPlace($place, $level = 1) {
		$query = $this->db->select('iduser')->get_where($this->table_name . $level , array('place' => $place))->result_array();
		if($query->num_rows()) {
			$query = $query->result_array();
			return $query[0]['iduser'];
		}
		return false;
	}

	public function get_weight($place, $level = 1) {
		return $this->db->select('matrix_weight')->get_where($this->table_name . $level, array('place' => $place))->row_array();
	}

	public function update_weight($place, $weight, $level = 1) {
		return $this->db->where('place', $place)->update($this->table_name . $level, array('matrix_weight' => $weight));
	}
	
	//возвращает самое первое место пользователя по его ид
	public function getUsersPlace($id, $level = 1) {
		$query = $this->db->select('place')->order_by('place', 'asc')->get_where($this->table_name . $level, array('iduser' => $id))->result_array();
		if(empty($query))
			return null;
		return $query[0]['place'];
	}

	public function user_has_place($uid, $level) {
		$query = $this->db->get_where($this->table_name . $level, array('iduser' => $uid));
		if($query->num_rows())
			return true;
		return false;
	}

	public function insertIntoMatrix($id_new_user, $new_place, $after_place, $level = 1, $bought = 0) {
		$this->iduser = $id_new_user;
		$this->place = $new_place;
		$this->has_children = 0;

		$this->db->insert($this->table_name . $level, $this);

		$data = array('has_children' => 1);
		$this->db->where('place', $after_place)->update($this->table_name . $level, $data);
	}

	public function get_my_places_count($uid, $level = 1) {
		$this->db->where('iduser', $uid);
		$this->db->from($this->table_name . $level);
		return $this->db->count_all_results();
	}

	public function get_user_places($level) {
		return $this->db->count_all_results($this->table_name . $level);
	}

	public function get_places_closed($level) {
		return $this->db->where('matrix_weight >=', 6)->count_all_results($this->table_name . $level);
	}

	public function get_my_places($uid, $matrix_level = 1) {
		$this->db->select('place');
		$this->db->where('iduser', $uid);
		return $this->db->get($this->table_name . $matrix_level)->result_array();
	}

	public function getPlatformsCount($uid, $level = 1) {
		return $this->db->where('iduser', $uid)->count_all_results($this->table_name . $level);
	}
}
