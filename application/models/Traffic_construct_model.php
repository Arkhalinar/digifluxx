<?php
class Traffic_construct_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add_country($name, $cid) {
        $this->db->query("INSERT INTO `countries`(`cid`, `name`) VALUES (".$cid.", '".$name."')");
    }
    public function edit_country($id, $name, $cid) {
        $this->db->query("UPDATE `countries` SET `cid`=".$cid.", `name`='".$name."' WHERE id=".$id);
    }
    public function del_country($id) {
        $this->db->query("DELETE FROM `countries` WHERE id=".$id);
    }
    public function get_country($id) {
        $result = $this->db->query("SELECT * FROM `countries` WHERE id=".$id);
        $response = $result->row_array();
        return $response;
    }
    public function get_countries() {
        $result = $this->db->query("SELECT t1.id, t1.name as country, t2.name as category FROM `countries` as t1 INNER JOIN `categories` as t2 ON t1.cid=t2.id");
        $response = [];
        foreach ($result->result_array() as $row)
        {
            $response[] = $row;
        }
        return $response;
    }
    public function get_countries_for_conf() {
        $result = $this->db->query("SELECT * FROM `countries`");
        $response = [];
        foreach ($result->result_array() as $row)
        {
            $response[$row['id']]['name'] = $row['name'];
            $response[$row['id']]['cid'] = $row['cid'];
        }
        return $response;
    }
    public function get_isset_countries_categories() {
        $result = $this->db->query("SELECT DISTINCT(cid) as cid FROM `countries`");
        $response = [];
        foreach ($result->result_array() as $row)
        {
            $response[] = $row['cid'];
        }
        return $response;
    }

    public function add_category($name) {
        $this->db->query("INSERT INTO `categories`(`name`) VALUES ('".$name."')");
        $id = $this->db->insert_id();

        for ($i=1; $i <= 4; $i++) { 
            $this->db->query("INSERT INTO `settings_of_mark`(`type`, `value`) VALUES ('category_".$i."_".$id."', '{\"scales_for_up\":{\"1\":\"0\",\"2\":\"0\",\"3\":\"0\",\"4\":\"0\",\"5\":\"0\",\"6\":\"0\",\"7\":\"0\",\"8\":\"0\",\"9\":\"0\",\"10\":\"0\",\"11\":\"0\",\"12\":\"0\",\"13\":\"0\",\"14\":\"0\",\"15\":\"0\",\"16\":\"0\",\"17\":\"0\",\"18\":\"0\",\"19\":\"0\",\"20\":\"0\",\"21\":\"0\",\"22\":\"0\",\"23\":\"0\",\"24\":\"0\",\"25\":\"0\",\"26\":\"0\",\"27\":\"0\",\"28\":\"0\",\"29\":\"0\",\"30\":\"0\",\"31\":\"0\",\"32\":\"0\",\"33\":\"0\",\"34\":\"0\",\"35\":\"0\",\"36\":\"0\",\"37\":\"0\",\"38\":\"0\",\"39\":\"0\",\"40\":\"0\",\"41\":\"0\",\"42\":\"0\"},\"comm_back_pool\":\"0\",\"grunder_pool\":\"0\",\"liga_pool\":\"0\",\"invest_pool\":\"0\",\"sh_konto\":\"0\",\"system\":\"0\",\"sponsor\":\"0\",\"team\":\"0\",\"cashback\":\"0\",\"tax\":\"0\",\"rest\":\"0\",\"stripes_payment\":\"0\",\"all_sum\":0,\"adding_count\":0}')");
        }
    }
    public function edit_category($id, $name) {
        $this->db->query("UPDATE `categories` SET `name`='".$name."' WHERE id=".$id);
    }
    public function get_category($id) {
        $result = $this->db->query("SELECT * FROM `categories` WHERE id=".$id);
        $response = $result->row_array();
        return $response;
    }
    public function get_categories() {
        $result = $this->db->query("SELECT * FROM `categories`");
        $response = [];
        foreach ($result->result_array() as $row)
        {
            $response[] = $row;
        }
        return $response;
    }
    public function get_categories_for_conf() {
        $result = $this->db->query("SELECT * FROM `categories`");
        $response = [];
        foreach ($result->result_array() as $row)
        {
            $response[$row['id']] = $row['name'];
        }
        return $response;
    }

}
