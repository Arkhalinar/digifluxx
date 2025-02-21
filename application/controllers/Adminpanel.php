<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

class Adminpanel extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->load->model('tree_model', 'tree');
        $this->load->model('user_model', 'users');
        $this->load->model('settings_model');
        // $this->load->library('mlm');
        $this->load->library('authentication');
        if(get_cookie('lang') == null)
            $lang = 'english';
        else if(in_array(get_cookie('lang'), array('russian', 'english', 'german'))) {
            $lang = get_cookie('lang');
        } else {
            $lang = 'english';
        }
        // $lang = 'russian';
        // $lang = 'english';
        $this->config->set_item('language', $lang);
        $this->lang->load('common_site', $lang);

        if(!$this->authentication->is_admin() && $this->router->fetch_method() != 'login') {
            redirect('adminpanel/login');
        }

        $this->load->setPath('admin');

        
        $this->load->model('messages_model', 'messages');
        $msgs = $this->messages->get_unread($this->session->uid);
        $this->session->set_flashdata('new_messages', $msgs);
    }


    public function comm_pool_mess() {
      $this->load->model('Marketing_model', 'mark');
      $data['comm_pool_mess'] = $this->mark->get_pool_mess();

      if(isset($_POST['save_pool_mess'])) {
        $this->mark->edit_pool_mess($_POST['eng'], $_POST['rus'], $_POST['ger']);
        redirect("/adminpanel/comm_pool_mess");
      }

      $this->load->template('admin/comm_pool_mess', $data);
    }


    public function category_panel($page = 0) {
        $this->load->model('Traffic_construct_model', 'tc');
        $data['packets'] = $this->tc->get_categories();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Constructor';
        $this->load->template('admin/tcat_panel', $data);
    }
    public function category_create() {
        $this->load->model('Traffic_construct_model', 'tc');

        $data['page_name'] = 'Category page';

        $form_check = false;

        if(isset($_POST['save'])) {
            $this->tc->add_category($_POST['name']);
            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_tcat', $data);
        }else {
            redirect("/adminpanel/category_panel");
        }
    }
    public function category_edit($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $this->load->model('Traffic_construct_model', 'tc');
        $data['packet'] = $this->tc->get_category($id);
        
        if(isset($_POST['save'])) {
            $this->tc->edit_category($id, $_POST['name']);
            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_tcat', $data);
        }else {
            redirect("/adminpanel/category_panel");
        }
    }




    public function traf_proj_panel($page = 0) {
        $this->load->model('Project_model', 'prj');
        $data['packets'] = $this->prj->get_projects();
        $data['page_name'] = 'Constructor';

        $this->load->template('admin/proj_panel', $data);
    }
    public function traf_proj_create() {
        $this->load->model('Project_model', 'prj');

        $data['page_name'] = 'Category page';

        $form_check = false;

        if(isset($_POST['save'])) {

          $project_data = [];

          if($_POST['detail_type_cont'] == 'iframe') {
            $project_data['add_info'] = json_encode(['type' => 'iframe', 'height' => $_POST['height'], 'url' => $_POST['iframe_url']]);
            $project_data['body'] = "";
          }else{
            $project_data['add_info'] = json_encode(['type' => 'html']);
            $project_data['body'] = $_POST['body'];
          }

          if($_POST['type_cont'] == 'file')  {
              if(empty($_FILES['uploadfile']['tmp_name'])) {
                  echo json_encode(array('err' => 1, 'error_field' => 'file', 'mess' => $this->lang->line('cab_new_25')));
                  exit();
              }else {

                  if($_FILES['uploadfile']['error'] != 0) {
                      switch ($_FILES['uploadfile']['error']) {
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
                      $mime = (string) finfo_file($fi, $_FILES['uploadfile']['tmp_name']);
                      // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
                      if (strpos($mime, 'image') !== false){
                          $this->load->library('SimpleImage');

                         $image = new SimpleImage();

                          try
                          {
                              // $imagick = new \Imagick($_FILES['uploadfile']['tmp_name']);
                              // var_dump($imagick->valid());

                              if($image->load($_FILES['uploadfile']['tmp_name'])) {

                                    @$image_info = getimagesize($_FILES['uploadfile']['tmp_name']);

                                    if($image_info[2]  == IMAGETYPE_JPEG ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                    }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                    }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                    }

                                    $project_data['type'] = $_POST['type_cont'];
                                    $project_data['header'] = $_POST['header'];
                                    $project_data['img'] = $name;
                                    $project_data['url'] = $_POST['url'];
                                    $project_data['ref_url_for_check'] = $_POST['ref_url_for_check'];
                                    
                                    $this->prj->cr_new_project($project_data);
                                    $form_check = true;

                                    if($image_info[2]  == IMAGETYPE_JPEG ) {
                                        $image->save($name, $image_info[2]);
                                    }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                        $image->save($name, $image_info[2], 75, NULL, $_FILES['uploadfile']['tmp_name']);
                                    }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                        $image->save($name, $image_info[2]);
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
                  if($image->load($_POST['uploadfile'])) {

                    $project_data['type'] = $_POST['type_cont'];
                    $project_data['header'] = $_POST['header'];
                    $project_data['img'] = $_POST['uploadfile'];
                    $project_data['url'] = $_POST['url'];
                    $project_data['ref_url_for_check'] = $_POST['ref_url_for_check'];

                    $this->prj->cr_new_project($project_data);
                    $form_check = true;

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

        if($form_check == false) {
            $this->load->template('admin/add_proj', $data);
        }else {
            redirect("/adminpanel/traf_proj_panel");
        }
    }
    public function traf_proj_edit($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $form_check = false;

        $this->load->model('Project_model', 'prj');
        $data['packet'] = $this->prj->take_project($id);
        
        if(isset($_POST['save'])) {

            $project_data = ['id'=>$id, 'header' => $_POST['header'], 'url' => $_POST['url'], 'ref_url_for_check' => $_POST['ref_url_for_check']];

            if($_POST['detail_type_cont'] == 'iframe') {
              $project_data['add_info'] = json_encode(['type' => 'iframe', 'height' => $_POST['height'], 'url' => $_POST['iframe_url']]);
              $project_data['body'] = "";
            }else{
              $project_data['add_info'] = json_encode(['type' => 'html']);
              $project_data['body'] = $_POST['body'];
            }

            if($_POST['type_cont'] == 'file')  {
              if(!empty($_FILES['uploadfile']['tmp_name'])) {
                  if($_FILES['uploadfile']['error'] != 0) {
                      switch ($_FILES['uploadfile']['error']) {
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
                      $mime = (string) finfo_file($fi, $_FILES['uploadfile']['tmp_name']);
                      // Проверим ключевое слово image (image/jpeg, image/png и т. д.)
                      if (strpos($mime, 'image') !== false){
                          $this->load->library('SimpleImage');

                         $image = new SimpleImage();

                          try
                          {
                              // $imagick = new \Imagick($_FILES['uploadfile']['tmp_name']);
                              // var_dump($imagick->valid());

                              if($image->load($_FILES['uploadfile']['tmp_name'])) {

                                    @$image_info = getimagesize($_FILES['uploadfile']['tmp_name']);

                                    if($image_info[2]  == IMAGETYPE_JPEG ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                    }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                    }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                        $name = 'spproj/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                    }
                                    $project_data['img'] = $name;
                                    $project_data['type'] = $_POST['type_cont'];

                                    if($image_info[2]  == IMAGETYPE_JPEG ) {
                                        $image->save($name, $image_info[2]);
                                    }elseif($image_info[2]  == IMAGETYPE_GIF ) {
                                        $image->save($name, $image_info[2], 75, NULL, $_FILES['uploadfile']['tmp_name']);
                                    }elseif($image_info[2]  == IMAGETYPE_PNG ) {
                                        $image->save($name, $image_info[2]);
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
                  if($image->load($_POST['uploadfile'])) {

                    $project_data['img'] = $_POST['uploadfile'];
                    $project_data['type'] = $_POST['type_cont'];

                 }else {
                      echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                      exit();
                 }
              }catch (\Exception $e) {
                  echo json_encode(array('err' => 1, 'error_field' => 'file_url', 'mess' => $this->lang->line('cab_new_32')));
                  exit();
              }
            }

            $this->prj->admin_ed_project($project_data);
            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_proj', $data);
        }else {
            redirect("/adminpanel/traf_proj_panel");
        }
    }
    public function traf_proj_del($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $this->load->model('Project_model', 'prj');
        $this->prj->dl_project($id);
        redirect("/adminpanel/traf_proj_panel");
    }





    public function country_panel($page = 0) {
        $this->load->model('Traffic_construct_model', 'tc');
        $data['countries'] = $this->tc->get_countries();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Constructor';
        $this->load->template('admin/tc_panel', $data);
    }
    public function country_create() {
        $this->load->model('Traffic_construct_model', 'tc');
        $data['categs'] = $this->tc->get_categories();

        $data['page_name'] = 'Packet page';

        $form_check = false;

        if(isset($_POST['save'])) {
            $this->tc->add_country($_POST['name'], $_POST['cid']);
            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_tc', $data);
        }else {
            redirect("/adminpanel/country_panel");
        }
    }
    public function country_edit($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $this->load->model('Traffic_construct_model', 'tc');
        $data['categs'] = $this->tc->get_categories();
        $data['packet'] = $this->tc->get_country($id);
        
        if(isset($_POST['save'])) {
            $this->tc->edit_country($id, $_POST['name'], $_POST['cid']);
            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_tc', $data);
        }else {
            redirect("/adminpanel/country_panel");
        }
    }
    public function country_del($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $this->load->model('Traffic_construct_model', 'tc');
        $this->tc->del_country($id);

        redirect("/adminpanel/country_panel");

    }









    public function pre_ad_panel($page = 0) {
        $this->load->model('Pre_enter_ad_model', 'pre_ad');
        $data['blocks'] = $this->pre_ad->GetBlocks();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Pre_ad_view';
        $this->load->template('admin/pre_ad_panel', $data);
    }
    public function pre_ad_create() {
        $this->load->model('Pre_enter_ad_model', 'pre_ad');

        $data['page_name'] = 'Packet page';

        $form_check = false;

        if(isset($_POST['save']))
        {

            if($_POST['type_left'] == '-')
            {
                $block_1 = NULL;
            }
            else
            {

                switch ($_POST['type_left'])
                {
                    case 'text':
                        $content = $_POST['text_left'];
                        break;
                    case 'img':
                        if($_POST['type_img'] == 'dwnl')
                        {

                            if(empty($_FILES['left_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['left_img']['error'] != 0)
                                {
                                    switch ($_FILES['left_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['left_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['left_img']['tmp_name']))
                                            {
                                                if($_POST['size_left'] == '125x125' || $_POST['size_left'] == '300x50' || $_POST['size_left'] == '300x250' || $_POST['size_left'] == '300x600' || $_POST['size_left'] == '468x60' || $_POST['size_left'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_left']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['left_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['left_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }

                        }
                        elseif($_POST['type_img'] == 'link')
                        {
                            $content = $_POST['link_left'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_left'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_1 = json_encode([
                                        'type' => $_POST['type_left'],
                                        'content' => $content
                                    ]);
            }

            if($_POST['type_mid'] == '-')
            {
                $block_2 = NULL;
            }
            else
            {

                switch ($_POST['type_mid'])
                {
                    case 'text':
                        $content = $_POST['text_mid'];
                        break;
                    case 'img':
                        if($_POST['type_img_mid'] == 'dwnl')
                        {

                            if(empty($_FILES['mid_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['mid_img']['error'] != 0)
                                {
                                    switch ($_FILES['mid_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['mid_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['mid_img']['tmp_name']))
                                            {
                                                if($_POST['size_mid'] == '125x125' || $_POST['size_mid'] == '300x50' || $_POST['size_mid'] == '300x250' || $_POST['size_mid'] == '300x600' || $_POST['size_mid'] == '468x60' || $_POST['size_mid'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_mid']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['mid_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['mid_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }

                        }
                        elseif($_POST['type_img_mid'] == 'link')
                        {
                            $content = $_POST['link_mid'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_mid'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_2 = json_encode([
                                        'type' => $_POST['type_mid'],
                                        'content' => $content
                                    ]);
            }

            if($_POST['type_right'] == '-')
            {
                $block_3 = NULL;
            }
            else
            {

                switch ($_POST['type_right'])
                {
                    case 'text':
                        $content = $_POST['text_right'];
                        break;
                    case 'img':
                        if($_POST['type_img_right'] == 'dwnl')
                            if(empty($_FILES['right_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['right_img']['error'] != 0)
                                {
                                    switch ($_FILES['right_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['right_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['right_img']['tmp_name']))
                                            {
                                                if($_POST['size_right'] == '125x125' || $_POST['size_right'] == '300x50' || $_POST['size_right'] == '300x250' || $_POST['size_right'] == '300x600' || $_POST['size_right'] == '468x60' || $_POST['size_right'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_right']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['right_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['right_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }
                        elseif($_POST['type_img_right'] == 'link')
                        {
                            $content = $_POST['link_right'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_right'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_3 = json_encode([
                                        'type' => $_POST['type_right'],
                                        'content' => $content
                                    ]);
            }

            $info = [
                    'block_1' => $block_1,
                    'block_2' => $block_2,
                    'block_3' => $block_3,
                    'lang' => $_POST['lang'],
                    'status' => $_POST['status']
                    ];

            $form_check = true;
        }

        if($form_check == false || isset($_SESSION['err_pre_enter_ad1']) || isset($_SESSION['err_pre_enter_ad2']) || isset($_SESSION['err_pre_enter_ad3']))
        {
            $this->load->template('admin/pre_ad_create', $data);
        }
        else
        {
            $this->pre_ad->CreateNewBlock($info);
            redirect("/adminpanel/pre_ad_panel");
        }
    }
    public function pre_ad_del($id) {
        $this->load->model('Pre_enter_ad_model', 'pre_ad');
        $this->pre_ad->DeleteBlock(['id' => $id]);
        redirect("/adminpanel/pre_ad_panel");
    }
    public function pre_ad_edit($id) {

        $this->load->model('Pre_enter_ad_model', 'pre_ad');

        $data['page_name'] = 'Packet page';

        $form_check = false;

        if(isset($_POST['save']))
        {

            if($_POST['type_left'] == '-')
            {
                $block_1 = NULL;
            }
            else
            {

                switch ($_POST['type_left'])
                {
                    case 'text':
                        $content = $_POST['text_left'];
                        break;
                    case 'img':
                        if($_POST['type_img'] == 'dwnl')
                        {

                            if(empty($_FILES['left_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['left_img']['error'] != 0)
                                {
                                    switch ($_FILES['left_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['left_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['left_img']['tmp_name']))
                                            {
                                                if($_POST['size_left'] == '125x125' || $_POST['size_left'] == '300x50' || $_POST['size_left'] == '300x250' || $_POST['size_left'] == '300x600' || $_POST['size_left'] == '468x60' || $_POST['size_left'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_left']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['left_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['left_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad1'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }

                        }
                        elseif($_POST['type_img'] == 'link')
                        {
                            $content = $_POST['link_left'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_left'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_1 = json_encode([
                                        'type' => $_POST['type_left'],
                                        'content' => $content
                                    ]);
            }

            if($_POST['type_mid'] == '-')
            {
                $block_2 = NULL;
            }
            else
            {

                switch ($_POST['type_mid'])
                {
                    case 'text':
                        $content = $_POST['text_mid'];
                        break;
                    case 'img':
                        if($_POST['type_img_mid'] == 'dwnl')
                        {

                            if(empty($_FILES['mid_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['mid_img']['error'] != 0)
                                {
                                    switch ($_FILES['mid_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['mid_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['mid_img']['tmp_name']))
                                            {
                                                if($_POST['size_mid'] == '125x125' || $_POST['size_mid'] == '300x50' || $_POST['size_mid'] == '300x250' || $_POST['size_mid'] == '300x600' || $_POST['size_mid'] == '468x60' || $_POST['size_mid'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_mid']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['mid_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['mid_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad2'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }

                        }
                        elseif($_POST['type_img_mid'] == 'link')
                        {
                            $content = $_POST['link_mid'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_mid'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_2 = json_encode([
                                        'type' => $_POST['type_mid'],
                                        'content' => $content
                                    ]);
            }

            if($_POST['type_right'] == '-')
            {
                $block_3 = NULL;
            }
            else
            {

                switch ($_POST['type_right'])
                {
                    case 'text':
                        $content = $_POST['text_right'];
                        break;
                    case 'img':
                        if($_POST['type_img_right'] == 'dwnl')
                            if(empty($_FILES['right_img']['tmp_name']))
                            {
                                $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_25');
                            }
                            else
                            {
                                if($_FILES['right_img']['error'] != 0)
                                {
                                    switch ($_FILES['right_img']['error'])
                                    {
                                        case '1':
                                        case '2':
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_26');
                                            break;

                                        case '3':
                                        case '4':
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_27');
                                            break;

                                        default:
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_27');
                                            break;
                                    } 
                                }
                                else
                                {
                                    $fi = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime = (string) finfo_file($fi, $_FILES['right_img']['tmp_name']);
                                    if(strpos($mime, 'image') !== false)
                                    {
                                        $this->load->library('SimpleImage');
                                        $image = new SimpleImage();

                                        try
                                        {

                                            if($image->load($_FILES['right_img']['tmp_name']))
                                            {
                                                if($_POST['size_right'] == '125x125' || $_POST['size_right'] == '300x50' || $_POST['size_right'] == '300x250' || $_POST['size_right'] == '300x600' || $_POST['size_right'] == '468x60' || $_POST['size_right'] == '728x90')
                                                {

                                                    $arr_of_size = explode('x', $_POST['size_right']);

                                                    if($arr_of_size[0] != $image->getWidth() && $arr_of_size[1] != $image->getHeight())
                                                    {
                                                        $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_29');
                                                    }
                                                    else
                                                    {
                                                        @$image_info = getimagesize($_FILES['right_img']['tmp_name']);

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.jpg';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.gif';
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $name = 'pre_enter/'.rand(1,100).rand(1,100).time().rand(1,100).rand(1,100).'.png';
                                                        }

                                                        if($image_info[2]  == IMAGETYPE_JPEG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_GIF )
                                                        {
                                                            $image->save($name, $image_info[2], 75, NULL, $_FILES['right_img']['tmp_name']);
                                                        }
                                                        elseif($image_info[2]  == IMAGETYPE_PNG )
                                                        {
                                                            $image->resize($arr_of_size[0], $arr_of_size[1]);
                                                            $image->save($name, $image_info[2]);
                                                        }

                                                        $content = '/'.$name;

                                                    }
                                                }else {
                                                    $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_31');
                                                }
                                            }
                                            else
                                            {
                                                $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                            }
                                        }
                                        catch (\Exception $e)
                                        {
                                            $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['err_pre_enter_ad3'] = $this->lang->line('cab_new_32');
                                    }
                                }
                            }
                        elseif($_POST['type_img_right'] == 'link')
                        {
                            $content = $_POST['link_right'];
                        }
                        break;
                    case 'vid':
                        $url = $_POST['vid_right'];
                        $vidparser = parse_url($url);
                        parse_str($vidparser['query'], $query);
                        $content = $query['v']; 
                        break;
                }

                $block_3 = json_encode([
                                        'type' => $_POST['type_right'],
                                        'content' => $content
                                    ]);
            }

            $info = [
                    'block_1' => $block_1,
                    'block_2' => $block_2,
                    'block_3' => $block_3,
                    'lang' => $_POST['lang'],
                    'status' => $_POST['status'],
                    'id' => $_POST['block_id']
                    ];

            $form_check = true;
        }

        if($form_check == false || isset($_SESSION['err_pre_enter_ad1']) || isset($_SESSION['err_pre_enter_ad2']) || isset($_SESSION['err_pre_enter_ad3']))
        {
            $block = $this->pre_ad->GetBlocks(['id' => $id]);
            $this->load->template('admin/pre_ad_edit', ['block' => $block]);
        }
        else
        {
            // var_dump($info);exit();
            $this->pre_ad->EditBlock($info);
            redirect("/adminpanel/pre_ad_panel");
        }
    }





    public function code_setts($id = 0) {
        $this->load->model('Special_model', 'special');

        if(isset($_POST['save'])) {
            $this->special->update_conf($_POST);
            $_SESSION['sett_ch_succ'] = 'Данные успешно изменены';
        }
        
        $data['conf'] = $this->special->GetConfig();
        $this->load->template('admin/code_setts', $data);
    }





    public function test_test_adv() {
        $sum = 59.5;
        $result2[0]['Credits'] = 0.8403361344;

        // /119 * 100

        echo bcdiv(100, 119, 200);

        echo '<br>';

        echo bcmul(bcdiv(59.5, 119, 2), 100, 2);

        echo '<br>';

        echo round(bcmul(59.5, 0.8403361344537815, 2));
    }

    public function constructor() {
        $data = array();

        $this->load->template('admin/constructor', $data);
    }

    public function block_user($username) {
        $user = $this->users->getIdByLogin($username);
        if($user != null && $user != false) {
            $this->users->add_to_blacklist($this->session->uid, $user['id']);
            $this->session->set_flashdata('blacklisted', true);
        }
        else
            $this->session->set_flashdata('blacklist_error', true);
        redirect('adminpanel/mail');
    }

    public function unblock_user($username) {
        $user = $this->users->getIdByLogin($username);
        if($user != null && $user != false) {
            $this->users->remove_from_blacklist($this->session->uid, $user['id']);
            $this->session->set_flashdata('unblacked', true);
        }
        else
            $this->session->set_flashdata('blacklist_error', true);
        redirect('adminpanel/mail');
    }

    private function get_user_places() {
        $data = array();
        for($i = 1; $i <= 6; $i++) {
            $data[$i] = $this->tree->get_user_places($i);
        }
        return $data;
    }

    private function get_places_closed() {
        $data = array();
        for($i = 1; $i <= 6; $i++) {
            $data[$i] = $this->tree->get_places_closed($i);
        }
        return $data;
    }

    public function ch_rest_coin() {
        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();

        $data['transactionss'] = $this->settings->get_hist();
        // var_dump($_POST);
        // exit();

        if(isset($_POST['new_coin_val'])) {
            if($_POST['new_coin_val'] > $settings['RemCoins']) {
                $_SESSION['error'] = 'Недостаточно коинов';
            }else{
                $this->settings->update_coin_val($_POST['new_coin_val']);
                $_SESSION['success'] = 'Коины успешно вычтены';
            }
            redirect('adminpanel/ch_rest_coin');
        }

        $settings = $this->settings->get_settings();
        $data['Cur_Coin_bal'] = $settings['RemCoins'];

        if($settings['Active_Fake_Buying'] == 1) {
            $data['Status'] = 'Включено';
        }else {
            $data['Status'] = 'Выключено';
        }
        $data['Min_min'] = $settings['Min_time'];
        $data['Max_min'] = $settings['Max_time'];
        $data['Min_coin'] = $settings['Min_coin'];
        $data['Max_coin'] = $settings['Max_coin'];

        $this->load->template('admin/ch_rest_coin', $data);
    }

    public function bonus_sett() {



        // <button onclick="document.location.href='?ch_st_main'">Включить отображение бонуса на главной</button>
        // <hr>
        // <button onclick="document.location.href='?ch_st_cab'">Включить отображение бонуса в кабинете</button>

        $this->load->model('Comp_model', 'comp');
        $this->load->model('settings_model', 'settings');

        $data['setts'] = $this->settings->get_settings();

        if(isset($_GET['ch_st_main'])) {
            $this->comp->ch_st_main($_GET['ch_st_main']);

            redirect('adminpanel/bonus_sett');
        }elseif(isset($_GET['ch_st_cab'])) {
            $this->comp->ch_st_cab($_GET['ch_st_cab']);

            redirect('adminpanel/bonus_sett');
        }

        $this->load->template('admin/bonus_sett', $data);
    }

    public function save_mail() {
        $data = array();

        $data['links'] = "";

        if(isset($_GET['resave'])) {
            $this->load->model('Comp_model', 'comp');
            $data['setts'] = $this->comp->cr_mail_files();

            $data['links'] = "
                <a href='/ads_mail_eng.txt' download='ads_mail_eng.txt'>Скачать файл ENG</a><br><br>
                <a href='/ads_mail_rus.txt' download='ads_mail_rus.txt'>Скачать файл RUS</a><br><br>
                <a href='/ads_mail_ger.txt' download='ads_mail_ger.txt'>Скачать файл GER</a><br><br>
                ";
        }

        $this->load->template('admin/save_mail', $data);
    }

    public function add_code() {
        $data = array();
        
        if(isset($_POST['add'])) {
            $this->load->model('Comp_model', 'comp');
            $data['setts'] = $this->comp->add_spec_code($_POST['format'], $_POST['code']);
            $_SESSION['success'] = 'Баннер успешно добавлен';
        }

        $this->load->template('admin/add_code', $data);
    }

    public function ch_active_cron() {
        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();


        $data['transactionss'] = $this->settings->get_hist();

        // var_dump($_POST);
        // exit();

        if(isset($_POST['min_min'])) {
            $this->settings->update_fake_active($_POST['status'], $_POST['min_min'], $_POST['max_min'], $_POST['min_coin'], $_POST['max_coin']);
            $_SESSION['success2'] = 'Параметры успешно сохранены';
            redirect('adminpanel/ch_active_cron');
        }

        $settings = $this->settings->get_settings();
        $data['Cur_Coin_bal'] = $settings['RemCoins'];

        if($settings['Active_Fake_Buying'] == 1) {
            $data['Status'] = 'Включено';
        }else {
            $data['Status'] = 'Выключено';
        }
        $data['Min_min'] = $settings['Min_time'];
        $data['Max_min'] = $settings['Max_time'];
        $data['Min_coin'] = $settings['Min_coin'];
        $data['Max_coin'] = $settings['Max_coin'];

        $this->load->template('admin/ch_rest_coin', $data);
    }

    public function index() {
        $res = json_encode(array());
        // @$res = file_get_contents('https://bitaps.com/api/address/1MEbRxTqWda9etTsMJzqRdSuMwyP7yPjES');
        $json = json_decode($res);
        // exit();
        // require_once('cpayeer.php');
        // $accountNumber = 'P1008354594';
        // $apiId   = '715261449';
        // $apiKey   = 'iF7elrV3PUd90DUi';

        // $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
        
        // if( $curl = curl_init() ) {

        //   $open_key = 'Rc04MG2qx2DC0YnQc5DYEGBXbqAf9RsG';
        //   $secr_key = 'KLPjibxKTnaoQazFi6ZlErXmkFQe4EAcJQGfcSFnUdidsX19VZRBBuA7oDZ2CvGD';

        //   curl_setopt($curl, CURLOPT_URL, 'https://app.coinspaid.com/api/v2/accounts/list');
        //   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //   curl_setopt($curl, CURLOPT_POST, true);

        //   $post_data = [];

        //   $requestBody = json_encode($post_data);
        //   $signature   = hash_hmac('sha512', $requestBody, $secr_key);

        //   curl_setopt($curl, CURLOPT_HTTPHEADER, [
        //                         'Content-Type: application/json',
        //                         'X-Processing-Key:'.$open_key,
        //                         'X-Processing-Signature:'.$signature
        //                       ]);

        //   curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        //   $out = curl_exec($curl);
        //   $res = json_decode($out);
        //   curl_close($curl);
        //   $data['respond'] = $res->data[0]->balance; // Response array

        //}else{

          $data['respond'] = 0; // Response array

        //}

        $this->load->model('finances_model', 'finances');
        $data['us_stat_info'] = $this->users->get_stat_info();
        // exit();
        // var_dump($data['us_stat_info']);exit();
        $data['total_users'] = $this->users->get_total_count();
        $data['last_regs'] = $this->users->get_last_regs();

        $data['total_income'] = $this->finances->get_total_income();
        $data['last_buying'] = $this->finances->get_last_buying();
        
        $data['get_us_bals'] = $this->finances->get_us_bals();

        $data['all_click'] = $this->finances->get_all_click();
        $data['all_show'] = $this->finances->get_all_show();

        $data['spec_stat'] =  $this->finances->get_spec_stat();
        

        require 'stripe-php/init.php';
        \Stripe\Stripe::setApiKey('sk_live_5LzxPI0aNEnEntL6zyqzmkab');
        $balance = \Stripe\Balance::retrieve();

        $data['stripe_bal'] = $balance->available[0]->amount;


        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('main_site_page');

        // require_once("MerchantWebService.php");
        // $merchantWebService = new MerchantWebService();
        // $arg0 = new authDTO();
        // $arg0->apiName = "DIGIFLUXX API";
        // $arg0->accountEmail = "digifluxx@gmx.de";
        // $arg0->authenticationToken = $merchantWebService->getAuthenticationToken("I_11W84nVp");

        // $getBalances = new getBalances();
        // $getBalances->arg0 = $arg0;

        // try {
        //     $getBalancesResponse = $merchantWebService->getBalances($getBalances);
        //     $data['respond2'] = $getBalancesResponse->return[1]->amount;
        // } catch (Exception $e) {
            $data['respond2'] = 0;//$arr_pe['balance']['USD']['DOSTUPNO'];
        //}

        $data['stat_of_ad'] = $this->users->get_ad_stat();

        $this->load->template('admin/dashboard', $data);
    }

    public function start_queues() {
        $this->load->model('queue_model');
        $users = $this->queue_model->get_queue();

        $this->load->library('mlm');
        $this->load->library('tree_model', 'tree');
        foreach ($users as $c_user) {
            $user = $this->users->getUserById($c_user['iduser']);
            $sponsor_id = 0;
            if ($this->tree->user_has_place($user['id'], 1) == false) {
                $sponsor_id = $user['idsponsor'];
            } else {
                $sponsor_id = $user['id'];
            }

            $this->mlm->addTreeNode($user['id'], $sponsor_id, 1, 1);
            if (!$this->users->user_has_reflink($user['id'])) {
                $this->generate_reflink($user['id']);
                $this->users->set_status($user['id'], 3);
                if ($user['current_level'] < 1) {
                    $this->users->update_level($user['id'], 1);
                }
            }
        }
        $this->queue_model->clear();
        $this->session->set_flashdata('queued', true);
        redirect('adminpanel/index');
    }

    public function generate_reflink($uid) {
        $user = $this->users->getUserById($uid);
        $this->load->helper('string');
        $link = '';
        do {
            $link = substr($user['login'], 0, 3) . random_string('numeric', rand(4,6));
        } while ($this->users->get_user_by_reflink($link) != false);
        $this->users->set_reflink($uid, $link);
    }

    public function login() {

        if($this->authentication->is_admin())
            redirect('adminpanel/index');

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('login_form');

        $this->form_validation->set_rules('username', 'lang:username', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');
        $this->form_validation->set_rules('password', 'lang:password', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');

        $cont = true;

        if(isset($_POST['code'])) {
            require_once 'ga/PHPGangsta//GoogleAuthenticator.php';

            $ga = new PHPGangsta_GoogleAuthenticator();
            $secret = 'CPGPREHYMLJZJTPH';
            $oneCode = $ga->getCode($secret);
            $checkResult = $ga->verifyCode($secret, $_POST['code'], 2);    // 2 = 2*30sec clock tolerance
             $checkResult = true;
            if (!$checkResult) {
                $_SESSION['error'] = 'Не верный код';
                $this->load->template('admin/login', $data, false, true);
                $cont = false;
            }
        }

        $cont = true;

        if($cont) {

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->template('admin/login', $data, false, true);
            } else {

                if($this->users->checkUserByCredentials($this->input->post('username'), $this->input->post('password'), 1)) {
                    $user_creds = $this->users->getUserCreds($this->input->post('username'));
                    $user = $this->users->getUserById($user_creds['id']);
                    $sess_data = array('uid' => $user['id'],
                        'username' => $user['login'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'lastname' => $user['lastname'],
                        'skype' => $user['skype'],
                        'mobile_num' => $user['mobile_num'],
                        'reflink' => '',  // $user['reflink'],);
                        'isadmin' => true);
                    $this->session->set_userdata($sess_data);
                    $this->users->updateUserIp($user['id']);
                    $this->load->model('finances_model', 'finances');
                    $sitekey = $this->finances->make_sitekey();
                    $this->load->model('logger_model', 'logger');
                    $this->logger->add_action('Вход под администратором', $sitekey);
                    redirect('adminpanel/index');
                } else {
                    $this->load->template('admin/login', array(), false, true);
                    // , array('login_failed' => true, 'page_name' => $data['page_name'])
                }
            }

        }
    }

    public function gouser($login) {
        $user_creds = $this->users->getUserCreds($login);
        set_cookie('uid', $user_creds['id'], '3600');
        $user = $this->users->getUserById($user_creds['id']);
        $sess_data = array(
            'old' => $_SESSION,
            'uid' => $user['id'],
            'username' => $user['login'],
            'email' => $user['email'],
            'name' => $user['name'],
            'lastname' => $user['lastname'],
            'skype' => $user['skype'],
            'mobile_num' => $user['mobile_num'],
            'reflink' => $user['reflink'],
            'ava' => $user['ava'],
            'ret_to_admin' => true);
        $this->session->set_userdata($sess_data);
        $signed_info = $this->authentication->getAuthString($user_creds['id'], $user_creds['email'], $user_creds['password']);
        set_cookie('signed_info', $signed_info, '3600');
        set_cookie('lang', $user['u_lang'], 3600 * 80);
        redirect('/cabinet/index');
    }

    public function settings() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $data['options'] = $this->settings_model->get_settings();
        $data['login'] = $this->users->getLoginById(1);

        $this->form_validation->set_rules('smtp_host', 'lang:smtp_host', 'required|trim|htmlspecialchars|strip_tags|xss_clean|max_length[255]|valid_url');
        $this->form_validation->set_rules('smtp_port', 'lang:smtp_port', 'required|trim|htmlspecialchars|strip_tags|xss_clean|max_length[6]|numeric');
        $this->form_validation->set_rules('smtp_user', 'lang:smtp_user', 'required|trim|htmlspecialchars|strip_tags|xss_clean|max_length[255]|regex_match[/^[a-z0-9@_\-.]+$/i]', array('smtp_user' => $this->lang->line('name_check')));
        $this->form_validation->set_rules('smtp_pass', 'lang:smtp_pass', 'required|trim|htmlspecialchars|strip_tags|xss_clean|max_length[255]|valid_url');
        $this->form_validation->set_rules('bch_wallet_id', 'lang:bch_wallet_id', 'trim|htmlspecialchars|strip_tags|xss_clean|alpha_dash|max_length[50]');
        $this->form_validation->set_rules('bch_password', 'lang:bch_password', 'trim|htmlspecialchars|strip_tags|xss_clean|max_length[250]');
        $this->form_validation->set_rules('api_key', 'lang:api_key', 'trim|htmlspecialchars|strip_tags|xss_clean|alpha_dash|max_length[50]');
        $this->form_validation->set_rules('xpub', 'lang:bch_xpub', 'trim|htmlspecialchars|strip_tags|xss_clean|alpha_numeric|max_length[150]');
        $this->form_validation->set_rules('percent', 'lang:withdraw_percent', 'required|trim|htmlspecialchars|strip_tags|xss_clean|max_length[10]|numeric');
        $this->form_validation->set_rules('start_date', 'lang:start_date', 'trim|htmlspecialchars|strip_tags|xss_clean|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/]');
        $this->form_validation->set_rules('site_name', 'lang:site_name', 'required|trim|htmlspecialchars|strip_tags|xss_clean');

        $settings = $this->settings_model->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('settings_page');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->template('admin/settings', $data);
        } else {
            if($this->input->post('bch_password')) {
                $this->load->library('encryption');
                $_POST['bch_password'] = $this->encryption->encrypt($_POST['bch_password']);
            }
            $this->settings_model->update_settings();
            redirect('adminpanel/settings');
        }
    }

    public function pass_change() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $data['options'] = $this->settings_model->get_settings();
        $data['login'] = $this->users->getLoginById(1);

        $this->form_validation->set_rules('username', 'lang:username', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');
        $this->form_validation->set_rules('password', 'lang:current_password', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', array('password_check', array($this->users, 'check_password'))));
        $this->form_validation->set_rules('newpassword', 'lang:new_password', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', array('password_identity', array($this->users, 'check_identity'))));
        $this->form_validation->set_rules('passconf', 'lang:repeat_new_password', 'required|matches[newpassword]|trim|htmlspecialchars|strip_tags|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->template('admin/settings', $data);
        }
        else {
            if($this->input->post('username') != $this->session->username) {
                $this->session->username = $this->input->post('username');
                $this->users->update_login($this->session->uid, $this->input->post('username'));
            }
            $this->users->setNewPassword(1);
            $this->session->set_flashdata('passchanged', true);
            $this->load->model('finances_model', 'finances');
            $sitekey = $this->finances->make_sitekey();
            $this->load->model('logger_model', 'logger');
            $this->logger->add_action('Пароль администратора изменен', $sitekey);
            redirect('adminpanel/settings');
        }
    }

    public function get_history($uid, $page = 0, $return = false) {
        if(!isset($uid) || $uid < 0) {
            redirect('adminpanel/view_user_history');
        }
        $this->load->model('finances_model', 'finances');
        $total_rows = $this->finances->getTransactionsCount($uid);
        $data['transactions'] = $this->finances->getMyTransactions(10, $page, $uid);
        $data['general_info'] = $this->users->getStatusInfo($uid);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_history/' . $uid;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/view_history', $data, true);
        else
            return $this->load->template('admin/view_history', $data, true);
    }

    public function get_history2($page = 0, $return = false) {
        $this->load->model('finances_model', 'finances');

        $this->load->model('settings_model', 'settings');

        $settings = $this->settings->get_settings();

        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('view_user_history_page');

        $total_rows = $this->finances->getFullTransactionsCount();
        $data['transactions'] = $this->finances->getTransactions(10, $page);
        // echo '<pre>';
        // var_dump($data['transactions']);
        // echo '</pre>';
        // exit();
        // $data['general_info'] = $this->users->getStatusInfo($uid);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_history2';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/view_history', $data, true);
        else
            return $this->load->template('admin/view_history', $data, true);
    }

    public function view_all_user_history($uid = '', $page = 0) {
        $page = 1;
        $this->load->model('finances_model', 'finances');
        $this->load->model('settings_model', 'settings');

        $settings = $this->settings->get_settings();

        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('view_user_history_page');

        $data['transactions'] = $this->finances->getTransactions(10, $page);
        $total_rows = $this->finances->getFullTransactionsCount();
        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_history2';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_all_user_history', $data, true);
    }

    public function get_depo($page = 0, $return = false) {
        $this->load->model('Deposit_model', 'depo');
        $data['transactions'] = $this->depo->getDepo(10, $page);
        $total_rows = $this->depo->getDepoCount();
        // $data['general_info'] = $this->users->getStatusInfo($uid);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_depo';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/view_all_depo', $data, true);
        else
            return $this->load->template('admin/view_all_depo', $data, true);
    }

    public function view_all_deposits($uid = '', $page = 0) {

        if($this->input->post('val') === NULL) {
            $page = 1;
            $this->load->model('Deposit_model', 'depo');
            $this->load->model('settings_model', 'settings');

            $settings = $this->settings->get_settings();

            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = 'Depo';

            $data['transactions'] = $this->depo->getDepo(10, $page);
            $total_rows = $this->depo->getDepoCount();
            $this->load->library('pagination');

            $config['base_url'] = base_url() . '/index.php/adminpanel/view_all_deposits';
            $config['total_rows'] = $total_rows;
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<li>';
            $config['full_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<span>';
            $config['cur_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            echo $this->load->template('admin/view_all_deposits', $data, true);
        }else {
            $this->load->model('Deposit_model', 'depo');
            $this->load->model('settings_model', 'settings');
            $settings = $this->settings->get_settings();
            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = $this->lang->line('view_user_history_page');

            $this->get_depo_for_search($this->input->post('val'), $this->input->post('type'));
        }

    }

    public function get_depo_for_search($uid, $type, $page = 0, $return = false) {
        $this->load->model('Deposit_model', 'depo');

        if($type == 'login') {
            $us_info = $this->users->getIdByUser($uid);
            $total_rows = $this->depo-> getDepoCount2($type, $us_info['id']);
            $data['transactions'] = $this->depo->getMyDepo2(10, $page, $type, $us_info['id']);
        }else {
            $total_rows = $this->depo-> getDepoCount2($type, $uid);
            $data['transactions'] = $this->depo->getMyDepo2(10, $page, $type, $uid);
        }

        // var_dump($data['transactions']);exit();

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_depo_for_search/'.$uid.'/'.$type;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/view_all_deposits', $data, true);
        else
            return $this->load->template('admin/view_all_deposits', $data, true);
    }



    public function test_code() {
        // echo '<script type="text/javascript" src="https://adhitzads.com/1034502"></script>';

        echo base64_decode('PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iaHR0cHM6Ly9hZGhpdHphZHMuY29tLzEwMzQ1MDIiPjwvc2NyaXB0Pg==');
    }



    public function view_mess($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();

        if($this->input->post('val') === NULL && !isset($_SESSION['val'])) {

            $data['comps'] = $this->comp->take_all_mess($page);

            $total_rows = $this->comp->get_mess_total_count();

        }else {

            if($this->input->post('val') != NULL) {
                $val = $this->input->post('val');
                $_SESSION['val'] = $val;
                $type = $this->input->post('type');
                $_SESSION['type'] = $type;
            }else {
                $val = $_SESSION['val'];
                $type = $_SESSION['type'];
            }

            // var_dump($_SESSION);exit();

            $data['comps'] = $this->comp->take_all_mess_search($page, $type, $val);

            $total_rows = $this->comp->get_mess_total_count_search($page, $type, $val);

        }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_mess/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 5;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_mess', $data, true);

    }

    public function answ_setts() {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->save_answers($_POST);
        }

        $data['answers'] = $this->comp->get_answers();

        echo $this->load->template('admin/answ_setts', $data, true);
    }
    public function answ_setts2() {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->save_answers($_POST);
        }

        $data['answers'] = $this->comp->get_answers();

        echo $this->load->template('admin/answ_setts2', $data, true);
    }
    public function answ_setts3() {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->save_answers($_POST);
        }

        $data['answers'] = $this->comp->get_answers();

        echo $this->load->template('admin/answ_setts3', $data, true);
    }

    public function view_clink($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();

        if($this->input->post('val') === NULL && !isset($_SESSION['val'])) {

            $data['comps'] = $this->comp->take_all_clink($page);

            $total_rows = $this->comp->get_clink_total_count();

        }else {

            if($this->input->post('val') != NULL) {
                $val = $this->input->post('val');
                $_SESSION['val'] = $val;
                $type = $this->input->post('type');
                $_SESSION['type'] = $type;
            }else {
                $val = $_SESSION['val'];
                $type = $_SESSION['type'];
            }

            $data['comps'] = $this->comp->take_all_clink_search($page, $type, $val);

            $total_rows = $this->comp->get_clink_total_count_search($page, $type, $val);

        }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_clink/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 5;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_clink', $data, true);

    }

    public function view_ads($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();

        if($this->input->post('val') === NULL && !isset($_SESSION['val'])) {

            $data['comps'] = $this->comp->take_all_text_ad($page);

            $total_rows = $this->comp->get_text_ad_total_count();

        }else {

            if($this->input->post('val') != NULL) {
                $val = $this->input->post('val');
                $_SESSION['val'] = $val;
                $type = $this->input->post('type');
                $_SESSION['type'] = $type;
            }else {
                $val = $_SESSION['val'];
                $type = $_SESSION['type'];
            }

            $data['comps'] = $this->comp->take_all_text_ad_search($page, $type, $val);

            $total_rows = $this->comp->get_text_ad_total_count_search($page, $type, $val);

        }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_ads/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 5;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_ads', $data, true);

    }

    public function reset_ads() {
        unset($_SESSION['val']);
        unset($_SESSION['type']);
        redirect('adminpanel/view_ads');
    }
    public function reset_clink() {
        unset($_SESSION['val']);
        unset($_SESSION['type']);
        redirect('adminpanel/view_clink');
    }
    public function reset_mess() {
        unset($_SESSION['val']);
        unset($_SESSION['type']);
        redirect('adminpanel/view_mess');
    }

    public function view_adv($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();

        // if($this->input->post('val') === NULL && !isset($_SESSION['val_b'])) {

            $data['comps'] = $this->comp->take_all_advs($page);

            $total_rows = $this->comp->get_advs_total_count();

        // }else {

        //     if($this->input->post('val') != NULL) {
        //         $val = $this->input->post('val');
        //         $_SESSION['val_b'] = $val;
        //         $type = $this->input->post('type');
        //         $_SESSION['type_b'] = $type;
        //     }else {
        //         $val = $_SESSION['val_b'];
        //         $type = $_SESSION['type_b'];
        //     }

        //     $data['comps'] = $this->comp->take_all_bans_search($page, $type, $val);

        //     $total_rows = $this->comp->get_bans_total_count_search($page, $type, $val);

        // }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_adv/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_adv', $data, true);

    }








    public function packet_panel($page = 0) {
        $this->load->model('packet_model', 'packet');
        $data['packets'] = $this->packet->get();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Constructor';
        $this->load->template('admin/packet_panel', $data);
    }
    public function packet_edit($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;

        $this->load->model('packet_model', 'packet');
        $data['packet'] = $this->packet->get_packet_by_id($id);
        
        if(isset($_POST['save'])) {
            $this->load->model('marketing_model', 'mark');
            $mark_setts = $this->mark->get_all_mark_setts();
            if($_POST['bp1'] != NULL && $_POST['bp1'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level1']], true);
                if($_POST['insta_balance1'] < 0) {
                    $_SESSION['err_bal_1'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance1'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_1'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && $_POST['bp2'] != NULL && $_POST['bp2'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level2']], true);
                if($_POST['insta_balance2'] < 0) {
                    $_SESSION['err_bal_2'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance2'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_2'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && !isset($_SESSION['err_bal_2']) && $_POST['bp3'] != NULL && $_POST['bp3'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level3']], true);
                if($_POST['insta_balance3'] < 0) {
                    $_SESSION['err_bal_3'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance3'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_3'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && !isset($_SESSION['err_bal_2']) && !isset($_SESSION['err_bal_3']) && $_POST['bp4'] != NULL && $_POST['bp4'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level4']], true);
                if($_POST['insta_balance4'] < 0) {
                    $_SESSION['err_bal_4'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance4'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_4'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if($_POST['price'] < 0) {
                $_SESSION['err_price'] = 'Price can`t be < 0';
            }

            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_packet', $data);
        }else {
            $this->packet->edit_packet($id);
            redirect("/adminpanel/packet_panel");
        }
    }
    public function add_packet() {
        $this->load->model('packet_model', 'packet');

        $data['page_name'] = 'Packet page';

        $form_check = false;

        if(isset($_POST['save'])) {
            $this->load->model('marketing_model', 'mark');
            $mark_setts = $this->mark->get_all_mark_setts();
            if($_POST['bp1'] != NULL && $_POST['bp1'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level1']], true);
                if($_POST['insta_balance1'] < 0) {
                    $_SESSION['err_bal_1'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance1'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_1'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && $_POST['bp2'] != NULL && $_POST['bp2'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level2']], true);
                if($_POST['insta_balance2'] < 0) {
                    $_SESSION['err_bal_2'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance2'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_2'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && !isset($_SESSION['err_bal_2']) && $_POST['bp3'] != NULL && $_POST['bp3'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level3']], true);
                if($_POST['insta_balance3'] < 0) {
                    $_SESSION['err_bal_3'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance3'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_3'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if(!isset($_SESSION['err_bal_1']) && !isset($_SESSION['err_bal_2']) && !isset($_SESSION['err_bal_3']) && $_POST['bp4'] != NULL && $_POST['bp4'] == 'on') {
                $info_lvl = json_decode($mark_setts['lvl_'.$_POST['level4']], true);
                if($_POST['insta_balance4'] < 0) {
                    $_SESSION['err_bal_4'] = 'Can`t be < 0';
                }elseif($_POST['insta_balance4'] >= $info_lvl['all_sum']) {
                    $_SESSION['err_bal_4'] = 'Can`t be >= '.$info_lvl['all_sum'];
                }
            }

            if($_POST['price'] < 0) {
                $_SESSION['err_price'] = 'Price can`t be < 0';
            }

            $form_check = true;
        }

        if($form_check == false) {
            $this->load->template('admin/add_packet', $data);
        } else {
            $this->packet->add_packet();
            redirect("/adminpanel/packet_panel");
        }
    }
    public function packet_del($id) {
        $this->load->model('packet_model', 'packet');
        $this->packet->del_packet($id);
        redirect("/adminpanel/packet_panel");
    }













    public function news_panel2($page = 0) {
        $this->load->model('news_model', 'news');
        $total_rows = $this->news->get_total_news2();
        $data['news'] = $this->news->get_news2(10, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/news_panel2/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Новости';

        $this->load->template('admin/news2', $data);
    }
    public function news_edit2($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('news_model', 'news');
        $data['news'] = $this->news->get_news_by_id2($id);
        
        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news2', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->edit_news2($id);
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel2");
        }
    }
    public function add_news2() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('news_add_page');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news2', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->add_news2();
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel2");
        }
    }


    public function news_panel3($page = 0) {
        $this->load->model('news_model', 'news');
        $total_rows = $this->news->get_total_news3();
        $data['news'] = $this->news->get_news3(10, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/news_panel3/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Новости';

        $this->load->template('admin/news3', $data);
    }
    public function news_edit3($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('news_model', 'news');
        $data['news'] = $this->news->get_news_by_id3($id);
        
        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news3', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->edit_news3($id);
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel3");
        }
    }
    public function add_news3() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('news_add_page');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news3', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->add_news3();
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel3");
        }
    }







    public function accept_adv($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->accept_adv($id, $_GET['sum']);
        redirect('adminpanel/view_adv');
    }

    public function view_tprj($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $this->load->model('Traffic_model', 'traf');
        $this->load->model('Traffic_construct_model', 'traf_c');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();
        $data['countries'] = $this->traf_c->get_countries_for_conf();

        if($this->input->post('val') === NULL && !isset($_SESSION['val_b'])) {

            $data['comps'] = $this->traf->take_all_tprj($page);

            $total_rows = $this->traf->get_tprj_total_count();

        }else {

            if($this->input->post('val') != NULL) {
                $val = $this->input->post('val');
                $_SESSION['val_b'] = $val;
                $type = $this->input->post('type');
                $_SESSION['type_b'] = $type;
            }else {
                $val = $_SESSION['val_b'];
                $type = $_SESSION['type_b'];
            }

            $data['comps'] = $this->traf->take_all_tprj_search($page, $type, $val);

            $total_rows = $this->traf->get_tprj_total_count_search($page, $type, $val);

        }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_tprj/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_tprj', $data, true);

    }

    public function reset_tprj() {
        unset($_SESSION['val_b']);
        unset($_SESSION['type_b']);
        redirect('adminpanel/view_tprj');
    }

    public function view_bnr($page = 0) {

        $this->load->library('pagination');
        $this->load->model('Comp_model', 'comp');
        $data['setts'] = $this->comp->get_setts();

        $data['answers'] = $this->comp->get_answers();

        if($this->input->post('val') === NULL && !isset($_SESSION['val_b'])) {

            $data['comps'] = $this->comp->take_all_bans($page);

            $total_rows = $this->comp->get_bans_total_count();

        }else {

            if($this->input->post('val') != NULL) {
                $val = $this->input->post('val');
                $_SESSION['val_b'] = $val;
                $type = $this->input->post('type');
                $_SESSION['type_b'] = $type;
            }else {
                $val = $_SESSION['val_b'];
                $type = $_SESSION['type_b'];
            }

            $data['comps'] = $this->comp->take_all_bans_search($page, $type, $val);

            $total_rows = $this->comp->get_bans_total_count_search($page, $type, $val);

        }

        $config['base_url'] = base_url() . '/index.php/adminpanel/view_bnr/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        echo $this->load->template('admin/view_bnr', $data, true);

    }

    public function reset_bnr() {
        unset($_SESSION['val_b']);
        unset($_SESSION['type_b']);
        redirect('adminpanel/view_bnr');
    }



    public function members($page = 0) {

        if($this->input->post('val') === NULL && $this->input->post('val1') === NULL) {
            $data['members'] = $this->users->get_all_users('desc', $page);
            $this->load->library('pagination');

            $this->load->model('settings_model', 'settings');
            $settings = $this->settings->get_settings();
            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = $this->lang->line('users_page');

            $total_rows = $this->users->get_total_count();
            $config['base_url'] = base_url() . '/index.php/adminpanel/members/';
            $config['total_rows'] = $total_rows;
            $config['per_page'] = 30;
            $config['full_tag_open'] = '<li>';
            $config['full_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<span>';
            $config['cur_tag_close'] = '</span>';

            $this->pagination->initialize($config);

            $this->load->template('admin/members', $data);
        }else {
            $this->load->model('settings_model', 'settings');
            $settings = $this->settings->get_settings();
            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = $this->lang->line('view_user_history_page');

            if(isset($_POST['val1'])){
                $_POST['val'] = $_POST['val1'].'_'.$_POST['val2'];
            }

            $this->get_users_for_search($this->input->post('val'), $this->input->post('type'));
        }

    }

    public function get_users_for_search($uid, $type, $page = 0, $return = false) {

        if($type == 'login') {
            $us_info = $this->users->getIdByUser($uid);
            $total_rows = $this->users->getUsersCount2($type, $us_info['id']);
            $data['members'] = $this->users->getMyUsers2(50, $page, $type, $us_info['id']);
        }else {
            $total_rows = $this->users->getUsersCount2($type, $uid);
            $data['members'] = $this->users->getMyUsers2(50, $page, $type, $uid);
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_users_for_search/'.$uid.'/'.$type;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 5;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/members', $data, true);
        else
            return $this->load->template('admin/members', $data, true);
    }

    public function get_his_for_search($uid, $type, $page = 0, $return = false) {
        $this->load->model('finances_model', 'finances');

        if($type == 'login') {
            $us_info = $this->users->getIdByUser($uid);
            $total_rows = $this->finances->getTransactionsCount2($type, $us_info['id']);
            $data['transactions'] = $this->finances->getMyTransactions2(10, $page, $type, $us_info['id']);
        }else {
            $total_rows = $this->finances->getTransactionsCount2($type, $uid);
            $data['transactions'] = $this->finances->getMyTransactions2(10, $page, $type, $uid);
        }

        // var_dump($data['transactions']);exit();

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/get_his_for_search/'.$uid.'/'.$type;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);
        if(!$return)
            echo $this->load->template('admin/view_history', $data, true);
        else
            return $this->load->template('admin/view_history', $data, true);
    }
    public function view_user_history($uid = '', $page = 0) {

        if($this->input->post('val') === NULL) {



            $page = 1;
            $this->load->model('finances_model', 'finances');
            $this->load->model('settings_model', 'settings');

            $settings = $this->settings->get_settings();

            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = $this->lang->line('view_user_history_page');



            $data['transactions'] = $this->finances->getTransactions(10, $page);

            // echo 1;exit();

            $total_rows = $this->finances->getFullTransactionsCount();


            
            $this->load->library('pagination');

            $config['base_url'] = base_url() . '/index.php/adminpanel/get_history2';
            $config['total_rows'] = $total_rows;
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<li>';
            $config['full_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<span>';
            $config['cur_tag_close'] = '</span>';



            $this->pagination->initialize($config);

            echo $this->load->template('admin/view_history', $data, true);
        }else {
            $this->load->model('finances_model', 'finances');
            $this->load->model('settings_model', 'settings');
            $settings = $this->settings->get_settings();
            $data['site_name'] = $settings['site_name'];
            $data['page_name'] = $this->lang->line('view_user_history_page');

            $this->get_his_for_search($this->input->post('val'), $this->input->post('type'));
        }
    }




    



    public function acc_ads($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->acc_text_ad($id);
        redirect('adminpanel/view_ads');
    }
    public function cancel_ads($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->cancel_text_ad($id, $_POST['riason']);
        redirect('adminpanel/view_ads');
    }

    public function acc_clink($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->acc_clink($id);
        redirect('adminpanel/view_clink');
    }
    public function cancel_clink($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->cancel_clink($id, $_POST['riason']);
        redirect('adminpanel/view_clink');
    }

    public function acc_mail($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->acc_mail($id);
        redirect('adminpanel/view_mess');
    }
    public function cancel_mail($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->cancel_mail($id, $_POST['riason']);
        redirect('adminpanel/view_mess');
    }

    public function acc_bnr($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->acc_bnr($id);
        redirect('adminpanel/view_bnr');
    }
    public function del_bnr($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->del_bnr($id);
        redirect('adminpanel/view_bnr');
    }
    
    public function del_ads($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->del_text_ads($id);
        redirect('adminpanel/view_ads');
    }

    public function del_clink($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->del_ads_clink($id);
        redirect('adminpanel/view_clink');
    }

    public function del_mail($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->del_mail($id);
        redirect('adminpanel/view_mess');
    }

    public function cancel_bnr($id) {
        $this->load->model('Comp_model', 'comp');
        $this->comp->cancel_bnr($id, urldecode($_GET['rsn']));
        redirect('adminpanel/view_bnr');
    }

    public function cancel_tprj($id) {
        $this->load->model('Traffic_model', 'traf');
        $this->traf->cancel_tprj($id, urldecode($_GET['rsn']));
        redirect('adminpanel/view_tprj');
    }
    

    // {"address": "147YXXFXtAJtKVaeQsoUEPa8vakynmzxEX", "redeem_code": "BTCvEvXpdgrBtAWQScvw5NnvYMxfG6bTEePh6Dd8dyhoSnqZjref1", "invoice": "invPLtAPGVUsGfvEX6hpx5ReX1aXxHWQbRDZLrUEwsT7PigErgQat"}

    public function view_fin_setts($id = 0) {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->update_fin_setts($_POST);
            $_SESSION['sett_ch_succ'] = 'Данные успешно изменены';
        }
        
        $data['setts'] = $this->comp->get_fin_setts();
        $this->load->template('admin/view_fin_setts', $data);
    }

    public function save_bonus_sett() {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->update_bonus_setts($_POST);
            $_SESSION['sett_ch_succ'] = 'Данные успешно изменены';
        }
        
        redirect('adminpanel/bonus_sett');
    }

    public function save_time_bonus_sett() {
        $this->load->model('Comp_model', 'comp');

        if(isset($_POST['save'])) {
            $this->comp->update_time_bonus_setts($_POST);
            $_SESSION['sett_ch_succ2'] = 'Данные успешно изменены';
        }
        
        redirect('adminpanel/bonus_sett');
    }

    public function ch_link_state() {
        $this->load->model('Comp_model', 'comp');

        $this->comp->update_link_bonus_setts($_GET['ch_st_main_link']);
        
        redirect('adminpanel/bonus_sett');   
    }

    public function del_user($uid, $del = 0) {
        $user = $this->users->getUserById($uid);
        if($user['status'] != 1) {
            $this->session->set_flashdata('active', true);
            redirect('adminpanel/users');
        }
        if($del == 0) {
            $data['uid'] = $uid;
            $this->load->template('admin/delete', $data);
        } else {
            $this->users->delete($uid);
            $this->load->model('finances_model', 'finances');
            $sitekey = $this->finances->make_sitekey();
            $this->load->model('logger_model', 'logger');
            $this->logger->add_action('Администратор удалил пользователя с id ' . $uid . ' и логином ' . $user['login'], $sitekey);
            redirect('adminpanel/users');
        }
    }

    public function re_test() {
        $this->load->model('Marketing_model', 'mark');
        $this->mark->re_save_system();
    }

    public function users($uid = 0, $page = 0) {
        $this->load->model('finances_model', 'finances');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['manual_packets'] = $this->settings->get_packets();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('users_page');

        if(isset($_POST['name_of_added_packet'])) {

            $this->load->model('Marketing_model', 'mark');
            switch ($_POST['name_of_added_packet']) {
                case 'Packet_1':
                    $this->mark->buy_scale('packet_1', $uid);
                    break;
                case 'Packet_2':
                    $this->mark->buy_scale('packet_2', $uid);
                    break;
                case 'Packet_3':
                    $this->mark->buy_scale('packet_3', $uid);
                    break;
                case 'Packet_4':
                    $this->mark->buy_scale('packet_4', $uid);
                    break;
                default:
                    $this->mark->manual_buy($_POST['name_of_added_packet'], $uid);
                    break;
            }
        }

        if($uid > 0 && !$this->input->post('save')) {
            $data['user'] = $this->users->getUserById($uid);

            if($data['user']['tarif'] != NULL) {
                $data['user_queue_info'] = $this->users->getUserQueueNumber($uid);
            }else {
                $data['user_queue_info'] = NULL;
            }

            $data['queue_info'] = $this->users->getCountQueue();

            $login = $this->users->getLoginById($data['user']['idsponsor']);
            $data['user']['sponsor_login'] = $login['login'];
            $this->load->template('admin/user_search', $data);
            return;
        }

        if($this->input->post('seacrh')) {

            $this->form_validation->set_rules('username', 'lang:username', 'trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');
            $this->form_validation->set_rules('skype', 'lang:skype', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', 'alpha_dash'));
            $this->form_validation->set_rules('email', 'lang:email', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', 'valid_email'));
            $this->form_validation->set_rules('balance', 'lang:balance', 'trim|htmlspecialchars|strip_tags|xss_clean|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->load->template('admin/user_search', $data);
            } else {
                $data['user'] = $this->users->find();
                if(!is_null($data['user']['idsponsor'])) {
                    $data['user']['dropdown_opts'] = array('1' => 'not_confirmed',
                        '2' => 'active',
                        '3' => 'payed',
                        '4' => 'blocked',
                    );
                    $data['user']['selected'] = $data['user']['status'];
                    $total_rows = $this->finances->getTransactionsCount($data['user']['id']);
                    $data['transactions'] = $this->finances->getMyTransactions(5, $page, $data['user']['id']);
                    $data['general_info'] = $this->users->getStatusInfo($data['user']['id']);
                    $this->load->library('pagination');

                    $config['base_url'] = base_url() . '/index.php/adminpanel/users/' . $data['user']['id'];
                    $config['total_rows'] = $total_rows;
                    $config['per_page'] = 5;
                    $config['full_tag_open'] = '<li>';
                    $config['full_tag_close'] = '</li>';
                    $config['cur_tag_open'] = '<span>';
                    $config['cur_tag_close'] = '</span>';

                    $this->pagination->initialize($config);
                    $this->load->template('admin/user_search', $data);
                }
                else {
                    unset($data['user']);
                    $this->load->template('admin/user_search', $data);
                }
            }
            return;
        } else if($this->input->post('save')) {


            $this->form_validation->set_rules('save_skype', 'skype', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean'));
            $this->form_validation->set_rules('save_email', 'lang:email', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', 'valid_email'));
            
            $this->form_validation->set_rules('save_balance_btc', 'lang:balance', 'trim|htmlspecialchars|strip_tags|xss_clean|numeric');
            $this->form_validation->set_rules('save_balance_btc2', 'lang:balance', 'trim|htmlspecialchars|strip_tags|xss_clean|numeric');
            
            $this->form_validation->set_rules('save_name', 'lang:name', 'trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('save_sponsor_login', 'lang:sponsor_login', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[50]', array('user_callable',array($this->users, 'user_check'))));
            $this->form_validation->set_rules('save_lastname', 'lang:last_name', 'trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('save_mobilenum', 'lang:mobile_num', 'trim|htmlspecialchars|strip_tags|xss_clean|numeric|max_length[17]');
            $this->form_validation->set_rules('newpassword', 'lang:new_password', array('trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]', array('password_identity', array($this->users, 'check_identity'))));
            $this->form_validation->set_rules('passconf', 'lang:repeat_new_password', 'matches[newpassword]|trim|htmlspecialchars|strip_tags|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                
                $data['user'] = $this->users->find2($this->input->post('us_id'));

                $data['user']['dropdown_opts'] = array(
                    '1' => 'not_confirmed',
                    '2' => 'active',
                    '3' => 'payed',
                    '4' => 'blocked',
                );
                
                $data['user']['selected'] = $data['user']['status'];

                $data['general_info'] = $this->users->getStatusInfo($this->input->post('us_id'));

                $data['user'] = $this->users->find2($this->input->post('us_id'));
                $data['user']['dropdown_opts'] = array('1' => 'not_confirmed',
                    '2' => 'active',
                    '3' => 'payed',
                    '4' => 'blocked',
                );
                $data['user']['selected'] = $data['user']['status'];

                $this->load->template('admin/user_search', $data);
            }else {
                $data['user_before'] = $this->users->getUserById($this->input->post('us_id'));
                $login = $this->users->getLoginById($data['user_before']['idsponsor']);
                $data['user_before']['sponsor_login'] = $login['login'];

                $this->users->update_user($this->input->post('us_id'));

                $data['user'] = $this->users->getUserById($this->input->post('us_id'));
                $login = $this->users->getLoginById($data['user']['idsponsor']);
                $data['user']['sponsor_login'] = $login['login'];

                if($data['user']['tarif'] != NULL) {
                    $data['user_queue_info'] = $this->users->getUserQueueNumber($this->input->post('us_id'));
                }else {
                    $data['user_queue_info'] = NULL;
                }

                $data['queue_info'] = $this->users->getCountQueue();

                $sitekey = $this->finances->make_sitekey();
                $this->load->model('logger_model', 'logger');
                $str = "Адмнистратор изменил данные пользователя " . $data['user']['id'];

                if(bcsub($this->input->post('save_balance_btc'), $data['user_before']['amount_btc'], 4) != 0) {
                    $str .= " и установил новый рекламный баланс: " . $this->input->post('save_balance_btc').'(старый - '.$data['user_before']['amount_btc'].') ';
                }

                if(bcsub($this->input->post('save_balance_btc2'), $data['user_before']['add_amount_btc'], 4) != 0) {
                    $str .= " и установил новый основной баланс: " . $this->input->post('save_balance_btc2').'(старый - '.$data['user_before']['add_amount_btc'].') ';
                }

                if($this->input->post('newpassword') != null) {
                    $str .= " и изменил пароль для входа";
                }

                $this->logger->add_action($str, $sitekey);
                $this->session->set_flashdata('updated', true);
                
                $data['user'] = $this->users->find2($this->input->post('us_id'));
                $this->load->template('admin/user_search', $data);
            }
            return;
        } else {
            $this->load->template('admin/user_search', $data);
        }
    }

    public function structs($place = 0, $matrix_level = 1) {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('structs_page');

        $this->form_validation->set_rules('username', 'lang:username', 'trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');

        $run = 0;
        if($this->input->post('username')) {
            $run = $this->form_validation->run();
            if($run == false) {
                $data['not_found'] = true;
                $this->load->template('admin/view_struct', $data);
            }
        }
        if ($matrix_level  > 6) $matrix_level = 1;

        if (get_cookie('scr_width') < 500)
            $max_level = 2;
        else
            $max_level = 3;
        if($run || $place > 0) {
            if($this->input->post('username')) {
                $user = $this->users->getIdByLogin($this->input->post('username'));
                if ($user == null || $user == false) {
                    $data['not_found'] = true;
                    $this->load->template('admin/view_struct', $data);
                } else {
                    $user_level = $this->users->get_level($user['id']);
                    $data['user_level'] = $user_level;
                    for($i = 1; $i <= $user_level; $i++) {
                        $str = '';
                        $data['struct'][$i]['count_places'] = $this->tree->get_my_places_count($user['id'], $i);
                        $places = $this->tree->get_my_places($user['id'], $i);

                        foreach($places as $place) {
                            $str .= $place['place'];
                            if($place != end($places))
                                $str .= ', ';
                        }
                        $data['struct'][$i]['first_place'] = $places[0];
                        $data['struct'][$i]['places'] = $str;
                        $first_place = $this->tree->getUsersPlace($user['id']);
                        $data['struct'][$i]['first_place'] = $first_place;
                        $closure = $this->mlm->check_struct_closure($first_place, $i);
                        $data['struct'][$i]['level_closure'] = $closure;
                        $data['struct'][$i]['lvl_percent_closure'] = (int) (100 / 7 * $closure);
                    }


                    $place = $this->tree->getUsersPlace($user['id']);
                }
            } else {
                $data['users'] = $this->mlm->get_nodes(1, 1, $max_level);
            }

            $this->load->template('admin/view_struct', $data);
            } else {
            $this->load->template('admin/view_struct', $data);
        }
    }
    
    public function view_struct($place, $level) {
        if($place < 1)
            $place = 1;
        if($level > 6)
            $level = 6;
        if($level < 1)
            $level = 1;

        if (get_cookie('scr_width') < 500)
            $max_level = 2;
        else
            $max_level = 3;

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('structs_page');

        $data['level'] = $level;
        $data['users'] = $this->mlm->get_nodes($level, $place, $max_level);
        $this->load->template('admin/view_level', $data);
    }


    public function news_panel($page = 0) {
        $this->load->model('news_model', 'news');
        $total_rows = $this->news->get_total_news();
        $data['news'] = $this->news->get_news(10, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/news_panel/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = 'Новости';

        $this->load->template('admin/news', $data);
    }

    public function news_view($id = 1) {
        if(!is_numeric($id) || $id < 1)
            $id = 1;
        $this->load->model('news_model', 'news');
        $data['news'] = $this->news->get_news_by_id($id);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('news_page');
        $this->load->template('admin/view_news', $data);
    }

    public function add_news() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('news_add_page');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->add_news();
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel");
        }
    }

    public function upload_imgs() {
        $config['upload_path']          ='./assets/uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 3000;
        $config['max_width']            = 3000;

        $config['max_height']           = 3000;
        $config['file_name']            = time() . $_FILES['file']['name'];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $this->output->set_status_header(500, 'Error File Upload');

            return;
        }
        else
        {
            //тут два слеша потому, что функция пост-обработки уберет все '../', а один слэш нам нужен
            echo json_encode(array('location' => base_url() . '/assets/uploads/' . $this->upload->data('file_name')));
        }
    }

    public function issues($page = 0) {
        $this->load->model('support_model', 'support');

        $total_rows = $this->support->get_total_issues();
        $data['issues'] = $this->support->get_messages(10, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/issues/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('issues_page');

        $this->load->template('admin/issues', $data);
    }

    public function delete_issue($id) {
        $this->load->model('support_model', 'support');
        $this->support->delete_issue($id);
        $this->session->set_flashdata('issue_deleted', true);
        redirect('adminpanel/issues');
    }

    public function mail() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security'); //надо для работы с xss_clean
        $this->load->library('form_validation');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('mail_page');

        if(!$this->input->post('mass')) {
            $this->form_validation->set_rules('ulogin', 'lang:user_login', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[3]', 'max_length[255]'));
        }
        $this->form_validation->set_rules('title', 'lang:message_title', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[5]', 'max_length[400]'));
        $this->form_validation->set_rules('message', 'lang:message_body', array('required', 'trim', 'htmlspecialchars', 'strip_tags', 'xss_clean', 'min_length[5]'));

        $data['mail'] = $this->messages->get_messages($this->session->uid);

        if($this->form_validation->run() == false) {
            $this->load->template('admin/mail', $data);
        } else {
            if($this->input->post('mass')) {
                $uids = $this->users->get_all_users();
                foreach ($uids as $user) {
                    if($user['id'] != 1 && !$this->users->get_blacklisted($user['id'], 1)) {
                        $this->messages->add_message($this->session->uid, $user['id']);
                    }
                }
                $this->session->set_flashdata('messages_sent', true);
            } else {
                $receiver_id = $this->users->getIdByLogin($this->input->post('ulogin'));
                if($receiver_id['id'] == null) {
                    $this->session->set_flashdata('no_such_user', true);
                } else if($this->users->get_blacklisted($receiver_id['id'], 1)) {
                    $this->session->set_flashdata('in_blacklist', true);
                } else {
                    $this->messages->add_message($this->session->uid, $receiver_id['id']);
                    $this->session->set_flashdata('message_sent', true);
                }
            }
            redirect('adminpanel/mail');
        }
    }

    public function read_msg($id) {
        $data['message'] = $this->messages->get_message($id, $this->session->uid);
        if(is_null($data['message']))
            return false;
        else {
            $this->messages->mark_as_read($id);
            $this->load->view('admin/view_message', $data);
        }
    }

    public function del_msg($id) {
        $this->messages->del_message($id, $this->session->uid);
        $data['msg_deleted'] = true;
        $this->load->view('admin/view_message', $data);
    }

    public function banners() {
        $this->load->helper('form');
        $this->load->helper('directory');
        $data['banners'] = directory_map('./assets/uploads/banners/');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('banners_page');

        $this->load->template('admin/banners', $data);
    }

    public function add_banner() {
        $config['upload_path']          = './assets/uploads/banners/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2000;
        $config['max_width']            = 2000;
        $config['max_height']           = 1000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            $this->load->helper('form');
            $this->load->template('admin/banners', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $this->session->set_flashdata('uploaded', true);
            redirect('adminpanel/banners');
        }
    }

    public function del_banner($banner_name) {
        $this->load->helper('file');
        $name = (get_file_info('./assets/uploads/banners/' . $banner_name));
        if($name != false) {
            unlink('./assets/uploads/banners/' . $banner_name);
            $this->session->set_flashdata('file_deleted', true);
        }
        redirect('adminpanel/banners');
    }
    public function del_slider($slider_name) {
        $this->load->helper('file');
        $name = (get_file_info('./assets/uploads/slider/' . $slider_name));
        if($name != false) {
            unlink('./assets/uploads/slider/' . $slider_name);
            $this->session->set_flashdata('file_deleted', true);
        }
        redirect('adminpanel/marketing');
    }

    public function marketing() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('text_body', 'lang:news_text', 'required|min_length[3]');

        $this->load->model('marketing_model', 'marketing');
        $text = $this->marketing->get_text();
        $data['text'] = $text['marketing_text'];

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('marketing_page');

        if($this->form_validation->run() == false) {
            $this->load->helper('directory');
            $data['images'] = directory_map('./assets/uploads/slider/');

            $this->load->template('admin/marketing', $data);
        } else {
            $this->marketing->change_text();
            redirect("adminpanel/marketing");
        }
    }

    public function product() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('link', 'lang:link', 'required|valid_url|max_length[300]|prep_url');
        $this->form_validation->set_rules('text_body', 'lang:news_text', 'required|min_length[3]');

        $this->load->model('product_model', 'product');
        $text = $this->product->get_text();
        $data['text'] = $text['product_text'];
        $data['link'] = $text['product_link'];

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('product_page');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/product', $data);
        } else {
            $this->product->update_data();
            redirect("adminpanel/product");
        }
    }

    public function upload_slider() {
        $config['upload_path']          ='./assets/uploads/slider';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 3000;
        $config['max_width']            = 3000;
        $config['encrypt_name']         = true;
        $config['max_height']           = 3000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('sliderfile'))
        {
            $this->load->helper(array('form', 'url'));
            $this->load->helper('security');
            $this->load->library('form_validation');

            $data['error'] = $this->upload->display_errors();
            $this->load->model('marketing_model', 'marketing');
            $text = $this->marketing->get_text();
            $data['text'] = $text['marketing_text'];
            $data['images'] = directory_map('./assets/uploads/slider/');

            $this->load->template('admin/marketing', $data);
        }
        else
        {
            redirect('adminpanel/marketing');
        }
    }

    public function news_edit($id) {
        if (!is_numeric($id) || $id < 1)
            $id = 1;
        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->load->model('news_model', 'news');
        $data['news'] = $this->news->get_news_by_id($id);
        
        $this->form_validation->set_rules('title_russian', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_english', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('title_german', 'lang:news_title', 'required|min_length[5]|max_length[400]');
        $this->form_validation->set_rules('text_body_russian', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_english', 'lang:news_text', 'required|min_length[3]');
        $this->form_validation->set_rules('text_body_german', 'lang:news_text', 'required|min_length[3]');

        if($this->form_validation->run() == false) {
            $this->load->template('admin/add_news', $data);
        } else {
            $this->load->model('news_model', 'news');
            $this->news->edit_news($id);
            $this->session->set_flashdata('news_added', true);
            redirect("/adminpanel/news_panel");
        }
    }

    public function accept_payment_old($payment_id) {
        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $password = $settings['blockchain_password'];
        $this->load->library('encryption');
        $password = $this->encryption->decrypt($password);
        $wallet = $settings['blockchain_wallet_id'];

        $this->load->model('finances_model', 'finances');
        $trans_info = $this->finances->get_transaction($payment_id);
        $sum = $trans_info['amount'];
        $comission = $trans_info['comission'];

        $balance = json_decode(file_get_contents('http://localhost:3000/merchant/' . $wallet . '/balance?password=' . $password));
        if($balance->error) {
            $this->session->set_userdata('withdraw_error', $balance->error);
        } else {
            //информация возвращается в Сатоси, поэтому нужно ее конвертнуть в биткоин
            if ($balance->balance / 100000000 >= $sum) {
                $link = 'http://localhost:3000/merchant/' . $wallet . '/payment?password=' . $password;
                $to = 'address';
                if($comission > 0)
                    $comission = $sum * $comission / 100;
                $amount = ($sum - $comission) * 100000000;
                $params = 'to=' . $to . '&amount=' . $amount;
                $res = json_decode(file_get_contents($link . $params));
                if ($res->tx_hash) {
                    $this->session->set_userdata('transferred', true);
                    $this->finances->confirm_payment($payment_id);
                    $sitekey = $this->finances->make_sitekey();
                    $this->load->model('logger_model', 'logger');
                    $str = "Адмнистратор подтвердил вывод " . $sum . ' btc на кошелек ' . $to . ', для транзакции с id ' . $payment_id;
                    $this->logger->add_action($str, $sitekey);
                }
            } else {
                $this->session->set_userdata('low_funds', true);
            }
        }
        redirect('adminpanel/payments');
    }
    
    public function accept_payment($payment_id) {

        $this->load->model('user_model', 'users');
        $this->load->library('withdraw');
        $this->load->model('finances_model', 'finances');
        $tx = $this->finances->get_transaction($payment_id);
        $uid = $tx['idsender'];
        $user = $this->users->getUserById($uid);
        $wallet = $tx['btc_address'];
        $system = $tx['currency'];
        $sum = $tx['amount'];
        
        // if(in_array($system, array('ETH', 'BTC', 'BCH', 'LTC', 'DASH'))) {

        //     $res = $this->withdraw->crypto($system, $uid, $sum, $wallet, $payment_id);  

        //     // $f = fopen('ara_test.txt3', 'a+');
        //     // fwrite($f, json_encode($res));

        //     if(is_array($res)) {
        //         $this->session->set_userdata('payment_error', true);
        //         $this->session->set_flashdata('desc', $res[1]);
        //         redirect('adminpanel/payments');
        //     }
        //     if($res == -3) {
        //         $this->session->set_userdata('payment_error', true);
        //         $this->session->set_flashdata('desc', 'Выплата по биткоину: сумма меньше $2000');
        //         redirect('adminpanel/payments');
        //     }
        //     if($res == 1) {
        //         $this->session->set_userdata('transferred', true);
        //         // $this->finances->confirm_payment($payment_id);
        //         $sitekey = $this->finances->make_sitekey();
        //         $this->load->model('logger_model', 'logger');
        //         $str = "Адмнистратор подтвердил вывод " . $sum . ' btc на кошелек ' . $to . ', для транзакции с id ' . $payment_id;
        //         $this->logger->add_action($str, $sitekey);
        //         redirect('adminpanel/payments');
        //     } else {
        //         $this->session->set_flashdata('payment_error', true);
        //         redirect('adminpanel/payments');
        //     }
        // }

        //echo $this->finances->convert_to_btc($tx['amount']);exit();

        if($system == 'BTC') {
            if( $curl = curl_init() ) {

              $open_key = 'Rc04MG2qx2DC0YnQc5DYEGBXbqAf9RsG';
              $secr_key = 'KLPjibxKTnaoQazFi6ZlErXmkFQe4EAcJQGfcSFnUdidsX19VZRBBuA7oDZ2CvGD';

              curl_setopt($curl, CURLOPT_URL, 'https://app.coinspaid.com/api/v2/withdrawal/crypto');
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_POST, true);

              $post_data = [
                  "foreign_id" => "uid:".$uid,
                  "currency" => "BTC",
                  "amount" => $this->finances->convert_to_btc($tx['amount']),
                  "address" => $wallet
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

            //$address = $res->data->address; // Bitcoin address to receive payments
            //$payment_code = $res->data->id; //Payment Code

            // $address = 'testwallet'; // Bitcoin address to receive payments
            // $payment_code = '201010102'; //Payment Code

            // $this->load->model('invoices_model', 'invoices');
            // $this->invoices->save_wallet($this->session->uid, $address, $payment_code);

            if(isset($res->data->id)) {
                //$respond["status"] == 'success'
                $this->finances->confirm_payment($payment_id);
            }



            // $redeemcode = 'BTCv3BCLhVoGUk7oQBuJNx9rajgwJ7kvrCy2891fDjA2gs8qcBqji';

            // $postfields = json_encode(array('redeemcode'=> $redeemcode, 'address'=> $wallet, 'amount' => bcsub(bcmul(bcdiv($sum, 3643.97574828, 8), 100000000), 25000, 0) ) );

            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "https://bitaps.com/api/use/redeemcode");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // $data = curl_exec($ch);
            // $respond = json_decode($data,true);

            // $sum = 48;

            // echo bcdiv($sum, 3643.97574828, 8);exit();

            //var_dump($respond);
            // echo '<br>'.$wallet.'<br>';
            // echo bcsub(bcdiv($sum, 3643.97574828, 8), 0.00025, 8);
            //exit();

            // if($respond["status"] == 'success') {
            //     $this->finances->confirm_payment($payment_id);
            // }

            return true;
        }elseif($system == 'EUR') {
            require_once("MerchantWebService.php");
            $merchantWebService = new MerchantWebService();

            $arg0 = new authDTO();
            
            $arg0->apiName = "DIGIFLUXX API";
            $arg0->accountEmail = "digifluxx@gmx.de";
            $arg0->authenticationToken = $merchantWebService->getAuthenticationToken("I_11W84nVp");
            
            $arg1 = new sendMoneyRequest();
            $arg1->amount = $tx['amount']+0;
            $arg1->currency = "EUR";
            //$arg1->email = "receiver_email";
            $arg1->walletId = str_replace(' ', '', $tx['btc_address']);
            $arg1->note = "Digifluxx withdrawal";

            // echo $arg1->amount.'<br>';
            // echo $arg1->walletId;
            // exit();

            $validationSendMoney = new validationSendMoney();
            $validationSendMoney->arg0 = $arg0;
            $validationSendMoney->arg1 = $arg1;

            $sendMoney = new sendMoney();
            $sendMoney->arg0 = $arg0;
            $sendMoney->arg1 = $arg1;

            try {
                $merchantWebService->validationSendMoney($validationSendMoney);
                $sendMoneyResponse = $merchantWebService->sendMoney($sendMoney);

                $this->finances->confirm_payment($payment_id);
            } catch (Exception $e) {
                echo "ERROR MESSAGE => " . $e->getMessage() . "<br/>";
                echo $e->getTraceAsString();
                exit();
            }
        }elseif(false && $system == 'PE') {

            require_once('cpayeer.php');
            $accountNumber = 'P1008354594';
            $apiId   = '715261449';
            $apiKey   = 'iF7elrV3PUd90DUi';

            $payeer = new CPayeer($accountNumber, $apiId, $apiKey);

            $description = 'Withdraw Traffic Star.';

            if($payeer->isAuth()) {
                $arTransfer = $payeer->transfer(array(
                    'curIn' => 'USD', // счет списания 
                    'sum' => $sum,  // Сумма получения 
                    'curOut' => 'USD', // валюта получения  
                    'to' => $wallet,  // Получатель
                    'comment' => $description,
                ));

                if(!empty($arTransfer["historyId"])) {
                    $this->finances->confirm_payment($payment_id);
                    return true;
                }else {
                    // echo 'fail';exit();
                    return false;
                }

            }else {
                return false;
            }

        }


        // $sum = bcmul($sum, 100000000, 8);

        // $sum = bcsub($sum, 0.0001, 8);

        // $res = file_get_contents('http://localhost:3000/merchant/5da9c141-b35e-4785-8a64-61963e5b81c0/payment?password='.urlencode('alex1web1').'&to='.$wallet.'&amount='.$sum.'&from=0&api_code=b3556edf-0cba-468b-a2b2-7073e6c14bd7');

        // if($res) {

        //     $res_obj = json_decode($res);


        //     $f = fopen('blockchain-send_OUT.txt', 'a+');
        //     fwrite($f, 'query string:' . $res . "\r\n");
        //     fwrite($f, "======END OF QUERY======\r\n\r\n");

        //     $this->finances->confirm_payment($payment_id);

        //     // $res2 = $conn->query("SELECT * FROM accounts WHERE username='".$_POST['username']."'");
        //     // $arr2 = $res2->fetch_array(MYSQLI_ASSOC);

        //     // $conn->query("INSERT INTO `transactions_out`(`idw`, `uid`, `cur`, `amount`, `address`, `pay_code`, `invoice`, `Status`, `Status_for_show`, `Conf`, `date`) VALUES (".$arr['id'].", ".$arr2['id'].",'".$arr['cur']."',".$arr['sum'].",'".$arr['addr']."','".$res_obj->tx_hash."','',0,1,0,'".time()."')");

        //     // fwrite($f, "query - "."INSERT INTO `transactions_out`(`idw`, `uid`, `cur`, `amount`, `address`, `pay_code`, `invoice`, `Status`, `Status_for_show`, `Conf`, `date`) VALUES (".$arr['id'].", ".$arr2['id'].",'".$arr['cur']."',".$arr['sum'].",'".$arr['addr']."','".$res_obj->tx_hash."','',0,1,0,'".time()."')"." |ERROR - ".$conn->error."\r\n\r\n");

        //     // $conn->query("UPDATE withdrawals SET status_out=1 WHERE id=".$_POST['id']);

        // }else {

        //     echo 'ERROR_payment';exit();

        // }

    }

    public function cancel_payment($payment_id, $riason = '') {
        $this->load->model('finances_model', 'finances');
        $this->finances->cancel_payment($payment_id, $riason);
        $trans_info = $this->finances->get_transaction($payment_id);
        $this->users->addFunds_ads($trans_info['idsender'], $trans_info['amount'],  $trans_info['currency']);
        $sitekey = $this->finances->make_sitekey();
        $this->load->model('logger_model', 'logger');
        $str = "Адмнистратор отенил транзакцию с id " . $payment_id;
        $this->logger->add_action($str, $sitekey);
    }
    
    public function process_payments(){
        //act: 1 - confirm, 2 - dismiss
        // if($this->input->post('act') && count($this->input->post('act') > 0)) {
            foreach ($this->input->post('table_records') as $item) {
                if(is_numeric($item) && $item > 0) {
                    if($this->input->post('act') == 1) {
                        $this->accept_payment($item);
                    } else if ($this->input->post('act') == 2) {
                        $this->cancel_payment($item, $this->input->post('riason_'.$item));
                    }
                }
            }
        // }
        redirect('adminpanel/payments');
    }

    public function process_banners(){
        //act: 1 - confirm, 2 - dismiss, 3 - delete
        // echo '<pre>';
        // var_dump($this->input->post('act'));
        // var_dump($this->input->post('table_records'));
        // echo '</pre>';
        // exit();
        // if($this->input->post('act') && count($this->input->post('act') > 0)) {
            $this->load->model('Comp_model', 'comp');
            foreach ($this->input->post('table_records') as $item) {
                if(is_numeric($item) && $item > 0) {
                    if($this->input->post('act') == 1) {
                        $this->comp->acc_bnr($item);
                    }elseif ($this->input->post('act') == 2) {
                        // echo 'here';exit();
                        $this->comp->cancel_bnr($item, $this->input->post('riason_'.$item));
                    }elseif ($this->input->post('act') == 3) {
                        $this->comp->del_bnr($item);
                    }
                }
            }
        // }
        redirect('adminpanel/view_bnr');
    }

    public function process_tprjs(){
        //act: 1 - confirm, 2 - dismiss, 3 - delete
        // echo '<pre>';
        // var_dump($this->input->post('act'));
        // var_dump($this->input->post('table_records'));
        // echo '</pre>';
        // exit();
        // if($this->input->post('act') && count($this->input->post('act') > 0)) {
            $this->load->model('Traffic_model', 'traf');
            foreach ($this->input->post('table_records') as $item) {
                if(is_numeric($item) && $item > 0) {
                    if($this->input->post('act') == 1) {
                        $this->traf->acc_tprj($item);
                    }elseif ($this->input->post('act') == 2) {
                        // echo 'here';exit();
                        $this->traf->cancel_tprj($item, $this->input->post('riason_'.$item));
                    }elseif ($this->input->post('act') == 3) {
                        $this->traf->del_tprj($item);
                    }elseif ($this->input->post('act') == 4) {
                        $this->traf->add_traf_to_tprj($item, $this->input->post('traf_add_'.$item), $this->input->post('country_'.$item));
                    }
                }
            }
        // }
        redirect('adminpanel/view_tprj');
    }







    public function new_message_count() {
        $msgs = $this->messages->get_unread($this->session->uid);
        $this->session->set_flashdata('new_messages', $msgs);
        echo $msgs;
    }

    public function payments($page = 0) {
        $this->load->model('finances_model', 'finances');
        $total_rows = $this->finances->getPendingTransactionsCount();
        $data['transactions'] = $this->finances->getPendingTransactions(100, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/payments/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 100;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('payments_page');

        $this->load->template('admin/pending_payments', $data);
    }

    public function payments_accepted($page = 0) {
        $this->load->model('finances_model', 'finances');
        $total_rows = $this->finances->getPendingTransactionsCount2();
        $data['transactions'] = $this->finances->getPendingTransactions2(100, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/payments_accepted/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 100;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('payments_page');

        $this->load->template('admin/pending_payments2', $data);
    }

    public function payments_decleaned($page = 0) {
        $this->load->model('finances_model', 'finances');
        $total_rows = $this->finances->getPendingTransactionsCount3();
        $data['transactions'] = $this->finances->getPendingTransactions3(100, $page);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/index.php/adminpanel/payments_decleaned/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 100;
        $config['full_tag_open'] = '<li>';
        $config['full_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $data['page_name'] = $this->lang->line('payments_page');

        $this->load->template('admin/pending_payments3', $data);
    }

    public function logout() {
        delete_cookie('uid');
        delete_cookie('signed_info');
        $this->session->sess_destroy();
        redirect('user/login');
    }
}