<?php
// exit();
defined('BASEPATH') OR exit('No direct script access allowed');

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

class Marketing_test extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->model('user_model', 'users');
      $this->load->model('settings_model');
      $this->load->library('authentication');
      $lang = 'english';
      $this->config->set_item('language', $lang);
      $this->lang->load('common_site', $lang);

      if(!$this->authentication->is_admin() && $this->router->fetch_method() != 'login') {
          redirect('adminpanel/login');
      }
    }
  
  public function com_perc_pool_change() {
    $this->load->model('Marketing_model', 'mark');
    $this->mark->com_perc_pool_change($_POST['oper'], $_POST['sum']);
    redirect("/marketing_test/conf_page");
  }
  public function com_pool_change() {
    $this->load->model('Marketing_model', 'mark');
    $this->mark->com_pool_change($_POST['oper'], $_POST['sum']);
    redirect("/marketing_test/conf_page");
  }
  public function com_distr_part_pool_change() {
    $this->load->model('Marketing_model', 'mark');
    $this->mark->com_distr_part_pool_change($_POST['oper'], $_POST['sum']);
    redirect("/marketing_test/conf_page");
  }
  public function conf_page() {
    $this->load->model('Marketing_model', 'mark');
    $setts = $this->mark->get_setts();

    $setts['active_all_scales_count'] = $this->mark->get_count_active_scales();

    $this->load->template('marketing_test/conf_page', $setts, false, true);
  }
  public function create_setts() {
    $this->load->model('Marketing_model', 'mark');
    $setts = $this->mark->create_mark_setts();
  }
  public function look_lvl($type = '') {
    $this->load->model('Marketing_model', 'mark');

    $empty = false;

    if($type != '') {
      // echo $type;exit();
      $arr = explode('_', $type);
      $_SESSION['filter_'.$arr[0]] = $arr[1];
      Header('Location: /marketing_test/look_lvl');
      exit();
    }

    if(isset($_POST['Save_Curr_Sum'])) {
        $this->mark->save_curr_sum($_POST['curr_value'], $_POST['curr_sum']);
        Header('Location: /marketing_test/look_lvl');
        exit();  
    }

    // unset($_SESSION['lvl']);
    // unset($_SESSION['type']);

    // var_dump($_SESSION);exit();

    // if(isset($_POST['lvl']) && isset($_POST['type'])) {
    //   $_SESSION['lvl'] = $_POST['lvl'];
    //   $_SESSION['type'] = $_POST['type'];
    //   Header('Location: /marketing_test/look_lvl');
    //   exit();
    // }elseif(isset($_SESSION['lvl']) && isset($_SESSION['type'])) {
    //   $lvl = $_SESSION['lvl'];
    //   $type = $_SESSION['type'];
    // }else {
    //   $empty = true;
    // }

    if($empty) {
      $this->load->template('marketing_test/look_lvl', array(), false, true);
    }else {
      // $scales = $this->mark->get_level($lvl, $type);
      
      $arr_type = [];

      for ($v=1; $v <= 42; $v++) { 
        $arr_type[$v] = 'all';
      }

      $scales = $this->mark->get_all_levels($arr_type);

      $this->load->template('marketing_test/look_lvl', array('scales' => $scales), false, true);

    }
  }
  public function spec_hyst($id) {
    $this->load->model('Marketing_model', 'mark');
    $hyst_arr = $this->mark->get_all_spec_hyst($id);

    $real_arr = explode('_', $id);
    for($i = 0; $i < count($hyst_arr); $i++) {
        echo '<tr class="table_for_delete_'.$real_arr[0].'_'.$real_arr[1].'">';
          
        $reason_arr = json_decode($hyst_arr[$i]['reason']);

        switch ($reason_arr->event) {
          case 'up_lvl_scale':
            $event = 'add to upper level scale';
            break;
          case 'up_sponsor':
            $event = 'sponsor bonus';
            break;
          case 'up_team':
            $event = 'team bonus';
            break;
          case 'up_by_community_baklen_pool':
            $event = 'up community baklen pool';
            break;
          case 'up_i_pool':
            $event = 'up invest pool';
            break;
          case 'up_l_pool':
            $event = 'up liga pool';
            break;
          case 'up_gr_pool':
            $event = 'up grunder pool';
            break;
          case 'up_sysbill':
            $event = 'up kosten';
            break;
          case 'up_stripes_payment':
            $event = 'up stripes payment';
            break;
          case 'up_rest':
            $event = 'up rest';
            break;
          case 'up_tax':
            $event = 'up tax';
            break;

        }

        switch ($reason_arr->type) {
          case 'comm_bakl_pool':
              echo '<td colspan="2">Community Baklen Pool refills<br>('.$event.')</td>';
              break;
          case 'lvl_1':
              echo '<td colspan="2">Closed scale at lvl 1 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_2':
              echo '<td colspan="2">Closed scale at lvl 2 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_3':
              echo '<td colspan="2">Closed scale at lvl 3 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_4':
              echo '<td colspan="2">Closed scale at lvl 4 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_5':
              echo '<td colspan="2">Closed scale at lvl 5 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_6':
              echo '<td colspan="2">Closed scale at lvl 6 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_7':
              echo '<td colspan="2">Closed scale at lvl 7 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_8':
              echo '<td colspan="2">Closed scale at lvl 8 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_9':
              echo '<td colspan="2">Closed scale at lvl 9 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_10':
              echo '<td colspan="2">Closed scale at lvl 10 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_11':
              echo '<td colspan="2">Closed scale at lvl 11 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_12':
              echo '<td colspan="2">Closed scale at lvl 12 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_13':
              echo '<td colspan="2">Closed scale at lvl 13 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_14':
              echo '<td colspan="2">Closed scale at lvl 14 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_15':
              echo '<td colspan="2">Closed scale at lvl 15 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_16':
              echo '<td colspan="2">Closed scale at lvl 16 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_17':
              echo '<td colspan="2">Closed scale at lvl 17 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_18':
              echo '<td colspan="2">Closed scale at lvl 18 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_19':
              echo '<td colspan="2">Closed scale at lvl 19 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_20':
              echo '<td colspan="2">Closed scale at lvl 20 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_21':
              echo '<td colspan="2">Closed scale at lvl 21 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_22':
              echo '<td colspan="2">Closed scale at lvl 22 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_23':
              echo '<td colspan="2">Closed scale at lvl 23 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_24':
              echo '<td colspan="2">Closed scale at lvl 24 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_25':
              echo '<td colspan="2">Closed scale at lvl 25 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_26':
              echo '<td colspan="2">Closed scale at lvl 26 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_27':
              echo '<td colspan="2">Closed scale at lvl 27 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_28':
              echo '<td colspan="2">Closed scale at lvl 28 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_29':
              echo '<td colspan="2">Closed scale at lvl 29 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_30':
              echo '<td colspan="2">Closed scale at lvl 30 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_31':
              echo '<td colspan="2">Closed scale at lvl 31 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_32':
              echo '<td colspan="2">Closed scale at lvl 32 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_33':
              echo '<td colspan="2">Closed scale at lvl 33 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_34':
              echo '<td colspan="2">Closed scale at lvl 34 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_35':
              echo '<td colspan="2">Closed scale at lvl 35 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_36':
              echo '<td colspan="2">Closed scale at lvl 36 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_37':
              echo '<td colspan="2">Closed scale at lvl 37 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_38':
              echo '<td colspan="2">Closed scale at lvl 38 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_39':
              echo '<td colspan="2">Closed scale at lvl 39 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_40':
              echo '<td colspan="2">Closed scale at lvl 40 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_41':
              echo '<td colspan="2">Closed scale at lvl 41 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'lvl_42':
              echo '<td colspan="2">Closed scale at lvl 42 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'packet_1':
              echo '<td colspan="2">Buying packet 1 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'packet_2':
              echo '<td colspan="2">Buying packet 2 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'packet_3':
              echo '<td colspan="2">Buying packet 3 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'packet_4':
              echo '<td colspan="2">Buying packet 4 by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'active_1':
              echo '<td colspan="2">Activation (1) by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'active_2':
              echo '<td colspan="2">Activation (2) by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'active_3':
              echo '<td colspan="2">Activation (3) by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'active_4':
              echo '<td colspan="2">Activation (4) by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'active_5':
              echo '<td colspan="2">Activation (5) by user - '.$reason_arr->uid.'<br>up to scale with id - '.$reason_arr->scid.' at lvl - '.$reason_arr->lvl.'<br>('.$event.')</td>';
              break;
          case 'spec_scale_reffs':
              echo '<td colspan="2">Manual refills</td>';
            break;
        }
          
        echo '<td colspan="2">'.$hyst_arr[$i]['sum'].'</td>';

        echo '<td colspan="2">'.date('d.m.Y H:i:s', $hyst_arr[$i]['date']).'</td>';

        echo '</tr>';
    }
  }
  public function mark_setts_page($type = '') {
    
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $this->load->model('Marketing_model', 'mark');
    $this->load->model('Traffic_construct_model', 'tc');

    if(isset($_POST['Save'])) {
      $this->mark->save_mark_setts($_POST);
      Header('Location: /marketing_test/mark_setts_page');
      exit();
    }

    $this->load->template('marketing_test/mark_setts', array('type' => $type, 'categs' => $this->tc->get_categories_for_conf(), 'setts' => $this->mark->get_all_mark_setts()), false, true);
  }
  public function user_page() {
    $this->load->model('Marketing_model', 'mark');

    // $this->mark->create_many_users();exit();

    $empty = false;

    if(isset($_POST['Create'])) {
      $this->mark->create_user($_POST['login'], $_POST['idsponsor'], $_POST['balance']);
      Header('Location: /marketing_test/user_page');
      exit();
    }

    if(isset($_POST['Resave'])) {
      $this->mark->re_save_user($_POST['uid'], $_POST['idsponsor'], $_POST['balance']);
      Header('Location: /marketing_test/user_page');
      exit();
    }
    
    if(isset($_POST['type_us']) && $_POST['type_us'] == 'empty'){
      $empty = true;
      $_SESSION['type_us'] = "empty";
    }elseif(isset($_POST['type_us']) && ($_POST['type_us'] == 'login' || $_POST['type_us'] == 'id')) {
      $_SESSION['type_us'] = $_POST['type_us'];
      $_SESSION['val_us'] = $_POST['val_us'];
      Header('Location: /marketing_test/user_page');
      exit();
    }elseif(isset($_SESSION['type_us']) && isset($_SESSION['val_us'])) {
      $type = $_SESSION['type_us'];
      $val = $_SESSION['val_us'];
    }else {
      $empty = true;
    }

    if( (isset($_SESSION['type_us']) && $_SESSION['type_us'] == 'empty') || $empty) {
      $us_info = $this->mark->get_us_info('empty');
    }else {
      $us_info = $this->mark->get_us_info($type, $val);
    }

    $all_users = $this->mark->get_all_users();

    $this->load->template('marketing_test/user_page', array('user' => $us_info, 'users' => $all_users), false, true);
  }
  public function hyst_page() {
    $this->load->model('Marketing_model', 'mark');

    $empty = false;

    if(isset($_POST['type']) && is_numeric($_POST['type']) && ($_POST['type'] >= 1 && $_POST['type'] <= 4)) {

      $type = $_POST['type'];
      
      switch ($_POST['type']) {
        case 1:
        case 2:
        case 3:
        case 4:
          if(isset($_POST['val']) && is_string($_POST['val'])) {
            $val = $_POST['val'];
          }
          break;
      }

      $_SESSION['type'] = $type;
      $_SESSION['val'] = $val;
      Header('Location: /marketing_test/hyst_page');
      exit();

    }elseif(isset($_SESSION['type']) && isset($_SESSION['val'])) {
      $type = $_SESSION['type'];
      $val = $_SESSION['val'];
    }else {
      $empty = true;
    }

    if($empty) {
      $hyst = $this->mark->get_hyst('empty');
    }else {
      $hyst = $this->mark->get_hyst($type, $val);
    }
    $this->load->template('marketing_test/hyst_page', array('hyst' => $hyst), false, true);
  }
  public function spec_hyst_page(){
    $this->load->model('Marketing_model', 'mark');

    $empty = false;

    if(isset($_POST['type']) && is_numeric($_POST['type']) && ($_POST['type'] >= 1 && $_POST['type'] <= 5)) {

      $type = $_POST['type'];
      
      switch ($_POST['type']) {
        case 1:
        case 2:
        case 3:
        case 4:
          if(isset($_POST['val']) && is_string($_POST['val'])) {
            $val = $_POST['val'];
          }
          break;
      }

      $_SESSION['type_2'] = $type;
      $_SESSION['val_2'] = $val;
      Header('Location: /marketing_test/spec_hyst_page');
      exit();

    }elseif(isset($_SESSION['type_2']) && isset($_SESSION['val_2'])) {
      $type = $_SESSION['type_2'];
      $val = $_SESSION['val_2'];
    }else {
      $empty = true;
    }

    if($empty) {
      $hyst = $this->mark->get_spec_hyst('empty');
    }else {
      $hyst = $this->mark->get_spec_hyst($type, $val);
    }
    $this->load->template('marketing_test/spec_hyst_page', array('hyst' => $hyst), false, true);
  }
  public function panel_page(){
    $this->load->model('Marketing_model', 'mark');
    if(isset($_POST['type_action'])) {
      switch ($_POST['type_action']) {
        case '1':
          $arr = $this->mark->get_uid_by_login($_POST['login']);
          if($this->mark->buy_scale('packet_'.$_POST['packet'], $arr['id'])) {
            $_SESSION['resb'] = 'Buying successfull';
            $_SESSION['typeb'] = 'success';
          }else {
            $_SESSION['resb'] = 'User '.$_POST['login'].' already has scale';
            $_SESSION['typeb'] = 'error';
          }
          break;
        case '2':
          for($i = $_POST['id_begin']; $i <= $_POST['id_end']; $i++) {
            $this->mark->buy_scale('packet_'.$_POST['packet'], $i);
          }
          break;
        case '3':
          $arr = $this->mark->get_uid_by_login($_POST['login']);
          $this->mark->buy_scale('active_'.$_POST['active'], $arr['id']);
          break;
        case '4':
          for($i = $_POST['id_begin']; $i <= $_POST['id_end']; $i++) {
            $this->mark->buy_scale('active_'.$_POST['packet'], $i);
          }
          break;
        case '5':
          if($_POST['restart_system'] != '') {
            $this->mark->system_zero();
          }
          break;
        case '6':
          $this->mark->start_pool_distribution($_POST['pool']);
          break;
        default:
          # code...
          break;
      }
      Header('Location: /marketing_test/panel_page');
      exit();
    }
    $this->load->template('marketing_test/panel_page', array(), false, true);
  }

  public function queue_start() {
    ini_set('max_execution_time', 900);
    $this->load->model('Marketing_model', 'mark');
    $a = time();
    $this->mark->queue_take();
    $b = time();
    echo $b-$a;
  }
}
