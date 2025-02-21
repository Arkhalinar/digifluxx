<?php
class Product_model extends CI_Model {

    private $table_name = "product";

    public $product_text;
    public $product_link;

    public function __construct() {
        parent::__construct();
    }

    public function update_data() {
        $this->product_text = $this->input->post('text_body');
        $this->product_link = $this->input->post('link');
        $this->db->where('id', 1)->update($this->table_name, $this);
    }

    public function change_text() {
        $this->product_text= $this->input->post('text_body');
        $this->db->where('id', 1)->update($this->table_name, $this);
    }

    public function get_text() {
        return $this->db->get($this->table_name)->row_array();
    }
}
