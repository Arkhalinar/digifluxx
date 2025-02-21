<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Special extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Special_model', 'special');
    }

    public function scpt() {
        if(isset($_GET['a'])) {
            $data['special_id'] = $_GET['a'];
            $this->load->view('special/scriptjs', $data);
        }
    }

    public function sbtl() {
        Header('Access-Control-Allow-Origin: *');

        $body = file_get_contents('php://input');

        $BanForShow = $this->special->GetBanByCode($body);

        $BanForShow['error'] = false;

        echo json_encode($BanForShow);
    }

    public function create_code() {
    	

    	$config = json_encode([
    					'format' => $_POST['format'],
    					'lang_type' =>  $_POST['lang_type'],
    					'static_lang' =>  $_POST['static_lang']
    	]);

        $id = $this->special->AddCode($_SESSION['uid'], $_POST['type'], $config);

        echo json_encode( [ 'err' => 0, 'ban_info' => [ 'id' => $id, 'type' => $_POST['type'], 'format' => $_POST['format'], 'lang_type' =>  $_POST['lang_type'], 'static_lang' => $_POST['static_lang'] ] ] );
    }
    public function ch_code_info() {

    	$config = json_encode([
    					'format' => $_POST['ch_format'],
    					'lang_type' =>  $_POST['ch_lang_type'],
    					'static_lang' =>  $_POST['ch_static_lang']
    	]);

        $this->special->ChangeCode($_SESSION['uid'], $_POST['id_for_edit'], $_POST['ch_type'], $config);

        $id = $_POST['id_for_edit'];

        echo json_encode( [ 'err' => 0, 'ban_info' => [ 'id' => $id, 'type' => $_POST['ch_type'], 'format' => $_POST['ch_format'], 'lang_type' =>  $_POST['ch_lang_type'], 'static_lang' => $_POST['ch_static_lang'] ] ] );
    }
    public function del_code($id) {
    	$this->special->DelCode($_SESSION['uid'], $id);
    }

    public function ac() {
        Header('Access-Control-Allow-Origin: *');

    	$body = file_get_contents('php://input');

        $this->special->Logs(time().' | '.json_encode($body));

        $ArrWithInfo = explode('_', $body);
        
        $bid = $ArrWithInfo[0];
    	$this->special->AddClick($bid);

        $this->load->model('Comp_model', 'comp');

        $id = $ArrWithInfo[1];
        $this->comp->up_count_ban($id, 'ban');
    }
}