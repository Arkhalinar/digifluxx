<?php
class Mail_model extends CI_Model {

    private $table_name = "mailrotator";

    public $email;
    public $sent_emails;

    public function __construct() {
        parent::__construct();
    }

    public function in_limit($adr) {
        $res = $this->db->where('email', $adr)->get($this->table_name)->row_array();
        if($res['last_update'] == null || strtotime(date('Y-m-d')) < strtotime($res['last_update']))
            return true;
        if($res['sent_emails'] < 500)
            return true;
        return false;
    }

    public function update_table($adr) {
        $res = $this->db->where('email', $adr)->get($this->table_name)->row_array();
        if($res['last_update'] == null || strtotime(date('Y-m-d')) > strtotime($res['last_update'])) {
            $this->db->set('last_update', 'date(NOW())', false);
            $data['sent_emails'] = 1;
        }
        else {
            $data['sent_emails'] = $res['sent_emails'] + 1;
        }
        $this->db->where('email', $adr)->update($this->table_name, $data);
    }

}