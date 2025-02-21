<?php
class Logger_model extends CI_Model {

    private $table_name = "admin_log";

    public $action_string;
    public $sitekey;

    public function __construct() {
        parent::__construct();
    }

    public function add_action($action, $sitekey) {
        $this->action_string = $action;
        $this->sitekey = $sitekey;
        $this->db->set('action_date', 'NOW()', false);

        $this->db->insert($this->table_name, $this);
    }
}