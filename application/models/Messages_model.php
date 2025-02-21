<?php
class Messages_model extends CI_Model {

    private $table_name = "messages";

    public $title;
    public $body_text;
    public $idsender;
    public $idreceiver;

    public function __construct() {
        parent::__construct();
    }

    public function add_message($sender_id, $receiver_id) {
        $this->title = $this->input->post('title');
        $this->body_text = $this->input->post('message');
        $this->idsender = $sender_id;
        $this->idreceiver = $receiver_id;

        $this->db->set('date_add', 'NOW()', false);
        $this->db->insert($this->table_name, $this);
    }

    public function get_messages($receiver_id) {
        return $this->db->select('u.login as sender_login, m.* from users u, messages m')->where('m.idreceiver = ' . $receiver_id)
                    ->where('m.idsender = u.id')
                    ->order_by('date_add', 'DESC')
                    ->get()->result_array();
    }

    public function get_message($idmessage, $idreceiver) {
        return $this->db->select('u.login as sender_login, m.* from users u, messages m')
                    ->where('m.idsender = u.id and m.id = ' . $idmessage . ' and m.idreceiver = ' . $idreceiver)
                    ->get()
                    ->row_array();
    }

    public function del_message($idmessage, $idreceiver) {
        return $this->db->where(array('id' => $idmessage, 'idreceiver' => $idreceiver))
                    ->delete($this->table_name);
    }

    public function mark_as_read($id) {
        $data['is_read'] = 1;
        $this->db->where('id', $id)->update($this->table_name, $data);
    }

    public function get_unread($uid) {
        return $this->db->where(array('idreceiver' => $uid, 'is_read' => 0))->count_all_results($this->table_name);
    }
}