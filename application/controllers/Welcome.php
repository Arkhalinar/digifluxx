<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('settings_model', 'settings');
		$settings = $this->settings->get_settings();

		if($settings['site_opened'] != 1)
		{
			redirect('site/index');
		}

		if(get_cookie('lang') == null)
		{
			$lang = 'english';
			set_cookie('lang', $lang, 3600*24*30);
		}
		elseif(in_array(get_cookie('lang'), array('russian', 'english', 'german')))
		{
			$lang = get_cookie('lang');
		}
		else
		{
			$lang = 'english';
			set_cookie('lang', $lang, 3600*24*30);
		}

		$this->config->set_item('language', $lang);
		$this->lang->load('common_site', $lang);
	}

	public function change_perc() {
		// ini_set('error_reporting', E_ALL);
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		
		// $this->load->model('marketing_model', 'mark');
		// $this->mark->change_table();
	}

	public function main($refuser = null) {

		$this->load->model('settings_model', 'settings');
		$data['setts'] = $this->settings->get_settings();

		$data['main_stat'] = $this->settings->get_main_stat();

		$this->load->model('Comp_model', 'comp');
		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));
		$data['stat'] = $this->comp->getStatForMain();
		$data['tar'] = $this->comp->getTarInfo();
		$data['sets'] = $this->comp->get_setts();

		//write user reflink to cookie
		if($this->input->get('u') != null) {
			if(get_cookie('link') != null && get_cookie('link') != $this->input->get('u')) {
				$this->settings->UpCount($this->input->get('u'));
			}
			
			set_cookie('link', $this->input->get('u'), 3600*24*30);
			$this->session->set_userdata('link', $this->input->get('u'));
		}
		if($refuser != null) {
			if(get_cookie('link') != null && get_cookie('link') != $refuser) {
				$this->settings->UpCount($refuser);
			}
			
			set_cookie('link', $refuser, 3600*24*30);
			$this->session->set_userdata('link', $refuser);
		}
		
		if(get_cookie('lang') == null) {
			$lang = 'english';
			set_cookie('lang', $lang, 3600*24*30);
		}
		else if(in_array(get_cookie('lang'), array('russian', 'english', 'german'))) {
			$lang = get_cookie('lang');
		} else {
			$lang = 'english';
			set_cookie('lang', $lang, 3600*24*30);
		}

		$this->load->view('welcome/header');
		$this->load->view('welcome/index', $data);
		$this->load->view('welcome/footer', $data);
		
	}

	//SYSTEM CHANGING LINKS
	public function count_up()
	{
		if( isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['type']) && ($_POST['type'] == 'click' || $_POST['type'] == 'show') )
		{
			$this->load->model('Comp_model', 'comp');
	 		$this->comp->up_count_ban($_POST['id'], $_POST['cont_type']);
	 	}
	}
	public function clean_day_limit()
	{
		$this->load->model('Comp_model', 'comp');
 		$this->comp->clean_qual_stat();
	}



	//PAYMENT LINKS
	public function stripe_result()
	{
		$payload = @file_get_contents('php://input');
		$event = null;
		$event = json_decode($payload);

		if(json_last_error() === JSON_ERROR_NONE)
		{

			$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

			$this->load->model('finances_model', 'finances');
			$this->finances->save_full_deposit_log('Stripe', $sig_header, $event);

			require 'stripe-php/init.php';
			\Stripe\Stripe::setApiKey('sk_live_5LzxPI0aNEnEntL6zyqzmkab');
			$endpoint_secret = 'whsec_Em1qa54zkbn2TwLo1GRpAFic8AGo0cB3';

			if($event->type == 'checkout.session.completed' && $event->data->object->display_items[0]->currency == 'eur')
			{

			  $CustomerId = $event->data->object->customer;
			  $SumAtEuro = $event->data->object->display_items[0]->amount;
			  $TransactionId = $event->data->object->id;
			  $FullInfoAtJson = $payload;


			  $this->finances->up_balance_by_stripe($CustomerId, $SumAtEuro, $TransactionId, $FullInfoAtJson);

			}

			if($event->type == 'source.chargeable')
			{
			  $ArrOfUid = explode('_', $event->data->object->statement_descriptor);
			  $SumAtEuro = $event->data->object->amount;
			  $TransactionId = $event->data->object->id;
			  $FullInfoAtJson = $payload;

			  $this->finances->up_balance_by_sofort($ArrOfUid[1], $SumAtEuro, $TransactionId, $FullInfoAtJson);
			}
		}
	}
	public function payeer()
	{

		$f = fopen('payeer_logs.txt', 'a+');
		fwrite($f, $_SERVER['HTTP_X_REAL_IP']." POST - ".json_encode($_POST)."\n\r\n\r");
		fwrite($f, $_SERVER['HTTP_X_REAL_IP']." GET - ".json_encode($_GET)."\n\r\n\r");

		if (!in_array($_SERVER['HTTP_X_REAL_IP'], array('185.71.65.92', '185.71.65.189', '149.202.17.210'))) return;

		if (isset($_POST['m_sign']))
		{

			$pe_key = '37fe2df934';

			$arHash = array(
				$_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status']
			);

			if (isset($_POST['m_params']))
			{
				$arHash[] = $_POST['m_params'];
			}

			$arHash[] = $pe_key;

			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

			if($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
			{
				
				$this->load->model('invoices_model', 'invoices');
				
				$inv_info = $this->invoices->get_invoice_by_pay_code($sign_hash);

				if($inv_info == NULL)
				{

					$us_info = explode('_', $_POST['m_orderid']);

					$this->invoices->update_invoices_pe($us_info[1], $_POST['m_amount'],  $sign_hash);

				}

				echo $_POST['m_orderid'].'|success';
				exit();
			}
			echo $_POST['m_orderid'].'|error';
			exit();
		}
	}
	public function cpget()
	{

		$f = fopen('A_cp_new_logs3.txt', 'a+');
		fwrite($f, $_SERVER['HTTP_X_REAL_IP']." POST - ".json_encode($_POST)."\n\r\n\r");
		fwrite($f, $_SERVER['HTTP_X_REAL_IP']." GET - ".json_encode($_GET)."\n\r\n\r");

		if (isset($_POST['txn_id']))
		{

			$merchant_id = '157b18a4631a457a557355956fd41dcb';
			$secret = '37fe2df934';

			if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC']))
			{
			  die("No HMAC signature sent");
			}

			$merchant = isset($_POST['merchant']) ? $_POST['merchant']:'';
			if (empty($merchant))
			{
			  die("No Merchant ID passed");
			}

			if ($merchant != $merchant_id)
			{
			  die("Invalid Merchant ID");
			}

			$request = file_get_contents('php://input');
			if ($request === FALSE || empty($request))
			{
			  die("Error reading POST data");
			}

			$hmac = hash_hmac("sha512", $request, $secret);
			if ($hmac != $_SERVER['HTTP_HMAC'])
			{
			  die("HMAC signature does not match");
			}

			$this->load->model('invoices_model', 'invoices');
			$inv_info = $this->invoices->get_invoice_by_pay_code($_POST['txn_id']);

			if($inv_info == NULL || $inv_info['status'] != 100)
			{

				$us_info = explode('_', $_POST['item_number']);

				$this->invoices->update_invoices_cp($us_info[1], $_POST['amount2'],  $_POST['amount1'],  $_POST['received_confirms'], $_POST['txn_id'], $_POST['status'], $_POST['currency2']);

			}

		}
	}
	public function get_bitaps()
	{

		$f = fopen('bitaps_logs.txt', 'a+');
		fwrite($f, "POST - ".json_encode($_POST)."\n\r\n\r");
		fwrite($f, "GET - ".json_encode($_GET)."\n\r\n\r");

		if(isset($_POST['tx_hash']))
		{

			$this->load->model('invoices_model', 'invoices');
					
			$inv_info = $this->invoices->get_invoice_by_pay_code($_POST['tx_hash']);

			if($inv_info == NULL || $inv_info['status'] != 100)
			{
				$this->invoices->update_invoices($_GET['user'], $_POST['address'],  $_POST['amount'],  $_POST['confirmations'], $_POST['tx_hash'], $_POST['payout_miner_fee']);
			}

			echo $_POST ["invoice"];
		}
	}



	//PAGES
	public function index($refuser = null)
	{

		$data = array();

		if($refuser != null)
		{
			$this->load->model('settings_model', 'settings');
			if(get_cookie('link') != null && get_cookie('link') != $refuser)
			{
				$this->settings->UpCount($refuser);
			}
			
			set_cookie('link', $refuser, 3600*24*30);
			$this->session->set_userdata('link', $refuser);

			if(!empty($_GET))
			{
				$this->session->set_userdata('spec_ref_code', json_encode($_GET));
			}

		}

		$this->load->view('welcome/index3', $data, false, true);
	}
	public function mark($refuser = null)
	{

		$this->load->model('settings_model', 'settings');
		$data['setts'] = $this->settings->get_settings();

		$this->load->model('Comp_model', 'comp');
		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));
		

		$this->load->view('welcome/header');
		$this->load->view('welcome/mark', $data);
		$this->load->view('welcome/footer', $data);
	}
 	public function contacts()
 	{

		$this->load->model('Comp_model', 'comp');
		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		if(isset($_POST['g-recaptcha-response']))
		{
		
			if( $curl = curl_init() )
			{

			    curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			    curl_setopt($curl, CURLOPT_POST, true);
			    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			    curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=6LczIrQUAAAAAOuwpzHAILQdq19PYWBpAf-5Xq3n&response=".$_POST['g-recaptcha-response']);
			    $res = curl_exec($curl);

			    $res = json_decode($res);

			    if($res->success)
			    {
			        $cont = true;
			    }
			    else
			    {
			        $cont = false;
			    }
			    
			    curl_close($curl);
			}

			if($cont)
			{

				if($this->input->post())
				{
					$res = $this->send_msg();
					$this->comp->add_sup_mess($this->input->post('email'), $this->input->post('subject'), $this->input->post('message'));
					if($res)
						$data['sent_ok'] = true;
					else
						$data['sent_fail'] = true;
				}
			}
			else
			{
				$data['sent_fail'] = true;
			}

		}

		$this->load->view('welcome/header');
		$this->load->view('welcome/contacts', $data);
		$this->load->view('welcome/footer', $data);
 	}
 	public function faq()
 	{
 		$this->load->model('Comp_model', 'comp');
 		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		$this->load->view('welcome/header');
  		$this->load->view('welcome/faq');
  		$this->load->view('welcome/footer', $data);
 	}
 	public function term()
 	{
 		$this->load->model('Comp_model', 'comp');
 		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		$this->load->view('welcome/header');
  		$this->load->view('welcome/term');
  		$this->load->view('welcome/footer', $data);
 	}
 	public function privacy()
 	{
 		$this->load->model('Comp_model', 'comp');
 		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		$this->load->view('welcome/header');
  		$this->load->view('welcome/privat');
  		$this->load->view('welcome/footer', $data);
 	}
 	public function risk_warning_notice()
 	{
 		$this->load->model('Comp_model', 'comp');
 		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		$this->load->view('welcome/header');
  		$this->load->view('welcome/risk_warning_notice');
  		$this->load->view('welcome/footer', $data);
 	}
 	public function impressum()
 	{
 		$this->load->model('Comp_model', 'comp');
 		$data['bans'] = $this->comp->getBansForShow(array('125x125' => 0, '300x50' => 0, '300x250' => 0, '300x600' => 0, '468x60' => 4, '728x90' => 1), array('lang' => get_cookie('lang')));

		$this->load->view('welcome/header');
  		$this->load->view('welcome/impressum');
  		$this->load->view('welcome/footer', $data);
 	}

 	

 	//SOME ADDING FUNCS
	public function send_msg()
	{
		if($this->input->post())
		{
			$from = $this->input->post('email');
			$subj = $this->input->post('subject');
			$msg = $this->input->post('message');

			$this->load->library('mailrotator');

            $subject = 'Message from main page ';
            $message = 'E-mail of user: '.$from."\n\r". 'Message:'.$msg;
            return $this->mailrotator->send('support@digifluxx.com/', $subject, $message, $from);

		}
	}
}
