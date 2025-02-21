<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabinet extends CI_Controller {

    private $data = array();

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model', 'users');
        $this->load->model('Comp_model', 'comp');
        $this->load->model('Marketing_model', 'mark');

        $user = $this->users->getUserById($this->session->uid);

        $this->data = array('curr_arr' => $this->mark->get_curs(), 'user_info' => $user, 'tar' => $this->comp->getTarInfo(), 'freez_refs' => array());

        $this->load->model('finances_model', 'finances');
        $this->load->library('authentication');
        if(get_cookie('lang') == null)
            $lang = 'english';
        else if(in_array(get_cookie('lang'), array('russian', 'english', 'german'))) {
            $lang = get_cookie('lang');
        } else {
            $lang = 'english';
        }

        $this->config->set_item('language', $lang);
        $this->lang->load('common_site', $lang);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $this->data['setts'] = $settings;
        if($settings['site_opened'] != 1) {
            redirect('site/index');
        }

        if (!$this->authentication->checkAuth() || !$this->session->has_userdata('uid')) {
            redirect('/user/login');
        }

        if(!$this->users->user_verified(get_cookie('uid'))) {
            redirect('user/need_verification');
        }

        $this->load->model('messages_model', 'messages');
        $msgs = $this->messages->get_unread($this->session->uid);
        $this->session->set_flashdata('new_messages', $msgs);

        if(get_cookie('signed_info') != null && get_cookie('uid') != null) {
            set_cookie('signed_info', get_cookie('signed_info'), '3600');
            set_cookie('uid', get_cookie('uid'), '3600');
        }

        if (!$this->users->user_has_reflink($this->session->uid) || $this->session->reflink == '') {

            $this->generate_reflink();
            $this->data['user_info'] = $this->users->getUserById($this->session->uid);
        }



        if(isset($this->session->wallet)) {
            $this->load->model('invoices_model', 'invoices');
            if($this->invoices->check_payment($this->session->wallet))
                unset($_SESSION['wallet']);
        }
    }

    public function about_project($id) {

        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $data['setts'] = $this->comp->get_setts();

    
        $data['site_name'] = 'Project create';

        $this->load->model('Project_model', 'proj');
        $data['proj_info'] = $this->proj->take_project_for_look($id);

        $this->load->template('cabinet/project_page', $data);
    }

    public function my_projects() {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $data['setts'] = $this->comp->get_setts();

        $this->load->model('Project_model', 'proj');
        $data['prjs_info'] = $this->proj->take_us_projects(['uid' => $_SESSION['uid']]);

        $data['site_name'] = 'Project create';

        $this->load->template('cabinet/myprojs', $data);
    }
    public function sponsor_projects() {
        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 4, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $settings = $this->settings->get_settings();

        $this->load->model('Project_model', 'proj');

        $data['prjs'] = $this->proj->take_sp_projects(['uid' => $_SESSION['uid'], 'sid' => $data['user_info']['idsponsor']]);

        $this->load->template('cabinet/spprojs', $data);
    }

    public function cr_project() {
      if(!isset($_POST['cr_url']) || $_POST['cr_url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['cr_url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('my_projs_9')));
          exit();
      }else {
        $project_data = ['url' => $_POST['cr_url'], 'pid' => $_POST['pid']];

        $this->load->model('Project_model', 'proj');

        $this->proj->cr_new_us_project(['uid' => $_SESSION['uid'], 'project_data' => $project_data]);
        
        echo json_encode(array('err' => 0));
        exit();
      }
    }
    public function ed_project() {
      if(isset($_POST['id']) && is_numeric($_POST['id'])) {
        $this->load->model('Project_model', 'proj');
        $id = $_POST['id'];
        if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('my_projs_9')));
          exit();
        }elseif($this->proj->check_prj_lord($_SESSION['uid'], $id)) {
          // if($this->proj->check_ref_link_identif($_POST['url'], $id)) {
            $this->proj->ed_project(['id' => $id, 'url' => $_POST['url'], 'uid' => $_SESSION['uid']]);
            echo json_encode(array('err' => 0, 'mess' => $this->lang->line('my_projs_11'), 'id' => $id, 'new_url' => $_POST['url']));
            exit();
          // }else{
          //   echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('my_projs_10')));
          //   exit();
          // }
        }
      }
    }
    public function dl_project($id) {

        $this->load->model('Project_model', 'proj');

        $this->proj->dl_project(['uid'=>$_SESSION['uid'],'id'=>$id]);

        $_SESSION['del_b'] = $this->lang->line('sp_project12');

        redirect('cabinet/my_projects');
    }
    public function save_prj_stat() {
      $this->load->model('Project_model', 'proj');
      $this->proj->up_stat_project($_POST['url']);
    }

    public function GetStripeId() {
      if(isset($_POST['sum'])) {

        if(is_string($_POST['sum'])) {
          $_POST['sum'] = str_replace(',', '.', $_POST['sum']);
        }

        if(is_numeric($_POST['sum']) && $_POST['sum'] > 5) {

          $sum = $_POST['sum'];

          require 'stripe-php/init.php';

          \Stripe\Stripe::setApiKey('sk_live_5LzxPI0aNEnEntL6zyqzmkab');

          if($this->data['user_info']['customer_id'] != NULL) {
            $customer_id = $this->data['user_info']['customer_id'];
          }else {
            $customer_info = \Stripe\Customer::create([
              'description' => 'Customer for user with id='.$this->session->uid,
            ]);
            $this->users->SetCustomerId($this->session->uid, $customer_info->id);
            $customer_id = $customer_info->id;
          }



          $session = \Stripe\Checkout\Session::create([
            'customer' => $customer_id,
            'payment_method_types' => ['card'],
            'line_items' => [[
              'name' => 'Credits',
              'description' => 'Buying credits',
              // 'images' => ['https://example.com/t-shirt.png'],
              'amount' => $sum*100,
              'currency' => 'eur',
              'quantity' => 1,
            ]],
            'success_url' => 'https://digifluxx.com/cabinet/transactions?t_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://digifluxx.com/cabinet/transactions?fail',
          ]);

          // https://digifluxx.com/cabinet/transactions?session_id
          // https://digifluxx.com/cabinet/transactions?session_id

          echo json_encode(array('error' => 0, 'ssid' => $session->id));
        }else{
          echo json_encode(array('error' => 1, 'mess' => 'Wrong information'));
        }

      }else {
        echo json_encode(array('error' => 1, 'mess' => 'Wrong information'));
      }
    }


    public function IamPekunjia() {

      $this->users->add_to_pekunjia($this->session->uid);

    }
    public function GetAdvTempPay() {
      if(isset($_POST['WalletOrTID']) && is_string($_POST['WalletOrTID'])) {
        $this->load->model('Marketing_model', 'mark');

        if($this->mark->CheckTempAdvPay($_POST['WalletOrTID'])) {
          $id = $this->mark->SaveTempAdvPay($_POST['WalletOrTID'], $this->session->uid);
          require_once("MerchantWebService.php");
          $merchantWebService = new MerchantWebService();
          $arg0 = new authDTO();
          $arg0->apiName = "DIGIFLUXX API";
          $arg0->accountEmail = "digifluxx@gmx.de";
          $arg0->authenticationToken = $merchantWebService->getAuthenticationToken("I_11W84nVp");

          $arg1 = $_POST['WalletOrTID'];

          $findTransaction = new findTransaction();
          $findTransaction->arg0 = $arg0;
          $findTransaction->arg1 = $arg1;

          try {
              $findTransactionResponse = $merchantWebService->findTransaction($findTransaction);

              if($findTransactionResponse->return->currency == 'EUR') {

                $sum = $findTransactionResponse->return->amount;
                $this->load->model('Comp_model', 'comp');
                $this->comp->accept_adv($id, $sum);

                echo json_encode(array('err' => 0));

              }else {
                echo json_encode(array('err' => 4));
              }
          } catch (Exception $e) {
              // echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
              // echo $e->getTraceAsString();
            echo json_encode(array('err' => 3));
          }
        }else {
          echo json_encode(array('err' => 2));
        }
      }else {
        echo json_encode(array('err' => 1));
      }
    }
    public function GetAdvTempPay2() {
      if(isset($_POST['WalletOrTID']) && is_string($_POST['WalletOrTID'])) {
        $this->load->model('Marketing_model', 'mark');
        $this->mark->SaveTempAdvPay($_POST['WalletOrTID'], $this->session->uid);
        echo json_encode(array('err' => 0));
      }else {
        echo json_encode(array('err' => 1));
      }
    }
    public function temppage($sum = '', $type = '') {
        $data = $this->data;

        $this->load->model('Marketing_model', 'mark');
        $data['curr_arr'] = $this->mark->get_curs();

        $data['sum'] = $sum;
        $data['type'] = $type;

        $this->load->template('cabinet/temppage', $data);
    }
    public function addbalance() {
        $this->load->model('Marketing_model', 'mark');
        $this->mark->create_activation($_POST['sum'], $_POST['type'], $this->session->uid);
        redirect('/cabinet/index');
    }
    public function save_percent() {
      if(!isset($_POST['val']) || !is_numeric($_POST['val'])) {
        echo json_encode(array('err' => 1, 'mess' => 'Wrong information'));
        exit();
      }elseif(!isset($_POST['type']) || !is_string($_POST['type'])) {
        echo json_encode(array('err' => 1, 'mess' => 'Wrong information'));
        exit();
      }elseif($_POST['val'] != 30 && $_POST['sum'] != 0) {
        echo json_encode(array('err' => 1, 'mess' => 'Wrong information'));
        exit();
      }elseif($_POST['type'] != '#bl-1' && $_POST['type'] != '#bl-2') {
        echo json_encode(array('err' => 1, 'mess' => 'Wrong information'));
        exit();
      }else {
        $this->load->model('Marketing_model', 'mark');
        if($this->mark->save_percent($this->session->uid, $_POST['val'], $_POST['type'])){
          echo json_encode(array('err' => 0, 'mess' => ''));
          exit();
        }else {
          echo json_encode(array('err' => 1, 'mess' => 'Wrong information'));
          exit();
        }
      }
    }
    public function paysuccess($type = 0) {
      if(isset($type) && ($type == 'buy_ad' || $type == 'buy_bp')) {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/paysuccess', $data);
      }
    }
    public function buyplace($number = 0) {
      if(isset($number) && is_numeric($number) && ($number == 1 || $number == 2 || $number == 3 || $number == 4)) {

        $f = fopen('AA_LOGS_TEST_TIME.txt', 'a+');
        fwrite($f, 'iter 1 '.time()."\n\r\n\r");

        $this->load->model('Marketing_model', 'mark');
        if($this->mark->buy_scale('packet_'.$number, $this->data['user_info']['id'])) {
          redirect('/cabinet/paysuccess/buy_bp');
        }else{
          redirect('/cabinet/page'.($number-1).'?false');
        }
      }
    }
    public function page4($id) {
        $this->load->model('Marketing_model', 'mark');
        $hyst_arr = $this->mark->get_all_spec_hyst($id);

        // echo $hyst_arr;exit();

        $mark_setts = $this->mark->get_all_mark_setts();

        $real_arr = explode('_', $id);
        $info = json_decode($mark_setts['lvl_'.$real_arr[0]], true);

        echo '<thead id="hist_for_delete"><tr role="row"><th>'.$this->lang->line('scale_h_01').'</th><th>'.$this->lang->line('scale_h_02').'</th><th>'.$this->lang->line('scale_h_03').'</th></tr>';
        for($i = 0; $i < count($hyst_arr); $i++) {
            echo '<tr>';

            $reason_arr = json_decode($hyst_arr[$i]['reason']);

            switch ($reason_arr->event) {
              case 'up_lvl_scale':
                $event = $this->lang->line('scale_h_1');
                break;
              case 'up_sponsor':
                $event = $this->lang->line('scale_h_2');
                break;
              case 'up_team':
                $event = $this->lang->line('scale_h_3');
                break;
              case 'up_by_community_baklen_pool':
                $event = $this->lang->line('scale_h_4');
                break;
              case 'up_i_pool':
                $event = $this->lang->line('scale_h_5');
                break;
              case 'up_l_pool':
                $event = $this->lang->line('scale_h_6');
                break;
              case 'up_gr_pool':
                $event = $this->lang->line('scale_h_7');
                break;
              case 'up_sysbill':
                $event = $this->lang->line('scale_h_8');
                break;
              case 'up_stripes_payment':
                $event = $this->lang->line('scale_h_9');
                break;
              case 'up_rest':
                $event = $this->lang->line('scale_h_10');
                break;
              case 'up_tax':
                $event = $this->lang->line('scale_h_11');
                break;
            }

            switch ($reason_arr->type) {
              case 'comm_bakl_pool':
              echo '<td>Community Baklen Pool distribution<br>('.$event.')</td>';
              break;
              case 'lvl_1':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 1, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_2':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 2, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_3':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 3, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_4':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 4, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_5':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 5, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_6':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 6, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_7':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 7, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_8':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 8, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_9':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 9, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_10':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 10, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_11':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 11, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_12':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 12, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_13':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 13, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_14':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 14, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_15':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 15, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_16':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 16, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_17':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 17, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_18':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 18, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_19':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 19, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_20':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 20, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_21':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 21, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_22':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 22, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_23':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 23, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_24':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 24, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_25':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 25, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_26':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 26, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_27':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 27, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_28':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 28, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_29':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 29, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_30':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 30, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_31':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 31, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_32':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 32, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_33':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 33, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_34':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 34, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_35':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 35, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_36':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 36, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_37':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 37, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_38':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 38, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_39':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 39, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_40':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 40, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_41':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 41, $hyst_arr[$i]['login'], $event);
                  break;
              case 'lvl_42':
                  echo sprintf('<td>'.$this->lang->line('scale_h_12').'</td>', 42, $hyst_arr[$i]['login'], $event);
                  break;
              case 'packet_1':
                  echo sprintf('<td>'.$this->lang->line('scale_h_13').'</td>', 1, $hyst_arr[$i]['login'], $event);
                  break;
              case 'packet_2':
                  echo sprintf('<td>'.$this->lang->line('scale_h_13').'</td>', 2, $hyst_arr[$i]['login'], $event);
                  break;
              case 'packet_3':
                  echo sprintf('<td>'.$this->lang->line('scale_h_13').'</td>', 3, $hyst_arr[$i]['login'], $event);
                  break;
              case 'active_1':
                  echo sprintf('<td>'.$this->lang->line('scale_h_15').'</td>',1, $hyst_arr[$i]['login'], $event);
                  break;
              case 'active_2':
                  echo sprintf('<td>'.$this->lang->line('scale_h_15').'</td>',2, $hyst_arr[$i]['login'], $event);
                  break;
              case 'active_3':
                  echo sprintf('<td>'.$this->lang->line('scale_h_15').'</td>',3, $hyst_arr[$i]['login'], $event);
                  break;
              case 'active_4':
                  echo sprintf('<td>'.$this->lang->line('scale_h_15').'</td>',4, $hyst_arr[$i]['login'], $event);
                  break;
              case 'active_5':
                  echo sprintf('<td>'.$this->lang->line('scale_h_15').'</td>',5, $hyst_arr[$i]['login'], $event);
                  break;
              case 'spec_scale_reffs':
                  echo sprintf($this->lang->line('scale_h_12'), $hyst_arr[$i]['login'], $event);
                  echo '<td>Manual refills</td>';
                break;
            }

            $sum = bcmul(1000, bcdiv($hyst_arr[$i]['sum'], $info['all_sum'], 5), 3)+0;
            // .'|'.$hyst_arr[$i]['sum']  |'.$hyst_arr[$i]['login'].'

            echo '<td>'.$sum.'</td>';

            echo '<td>'.date('d.m.Y H:i:s', $hyst_arr[$i]['date']).'</td>';

            echo '</tr>';
        }
        echo '</thead>';
    }
    public function page5() {
      $this->load->model('Marketing_model', 'mark');
      $this->mark->update_re_status($this->session->uid, $_POST['type'], $_POST['val']);
    }
    public function structtr($Login = '') {
        $data = $this->data;

        $own = true;

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        if($Login != '' && is_string($Login)) {
            $data['search'] = $this->comp->get_struct_trinar2($Login, $data['user_info']['login']);
        }else{
            $data['search'] = $this->comp->get_struct_trinar2($data['user_info']['login']);
            $own = false;
        }

        // echo '</pre>';
        // var_dump($data['search']);
        // echo '</pre>';
        // exit();

        if(isset($data['search']['error']) && $own) {
            redirect('/cabinet/structtr');
        }else {
            $this->load->template('cabinet/structtr', $data);
        }
    }
    public function TechWork() {
        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/techwork', $data);
    }
    public function NewTarifs() {

        if($_SESSION['uid'] != 703 && $_SESSION['uid'] != 1 && $_SESSION['uid'] != 2024) {
            redirect('cabinet/index');
        }

        $data = $this->data;

        $data['sets'] = $this->comp->get_setts();

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/newtarifs', $data);
    }
    public function programm() {

        // if($_SESSION['uid'] != 703 && $_SESSION['uid'] != 1 && $_SESSION['uid'] != 2024) {
        //     redirect('cabinet/index');
        // }

        $data = $this->data;

        $data['binar_info'] = $this->comp->get_full_binar_info($this->session->uid);

        $data['linar_info'] = $this->comp->get_full_linar_info($this->session->uid);

        $data['trinar_info'] = $this->comp->get_full_new_trinar_info($this->session->uid);

        // var_dump($data['trinar_info']);exit();

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/programm', $data);
    }

    /*
        pages
    */
    public function wallets() {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        $data['widthdraws_btc'] = $this->finances->getMyWithdraws($this->session->uid, 'BTC');

        $data['refills_btc'] = $this->finances->getMyRefills($this->session->uid, 'BTC');

        $data['widthdraws_pe'] = $this->finances->getMyWithdraws($this->session->uid, 'PE');

        $data['refills_pe'] = $this->finances->getMyRefills($this->session->uid, 'PE');

        // $data['widthdraws_adv'] = $this->finances->getMyWithdraws($this->session->uid, 'ADV');

        // $data['refills_adv'] = $this->finances->getMyRefills($this->session->uid, 'ADV');

        $data['refills_adv'] = $this->finances->getMyRefills($this->session->uid, 'CP');

        $data['curs'] = $this->finances->get_curs_btc();

        // $f = file_get_contents('https://api.cryptonator.com/api/ticker/btc-usd');
        // var_dump($f); exit();

        $this->load->template('cabinet/wallet', $data);
    }
    public function payforms() {

        $data = $this->data;

        $this->load->template('cabinet/payforms', $data, false, true);
    }
    public function index() {

        $data = $this->data;

        $this->load->model('Pre_enter_ad_model', 'pre_ad');
        $data['blocks'] = $this->pre_ad->GetBlocks(['lang' => $data['user_info']['u_lang'], 'status' => 1]);

        $data['user_stat'] = $this->users->getUserStatById($this->session->uid);

        $data['user_ad_stat'] = $this->users->getAdUserStatById($this->session->uid);

        // if(isset($_GET['allali'])) {
        //   var_dump( get_cookie('lang'));
        //   exit();
        // }

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        if(isset($_GET['allali'])) {
          var_dump( get_cookie('lang'));
          exit();
        }

        $data['fin_stat'] = $this->comp->getFinStat($this->session->uid);

        $settings = $this->settings->get_stat($this->session->uid);

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('main_site_page');

        $sponsor = $this->users->getSponsor($this->session->uid);
        $data['sponsor_name'] = $sponsor['login'];

        $this->load->model('Marketing_model', 'mark');

        $data['comm_pool_mess'] = $this->mark->get_pool_mess();

        $data['mark_setts'] = $this->mark->get_setts();
        $data['scale_1'] = $this->mark->get_all_accs_array($this->session->uid, 1, 'active');
        $data['scale_10'] = $this->mark->get_all_accs_array($this->session->uid, 2, 'active');
        $data['scale_100'] = $this->mark->get_all_accs_array($this->session->uid, 3, 'active');
        $data['scale_1000'] = $this->mark->get_all_accs_array($this->session->uid, 4, 'active');

        $this->load->model('news_model', 'news');
        $latest_news = $this->news->get_news(2,0);

        if(!empty($latest_news)) {
            $data['show_news'] = $latest_news;
        }

        $latest_news = $this->news->get_news2(1,0);

        if(!empty($latest_news)) {
            $data['show_news2'] = $latest_news[0];
        }

        $latest_news = $this->news->get_news3(1,0);

        if(!empty($latest_news)) {
            $data['show_news3'] = $latest_news[0];
        }

        $this->load->template('cabinet/index', $data);
    }
    public function load() {
        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 3, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $data['site_name'] = 'Advertise';
        $this->load->template('cabinet/adver', $data);
    }
    public function myban($type = '') {

        // if(function_exists('bcdiv')) {
        //   echo 'ok';
        // }else{
        //   echo 'no';
        // }
        // exit();

        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $data['setts'] = $this->comp->get_setts();

        $arr_for_search = array('s_0', 's_1', 's_2', 's_3', 'f_0', 'f_1', 'f_2', 'f_3', 'f_4', 'o_0', 'o_1', 'o_2', 'reset');



        if(is_string($type) && $type != '' && in_array($type, $arr_for_search)) {
          switch ($type) {
            case 'reset':
              if(isset($_SESSION['filter_status'])) {
                unset($_SESSION['filter_status']);
              }
              if(isset($_SESSION['filter_format'])) {
                unset($_SESSION['filter_format']);
              }
              if(isset($_SESSION['filter_order'])) {
                unset($_SESSION['filter_order']);
              }
              break;
            case 's_0':
              if(isset($_SESSION['filter_status'])) {
                unset($_SESSION['filter_status']);
              }
              break;
            case 's_1':
            case 's_2':
            case 's_3':
              $_SESSION['filter_status'] = $type;
              break;
            case 'f_0':
              if(isset($_SESSION['filter_format'])) {
                unset($_SESSION['filter_format']);
              }
              break;
            case 'f_1':
            case 'f_2':
            case 'f_3':
            case 'f_4':
              $_SESSION['filter_format'] = $type;
              break;
            case 'o_0':
              if(isset($_SESSION['filter_order'])) {
                unset($_SESSION['filter_order']);
              }
              break;
            case 'o_1':
            case 'o_2':
              $_SESSION['filter_order'] = $type;
              break;
          }
        }

        if(isset($_SESSION['filter_status'])) {
          $f_st = $_SESSION['filter_status'];
        }else {
          $f_st = '';
        }

        if(isset($_SESSION['filter_format'])) {
          $f_fm = $_SESSION['filter_format'];
        }else {
          $f_fm = '';
        }

        if(isset($_SESSION['filter_order'])) {
          $f_od = $_SESSION['filter_order'];
        }else {
          $f_od = '';
        }

        $this->load->model('Marketing_model', 'mark');
        $data['mark_sett'] = $this->mark->get_all_mark_setts();

        $data['comps'] = $this->comp->take_my_bans($_SESSION['uid'], $f_st, $f_fm, $f_od);

        $data['site_name'] = 'Banner create';

        // ini_set('error_reporting', E_ALL);
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);

        //$this->load->template('cabinet/header', $data);
        $this->load->template('cabinet/myban', $data);
        
        // $content  = $this->view('cabinet/header', $data);
        // $content .= $this->view('cabinet/myban', $data);
        // $content .= $this->view('cabinet/footer', $data);

        // return $content;
    }
    public function mytext($type = '') {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));
        $data['setts'] = $this->comp->get_setts();

        $arr_for_search = array('s_0', 's_1', 's_2', 's_3', 'o_0', 'o_1', 'o_2', 'reset');

        if(is_string($type) && $type != '' && in_array($type, $arr_for_search)) {
          switch ($type) {
            case 'reset':
              if(isset($_SESSION['filter_status_tad'])) {
                unset($_SESSION['filter_status_tad']);
              }
              if(isset($_SESSION['filter_order_tad'])) {
                unset($_SESSION['filter_order_tad']);
              }
              break;
            case 's_0':
              if(isset($_SESSION['filter_status_tad'])) {
                unset($_SESSION['filter_status_tad']);
              }
              break;
            case 's_1':
            case 's_2':
            case 's_3':
              $_SESSION['filter_status_tad'] = $type;
              break;
            case 'o_0':
              if(isset($_SESSION['filter_order_tad'])) {
                unset($_SESSION['filter_order_tad']);
              }
              break;
            case 'o_1':
            case 'o_2':
              $_SESSION['filter_order_tad'] = $type;
              break;
          }
        }

        if(isset($_SESSION['filter_status_tad'])) {
          $f_st = $_SESSION['filter_status_tad'];
        }else {
          $f_st = '';
        }

        if(isset($_SESSION['filter_order_tad'])) {
          $f_od = $_SESSION['filter_order_tad'];
        }else {
          $f_od = '';
        }

        $data['comps'] = $this->comp->take_my_text_ad($_SESSION['uid'], $f_st, $f_od);

        $this->load->model('Marketing_model', 'mark');
        $data['mark_sett'] = $this->mark->get_all_mark_setts();

        $data['site_name'] = 'Banner create';
        $this->load->template('cabinet/mytext', $data);
    }
    public function myvid($type = '') {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));
        $data['setts'] = $this->comp->get_setts();

        $arr_for_search = array('s_0', 's_1', 's_2', 's_3', 'o_0', 'o_1', 'o_2', 'reset');

        if(is_string($type) && $type != '' && in_array($type, $arr_for_search)) {
          switch ($type) {
            case 'reset':
              if(isset($_SESSION['filter_status_vad'])) {
                unset($_SESSION['filter_status_vad']);
              }
              if(isset($_SESSION['filter_order_vad'])) {
                unset($_SESSION['filter_order_vad']);
              }
              break;
            case 's_0':
              if(isset($_SESSION['filter_status_vad'])) {
                unset($_SESSION['filter_status_vad']);
              }
              break;
            case 's_1':
            case 's_2':
            case 's_3':
              $_SESSION['filter_status_vad'] = $type;
              break;
            case 'o_0':
              if(isset($_SESSION['filter_order_vad'])) {
                unset($_SESSION['filter_order_vad']);
              }
              break;
            case 'o_1':
            case 'o_2':
              $_SESSION['filter_order_vad'] = $type;
              break;
          }
        }

        if(isset($_SESSION['filter_status_vad'])) {
          $f_st = $_SESSION['filter_status_vad'];
        }else {
          $f_st = '';
        }

        if(isset($_SESSION['filter_order_vad'])) {
          $f_od = $_SESSION['filter_order_vad'];
        }else {
          $f_od = '';
        }

        $data['comps'] = $this->comp->take_my_vid_ad($_SESSION['uid'], $f_st, $f_od);

        $this->load->model('Marketing_model', 'mark');
        $data['mark_sett'] = $this->mark->get_all_mark_setts();

        $data['site_name'] = 'Banner create';
        $this->load->template('cabinet/myvideo', $data);
    }
    public function tarifs() {
        // $data = $this->data;

        // echo '<pre>';
        // var_dump($data['tar']);
        // echo '</pre>';
        // exit();

        // $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 2, '300x600' => 0, '468x60' => 5, '728x90' => 1));
        // $data['sets'] = $this->comp->get_setts();

        // $data['us_structs'] = $this->comp->get_us_structs($this->session->uid);

        // $data['site_name'] = 'Tarifs';
        // $this->load->template('cabinet/tarifs', $data);

         $data = $this->data;

        $data['sets'] = $this->comp->get_setts();

        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 2, '300x50' => 0, '300x250' => 1, '300x600' => 0, '468x60' => 5, '728x90' => 3), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/newtarifs2', $data);
    }
    public function transactions($page = 1, $curr = 'all') {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        // $curr = 'all';

        // $data['curr_ac'] = $curr;

        $data['widthdraws'] = $this->finances->getMyWithdraws($this->session->uid);

        // $data['refills_btc'] = $this->finances->getMyRefills($this->session->uid, 'BTC');

        if(isset($_SESSION['search_type']) || isset($_POST['search'])) {

            if(isset($_POST['search'])) {
                $type = $_POST['type'];
                $_SESSION['search_type'] = $type;
                $val = $_POST['val'];
                $_SESSION['search_val'] = $val;
            }else {
                $type = $_SESSION['search_type'];
                $val = $_SESSION['search_val'];
            }

            $total_rows = $this->finances->getTransactionsCount_search($this->session->uid, $type, $val);

            if(!is_numeric($page) || $page < 0 || $page*10-9 > $total_rows) {
                $page = 1;
            }

            $data['transactions_all'] = $this->finances->getMyTransactions_search(10, $page*10-10, $this->session->uid, $type, $val);

        }else {

            $total_rows = $this->finances->getTransactionsCount($this->session->uid);

            if(!is_numeric($page) || $page < 0 || $page*10-9 > $total_rows) {
                $page = 1;
            }

            $data['transactions_all'] = $this->finances->getMyTransactions(10, $page*10-10, $this->session->uid);

        }

        if($total_rows <= 10) {
            $data['pagi'] = '';
        }elseif($page == 1) {
            $data['pagi'] = '
            <span class="active-page">1</span>
            <span onclick="document.location.href=\'/cabinet/transactions/2\'">2</span>
            ';
        }elseif($page*10 >= $total_rows) {
            $data['pagi'] = '
            <span onclick="document.location.href=\'/cabinet/transactions/'.($page-1).'\'">'.($page-1).'</span>
            <span class="active-page">'.$page.'</span>
            ';
        }else {
            $data['pagi'] = '
              <span onclick="document.location.href=\'/cabinet/transactions/'.($page-1).'\'">'.($page-1).'</span>
              <span class="active-page">'.$page.'</span>
              <span onclick="document.location.href=\'/cabinet/transactions/'.($page+1).'\'">'.($page+1).'</span>
            ';
        }

        // var_dump($total_rows);exit();

        echo $this->load->template('cabinet/trans', $data, true);
    }
    public function get_refs() {
        if(isset($_POST['lvl']) && is_numeric($_POST['lvl']) && ($_POST['lvl'] > 0 && $_POST['lvl'] < 12) && isset($_POST['page']) && is_numeric($_POST['page']) && $_POST['page'] > 0) {
          echo json_encode($this->users->get_refs($this->session->uid, $_POST['lvl'], $_POST['page']));
        }
    }
    public function refspage() {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $sponsor = $this->users->getSponsor($this->session->uid);
        $data['sponsor_name'] = $sponsor['login'];
        $data['sponsor_skype'] = $sponsor['skype'];
        $data['sponsor_mail'] = $sponsor['email'];
        $data['sponsor_mob'] = $sponsor['mobile_num'];

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('refs_page');
        $this->load->template('cabinet/refs2', $data);
    }
    public function setting() {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->helper(array('form', 'url'));
        $this->load->template('cabinet/sett', $data);
    }
    public function supp() {
        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/supp', $data);
    }
    public function banners() {
        $data = $this->data;

        $this->load->helper('form');
        $this->load->helper('directory');

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 4, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $banners = directory_map('./assets/uploads/banners/');
        $i = 0;
        foreach ($banners as $banner) {
            $data['banners'][$i]['path'] = md5($banner);
            $data['banners'][$i]['img'] = $banner;
            $i++;
        }
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('banners_page');


        $this->load->template('cabinet/banners', $data);
    }
    public function news($page = 0) {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 4, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->model('news_model', 'news');
        $data['news'] = $this->news->get_news(10, $page);

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('news_page');
        $this->load->template('cabinet/news', $data);
    }
    public function special() {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->model('Special_model', 'special');
        $data['codes'] = $this->special->takeUserCodes($_SESSION['uid']);

        $this->load->template('cabinet/special', $data);
    }
    public function page0($type = '') {
        $data = $this->data;

        $data['type'] = $type;

        $this->load->model('Marketing_model', 'mark');
        $data['user_scales'] = $this->mark->get_all_accs_array($this->session->uid, 1, $type);
        $data['mark_setts'] = $this->mark->get_all_mark_setts();

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/page0', $data);
    }
    public function page1($type = '') {
        $data = $this->data;

        $data['type'] = $type;

        $this->load->model('Marketing_model', 'mark');
        $data['user_scales'] = $this->mark->get_all_accs_array($this->session->uid, 2, $type);
        $data['mark_setts'] = $this->mark->get_all_mark_setts();

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/page1', $data);
    }
    public function page2($type = '') {
        $data = $this->data;

        $data['type'] = $type;

        $this->load->model('Marketing_model', 'mark');
        $data['user_scales'] = $this->mark->get_all_accs_array($this->session->uid, 3, $type);
        $data['mark_setts'] = $this->mark->get_all_mark_setts();

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/page2', $data);
    }
    public function page3($type = '') {
        $data = $this->data;

        $data['type'] = $type;

        $this->load->model('Marketing_model', 'mark');
        $data['user_scales'] = $this->mark->get_all_accs_array($this->session->uid, 4, $type);
        $data['mark_setts'] = $this->mark->get_all_mark_setts();

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 1, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $this->load->template('cabinet/page3', $data);
    }
    /*
        end pages
    */


    /*
        banner operations
    */
    public function copyb() {
      if(!isset($_POST['i']) || !is_numeric($_POST['i'])) {
        echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
      }else {
        $id = $this->comp->copy_ban($_SESSION['uid'], $_POST['i']);
        $ban_info = $this->comp->take_bans($id);
        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode($ban_info)));
      }
      exit();
    }
    public function addban() {
      if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
          exit();
      }elseif(!isset($_POST['cr_lang_ban']) || ($_POST['cr_lang_ban'] != 'all' && $_POST['cr_lang_ban'] != 'russian' && $_POST['cr_lang_ban'] != 'english' && $_POST['cr_lang_ban'] != 'german')) {
          echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
          exit();
      }else {

          if(!isset($_POST['type_of_ad']) || !in_array($_POST['type_of_ad'], [0,1])) {
            $_POST['type_of_ad'] = 0;
          }

          if($_POST['type_cont'] == 'file')  {
              if(empty($_FILES[0]['tmp_name'])) {
                  echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_25')));
                  exit();
              }else {

                  if($_FILES[0]['error'] != 0) {
                      switch ($_FILES[0]['error']) {
                        case '1':
                        case '2':
                          echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_26')));
                          exit();
                          break;

                        case '3':
                        case '4':
                          echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_27')));
                          exit();
                          break;

                        default:
                          echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_27')));
                          exit();
                          break;
                      }
                  }else{
                      $fi = finfo_open(FILEINFO_MIME_TYPE);
                      $mime = (string) finfo_file($fi, $_FILES[0]['tmp_name']);
                      // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
                      if (strpos($mime, 'image') !== false){
                          $this->load->library('SimpleImage');

                         $image = new SimpleImage();

                          try
                          {
                              // $imagick = new \Imagick($_FILES['uploadfile']['tmp_name']);
                              // var_dump($imagick->valid());

                              if($image->load($_FILES[0]['tmp_name'])) {
                                  if($_POST['size'] == '125x125' || $_POST['size'] == '300x50' || $_POST['size'] == '300x250' || $_POST['size'] == '300x600' || $_POST['size'] == '468x60' || $_POST['size'] == '728x90') {

                                      $arr_of_size = explode('x', $_POST['size']);

                                      if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight()) {
                                          echo json_encode(array('err' => 1, 'error_field' => 'size', 'mess' => $this->lang->line('cab_new_29')));
                                          exit();
                                      }else {

                                          @$image_info = getimagesize($_FILES[0]['tmp_name']);

                                          if($image_info[2]  == IMAGETYPE_JPEG ) {
                                              $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                          }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                              $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                          }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                              $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                          }

                                          $id = $this->comp->add_new_ban($_SESSION['uid'], $name, $_POST['url'], $_POST['size'], $_POST['type_of_ad'], $_POST['cr_lang_ban'], 1);

                                          if($image_info[2]  == IMAGETYPE_JPEG ) {
                                              $image->resize($arr_of_size[0], $arr_of_size[1]);
                                              $image->save($name, $image_info[2]);
                                          }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                              $image->save($name, $image_info[2], 75, NULL, $_FILES[0]['tmp_name']);
                                          }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                              $image->resize($arr_of_size[0], $arr_of_size[1]);
                                              $image->save($name, $image_info[2]);
                                          }

                                          $ban_info = $this->comp->take_bans($id);

                                          echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode($ban_info) ));
                                          exit();

                                      }
                                  }else {
                                      echo json_encode(array('err' => 1, 'error_field' => 'size', 'mess' => $this->lang->line('cab_new_31')));
                                      exit();
                                  }
                             }else {
                                  echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                                  exit();
                             }
                          }catch (\Exception $e) {
                              echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                              exit();
                          }
                      }else {
                          echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                          exit();
                      }
                  }
              }
          }else {

              $this->load->library('SimpleImage');

             $image = new SimpleImage();

              try
              {
                  // $imagick = new \Imagick($_POST['uploadfile']);
                  // var_dump($imagick->valid());

                  if($image->load($_POST['uploadfile'])) {

                    // echo 5;exit();

                      if($_POST['size'] == '125x125' || $_POST['size'] == '300x50' || $_POST['size'] == '300x250' || $_POST['size'] == '300x600' || $_POST['size'] == '468x60' || $_POST['size'] == '728x90') {

                          $arr_of_size = explode('x', $_POST['size']);

                          if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight()) {
                              echo json_encode(array('err' => 1, 'error_field' => 'size', 'mess' => $this->lang->line('cab_new_29')));
                              exit();
                          }else {

                              $id = $this->comp->add_new_ban($_SESSION['uid'], $_POST['uploadfile'], $_POST['url'], $_POST['size'], $_POST['type_of_ad'], $_POST['cr_lang_ban'], 2);

                              $ban_info = $this->comp->take_bans($id);

                              echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode($ban_info)));
                              exit();

                          }
                      }else {
                          echo json_encode(array('err' => 1, 'error_field' => 'size', 'mess' => $this->lang->line('cab_new_31')));
                          exit();
                      }
                 }else {
                      echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                      exit();
                 }
              }catch (\Exception $e) {
                  echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                  exit();
              }
          }
      }
    }
    public function count_up_b($id) {
        $this->comp->up_and_get_ban_mon($_SESSION['uid'], $id);
        redirect('cabinet/l_b');
    }
    public function save_conf() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID']) && isset($_POST['lang']) && ($_POST['lang'] == 'all' || $_POST['lang'] == 'russian' || $_POST['lang'] == 'english' || $_POST['lang'] == 'german')) {
            $this->comp->update_banner_conf($_SESSION['uid'], $_POST['ID'], $_POST['lang']);
        }
    }
    public function ch_ban_img() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            $id = $_POST['ID'];
            if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
                echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
                exit();
            }elseif(!isset($_POST['ch_lang_ban']) || ($_POST['ch_lang_ban'] != 'all' && $_POST['ch_lang_ban'] != 'russian' && $_POST['ch_lang_ban'] != 'english' && $_POST['ch_lang_ban'] != 'german')) {
                echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
                exit();
            }elseif($this->comp->check_ban_lord($_SESSION['uid'], $id)) {
                if($_POST['cont_type'] == 'file') {
                    if(empty($_FILES[0]['tmp_name'])) {

                        $this->comp->ch_old_ban($id, $_SESSION['uid'], NULL, $_POST['url'], NULL, $_POST['ch_lang_ban']);

                        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode(array('ID' => $_POST['ID'], 'new_url' => $_POST['url'], 'new_img' => null) )));
                        exit();

                    }else {

                        if($_FILES[0]['error'] != 0) {
                            switch ($_FILES[0]['error']) {
                              case '1':
                              case '2':
                                echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_26')));
                                exit();
                                break;

                              case '3':
                              case '4':
                                echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_27')));
                                exit();
                                break;

                              default:
                                echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_27')));
                                exit();
                                break;
                            }
                        }else{
                            $fi = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = (string) finfo_file($fi, $_FILES[0]['tmp_name']);
                            // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
                            if (strpos($mime, 'image') !== false){
                                $this->load->library('SimpleImage');

                               $image = new SimpleImage();

                                try
                                {
                                    // $imagick = new \Imagick($_FILES[0]['tmp_name']);
                                    // var_dump($imagick->valid());

                                    if($image->load($_FILES[0]['tmp_name'])) {

                                        $ban_arr = $this->comp->take_bans($id);

                                        $arr_of_size = explode('x', $ban_arr['format']);

                                        if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight()) {
                                            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_29')));
                                            exit();
                                        }else {

                                            @$image_info = getimagesize($_FILES[0]['tmp_name']);

                                            if($image_info[2]  == IMAGETYPE_JPEG ) {
                                                $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                            }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                                $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                            }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                                $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                            }

                                            // $name = 'usban/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';

                                            // $image->resize($arr_of_size[0], $arr_of_size[1]);

                                            // $image->save($name);

                                            if($image_info[2]  == IMAGETYPE_JPEG ) {
                                                $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                $image->save($name, $image_info[2]);
                                            }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                                $image->save($name, $image_info[2], 75, NULL, $_FILES[0]['tmp_name']);
                                            }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                                $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                $image->save($name, $image_info[2]);
                                            }

                                            $this->comp->ch_old_ban($id, $_SESSION['uid'], $name, $_POST['url'], $_POST['cont_type'], $_POST['ch_lang_ban']);

                                            echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode(array('ID' => $_POST['ID'], 'new_url' => $_POST['url'], 'new_img' => '/'.$name) )));
                                            exit();

                                        }
                                   }else {
                                        echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                                        exit();
                                   }
                                }catch (\Exception $e) {
                                    echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                                    exit();
                                }
                            }else {
                                echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_32')));
                                exit();
                            }
                        }
                    }
                }elseif($_POST['cont_type'] == 'link') {
                    $this->load->library('SimpleImage');

                    if($_POST['uploadfile'] == '') {

                      $this->comp->ch_old_ban($id, $_SESSION['uid'], NULL, $_POST['url'], NULL, $_POST['ch_lang_ban']);

                      echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode(array('ID' => $_POST['ID'], 'new_url' => $_POST['url'], 'new_img' => null) )));
                       exit();

                    }else {

                     $image = new SimpleImage();

                      try
                      {
                          // $imagick = new \Imagick($_POST[0]);
                          // var_dump($imagick->valid());

                         if($image->load($_POST['uploadfile'])) {

                              $ban_arr = $this->comp->take_bans($id);

                              $arr_of_size = explode('x', $ban_arr['format']);

                              if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight()) {
                                  echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_29')));
                                  exit();
                              }else {

                                  $this->comp->ch_old_ban($id, $_SESSION['uid'], json_encode($_POST['uploadfile']), $_POST['url'], $_POST['cont_type'], $_POST['ch_lang_ban']);

                                  echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode( array('ID' => $_POST['ID'], 'new_url' => $_POST['url'], 'new_img' => $_POST['uploadfile']) )));
                                  exit();

                              }
                         }else {
                              echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                              exit();
                         }
                      }catch (\Exception $e) {
                          echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                          exit();
                      }
                    }
                }
            }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_32')));
                exit();
            }
        }
    }

    public function up_bal_ban() {
        if( (!isset($_POST['ID']) || !isset($_POST['count'])) || (isset($_POST['ID']) && !is_numeric($_POST['ID'])) || (isset($_POST['count']) && (!in_array($_POST['count'], ['active_1_1','active_2_1','active_3_1','active_4_1','active_5_1','active_1','active_2','active_3','active_4','active_5'])) ) ) {
            $result['error'] = 1;
            $result['mess'] = $this->lang->line('cab_new_17');
        }else {
            if($this->comp->check_ban_lord($_SESSION['uid'], $_POST['ID'])) {
                $user = $this->data['user_info'];
                $ban_arr = $this->comp->take_bans($_POST['ID']);

                $this->load->model('Marketing_model', 'mark');
                $curr_arr = $this->mark->get_curs();

                $name = 'CRT';

                $this->load->model('Marketing_model', 'mark');
                $mark_sett = $this->mark->get_all_mark_setts();

                $user_packet_info = json_decode($user['packet_status'], true);

                $type = $_POST['count'];

                $active_info = json_decode($mark_sett[$type], true);

                $packet1 = $user_packet_info['packet_1'];
                $packet2 = $user_packet_info['packet_2'];
                $packet3 = $user_packet_info['packet_3'];
                $packet4 = $user_packet_info['packet_4'];

                switch (true) {
                  case ($packet4 == 1):
                    $bonus = $mark_sett['bonus_4'];
                    break;
                  case ($packet3 == 1):
                    $bonus = $mark_sett['bonus_3'];
                    break;
                  case ($packet2 == 1):
                    $bonus = $mark_sett['bonus_2'];
                    break;
                  case ($packet1 == 1):
                    $bonus = $mark_sett['bonus_1'];
                    break;
                  default:
                    $bonus = 0;
                    break;
                }

                if(!$this->mark->buy_scale($type, $_SESSION['uid'])) {
                    $result['error'] = 1;
                    $result['mess'] = $this->lang->line('cab_new_19');
                }else {
                    if($this->comp->up_bal_ban($_SESSION['uid'], $_POST['ID'], $active_info['all_sum'], bcmul(bcmul($active_info['all_sum'], $curr_arr[$name], 0), (100+$bonus)/100, 0))) {

                        $result['error'] = 0;
                        $result['mess'] = $this->lang->line('cab_new_35');

                        $data = $this->comp->take_bans($_POST['ID']);
                        $result['type_of_ad'] = $data['type_of_ad'];

                        $result['bal'] = bcsub($user['amount_btc'], $active_info['all_sum'], 0);
                        $result['bal_comp'] = bcsub(bcadd($ban_arr['count'],  bcmul(bcmul($active_info['all_sum'], $curr_arr[$name], 0), (100+$bonus)/100, 0), 0), $ban_arr['current_count'], 0);

                        $result['type'] = $format;
                        $result['format'] = $ban_arr['format'];
                    }else {
                        $result['error'] = 1;
                        $result['mess'] = $this->lang->line('cab_new_37');
                    }
                }
            }else {
              $result['error'] = 1;
              $result['mess'] = $this->lang->line('cab_new_17');
            }
        }
        echo json_encode($result);
    }
    public function del_b($id) {

        $this->comp->del_b($_SESSION['uid'], $id);

        $_SESSION['del_b'] = $this->lang->line('cab_new_39');

        redirect('cabinet/myban');
    }
    public function ch_ban_state() {
        $_SESSION['conf_с'] = true;
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            if($this->comp->ch_ban_state($_SESSION['uid'], $_POST['ID'], $_POST['type'])) {
                echo json_encode(array('error' => 0));
            }else {
                echo json_encode(array('error' => 1));
            }
        }
    }
    public function ch_ban_type_ad() {
      $this->load->model('Marketing_model', 'mark');
      if($info = $this->comp->ch_ban_type_ad($_SESSION['uid'], $_POST['ID'], $this->mark->get_all_mark_setts())) {
        echo json_encode(array('error' => 0, 'new_bal' => $info['new_bal'], 'future_new_bal' => $info['future_new_bal']));
      }else {
        echo json_encode(array('error' => 1));
      }
    }
    /*
        end banner operations
    */

    /*
        text ad operations
    */
    public function copyt() {
      if(!isset($_POST['i']) || !is_numeric($_POST['i'])) {
        echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
      }else {
        $id = $this->comp->copy_text($_SESSION['uid'], $_POST['i']);
        $ban_info = $this->comp->take_text_ad($id);
        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_new_30'), 'ban_info' => json_encode($ban_info)));
      }
      exit();
    }
    public function addtext_ad() {
      if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
          exit();
      }elseif(!isset($_POST['cr_lang_text_ad']) || ($_POST['cr_lang_text_ad'] != 'all' && $_POST['cr_lang_text_ad'] != 'russian' && $_POST['cr_lang_text_ad'] != 'english' && $_POST['cr_lang_text_ad'] != 'german')) {
          echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
          exit();
      }else {

        if(!isset($_POST['type_of_ad']) || !in_array($_POST['type_of_ad'], [0,1])) {
          $_POST['type_of_ad'] = 0;
        }

        $id = $this->comp->add_new_text_ad($_SESSION['uid'], $_POST['type_of_ad'], $_POST['header'], $_POST['body'], $_POST['url'], $_POST['cr_lang_text_ad']);

        $ban_info = $this->comp->take_text_ad($id);

        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('mytext_s_5'), 'ban_info' => json_encode($ban_info)));
        exit();
      }
    }
    public function count_up_text_ad($id) {
        $this->comp->up_and_get_ban_mon($_SESSION['uid'], $id);
        redirect('cabinet/l_b');
    }
    public function save_conf_text_ad() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID']) && isset($_POST['lang']) && ($_POST['lang'] == 'all' || $_POST['lang'] == 'russian' || $_POST['lang'] == 'english' || $_POST['lang'] == 'german')) {
            $this->comp->update_banner_conf($_SESSION['uid'], $_POST['ID'], $_POST['lang']);
        }
    }
    public function ch_text_ad_info() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            $id = $_POST['ID'];
            if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
                echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
                exit();
            }elseif(!isset($_POST['ch_lang_text_ad']) || ($_POST['ch_lang_text_ad'] != 'all' && $_POST['ch_lang_text_ad'] != 'russian' && $_POST['ch_lang_text_ad'] != 'english' && $_POST['ch_lang_text_ad'] != 'german')) {
                echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
                exit();
            }elseif($this->comp->check_text_ad_lord($_SESSION['uid'], $id)) {
              $this->comp->ch_old_text_ad($id, $_SESSION['uid'], $_POST['header'], $_POST['body'], $_POST['url'], $_POST['ch_lang_text_ad']);
              echo json_encode(array('err' => 0, 'mess' => $this->lang->line('mytext_s_6'), 'ban_info' => json_encode(array('ID' => $_POST['ID'], 'new_url' => $_POST['url'], 'new_head' => $_POST['header'], 'new_body' => $_POST['body'], 'new_img' => null) )));
              exit();
            }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_32')));
                exit();
            }
        }
    }
    public function up_bal_text_ad() {
      if( (!isset($_POST['ID']) || !isset($_POST['count'])) || (isset($_POST['ID']) && !is_numeric($_POST['ID'])) || (isset($_POST['count']) && (!in_array($_POST['count'], ['active_1_1','active_2_1','active_3_1','active_4_1','active_5_1','active_1','active_2','active_3','active_4','active_5'])) ) ) {
            $result['error'] = 1;
            $result['mess'] = $this->lang->line('cab_new_17');
        }else {
          if($this->comp->check_text_ad_lord($_SESSION['uid'], $_POST['ID'])) {
              $user = $this->data['user_info'];
              $ban_arr = $this->comp->take_text_ad($_POST['ID']);

              $this->load->model('Marketing_model', 'mark');
              $curr_arr = $this->mark->get_curs();

              $name = 'CRT';

              $this->load->model('Marketing_model', 'mark');
              $mark_sett = $this->mark->get_all_mark_setts();

              $user_packet_info = json_decode($user['packet_status'], true);

              $type = $_POST['count'];

              $active_info = json_decode($mark_sett[$type], true);

              $packet1 = $user_packet_info['packet_1'];
              $packet2 = $user_packet_info['packet_2'];
              $packet3 = $user_packet_info['packet_3'];
              $packet4 = $user_packet_info['packet_4'];

              switch (true) {
                case ($packet4 == 1):
                  $bonus = $mark_sett['bonus_4'];
                  break;
                case ($packet3 == 1):
                  $bonus = $mark_sett['bonus_3'];
                  break;
                case ($packet2 == 1):
                  $bonus = $mark_sett['bonus_2'];
                  break;
                case ($packet1 == 1):
                  $bonus = $mark_sett['bonus_1'];
                  break;
                default:
                  $bonus = 0;
                  break;
              }

              if(!$this->mark->buy_scale($type, $_SESSION['uid'])) {
                  $result['error'] = 1;
                  $result['mess'] = $this->lang->line('cab_new_19');
              }else {
                  if($this->comp->up_bal_text_ad($_SESSION['uid'], $_POST['ID'], $active_info['all_sum'], bcmul(bcmul($active_info['all_sum'], $curr_arr[$name], 0), (100+$bonus)/100, 0)) ) {

                      $result['error'] = 0;
                      $result['mess'] = $this->lang->line('cab_new_35');

                      $data = $this->comp->take_text_ad($_POST['ID']);
                      $result['type_of_ad'] = $data['type_of_ad'];

                      $result['bal'] = bcsub($user['amount_btc'], $active_info['all_sum'], 0);
                      $result['bal_comp'] = bcsub(bcadd($ban_arr['count'],  bcmul(bcmul($active_info['all_sum'], $curr_arr[$name], 0), (100+$bonus)/100, 0), 0), $ban_arr['current_count'], 0);

                      $result['type'] = $format;
                      $result['format'] = $ban_arr['format'];
                  }else {
                      $result['error'] = 1;
                      $result['mess'] = $this->lang->line('cab_new_37');
                  }
              }
          }else {
             $result['error'] = 1;
              $result['mess'] = $this->lang->line('cab_new_17');
          }
      }
      echo json_encode($result);
    }
    public function del_text_ad($id) {

        $this->comp->del_text_ad($_SESSION['uid'], $id);

        $_SESSION['del_b'] = $this->lang->line('mytext_s_9');

        redirect('cabinet/mytext');
    }
    public function ch_text_ad_state() {
        $_SESSION['conf_с'] = true;
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            if($this->comp->ch_text_ad_state($_SESSION['uid'], $_POST['ID'], $_POST['type'])) {
                echo json_encode(array('error' => 0));
            }else {
                echo json_encode(array('error' => 1));
            }
        }
    }
    public function ch_text_type_ad() {
      $this->load->model('Marketing_model', 'mark');
      if($info = $this->comp->ch_text_type_ad($_SESSION['uid'], $_POST['ID'], $this->mark->get_all_mark_setts())) {
        echo json_encode(array('error' => 0, 'new_bal' => $info['new_bal'], 'future_new_bal' => $info['future_new_bal']));
      }else {
        echo json_encode(array('error' => 1));
      }
    }
    /*
        end text ad operations
    */


    /*
        vid ad operations
    */
    public function addvid_ad() {
      if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
          exit();
      }elseif(!isset($_POST['cr_lang_vid_ad']) || ($_POST['cr_lang_vid_ad'] != 'all' && $_POST['cr_lang_vid_ad'] != 'russian' && $_POST['cr_lang_vid_ad'] != 'english' && $_POST['cr_lang_vid_ad'] != 'german')) {
          echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
          exit();
      }else {
        $id = $this->comp->add_new_vid_ad($_SESSION['uid'], $_POST['url'], $_POST['cr_lang_vid_ad']);

        $ban_info = $this->comp->take_vid_ad($id);

        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('myvid_s_2'), 'ban_info' => json_encode($ban_info)));
        exit();
      }
    }
    public function count_up_vid_ad($id) {
        $this->comp->up_and_get_ban_mon($_SESSION['uid'], $id);
        redirect('cabinet/l_b');
    }
    public function save_conf_vid_ad() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID']) && isset($_POST['lang']) && ($_POST['lang'] == 'all' || $_POST['lang'] == 'russian' || $_POST['lang'] == 'english' || $_POST['lang'] == 'german')) {
            $this->comp->update_banner_conf($_SESSION['uid'], $_POST['ID'], $_POST['lang']);
        }
    }
    public function ch_vid_ad_info() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            $id = $_POST['ID'];
            if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
                echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('cab_new_33')));
                exit();
            }elseif(!isset($_POST['ch_lang_vid_ad']) || ($_POST['ch_lang_vid_ad'] != 'all' && $_POST['ch_lang_vid_ad'] != 'russian' && $_POST['ch_lang_vid_ad'] != 'english' && $_POST['ch_lang_vid_ad'] != 'german')) {
                echo json_encode(array('err' => 1, 'error_field' => 'lang', 'mess' => 'language is incorrect'));
                exit();
            }elseif($this->comp->check_vid_ad_lord($_SESSION['uid'], $id)) {
              $this->comp->ch_old_vid_ad($id, $_SESSION['uid'], $_POST['url'], $_POST['ch_lang_vid_ad']);
              echo json_encode(array('err' => 0, 'mess' => $this->lang->line('myvid_s_3'), 'ban_info' => json_encode(array('ID' => $_POST['ID'], 'new_url' => $_POST['url']) )));
              exit();
            }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_32')));
                exit();
            }
        }
    }
    public function up_bal_vid_ad() {
        if( (!isset($_POST['ID']) || !isset($_POST['count'])) || (isset($_POST['ID']) && !is_numeric($_POST['ID'])) || (isset($_POST['count']) && (!is_numeric($_POST['count']) || $_POST['count'] < 0) ) ) {
            $result['error'] = 1;
            $result['mess'] = $this->lang->line('cab_new_17');
        }else {
            if($this->comp->check_vid_ad_lord($_SESSION['uid'], $_POST['ID'])) {
                $user = $this->data['user_info'];
                $ban_arr = $this->comp->take_vid_ad($_POST['ID']);

                if(bccomp($user['amount_btc'], $_POST['count'], 4) < 0) {
                    $result['error'] = 1;
                    $result['mess'] = $this->lang->line('cab_new_19');
                }else {
                    if($this->comp->up_bal_vid_ad($_SESSION['uid'], $_POST['ID'], $_POST['count'])) {

                        $result['error'] = 0;
                        $result['mess'] = $this->lang->line('cab_new_35');

                        $result['bal'] = bcsub($user['amount_btc'], $_POST['count'], 0);
                        $result['bal_comp'] = bcadd($ban_arr['balance'], $_POST['count'], 0);

                        $result['type'] = $format;
                        $result['format'] = $ban_arr['format'];
                    }else {
                        $result['error'] = 1;
                        $result['mess'] = $this->lang->line('cab_new_37');
                    }
                }
            }else {
               $result['error'] = 1;
                $result['mess'] = $this->lang->line('cab_new_17');
            }
        }
        echo json_encode($result);
    }
    public function del_vid_ad($id) {

        $this->comp->del_vid_ad($_SESSION['uid'], $id);

        $_SESSION['del_b'] = $this->lang->line('cab_new_39');

        redirect('cabinet/myvid');
    }
    public function ch_vid_ad_state() {
        $_SESSION['conf_с'] = true;
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            if($this->comp->ch_vid_ad_state($_SESSION['uid'], $_POST['ID'], $_POST['type'])) {
                echo json_encode(array('error' => 0));
            }else {
                echo json_encode(array('error' => 1));
            }
        }
    }
    /*
        end vid ad operations
    */


    /*
        finance part
    */
    public function getActualBalance() {

        $this->comp->getBal($this->session->uid);

    }
    public function tr_to_another_wal() {
        if( isset($_POST['sum']) && is_numeric($_POST['sum']) && $_POST['sum'] > 0 ) {
            if($succ_info = $this->comp->TransferToAnotherBalance($this->session->uid, $_POST['sum'])) {
                echo json_encode(array('err' => 0, 'mess' => $this->lang->line('cab_tr_mess_1'), 'ads_bal' => $succ_info['ads_bal'], 'main_bal' => $succ_info['main_bal']));
            }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_tr_mess_2')));
            }
        }else {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_tr_mess_3')));
        }
    }
    public function SaveWal() {
        if(isset($_POST['wallet']) && is_string($_POST['wallet']) && $_POST['wallet'] != '') {
            $this->comp->saveWalToRet($_SESSION['uid'], $_POST['wallet']);

            echo json_encode(array('err' => 0, 'mess' => 'Ok'));
            exit();
        }else {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_40')));
            exit();
        }
    }
    public function GetAddressBCH() {

      // $res_addr = $this->invoices->get_wal_to_ref($this->session->uid);

      if(!is_null($this->data['user_info']['wallet_to_ref'])) {
          $address = $this->data['user_info']['wallet_to_ref'];
          $payment_code = '';
          $invoice = '';
      }else {
        // {"data":{"id":1317985,"currency":"TBTC","address":"2N9gymcDciBacmAoHXJ1UiKZ2DtPn4ARU4T","tag":null,"foreign_id":"uid:666"}}
        // {"data":{"id":1321128,"currency":"TBTC","address":"2NEsCUYuTVmefYqESDEW3zh4REU3EgwrvmL","tag":null,"foreign_id":"uid:666"}}

        // N - {"id":2495657,"type":"deposit","crypto_address":{"id":1321128,"currency":"TBTC","address":"2NEsCUYuTVmefYqESDEW3zh4REU3EgwrvmL","tag":null,"foreign_id":"uid:666"},"currency_sent":{"currency":"TBTC","amount":"0.02942315"},"currency_received":{"currency":"TBTC","amount":"0.02942315","amount_minus_fee":"0.02918777"},"transactions":[{"id":1774238,"currency":"TBTC","transaction_type":"blockchain","type":"deposit","address":"2NEsCUYuTVmefYqESDEW3zh4REU3EgwrvmL","tag":null,"amount":"0.02942315","txid":"69e7d9d52f00240ca7e5ed8ec0b2973b902a620c768c5f6c477cb206b975e134","confirmations":"1"}],"fees":[{"type":"deposit","currency":"TBTC","amount":"0.00023538"}],"error":null,"status":"confirmed"}

        // H - {"X-Processing-Signature":"3a08f609e23ce598a48417b3142f605d6b37e6beb5986ebaf3962477ffaa19724c659d84e9e76197706dab1e92890d9fe56de0dcf4efcc8f0f2dc9d4215c37f3","X-Processing-Key":"VAvkh3uWfTXET9RW48hFn7wuPpb6JRhn","User-Agent":"GuzzleHttp\/6.3.3 curl\/7.64.0 PHP\/7.3.8","Host":"digifluxx.com"}

        if( $curl = curl_init() ) {

          $open_key = 'Rc04MG2qx2DC0YnQc5DYEGBXbqAf9RsG';
          $secr_key = 'KLPjibxKTnaoQazFi6ZlErXmkFQe4EAcJQGfcSFnUdidsX19VZRBBuA7oDZ2CvGD';

          curl_setopt($curl, CURLOPT_URL, 'https://app.coinspaid.com/api/v2/addresses/take');
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);

          $post_data = [
              "foreign_id" => "uid:".$this->session->uid,
              "currency" => "BTC"
          ];

          $requestBody = json_encode($post_data);
          $signature   = hash_hmac('sha512', $requestBody, $secr_key);

          curl_setopt($curl, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/json',
                                'X-Processing-Key:'.$open_key,
                                'X-Processing-Signature:'.$signature
                              ]);

          curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
          $out = curl_exec($curl);
          $res = json_decode($out);
          curl_close($curl);
        }

        $address = $res->data->address; // Bitcoin address to receive payments
        $payment_code = $res->data->id; //Payment Code

        // $address = 'testwallet'; // Bitcoin address to receive payments
        // $payment_code = '201010102'; //Payment Code

        $this->load->model('invoices_model', 'invoices');
        $this->invoices->save_wallet($this->session->uid, $address, $payment_code);
      }

      echo json_encode(array('err' => 0, 'addr' => $address));
    }
    public function CheckResultWallet() {
        if(isset($_POST['wallet'])) {
            $this->load->model('invoices_model', 'invoices');
            if($res_addr = $this->invoices->check_wal_status($this->session->uid, $_POST['wallet'])) {
                $result = array('success' => 1, 'fail' => 0, 'mess' => $this->lang->line('wallet_269'));
            }else {
                $result = array('success' => 0, 'fail' => 1, 'mess' => $this->lang->line('wallet_270'));
            }
            echo json_encode($result);
        }
    }
    public function withdraw() {
        if(!isset($_POST['wallet']) || !is_string($_POST['wallet']) || $_POST['wallet'] == '') {
            echo json_encode(array('err' => 1, 'mess' => 'Incorrect wallet number.'));
            exit();
        }

        if($_POST['cur'] != 'EUR' && $_POST['cur'] != 'BTC') {
            echo json_encode(array('err' => 1, 'mess' => 'Incorrect currency.'));
            exit();
        }

        $_POST['sum'] = str_replace(',', '.', $_POST['sum']);

        if(!is_numeric($_POST['sum']) || $_POST['sum'] < 0) {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('inc_sum')));
            exit();
        }

        if($_POST['sum'] < 50) {
            echo json_encode(array('err' => 1, 'mess' => 'The minimum withdrawal is 50 Credits.'));
            exit();
        }

        if($_POST['sum'] > $this->data['user_info']['add_amount_btc']) {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('not_e_mon')));
            exit();
        }

        $this->finances->addTransaction($_POST['cur'], $this->session->uid, null, $_POST['sum'], 3, 2, 0, null, null, $_POST['wallet']);
        $this->users->subFunds('btc', $_POST['sum'], 0, $_POST['wallet']);

        echo json_encode(array(
                          'err' => 0,
                          'mess' => $this->lang->line('with_was_s'),
                          'res_bal' => (bcsub($this->data['user_info']['add_amount_btc']+0, $_POST['sum']+0, 0))
                        ));
        exit();
    }
    /*
        end finance part
    */



    /*
        callbacks
    */
    public function buy_tarif() {

        // if(true){

        //     echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_buy_mess_3')));

        // }else

        if(isset($_POST['type']) && is_string($_POST['type']) && ($_POST['type'] == 'b' || $_POST['type'] == 'l' || $_POST['type'] == 't')) {

            if($_POST['type'] == 'l') {
                $res_info = $this->comp->BuyLinear($this->session->uid);
            }elseif($_POST['type'] == 't') {
                $res_info = $this->comp->BuyTrinar($this->session->uid);
                //$res_info['error'] == 2;
            }else{
                $strname = 'binar';
                //должен вернутся новый баланс и новый уровень
                $res_info = $this->comp->Buy($this->session->uid, 1, $strname);

            }

            if($res_info['error'] == 0) {
                echo json_encode(array('err' => 0, 'mess' => $this->lang->line('new_struct_mess_1')));
            }elseif($res_info['error'] == 1) {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('new_struct_mess_2')));
            }elseif($res_info['error'] == 2) {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('new_struct_mess_3')));
            }

        }else {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_buy_mess_3')));
        }
    }
    public function buyads() {
        $_POST['type2'] = 2;
        if(!isset($_POST['type2']) || ($_POST['type2'] != 1 && $_POST['type2'] != 2) || ($_POST['type_of_buy'] == 0 && (!isset($_POST['count']) || $_POST['count'] <= 0) ) ) {
            echo json_encode(array('err' => 1, 'error_field' => 'count', 'mess' => $this->lang->line('cab_new_22')));
            exit();
        }elseif(!isset($_POST['type_of_buy']) || ($_POST['type_of_buy'] != 0 && $_POST['type_of_buy'] != 1 && $_POST['type_of_buy'] != 2 && $_POST['type_of_buy'] != 3 && $_POST['type_of_buy'] != 4)) {
            echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_22')));
            exit();
        }else {
            if($_POST['type2'] == 1 && $this->data['user_info']['tarif'] < 2) {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_199')));
                exit();
            }elseif($result = $this->comp->buy_ads($_SESSION['uid'], $_POST['type_of_buy'], $_POST['size2'], $_POST['count'])) {

                if($_POST['type2'] == 1) {
                    $type_of_ads = 'click';
                }else {
                    $type_of_ads = 'show';
                }

                echo json_encode(array('bal_main' => rtrim(rtrim(number_format($result['new_bal'], 4, '.', ''), "0"), "."), 'err' => 0, 'mess' => $this->lang->line('cab_new_23'), 'ads_info' => json_encode(array('type_of_ads' => 'bal_'.$type_of_ads, 'count' => $_POST['count'], 'format' => $_POST['size2'])) ));
                exit();
            }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('cab_new_19')));
                exit();
            }
        }
    }
    public function change_password() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security'); //надо для работы с xss_clean
        $this->load->library('form_validation');
        $this->load->library('authentication');

        $this->form_validation->set_rules('password', 'lang:current_password', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', array('password_check', array($this->users, 'check_password'))));
        $this->form_validation->set_rules('newpassword', 'lang:new_password', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', array('password_identity', array($this->users, 'check_identity'))));
        $this->form_validation->set_rules('passconf', 'lang:repeat_new_password', 'required|matches[newpassword]|trim|htmlspecialchars|strip_tags|xss_clean');

        $settings = $this->settings->get_settings();

        if ($this->form_validation->run() == FALSE) {
            $result = array('err' => 1, 'mess_pass' => form_error('password'), 'mess_npass' => form_error('newpassword'), 'mess_cpass' => form_error('passconf'));
        }
        else {
            $this->users->setNewPassword($this->session->uid);
            $user = $this->data['user_info'];
            $signed_info = $this->authentication->getAuthString($user['id'], $user['email'], $user['password']);
            set_cookie('signed_info', $signed_info, '3600');

            $result = array('err' => 0, 'mess' => $this->lang->line('mess_of_ch_p'));

        }
        echo json_encode($result);
    }
    public function GetAllTables() {

        $data['refills_btc'] = $this->finances->getMyRefills($this->session->uid, 'BTC');

        $data['refills_pe'] = $this->finances->getMyRefills($this->session->uid, 'PE');

        $data['refills_adv'] = $this->finances->getMyRefills($this->session->uid, 'ADV');

        echo json_encode($data);
    }
    public function GetAllWithdraws() {
        $data['widthdraws_btc'] = $this->finances->getMyWithdraws($this->session->uid, 'BTC');

        $data['widthdraws_pe'] = $this->finances->getMyWithdraws($this->session->uid, 'PE');

        $data['widthdraws_adv'] = $this->finances->getMyWithdraws($this->session->uid, 'ADV');

        echo json_encode($data);
    }
    public function GetAndSendMes() {
        $this->load->library('mailrotator');
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['g-recaptcha-response'])) {

            if( $curl = curl_init() ) {

                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6Lc7tsEUAAAAAIJ02MvYrX6XbZ4Y4QU7F8aL8tmY&response=".$_POST['g-recaptcha-response']);
                $res = curl_exec($curl);

                $res = json_decode($res);

                if($res->success) {
                    $cont = true;
                }else {
                    $cont = false;
                }

                curl_close($curl);
            }

            if($cont) {
                if($_POST['title'] == '' OR $_POST['message'] == ''){
                    $_SESSION['error'] = $this->lang->line('cab_new_1');
                }else {
                    $user = $this->data['user_info'];
                    $subject = 'Message from user '.$user['login'].': '.$this->input->post('title');
                    $message = 'E-mail of user: '.$user['email']."\n\r". 'Message:'.$this->input->post('message');

                    $this->comp->add_sup_mess($user['email'], 'FROM_CABINET '.$subject, $message);

                    $this->mailrotator->send('support@digifluxx.com', $subject, $message, $user['email']);
                    //$this->session->set_flashdata('message_sent', true);
                    $_SESSION['message_sent'] = true;
                }
            }else {
                // $this->session->set_flashdata('error_captcha', true);
                $_SESSION['error_captcha'] = true;
            }
        }
        redirect('/cabinet/supp');
    }
    /*
        end callbacks
    */



    /*
        adding funcs
    */
    public function ChStatus() {

        $this->users->ChStatus($this->session->uid);

    }
    public function ChStatus2() {

        $this->users->ChStatus2($this->session->uid);

    }
    public function ChStatusOfBon() {

        $this->users->ChBonusStatus($this->session->uid, $_POST['bonus']);

    }
    public function crop() {
        include 'crop_class.php';

        $crop = new CropAvatar(
          isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
          isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
          isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null
        );

        $response = array(
          'state'  => 200,
          'message' => $crop -> getMsg(),
          'result' => $crop -> getResult()
        );

        $arr = $this->users->getUsAv($this->session->username);
        $path_old = $arr[0]['ava'];
        if($path_old != 'assets/img/def_ava.jpg'){
            $arr = explode('/', $path_old);
            $arr2 = explode('.', $arr[1]);
            unlink($path_old);
            // unlink('avas/'.$arr2[0].'.original.'.$arr2[count($arr2)-1]);
        }

        // unlink($path1);

        $this->users->updateAvUs($this->session->username, $crop->getResult());
        $this->session->ava = $crop->getResult();

        // echo json_encode($response);

        redirect('cabinet/setting');
    }
    public function ava() {
        if(empty($_FILES['file']['name'])){

            $_SESSION['err_av_load'] = $lang['file_er_size'];
        }else {

            if($_FILES['file']['error'] != 0) {

                switch ($_FILES['file']['error']) {

                    case '1':
                    case '2':
                        $_SESSION['err_av_load'] = $lang['file_er_size'];
                    break;
                    case '3':
                        $_SESSION['err_av_load'] = $lang['file_er_size'];
                    break;
                    case '4':
                        $_SESSION['err_av_load'] = $lang['file_er_size'];
                    break;
                }

            }elseif(substr($_FILES['file']['type'], 0, strpos($_FILES['file']['type'], '/')) != 'image'){
                $_SESSION['err_av_load'] = $lang['file_er_type'];
            }else{

                $whitelist = array("jpg", "jpeg", "gif", "png");

                if(strpos($_FILES['file']['name'], '.')) {

                    $arrForCheck = explode('.', $_FILES['file']['name']);

                    if($arrForCheck[count($arrForCheck)-1] != $whitelist[0] && $arrForCheck[count($arrForCheck)-1] != $whitelist[1] && $arrForCheck[count($arrForCheck)-1] != $whitelist[2] && $arrForCheck[count($arrForCheck)-1] != $whitelist[3]){
                        $_SESSION['err_av_load'] = $lang['file_er_type'];
                    }else {

                        $type = $_FILES['file']['type'];
                        $size = $_FILES['file']['size'];

                        if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")) {
                            $_SESSION['err_av_load'] = $lang['file_er_type'];
                        }elseif ($size > 3024000) {
                            $_SESSION['err_av_load'] = $lang['file_er_size'];
                        }elseif (!getimagesize($_FILES['file']['tmp_name'])) {
                            $_SESSION['err_av_load'] = $lang['file_er_type'];
                        }else {

                            $_SESSION['succ_av_load'] = '';//'Файл успешно загружен';
                            $arr = explode('.', $_FILES['file']['name']);
                            $path1 = "avas/". time().'.'.$arr[count($arr)-1];
                            $path2 = "avas/m_". time().'.'.$arr[count($arr)-1];
                            copy($_FILES['file']['tmp_name'], $path1);


                            $final_width_of_image = 300; //Размер изображения которые Вы хотели бы получить (И ШИРИНА И ВЫСОТА)
                            $filename = $path1;

                            if(preg_match('/[.](jpg)$/', $filename) || preg_match('/[.](JPG)$/', $filename) || preg_match('/[.](jpeg)$/', $filename) || preg_match('/[.](JPEG)$/', $filename)) {
                              $im = imagecreatefromjpeg($filename);
                            }elseif (preg_match('/[.](gif)$/', $filename) || preg_match('/[.](GIF)$/', $filename)) {
                              $im = imagecreatefromgif($filename);
                            }elseif (preg_match('/[.](png)$/', $filename) || preg_match('/[.](PNG)$/', $filename)) {
                              $im = imagecreatefrompng($filename);
                            } //Определяем формат изображения
                            $ox = imagesx($im);
                            $oy = imagesy($im);
                            $nx = $final_width_of_image;
                            $ny = floor($oy * ($final_width_of_image / $ox));
                            $nm = imagecreatetruecolor($nx, $ny);
                            imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
                            imagejpeg($nm, $path2);


                            $arr = $this->users->getUsAv($this->session->username);
                            $path_old = $arr[0]['ava'];
                            if($path_old != 'assets/img/def_ava.jpg'){
                                unlink($path_old);
                            }

                            unlink($path1);

                            $this->users->updateAvUs($this->session->username, $path2);
                            $this->session->ava = $path2;

                        }
                    }
                }else {
                    $_SESSION['err_av_load'] = $lang['file_er_type'];
                }
            }
        }
        redirect('cabinet/setting');
    }

    public function country_check($str) {
        $country_arr = array(
                            "AX" => 'AALAND ISLANDS',
                            "AF" => 'AFGHANISTAN',
                            "AL" => 'ALBANIA',
                            "DZ" => 'ALGERIA',
                            "AS" => 'AMERICAN SAMOA',
                            "AD" => 'ANDORRA',
                            "AO" => 'ANGOLA',
                            "AI" => 'ANGUILLA',
                            "AQ" => 'ANTARCTICA',
                            "AG" => 'ANTIGUA AND BARBUDA',
                            "AR" => 'ARGENTINA',
                            "AM" => 'ARMENIA',
                            "AW" => 'ARUBA',
                            "AU" => 'AUSTRALIA',
                            "AT" => 'AUSTRIA',
                            "AZ" => 'AZERBAIJAN',
                            "BS" => 'BAHAMAS',
                            "BH" => 'BAHRAIN',
                            "BD" => 'BANGLADESH',
                            "BB" => 'BARBADOS',
                            "BY" => 'BELARUS',
                            "BE" => 'BELGIUM',
                            "BZ" => 'BELIZE',
                            "BJ" => 'BENIN',
                            "BM" => 'BERMUDA',
                            "BT" => 'BHUTAN',
                            "BO" => 'BOLIVIA',
                            "BA" => 'BOSNIA AND HERZEGOWINA',
                            "BW" => 'BOTSWANA',
                            "BV" => 'BOUVET ISLAND',
                            "BR" => 'BRAZIL',
                            "IO" => 'BRITISH INDIAN OCEAN TERRITORY',
                            "BN" => 'BRUNEI DARUSSALAM',
                            "BG" => 'BULGARIA',
                            "BF" => 'BURKINA FASO',
                            "BI" => 'BURUNDI',
                            "KH" => 'CAMBODIA',
                            "CM" => 'CAMEROON',
                            "CA" => 'CANADA',
                            "CV" => 'CAPE VERDE',
                            "KY" => 'CAYMAN ISLANDS',
                            "CF" => 'CENTRAL AFRICAN REPUBLIC',
                            "TD" => 'CHAD',
                            "CL" => 'CHILE',
                            "CN" => 'CHINA',
                            "CX" => 'CHRISTMAS ISLAND',
                            "CO" => 'COLOMBIA',
                            "KM" => 'COMOROS',
                            "CK" => 'COOK ISLANDS',
                            "CR" => 'COSTA RICA',
                            "CI" => 'COTE D`IVOIRE',
                            "CU" => 'CUBA',
                            "CY" => 'CYPRUS',
                            "CZ" => 'CZECH REPUBLIC',
                            "DK" => 'DENMARK',
                            "DJ" => 'DJIBOUTI',
                            "DM" => 'DOMINICA',
                            "DO" => 'DOMINICAN REPUBLIC',
                            "EC" => 'ECUADOR',
                            "EG" => 'EGYPT',
                            "SV" => 'EL SALVADOR',
                            "GQ" => 'EQUATORIAL GUINEA',
                            "ER" => 'ERITREA',
                            "EE" => 'ESTONIA',
                            "ET" => 'ETHIOPIA',
                            "FO" => 'FAROE ISLANDS',
                            "FJ" => 'FIJI',
                            "FI" => 'FINLAND',
                            "FR" => 'FRANCE',
                            "GF" => 'FRENCH GUIANA',
                            "PF" => 'FRENCH POLYNESIA',
                            "TF" => 'FRENCH SOUTHERN TERRITORIES',
                            "GA" => 'GABON',
                            "GM" => 'GAMBIA',
                            "GE" => 'GEORGIA',
                            "DE" => 'GERMANY',
                            "GH" => 'GHANA',
                            "GI" => 'GIBRALTAR',
                            "GR" => 'GREECE',
                            "GL" => 'GREENLAND',
                            "GD" => 'GRENADA',
                            "GP" => 'GUADELOUPE',
                            "GU" => 'GUAM',
                            "GT" => 'GUATEMALA',
                            "GN" => 'GUINEA',
                            "GW" => 'GUINEA-BISSAU',
                            "GY" => 'GUYANA',
                            "HT" => 'HAITI',
                            "HM" => 'HEARD AND MC DONALD ISLANDS',
                            "HN" => 'HONDURAS',
                            "HK" => 'HONG KONG',
                            "HU" => 'HUNGARY',
                            "IS" => 'ICELAND',
                            "IN" => 'INDIA',
                            "ID" => 'INDONESIA',
                            "IQ" => 'IRAQ',
                            "IE" => 'IRELAND',
                            "IL" => 'ISRAEL',
                            "IT" => 'ITALY',
                            "JM" => 'JAMAICA',
                            "JP" => 'JAPAN',
                            "JO" => 'JORDAN',
                            "KZ" => 'KAZAKHSTAN',
                            "KE" => 'KENYA',
                            "KI" => 'KIRIBATI',
                            "KW" => 'KUWAIT',
                            "KG" => 'KYRGYZSTAN',
                            "LA" => 'LAO PEOPLE`S DEMOCRATIC REPUBLIC',
                            "LV" => 'LATVIA',
                            "LB" => 'LEBANON',
                            "LS" => 'LESOTHO',
                            "LR" => 'LIBERIA',
                            "LY" => 'LIBYAN ARAB JAMAHIRIYA',
                            "LI" => 'LIECHTENSTEIN',
                            "LT" => 'LITHUANIA',
                            "LU" => 'LUXEMBOURG',
                            "MO" => 'MACAU',
                            "MG" => 'MADAGASCAR',
                            "MW" => 'MALAWI',
                            "MY" => 'MALAYSIA',
                            "MV" => 'MALDIVES',
                            "ML" => 'MALI',
                            "MT" => 'MALTA',
                            "MH" => 'MARSHALL ISLANDS',
                            "MQ" => 'MARTINIQUE',
                            "MR" => 'MAURITANIA',
                            "MU" => 'MAURITIUS',
                            "YT" => 'MAYOTTE',
                            "MX" => 'MEXICO',
                            "MC" => 'MONACO',
                            "MN" => 'MONGOLIA',
                            "MS" => 'MONTSERRAT',
                            "MA" => 'MOROCCO',
                            "MZ" => 'MOZAMBIQUE',
                            "MM" => 'MYANMAR',
                            "NA" => 'NAMIBIA',
                            "NR" => 'NAURU',
                            "NP" => 'NEPAL',
                            "NL" => 'NETHERLANDS',
                            "AN" => 'NETHERLANDS ANTILLES',
                            "NC" => 'NEW CALEDONIA',
                            "NZ" => 'NEW ZEALAND',
                            "NI" => 'NICARAGUA',
                            "NE" => 'NIGER',
                            "NG" => 'NIGERIA',
                            "NU" => 'NIUE',
                            "NF" => 'NORFOLK ISLAND',
                            "MP" => 'NORTHERN MARIANA ISLANDS',
                            "NO" => 'NORWAY',
                            "OM" => 'OMAN',
                            "PK" => 'PAKISTAN',
                            "PW" => 'PALAU',
                            "PA" => 'PANAMA',
                            "PG" => 'PAPUA NEW GUINEA',
                            "PY" => 'PARAGUAY',
                            "PE" => 'PERU',
                            "PH" => 'PHILIPPINES',
                            "PN" => 'PITCAIRN',
                            "PL" => 'POLAND',
                            "PT" => 'PORTUGAL',
                            "PR" => 'PUERTO RICO',
                            "QA" => 'QATAR',
                            "RE" => 'REUNION',
                            "RO" => 'ROMANIA',
                            "RU" => 'RUSSIAN FEDERATION',
                            "RW" => 'RWANDA',
                            "SH" => 'SAINT HELENA',
                            "KN" => 'SAINT KITTS AND NEVIS',
                            "LC" => 'SAINT LUCIA',
                            "PM" => 'SAINT PIERRE AND MIQUELON',
                            "VC" => 'SAINT VINCENT AND THE GRENADINES',
                            "WS" => 'SAMOA',
                            "SM" => 'SAN MARINO',
                            "ST" => 'SAO TOME AND PRINCIPE',
                            "SA" => 'SAUDI ARABIA',
                            "SN" => 'SENEGAL',
                            "CS" => 'SERBIA AND MONTENEGRO',
                            "SC" => 'SEYCHELLES',
                            "SL" => 'SIERRA LEONE',
                            "SG" => 'SINGAPORE',
                            "SK" => 'SLOVAKIA',
                            "SI" => 'SLOVENIA',
                            "SB" => 'SOLOMON ISLANDS',
                            "SO" => 'SOMALIA',
                            "ZA" => 'SOUTH AFRICA',
                            "GS" => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
                            "ES" => 'SPAIN',
                            "LK" => 'SRI LANKA',
                            "SD" => 'SUDAN',
                            "SR" => 'SURINAME',
                            "SJ" => 'SVALBARD AND JAN MAYEN ISLANDS',
                            "SZ" => 'SWAZILAND',
                            "SE" => 'SWEDEN',
                            "CH" => 'SWITZERLAND',
                            "SY" => 'SYRIAN ARAB REPUBLIC',
                            "TW" => 'TAIWAN',
                            "TJ" => 'TAJIKISTAN',
                            "TH" => 'THAILAND',
                            "TL" => 'TIMOR-LESTE',
                            "TG" => 'TOGO',
                            "TK" => 'TOKELAU',
                            "TO" => 'TONGA',
                            "TT" => 'TRINIDAD AND TOBAGO',
                            "TN" => 'TUNISIA',
                            "TR" => 'TURKEY',
                            "TM" => 'TURKMENISTAN',
                            "TC" => 'TURKS AND CAICOS ISLANDS',
                            "TV" => 'TUVALU',
                            "UG" => 'UGANDA',
                            "UA" => 'UKRAINE',
                            "AE" => 'UNITED ARAB EMIRATES',
                            "GB" => 'UNITED KINGDOM',
                            "US" => 'UNITED STATES',
                            "UM" => 'UNITED STATES MINOR OUTLYING ISLANDS',
                            "UY" => 'URUGUAY',
                            "UZ" => 'UZBEKISTAN',
                            "VU" => 'VANUATU',
                            "VE" => 'VENEZUELA',
                            "VN" => 'VIET NAM',
                            "WF" => 'WALLIS AND FUTUNA ISLANDS',
                            "EH" => 'WESTERN SAHARA',
                            "YE" => 'YEMEN',
                            "ZM" => 'ZAMBIA',
                            "ZW" => 'ZIMBABWE');
        if(!is_string($str) || $str == '' || !array_key_exists($str, $country_arr)) {
            $this->form_validation->set_message('country_check', 'Incorrect country');
            return false;
        }else {
            return true;
        }
    }

    public function profile() {

        $us_info = $this->users->getMyUsers2(1, 0, 'id', $this->session->uid);

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security'); //надо для работы с xss_clean
        $this->load->library('form_validation');
        $this->load->library('authentication');

        $this->form_validation->set_rules('name', 'lang:name', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'max_length[50]', 'alpha'));
        $this->form_validation->set_rules('lastname', 'lang:last_name', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'max_length[50]', 'alpha'));
        $this->form_validation->set_rules('skype', 'skype', 'trim|htmlspecialchars|strip_tags|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobilenum', 'lang:mobile_num', 'trim|htmlspecialchars|strip_tags|xss_clean|numeric|max_length[17]');
        $this->form_validation->set_rules('country', 'country', 'required|callback_country_check');

        $settings = $this->settings->get_settings();

        if($this->form_validation->run() == FALSE) {
            $result = array('err' => 1, 'mess_name' => form_error('name', '', ''), 'mess_lname' => form_error('lastname', '', ''), 'mess_skype' => form_error('skype', '', ''), 'mess_mob' => form_error('mobilenum', '', ''), 'mess_country' => form_error('country', '', ''));
        }else {
            $this->users->updateUserInfo($this->session->uid);

            $result = array('err' => 0, 'mess' => $this->lang->line('mess_of_chs'));
        }

        echo json_encode($result);
    }
    public function gen_fin_pass() {
        $this->load->helper('string');
        $pass = random_string('alnum', 8);
        $hashed = password_hash($pass, PASSWORD_BCRYPT);
        $this->users->update_fin_pass($hashed, $this->session->uid);

        $res = array('status' => 1, 'code' => 'OK', 'desc' => $this->lang->line('success'));
        echo json_encode($res);

        $this->load->library('mailrotator');
        $user = $this->users->getUserById($this->session->uid);
        $usermail = $user['email'];

        $subject = 'FOLK COIN - ' . $this->lang->line('your_fin_pass');
        $message = sprintf($this->lang->line('fin_pass_msg'), $pass);
        $this->mailrotator->send($usermail, $subject, $message);
        redirect('cabinet/setting');
    }
    private function check_dates($start_date, $end_date) {
        $pattern = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
        if(preg_match($pattern, $start_date, $match) && preg_match($pattern, $end_date, $match)) {
            return true;
        }
        return false;
    }
    private function encode_login($str) {

        return bin2hex(base64_encode(str_replace('==', '',base64_encode($str))));

    }
    private function decode_login($str) {

        return base64_decode(base64_decode(hex2bin($str)). '==');

    }
    public function generate_reflink() {
        $this->load->helper('string');
        $link = '';

        // $link = '258647';
        // var_dump($this->users->get_user_by_reflink($link));
        // exit();

        do {
            $link = random_string('numeric', 6);
        } while ($this->users->get_user_by_reflink($link) != false);
        $this->users->set_reflink($this->session->uid, $link);
        $this->session->set_userdata('reflink', $link);
    }
    public function mail() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security'); //надо для работы с xss_clean
        $this->load->library('form_validation');

        $this->form_validation->set_rules('ulogin', 'lang:user_login', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]'));
        $this->form_validation->set_rules('title', 'lang:message_title', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[5]', 'max_length[400]'));
        $this->form_validation->set_rules('message', 'lang:message_body', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[5]'));
        $this->form_validation->set_rules('captcha', 'lang:captcha', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', array('captcha-check', array($this, 'check_captcha'))));


        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('mail_page');

        if($this->form_validation->run() == false) {
            $data['mail'] = $this->messages->get_messages($this->session->uid);
            if($this->session->uid != 1) {
                $data['captcha'] = $this->make_captcha();
                $this->session->set_userdata('captcha', $data['captcha']['word']);
            }
            $this->load->template('cabinet/mail', $data);
        } else {
            $this->session->unset_userdata('captcha');
            $receiver_id = $this->users->getIdByLogin($this->input->post('ulogin'));
            if($receiver_id['id'] == null) {
                $this->session->set_flashdata('no_such_user', true);
            } else if($this->users->get_blacklisted($receiver_id['id'], $this->session->uid)) {
                $this->session->set_flashdata('in_blacklist', true);
            } else {
                $this->messages->add_message($this->session->uid, $receiver_id['id']);
                $this->session->set_flashdata('message_sent', true);
            }
            redirect('cabinet/mail');
        }
    }
    public function logout() {
        delete_cookie('uid');
        delete_cookie('signed_info');
        if($this->session->ret_to_admin && $_SESSION['old']) {
            $data = $_SESSION['old'];
            $this->session->set_userdata($data);
            redirect('adminpanel');
        }
        $this->session->sess_destroy();
        redirect('welcome');
    }
    /*
        end adding funcs
    */


    /*
    moder ad
    */
    public function traffic_projects($type = '') {

        $data = $this->data;

        $data['bans'] = $this->comp->getBansForShow(array('text_ad' => 4, 'ban_ad' => array('125x125' => 7, '300x250' => 0, '468x60' => 5, '728x90' => 1)), array('lang' => get_cookie('lang')));

        $data['setts'] = $this->comp->get_setts();

        $arr_for_search = array('s_0', 's_1', 's_2', 's_3', 'o_0', 'o_1', 'o_2', 'reset');



        if(is_string($type) && $type != '' && in_array($type, $arr_for_search)) {
          switch ($type) {
            case 'reset':
              if(isset($_SESSION['filter_status'])) {
                unset($_SESSION['filter_status']);
              }
              if(isset($_SESSION['filter_format'])) {
                unset($_SESSION['filter_format']);
              }
              if(isset($_SESSION['filter_order'])) {
                unset($_SESSION['filter_order']);
              }
              break;
            case 's_0':
              if(isset($_SESSION['filter_status'])) {
                unset($_SESSION['filter_status']);
              }
              break;
            case 's_1':
            case 's_2':
            case 's_3':
              $_SESSION['filter_status'] = $type;
              break;
            case 'o_0':
              if(isset($_SESSION['filter_order'])) {
                unset($_SESSION['filter_order']);
              }
              break;
            case 'o_1':
            case 'o_2':
              $_SESSION['filter_order'] = $type;
              break;
          }
        }

        if(isset($_SESSION['filter_status'])) {
          $f_st = $_SESSION['filter_status'];
        }else {
          $f_st = '';
        }

        if(isset($_SESSION['filter_order'])) {
          $f_od = $_SESSION['filter_order'];
        }else {
          $f_od = '';
        }

        $this->load->model('Marketing_model', 'mark');
        $data['mark_sett'] = $this->mark->get_all_mark_setts();

        $this->load->model('Traffic_model', 'traf');
        $this->load->model('Traffic_construct_model', 'traf_c');

        $data['comps'] = $this->traf->take_my_proj($_SESSION['uid'], $f_st, $f_fm, $f_od);
        $data['countries'] = $this->traf_c->get_countries_for_conf();
        $data['all_active_categs'] = $this->traf_c->get_isset_countries_categories();

        $data['site_name'] = 'Traffic projects';

        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

        $this->load->template('cabinet/traffic_projects', $data);
    }


    public function add_traffic_projects() {
      if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
          echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('traf_projs_25')));
          exit();
      }else {
        $this->load->model('Traffic_model', 'traf');
        $this->traf->add_new_tproj($_SESSION['uid'], $_POST['url'], $_POST['cr_country']);
        echo json_encode(array('err' => 0, 'mess' => $this->lang->line('traf_projs_28')));
        exit();
      }
    }
    public function ch_traffic_projects() {
        if(isset($_POST['ID']) && is_numeric($_POST['ID'])) {
            $id = $_POST['ID'];
            if(!isset($_POST['url']) || $_POST['url'] == '' || !preg_match('/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})/', $_POST['url'])) {
                echo json_encode(array('err' => 1, 'error_field' => 'url', 'mess' => $this->lang->line('traf_projs_25')));
                exit();
            }else{
              $this->load->model('Traffic_model', 'traf');
              if($this->traf->check_traffic_projects_lord($_SESSION['uid'], $id)) {
                $this->traf->ch_traffic_projects($id, $_SESSION['uid'], $_POST['url']);

                echo json_encode(array('err' => 0));
                exit();
              }else {
                echo json_encode(array('err' => 1, 'mess' => $this->lang->line('traf_projs_26')));
                exit();
              }
            }
        }
    }
    public function up_bal_traf_proj() {
        if(!isset($_POST['ID']) || (isset($_POST['ID']) && !is_numeric($_POST['ID']))) {
            echo json_encode(array('err' => 1, 'error_field' => 'buying_create', 'mess' => $this->lang->line('traf_projs_26')));
            exit();
        }else {
          if($actual_mark_conf = $this->mark->get_mark_setts($_POST['packet'])) {
            if($this->mark->try_add_to_queue($_SESSION['uid'], $_POST['packet'])) {

              $info = json_decode($actual_mark_conf['value'], true);

              $this->load->model('Traffic_model', 'traf');
              $this->traf->add_balance_tproj($_POST['ID'], $_SESSION['uid'], $_POST['country'], $info['adding_count']);
              $this->mark->add_to_queue($_SESSION['uid'], $_POST['packet']);
              echo json_encode(array('err' => 0));
              exit();
            }else{
              echo json_encode(array('err' => 1, 'error_field' => 'money', 'mess' => $this->lang->line('traf_projs_27')));
              exit();
            }
          }else{
            echo json_encode(array('err' => 1, 'error_field' => 'buying_create', 'mess' => $this->lang->line('traf_projs_26')));
            exit();
          }
        }
        echo json_encode($result);
    }
    public function del_traffic_projects($id) {

        $this->load->model('Traffic_model', 'traf');

        $this->traf->del($_SESSION['uid'], $id);

        $_SESSION['del_b'] = $this->lang->line('traf_projs_29');

        redirect('cabinet/traffic_projects');
    }
    /*
    end moder ad
    */

}
