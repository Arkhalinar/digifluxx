<?php
class Support_model extends CI_Model {

    private $table_name = "support_issues";

    public $title;
    public $body_text;
    public $iduser;

    public function __construct() {
        parent::__construct();
    }
    
    public function add_issue($uid) {
        $this->title = $this->input->post('title');
        $this->body_text = $this->input->post('message');
        $this->iduser = $uid;
        $this->db->set('date_add', 'NOW()', false);
        $this->db->insert($this->table_name, $this);
    }

    public function get_messages($limit, $offset) {
        return $this->db->select('u.login, si.* FROM users u, support_issues si', false)->where('u.id = si.iduser')->limit($limit, $offset)->get()->result_array();
    }

    public function get_total_issues() {
        return $this->db->count_all_results($this->table_name);
    }

    public function delete_issue($id) {
        return $this->db->where('id', $id)->delete($this->table_name);
    }
}