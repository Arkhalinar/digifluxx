<?php
class Special_model extends CI_Model {

    private $table_name = "banners_code";

    public function __construct() {
        parent::__construct();
    }

    public function takeUserCodes($uid) {
        $result = [];
        
        $response = $this->db->query("SELECT * FROM ".$this->table_name." WHERE uid=".$uid." ORDER BY id DESC");
        
        if($response->num_rows() > 0) {
            foreach ($response->result_array() as $row) {
                $result[] = $row;
            }
        }

        return $result;
    }
    public function Logs($str) {
        $this->db->query("INSERT INTO banner_code_logs(info, date) VALUES('".$str."', now())");
    }
    public function AddCode($uid, $type, $config) {
        $this->db->query("INSERT INTO ".$this->table_name."(uid, type, config, date) VALUES(".$uid.", ".$type.", '".$config."', now())");
        return $this->db->insert_id();
    }
    public function ChangeCode($uid, $id, $type, $config) {
        $this->db->query("UPDATE ".$this->table_name." SET config='".$config."', type=".$type." WHERE uid=".$uid." AND id=".$id);
    }
    public function DelCode($uid, $id) {
        $this->db->query("DELETE FROM ".$this->table_name." WHERE uid=".$uid." AND id=".$id);
    }
    public function GetBanByCode($info) {

        $ArrayWithInfo = explode('_', $info);

        $id = $ArrayWithInfo[0];

        $count = $ArrayWithInfo[1];

        $autolang = $ArrayWithInfo[2];

        switch ($autolang) {
            case 'en':
                $autolang = 'eng';
                break;
            case 'ru':
                $autolang = 'rus';
                break;
            case 'ge':
                $autolang = 'ger';
                break;
            default:
                $autolang = 'eng';
                break;
        }

        $response = $this->db->query("SELECT t1.*, t2.tags FROM ".$this->table_name." as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.id=".$id);

        if($response->num_rows() > 0) {
            $result = $response->row_array();
        }else{
            exit();
        }

        $conf = json_decode($result['config'], true);

        if($conf['lang_type'] == 'auto') {
            $lang = $autolang;
        }else {
            $lang = $conf['static_lang'];
        }

        if($result['type'] == 0) {

            $response = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='".$conf['format']."' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$count);

        }else{

            $response = $this->db->query("SELECT * FROM text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$count);

        }

        $arr_for_update = '';

        if($response->num_rows() >= $count) {
            foreach ($response->result_array() as $row) {
                if($result['type'] == 0) {
                    if($row['cont_type'] == 1){
                        $url = 'https://digifluxx.com/'.$row['bnr'];
                    }else {
                        $url = json_decode($row['bnr']);
                    }

                    $ArWithPars = explode('x', $row['format']);
                    $head = '';
                    $body = '';
                    $w = $ArWithPars[0];
                    $h = $ArWithPars[1];
                }else{
                    $url = '';
                    $head = $row['head'];
                    $body = $row['body'];
                    $w = 220;
                    $h = 110;
                }

                $ban_info[] = ['type' => $result['type'], 'w' => $w, 'h' => $h, 'url' => $url, 'head' => $head, 'body' => $body, 'adurl' => json_decode($row['url']), 'id' => $row['ID']];

                $str_for_update .= $row['ID'].',';
            }
        }else{
            if($result['type'] == 0) {
                $this->db->query("UPDATE banners SET seen=0 WHERE format='".$conf['format']."'");
                $response = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='".$conf['format']."' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$count);
            }else{
                $this->db->query("UPDATE text_ad SET seen=0");
                $response = $this->db->query("SELECT * FROM text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$count);
            }

            foreach ($response->result_array() as $row) {

                if($result['type'] == 0) {
                    if($row['cont_type'] == 1){
                        $url = 'https://digifluxx.com/'.$row['bnr'];
                    }else {
                        $url = json_decode($row['bnr']);
                    }

                    $ArWithPars = explode('x', $row['format']);
                    $head = '';
                    $body = '';
                    $w = $ArWithPars[0];
                    $h = $ArWithPars[1];
                }else{
                    $url = '';
                    $head = $row['head'];
                    $body = $row['body'];
                    $w = 220;
                    $h = 110;
                }

                $ban_info[] = ['type' => $result['type'], 'w' => $w, 'h' => $h, 'url' => $url, 'head' => $head, 'body' => $body, 'adurl' => json_decode($row['url']), 'id' => $row['ID']];

                $str_for_update .= $row['ID'].',';
            }

            if($response->num_rows() < $count) {
                $ban_info = array_merge($ban_info, array_slice($ban_info, 0, $count-$response->num_rows()));
            }

        }
        $str_for_update = substr($arr_for_update, 0, strlen($arr_for_update)-1);

        if($result['type'] == 0) {
            $this->db->query('UPDATE banners SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.$str_for_update.')');
        }else{
            $this->db->query('UPDATE text_ad SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.$str_for_update.')');
        }

        $earnString = '';

        if(($result['shows']+$count) >= 1000) {
            $oldValue = $result['shows']%1000;
            if($oldValue+$count >= 1000) {
                $config = $this->GetConfig();
                /*
                    '125x125' => [
                                    'sumForEarn' => 1
                                    ]
                    '300x250' => [
                                    'sumForEarn' => 1
                                    ]
                    '468x60' => [
                                    'sumForEarn' => 1
                                    ]
                */

                if($result['type'] == 0) {
                    $infoForEarn = $conf['format'];
                }else{
                    $infoForEarn = 'text_ad';
                }

                $earnString = ", earned=earned+".$config[$infoForEarn]['sumForEarn'];

                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$config[$infoForEarn]['sumForEarn']." WHERE id=".$result['uid']);
                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(1020, 'CDT', ".$result['uid'].", 1, ".$config[$infoForEarn]['sumForEarn'].", 'For 1000 shows of spec code with id=".$id."', now())");
            }
        }

        $this->db->query("UPDATE ".$this->table_name." SET shows=shows+".$count.$earnString." WHERE id=".$id);

        return ['bans' => $ban_info, 'bid' => $id];
    }
    public function AddClick($bid) {
        $this->db->query("UPDATE ".$this->table_name." SET clicks=clicks+1 WHERE id=".$bid);
    }
    public function GetConfig() {
        $response = $this->db->query("SELECT * FROM config_for_special_ad_codes");
        $result = $response->row_array();
        $info = json_decode($result['config'], true);
        return $info;
    }
    public function update_conf($arr) {
        $this->db->query("UPDATE config_for_special_ad_codes SET config='".json_encode(['text_ad'=>['sumForEarn'=>$arr['prtext_ad']], '125x125'=>['sumForEarn'=>$arr['pr125x125']], '300x250'=>['sumForEarn'=>$arr['pr300x250']], '468x60'=>['sumForEarn'=>$arr['pr468x60']]] )."'");
    }
}
?>