<?php
class Queue_model extends CI_Model {

    private $table_name = "payment_queue";

    public $iduser;

    public function __construct() {
        parent::__construct();
    }

    public function get_count() {
        return $this->db->count_all_results($this->table_name);
    }

    public function add_in_queue($uid) {
        $this->db->set('date_add', 'NOW()', false);
        $this->iduser = $uid;
        $this->db->insert($this->table_name, $this);
    }

    public function get_queue() {
        return $this->db->order_by('date_add', 'ASC')->get($this->table_name)->result_array();
    }

    public function clear() {
        return $this->db->where('id is not null')->delete($this->table_name);
    }
}