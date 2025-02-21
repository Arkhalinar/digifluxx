<?php
class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_projects() {
        $res = $this->db->query("SELECT * FROM project_for_sponsor_adver");
        $result = [];
        if($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }
    public function cr_new_project($info) {
        $this->db->query("INSERT INTO `project_for_sponsor_adver`(`type`, `header`, `body`, `add_info`, `img`, `url`, `ref_url_for_check`) VALUES ('".$info['type']."','".$info['header']."','".$info['body']."', '".$info['add_info']."', '".$info['img']."','".$info['url']."', '".$info['ref_url_for_check']."')");
    }
    public function cr_new_us_project($info) {
        $this->db->query("INSERT INTO `sponsor_projects`(`uid`, `pid`, `us_url`, `date`) VALUES (".$info['uid'].",".$info['project_data']['pid'].",'".$info['project_data']['url']."', now())");
    }
    public function admin_ed_project($info) {

        if(isset($info['type'])) {
            $add_str = ", type='".$info['type']."', img='".$info['img']."'";
        }else{
            $add_str = "";
        }

        $this->db->query("UPDATE `project_for_sponsor_adver` SET header='".$info['header']."', body='".$info['body']."', url='".$info['url']."', ref_url_for_check='".$info['ref_url_for_check']."', add_info='".$info['add_info']."'".$add_str." WHERE id=".$info['id']);
    }
    public function ed_project($info) {
        $this->db->query("UPDATE `sponsor_projects` SET us_url='".$info['url']."' WHERE pid=".$info['id']." AND uid=".$info['uid']);
    }
    public function dl_project($id) {
        $res = $this->db->query("SELECT * FROM project_for_sponsor_adver WHERE id=".$id);
        if($res->num_rows() > 0) {
            $pr_info = $res->row_array();
            if($pr_info['type'] == 'file') {
                unlink('../'.$img_info['type']);
            }
            $this->db->query("DELETE FROM project_for_sponsor_adver WHERE id=".$id);
        }
    }
    public function up_stat_project($url) {
        $this->db->query("UPDATE sponsor_projects SET clicks=clicks+1 WHERE us_url='".$url."'");
    }
    public function check_ref_link_identif($url, $id){
        $proj_info = $this->take_project($id);
        if(strpos($url, $proj_info['ref_url_for_check']) === 0) {
            return true;
        }else{
            return false;
        }
    }
    public function check_prj_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM sponsor_projects WHERE pid=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            $this->db->query("INSERT INTO sponsor_projects(uid, pid, us_url, date) VALUES(".$uid.", ".$id.", '', now())");
            return true;
        }
    }
    public function take_us_projects($info) {

        $all_projs = $this->get_projects();

        $res = $this->db->query("SELECT * FROM sponsor_projects WHERE uid=".$info['uid']);
        $result = [];
        if($res->num_rows() > 0) {

            foreach ($res->result_array() as $row) {
                $result[$row['pid']] = $row;
            }

        }

        return ['prjs'=>$all_projs, 'us_prjs'=>$result];
    }
    public function take_sp_projects($info) {

        $all_projs = $this->get_projects();

        $res = $this->db->query("SELECT sp.id, pfsa.id as pid, pfsa.type, pfsa.ref_url_for_check, pfsa.header, pfsa.body, pfsa.img FROM sponsor_projects as sp INNER JOIN project_for_sponsor_adver as pfsa ON sp.pid=pfsa.id WHERE sp.uid=".$info['sid']);
        $result = [];
        if($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {

                $res_us = $this->db->query("SELECT * FROM sponsor_projects WHERE uid=".$info['uid']." AND pid=".$row['pid']);
                if($res_us->num_rows() > 0) {
                    $us_pr_info = $res_us->row_array();
                    $row['us_url'] = $us_pr_info['us_url'];
                }else{
                    $row['us_url'] = '';
                }

                $result[] = $row;
            }

        }

        return $result;
    }
    public function take_project($id) {

        $res = $this->db->query("SELECT * FROM project_for_sponsor_adver WHERE id=".$id);
        if($res->num_rows() > 0) {
            $pr_info = $res->row_array();
        }

        return $pr_info;
    }

    public function take_project_for_look($id) {

        $res = $this->db->query("SELECT sp.us_url, pfsa.img, pfsa.body, pfsa.type, pfsa.header, pfsa.add_info FROM sponsor_projects as sp INNER JOIN project_for_sponsor_adver as pfsa ON sp.pid=pfsa.id WHERE sp.id=".$id);

        if($res->num_rows() > 0) {
            $result = $res->row_array();
        }

        return $result;
    }
    
}
?>