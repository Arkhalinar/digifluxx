<?php
class Pre_enter_ad_model extends CI_Model {

    private $table_name = "pre_enter_ad";

    public function __construct()
    {
        parent::__construct();
    }

    //config - array('id' =>, 'block_1' => , 'block_2' => , 'block_3' => , 'lang' => , 'status' => , 'date' => );
    public function GetBlocks($config = NULL)
    {   
        $search_string = '';
        if(!is_null($config)) {
            $search_string = " WHERE ";
            foreach ($config as $key => $value)
            {

                if($search_string != " WHERE ")
                {
                    $search_string .= " AND ";
                }

                if($key == 'id' || $key == 'status')
                {
                    $search_string .= $key."=".$value;
                }
                elseif($key == 'lang')
                {
                    $search_string .= "(".$key."='".$value."' OR lang='all')";
                }
                else
                {
                    $search_string .= $key."='".$value."'";
                }
            }
        }

        $result = $this->db->query("SELECT * FROM ".$this->table_name.$search_string);

        $response = [];

        foreach ($result->result_array() as $row)
        {
            $response[] = $row;
        }
        return $response;
    }
    public function CreateNewBlock($info)
    {
        // echo "INSERT INTO ".$this->table_name.$search_string."(block_1, block_2, block_3, lang, status, date) VALUES('".$info['block_1']."', '".$info['block_2']."', '".$info['block_3']."', '".$info['lang']."', ".$info['status'].", now())";exit();
        $this->db->query("INSERT INTO ".$this->table_name.$search_string."(block_1, block_2, block_3, lang, status, date) VALUES('".$info['block_1']."', '".$info['block_2']."', '".$info['block_3']."', '".$info['lang']."', ".$info['status'].", now())");
    }
    public function EditBlock($info)
    {
        $this->db->query("UPDATE ".$this->table_name." SET block_1='".$info['block_1']."', block_2='".$info['block_2']."', block_3='".$info['block_3']."', lang='".$info['lang']."', status=".$info['status'].", date=now() WHERE id=".$info['id']);
    }
    public function DeleteBlock($info)
    {
        $result = $this->db->query("SELECT * FROM ".$this->table_name." WHERE id=".$info['id']);
        $row = $result->row_array();

        if(!is_null($row['block_1'])) {
            $block_1_info = json_decode($row['block_1'], true);

            if($block_1_info['type'] == 'img' && substr($block_1_info['content'], 0, 1) == '/') {
                unlink(substr($block_1_info['content'], 1));
            }
        }

        if(!is_null($row['block_2'])) {
            $block_2_info = json_decode($row['block_2'], true);

            if($block_2_info['type'] == 'img' && substr($block_2_info['content'], 0, 1) == '/') {
                unlink(substr($block_2_info['content'], 1));
            }
        }

        if(!is_null($row['block_3'])) {
            $block_3_info = json_decode($row['block_3'], true);

            if($block_3_info['type'] == 'img' && substr($block_3_info['content'], 0, 1) == '/') {
                unlink(substr($block_3_info['content'], 1));
            }
        }

        $this->db->query("DELETE FROM ".$this->table_name." WHERE id=".$info['id']);

    }
}

?>