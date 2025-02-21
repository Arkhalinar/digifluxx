<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model', 'users');
        if(get_cookie('lang') == null)
        {
            $lang = 'english';
        }
        else if(in_array(get_cookie('lang'), array('russian', 'english', 'german')))
        {
            $lang = get_cookie('lang');
        }
        else
        {
            $lang = 'english';
        }

        $this->config->set_item('language', $lang);
        $this->lang->load('common_site', $lang);
        $this->load->setPath('user');

        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        if($settings['site_opened'] != 1)
        {
            redirect('site/index');
        }

        if($settings['registered_opened'] != 1)
        {
            $this->session->set_flashdata('reg_closed', true);
        }
    }



    //PAGES
    public function index()
    {
        redirect('user/login');
    }
    public function confirm_ip($link)
    {
        $this->users->confirm_ip($link);
        $this->session->set_flashdata('ip_confirmed', true);
        redirect('user/login');
    }
    public function login()
    {

        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];

        if(isset($_POST['g-recaptcha-response']))
        {

            if( $curl = curl_init() )
            {

                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6Lc7tsEUAAAAAIJ02MvYrX6XbZ4Y4QU7F8aL8tmY&response=".$_POST['g-recaptcha-response']);
                $res = curl_exec($curl);

                $res = json_decode($res);

                if($res->success)
                {
                    $can = true;
                }
                else
                {
                    $can = false;
                }
                $can = true;

                curl_close($curl);
            }

        }
        else
        {
            $can = false;
        }

        if(isset($_POST['g-recaptcha-response']) && !$can)
        {
            $_SESSION['er_cr_comp'] = $this->lang->line('error_captcha');
            $this->load->template('user/login', $data);
        }
        else
        {

            $this->load->library('authentication');
            if($this->authentication->checkAuth())
            {
                if(!is_null(get_cookie('uid')) && !$this->users->user_verified(get_cookie('uid')))
                {
                    $this->session->set_userdata('uid', get_cookie('uid'));
                    redirect('user/need_verification');
                }
                else
                {
                    redirect('/cabinet/index');
                }
            }

            $this->load->helper(array('form', 'url'));
            $this->load->helper('security');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'lang:username', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');
            $this->form_validation->set_rules('password', 'lang:password', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');

            if (!empty($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP'] != '178.62.201.102')
            {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            }
            elseif(!empty($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != '178.62.201.102')
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '178.62.201.102')
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }


            if($ip != '178.62.201.102' && !$this->users->check_trying($ip))
            {
                $this->session->set_flashdata('blocked', true);
                $this->load->template('user/login', $data);
            }
            elseif($this->form_validation->run() == FALSE)
            {
                if(isset($_SESSION['ip_confirmed']))
                {
                    $this->session->set_flashdata('ip_confirmed', true);
                }
                $this->load->template('user/login', $data);
            }
            else
            {
                if($this->users->is_blocked($this->input->post('username')))
                {
                    $this->session->set_flashdata('blocked', true);
                    $this->load->template('user/login', $data);
                }
                elseif($this->users->checkUserByCredentials($this->input->post('username'), $this->input->post('password')))
                {
                    $cur_ip = $this->input->ip_address();
                    $last_ip = $this->users->get_last_ip($this->input->post('username'));
                    $user_creds = $this->users->getUserCreds($this->input->post('username'));
                    set_cookie('uid', $user_creds['id'], '3600');
                    $user = $this->users->getUserById($user_creds['id']);
                    $sess_data = array('uid' => $user['id'],
                        'username' => $user['login'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'lastname' => $user['lastname'],
                        'skype' => $user['skype'],
                        'mobile_num' => $user['mobile_num'],
                        'reflink' => $user['reflink'],
                        'ava' => $user['ava']
                        );
                    $this->session->set_userdata($sess_data);
                    $this->users->UpdateVisitDate($user['id']);
                    $signed_info = $this->authentication->getAuthString($user_creds['id'], $user_creds['email'], $user_creds['password']);
                    set_cookie('signed_info', $signed_info, '3600');
                    set_cookie('lang', $user['u_lang'], 3600 * 80);
                    $this->users->updateUserIp($user['id']);
                    redirect('/cabinet/index');
                }
                else
                {

                    if($ip != '178.62.201.102')
                    {
                        $this->users->add_trying($ip);
                    }

                    $this->load->template('user/login', array('bans' =>$data['bans'], 'login_failed' => true, 'site_name' => $settings['site_name']));
                }
            }
        }
    }
    public function reg()
    {
        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $this->load->library('authentication');
        if ($this->authentication->checkAuth())
        {
            if(!is_null(get_cookie('uid')) && !$this->users->user_verified(get_cookie('uid')))
            {
                $this->session->set_userdata('uid', get_cookie('uid'));
                redirect('user/need_verification');
            }
            else
            {
                redirect('/cabinet/index');
            }
        }

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'lang:username', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]|alpha_dash');
        $this->form_validation->set_rules('password', 'lang:password', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];

        $data['sponsor_for_out'] = '3musketiere';
        $sponsor_for_out = -1;
        if(get_cookie('link') != null)
        {
            $sponsor_for_out = get_cookie('link');
        }
        if($this->session->link != null && $this->session->link > 0)
        {
            $sponsor_for_out = $this->session->link;
        }
        if($sponsor_for_out != -1)
        {
            $sponsor = $this->users->get_user_login_by_reflink($sponsor_for_out);
            if($sponsor != -1)
            {
                $data['sponsor_for_out'] = $sponsor;
            }
            else
            {
                $data['sponsor_for_out'] = '3musketiere';
            }
        }


        if ($this->form_validation->run() == FALSE)
        {
            if(isset($_SESSION['ip_confirmed']))
            {
                $this->session->set_flashdata('ip_confirmed', true);
            }
            $this->load->template('user/reg', $data);
        }
        else
        {
            if($this->users->is_blocked($this->input->post('username')))
            {
                $this->session->set_flashdata('blocked', true);
                $this->load->template('user/login', $data);
            }
            elseif($this->users->checkUserByCredentials($this->input->post('username'), $this->input->post('password')))
            {
                $cur_ip = $this->input->ip_address();
                $last_ip = $this->users->get_last_ip($this->input->post('username'));
                if(!$this->session->isadmin && $last_ip['last_ip'] != '' && $last_ip['last_ip'] != $cur_ip)
                {
                    $key = $this->generate_ip_verification();
                    $uid = $this->users->getIdByLogin($this->input->post('username'));
                    $user = $this->users->getUserById($uid['id']);
                    $this->users->make_ip_confirmation($key, $uid['id']);
                    $r = $this->send_validation_message($user['email'], 'confirm_ip_message', 'confirm_ip', 'confirm_ip/' . $key);
                    if($r)
                    {
                        $this->session->set_flashdata('ip_verify', true);
                    }
                    else
                    {
                        $this->session->set_flashdata('mail_send_false', true);
                    }
                    $this->load->template('user/login', $data);
                }
                else
                {
                    $user_creds = $this->users->getUserCreds($this->input->post('username'));
                    set_cookie('uid', $user_creds['id'], '3600');
                    $user = $this->users->getUserById($user_creds['id']);
                    $sess_data = array('uid' => $user['id'],
                        'username' => $user['login'],
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'lastname' => $user['lastname'],
                        'reflink' => $user['reflink'],
                        'ava' => $user['ava']
                        );
                    $this->session->set_userdata($sess_data);
                    $signed_info = $this->authentication->getAuthString($user_creds['id'], $user_creds['email'], $user_creds['password']);
                    set_cookie('signed_info', $signed_info, '3600');
                    set_cookie('lang', $user['u_lang'], 3600 * 80);
                    $this->users->updateUserIp($user['id']);
                    redirect('/cabinet/index');
                }
            }
            else
            {
                $this->load->template('user/login', array('login_failed' => true, 'site_name' => $settings['site_name']));
            }
        }
    }
    public function confirm_reset_pass($str)
    {
        $result = $this->users->check_password_token($str);
        if($result['res'] != 1 || is_null($result['res']))
        {
            $this->session->set_flashdata('token_err', true);
            redirect('user/login');
        }
        else
        {
            $this->users->updateUserIp($result['iduser']);
            $this->session->set_userdata('uuid', $result['iduser']);
            redirect('user/makenewpass');
        }
    }
    public function makenewpass()
    {
        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->load->library('authentication');

        $this->form_validation->set_rules('newpassword', 'lang:password', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('passconf', 'lang:passconf', 'required|matches[newpassword]|trim|htmlspecialchars|strip_tags|xss_clean');

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->template('user/makenewpass', $data);
        }
        else
        {
            $this->users->clean_confirmations($this->session->uuid);
            $this->users->setNewPassword($this->session->uuid);
            $this->session->unset_userdata('uuid');
            $this->session->set_flashdata('pass_changed', true);
            redirect('user/login');
        }
    }
    public function reset_pass()
    {
        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security');
        $this->load->library('form_validation');

        if(isset($_POST['g-recaptcha-response']))
        {

            if( $curl = curl_init() )
            {

                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6Lc7tsEUAAAAAIJ02MvYrX6XbZ4Y4QU7F8aL8tmY&response=".$_POST['g-recaptcha-response']);
                $res = curl_exec($curl);

                $res = json_decode($res);

                if($res->success)
                {
                    $can = true;
                }
                else
                {
                    $can = false;
                }
                $can = true;

                curl_close($curl);
            }

        }
        else
        {
            $can = true;
        }

        if(isset($_POST['g-recaptcha-response']) && !$can)
        {
            $_SESSION['er_cr_comp'] = $this->lang->line('error_captcha');
            $this->load->template('user/recovery', $data);
        }
        else
        {

            $this->form_validation->set_rules('email', 'lang:email', 'required|trim|htmlspecialchars|strip_tags|xss_clean|valid_email');

            $settings = $this->settings->get_settings();
            $data['site_name'] = $settings['site_name'];

            if($this->form_validation->run() == FALSE)
            {
                $this->load->template('user/recovery', $data);
            }
            else
            {
                $key = $this->generate_pass_verification();
                $uid = $this->users->getUserByEmail($this->input->post('email'));
                if($uid == null)
                {
                    $this->session->set_flashdata('mail_sent', true);
                    redirect('user/login');
                }
                else
                {
                    $this->users->make_pass_confirmation($key, $uid['id']);
                    $r = $this->send_validation_message($uid['email'], 'reset_pass_message', 'reset_pass_topic', 'reset_pass/' . $key);
                    if ($r)
                    {
                        $this->session->set_flashdata('mail_sent', true);
                    }
                    else
                    {
                        $this->session->set_flashdata('mail_send_false', true);
                    }
                    redirect('user/login');
                }
            }
        }
    }
    public function logout()
    {
        delete_cookie('uid');
        delete_cookie('signed_info');
        if(isset($_SESSION['ret_to_admin']) && $_SESSION['ret_to_admin'])
        {

            unset($_SESSION['uid']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['name']);
            unset($_SESSION['lastname']);
            unset($_SESSION['skype']);
            unset($_SESSION['mobile_num']);
            unset($_SESSION['reflink']);
            unset($_SESSION['ava']);
            unset($_SESSION['ret_to_admin']);

            $arr = $_SESSION['old'];

            unset($_SESSION['old']);

            $_SESSION = $arr;

            redirect('adminpanel');
        }
        else
        {
            $this->session->sess_destroy();
            redirect('welcome');
        }
    }
    public function signup()
    {

        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $this->load->helper(array('form', 'url'));
        $this->load->helper('security'); //надо для работы с xss_clean
        $this->load->library('form_validation');
        $this->load->library('authentication');
        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
                
        if( $curl = curl_init()  )
        {

            if(isset($_POST['g-recaptcha-response']))
            {

                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6Lc7tsEUAAAAAIJ02MvYrX6XbZ4Y4QU7F8aL8tmY&response=".$_POST['g-recaptcha-response']);
                $res = curl_exec($curl);

                $res = json_decode($res);


                curl_close($curl);

            }
        }

        $data['sponsor_for_out'] = '3musketiere';
        $sponsor_for_out = -1;
        if(get_cookie('link') != null)
        {
            $sponsor_for_out = get_cookie('link');
        }
        if($this->session->link != null && $this->session->link > 0)
        {
            $sponsor_for_out = $this->session->link;
        }
        if($sponsor_for_out != -1)
        {
            $sponsor = $this->users->get_user_login_by_reflink($sponsor_for_out);
            if($sponsor != -1)
            {
                $data['sponsor_for_out'] = $sponsor;
            }
            else
            {
                $data['sponsor_for_out'] = '3musketiere';
            }
        }

        if(!isset($_POST['g-recaptcha-response']) || !$res->success)
        {
            $this->load->template('user/reg', array('sponsor_for_out' => $data['sponsor_for_out'], 'bans' => $data['bans'], 'reg_failed' => true, 'cap_er' => $this->lang->line('error_captcha'), 'site_name' => $settings['site_name']));
        }
        else
        {

            if(!isset($_POST['assign']))
            {
                $this->load->template('user/reg', array('sponsor_for_out' => $data['sponsor_for_out'], 'bans' => $data['bans'], 'reg_failed' => true, 'ass_er' => $this->lang->line('registration_3'), 'site_name' => $settings['site_name']));
            }
            else
            {

                $this->form_validation->set_rules('username', 'lang:username', 'required|trim|htmlspecialchars|strip_tags|xss_clean|is_unique[users.login]|min_length[3]|max_length[255]|alpha_dash');
                $this->form_validation->set_rules('password', 'lang:password', 'required|trim|htmlspecialchars|strip_tags|xss_clean|min_length[3]|max_length[255]');
                $this->form_validation->set_rules('passconf', 'lang:passconf', 'required|matches[password]|trim|htmlspecialchars|strip_tags|xss_clean');
                $this->form_validation->set_rules('email', 'lang:email', 'required|trim|htmlspecialchars|strip_tags|xss_clean|is_unique[users.email]|valid_email');
                $this->form_validation->set_rules('country', 'country', 'required|callback_country_check');

                if($this->form_validation->run() == FALSE)
                {
                    $this->load->template('user/reg', array('sponsor_for_out' => $data['sponsor_for_out'], 'bans' => $data['bans'], 'reg_failed' => true, 'link' => 'signup', 'site_name' => $settings['site_name']));
                }
                else
                {

                    if($this->input->post('choose_lang') == 'russian')
                    {
                        set_cookie('lang', 'russian', 3600 * 80);
                        $lang = 'russian';
                    }
                    elseif($this->input->post('choose_lang') == 'english')
                    {
                        set_cookie('lang', 'english', 3600 * 80);
                        $lang = 'english';
                    }
                    elseif($this->input->post('choose_lang') == 'german')
                    {
                        set_cookie('lang', 'german', 3600 * 80);
                        $lang = 'german';
                    }
                    else
                    {
                        set_cookie('lang', 'english', 3600 * 80);
                        $lang = 'english';
                    }
                    
                    $this->config->set_item('language', $lang);
                    $this->lang->load('common_site', $lang);

                    $sponsor = -1;
                    $spec_ref_code = json_encode(array());
                    if(get_cookie('link') != null)
                    {
                        $sponsor = get_cookie('link');
                    }
                    if($this->session->link != null && $this->session->link > 0)
                    {
                        $sponsor = $this->session->link;
                    }

                    if($this->session->spec_ref_code != null)
                    {
                        $spec_ref_code = $this->session->spec_ref_code;
                    }

                    $uid = $this->users->addUser($sponsor, $spec_ref_code);

                    $key = 'registered_thanks';
                    $user = $this->users->getUserById($uid);
                    set_cookie('uid', $user['id'], '3600');
                    set_cookie('signed_info', $this->authentication->getAuthString($user['id'], $user['email'], $user['password']), '3600');
                    $sess_data = array('uid' => $user['id'],
                                'username' => $user['login'],
                                'email' => $user['email'],
                                'reflink' => $user['reflink'],
                                'ava' => $user['ava']);

                    $this->session->set_userdata($sess_data);
                    redirect('cabinet/');
                }
            }
        }
    }
    public function test_validation_message()
    {
        $this->load->library('mailrotator');
        $usermail = 'belik.v666@gmail.com';

        $subject = 'DIGIFLUXX - ok';
        $message = 'hi and hi test';
        return $this->mailrotator->send22($usermail, $subject, $message);
    }
    private function send_confirmation($uid)
    {
        $this->load->library('mailrotator');
        $usermail = $this->input->post('email');
        $encoded_link = $this->encode_params($uid, $usermail);

        $subject = 'DIGIFLUXX - ' . $this->lang->line('confirm_email');
        $message = sprintf($this->lang->line('confirmation_message'), '<br><br><a href="'.base_url() . 'index.php/verify/' . $encoded_link.'">'.base_url() . 'index.php/verify/' . $encoded_link.'</a><br><br>');
        return $this->mailrotator->send($usermail, $subject, $message);
    }
    public function confirm_email($str)
    {
        $this->load->helper('url');

        $data = $this->decode_params($str);

        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];

        if(!$this->users->validated($data[0]))
        {
            $this->users->validate_user($data[0]);
            $this->users->set_status($data[0], 2);
            $this->load->template('user/info', array('bans' => $data['bans'], 'result' => 'success_validation', 'site_name' => $settings['site_name']));
           $this->output->set_header('refresh:3;url=' . base_url() .'index.php/cabinet/index');
        }
        else
        {
            $this->users->validate_user($data[0]);
            $this->users->set_status($data[0], 2);
            $this->load->template('user/info', array('bans' => $data['bans'], 'result' => 'success_validation', 'site_name' => $settings['site_name']));
            $this->output->set_header('refresh:3;url=' . base_url() .'index.php/cabinet/index');
        }
    }
    public function need_verification()
    {
        $this->load->model('Comp_model', 'comp');
        $data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 2, '728x90' => 1), array('lang' => get_cookie('lang')));

        $settings = $this->settings->get_settings();
        $data['site_name'] = $settings['site_name'];
        $this->load->template('user/info', array('bans' => $data['bans'], 'result' => 'user_not_verified', 'site_name' => $settings['site_name']));
    }
    public function switch_lang($str = '')
    {
        if($str == 'russian' || $str == 'english' || $str == 'german')
        {
            set_cookie('lang', $str, 3600 * 80);
            $this->load->library('user_agent');
            
            if(isset($_SESSION['uid']))
            {
                $this->users->add_lang($str, $_SESSION['uid']);
            }
        }

        redirect($this->agent->referrer());
    }



    //ADDED FUNCS
    private function generate_ip_verification()
    {
        $this->load->helper('string');
        return random_string('alnum', 40);
    }
    private function generate_pass_verification()
    {
        $this->load->helper('string');
        return random_string('sha1');
    }
    public function country_check($str)
    {
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
        if(!is_string($str) || $str == '' || !array_key_exists($str, $country_arr))
        {
            $this->form_validation->set_message('country_check', 'Incorrect country');
            return false;
        }
        else
        {
            return true;
        }
    }
    private function send_validation_message($to, $message, $topic, $params)
    {
        $this->load->library('mailrotator');
        $usermail = $to;

        $subject = 'DIGIFLUXX - ' . $this->lang->line($topic);
        $message = sprintf($this->lang->line($message), base_url() . 'index.php/' . $params);
        return $this->mailrotator->send($usermail, $subject, $message);
    }
    private function encode_params($uid, $usermail)
    {
        $str = $uid . '/' . $usermail;
        $encoded = base64_encode(base64_encode($str));
        return bin2hex($encoded . 'salt');
    }
    private function decode_params($str)
    {
        $decoded = base64_decode(base64_decode(str_replace('salt', '', hex2bin($str))));
        $decoded = explode('/', $decoded);
        return $decoded;
    }
    public function mk()
    {
        echo password_hash('1234', PASSWORD_BCRYPT);
    }
}