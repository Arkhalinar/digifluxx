<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if(get_cookie('lang') == null)
            $lang = 'english';
        else if(in_array(get_cookie('lang'), array('russian', 'english', 'german'))) {
            $lang = get_cookie('lang');
        } else {
            $lang = 'english';
        }
        $this->config->set_item('language', $lang);
        $this->lang->load('common_site', $lang);
    }

    public function index() {
        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $this->load->view('user/site_closed');
    }
}