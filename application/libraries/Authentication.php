<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {
    protected $ci;

    function __construct()  {
        $this->ci =& get_instance();
        $this->ci->load->model('user_model', 'users', true);
    }

    function checkAuth() {
        return $this->ci->users->checkUserAutologin(get_cookie('uid'), get_cookie('signed_info'));
    }

    public function is_admin() {
        return $this->ci->session->isadmin;
    }

    function checkProjectAccess() {
        $pid = get_cookie('project_id');
        $password = get_cookie('project_password');

        if (is_null($pid) || is_null($password)) {
            return false;
        }

        $this->ci->load->model('projects_model', 'projects', true);
        if ($this->ci->projects->checkProjectPassword($pid, $password)) {
            return true;
        }

        return false;
    }

    function setProjectAccess($pid, $password) {
        $client_expiration = 3600;

        set_cookie('project_id', $pid, $client_expiration);
        set_cookie('project_password', $password, $client_expiration);
    }

    public function getAuthString($uid, $email, $pass_hash) {
        return md5($uid . $email . md5($pass_hash) . $pass_hash);
    }
}