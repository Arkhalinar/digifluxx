<?php
class Packet_model extends CI_Model {

    private $table_name = "manual_packets";

    public $name_of_packet;
    public $product;
    public $price;

    public function __construct() {
        parent::__construct();
    }

    public function add_packet() {
        $this->name_of_packet = json_encode(array('RUS' => $this->input->post('name_russian'), 'ENG' => $this->input->post('name_english'), 'GER' => $this->input->post('name_german')), JSON_UNESCAPED_UNICODE);

        if($_POST['bp1'] == NULL) {
            $array1 = array();
        }else {
            $array1 = array('lvl' => $_POST['level1'], 'insta_balance' => $_POST['insta_balance1']);
        }

        if($_POST['bp2'] == NULL) {
            $array2 = array();
        }else {
            $array2 = array('lvl' => $_POST['level2'], 'insta_balance' => $_POST['insta_balance2']);
        }

        if($_POST['bp3'] == NULL) {
            $array3 = array();
        }else {
            $array3 = array('lvl' => $_POST['level3'], 'insta_balance' => $_POST['insta_balance3']);
        }

        if($_POST['bp4'] == NULL) {
            $array4 = array();
        }else {
            $array4 = array('lvl' => $_POST['level4'], 'insta_balance' => $_POST['insta_balance4']);
        }

        $this->product = json_encode(array('1' => $array1, '2' => $array2, '3' => $array3, '4' => $array4));
        $this->price = $this->input->post('price');
        $this->db->set('date', 'NOW()', false);
        $this->db->insert($this->table_name, $this);
        // var_dump($this->db->error());exit();
    }

    public function edit_packet($id) {
        $this->name_of_packet = json_encode(array('RUS' => $this->input->post('name_russian'), 'ENG' => $this->input->post('name_english'), 'GER' => $this->input->post('name_german')), JSON_UNESCAPED_UNICODE);

        if($_POST['bp1'] == NULL) {
            $array1 = array();
        }else {
            $array1 = array('lvl' => $_POST['level1'], 'insta_balance' => $_POST['insta_balance1']);
        }

        if($_POST['bp2'] == NULL) {
            $array2 = array();
        }else {
            $array2 = array('lvl' => $_POST['level2'], 'insta_balance' => $_POST['insta_balance2']);
        }

        if($_POST['bp3'] == NULL) {
            $array3 = array();
        }else {
            $array3 = array('lvl' => $_POST['level3'], 'insta_balance' => $_POST['insta_balance3']);
        }

        if($_POST['bp4'] == NULL) {
            $array4 = array();
        }else {
            $array4 = array('lvl' => $_POST['level4'], 'insta_balance' => $_POST['insta_balance4']);
        }

        $this->product = json_encode(array('1' => $array1, '2' => $array2, '3' => $array3, '4' => $array4));
        $this->price = $this->input->post('price');
        $this->db->where('id', $id)->update($this->table_name, $this);
        // var_dump($this->db->error());exit();
    }

    public function del_packet($id) {
        $this->db->query('DELETE FROM '.$this->table_name.' WHERE id='.$id);
    }

    public function get() {

        return $this->db->order_by('id', 'DESC')->get($this->table_name)->result_array();

    }

    public function get_packet_by_id($id) {

        return $this->db->get_where($this->table_name, array('id' => $id))->row_array();

    }

}
