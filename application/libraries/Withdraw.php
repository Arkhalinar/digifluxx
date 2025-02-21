<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw {
    protected $ci;


    public function __construct()  {
        $this->ci =& get_instance();
        $this->ci->load->model('finances_model', 'finances');
        $this->ci->load->model('user_model', 'users');
        $this->ci->load->model('settings_model', 'settings');
    }
	
	public function adv_get_bal() {
		require_once(APPPATH . 'third_party/adv/MerchantWebService.php');
        $merchantWebService = new MerchantWebService();

        $arg0 = new authDTO();
        $arg0->apiName = 'tradprf';
        $arg0->accountEmail = 'adtradeprofit@gmail.com';
        $arg0->authenticationToken = $merchantWebService->getAuthenticationToken('37fe2df934');

        $getBalances = new getBalances();
		$getBalances->arg0 = $arg0;
		$getBalancesResponse = $merchantWebService->getBalances($getBalances);

        return $getBalancesResponse->return[0]->amount;;
	}

	public function adv($uid, $sum, $wallet, $is_confirmation = 0) {
            require_once(APPPATH . 'third_party/adv/MerchantWebService.php');
            $merchantWebService = new MerchantWebService();

            $arg0 = new authDTO();
            $arg0->apiName = 'tradprf';
            $arg0->accountEmail = 'adtradeprofit@gmail.com';
            $arg0->authenticationToken = $merchantWebService->getAuthenticationToken('37fe2df934');

            $arg1 = new sendMoneyRequest();
            $arg1->amount = round($sum, 2);
            $arg1->currency = "USD";
            // $arg1->email = "receiver_email";
            $arg1->walletId = $wallet;
            $arg1->note = 'From TradeProfit';
            $arg1->savePaymentTemplate = false;

            $validationSendMoney = new validationSendMoney();
            $validationSendMoney->arg0 = $arg0;
            $validationSendMoney->arg1 = $arg1;

            $sendMoney = new sendMoney();
            $sendMoney->arg0 = $arg0;
            $sendMoney->arg1 = $arg1;

            try {
                $merchantWebService->validationSendMoney($validationSendMoney);
                $sendMoneyResponse = $merchantWebService->sendMoney($sendMoney);
				
				if($is_confirmation > 0)
					$this->ci->finances->confirm_payment($is_confirmation);
				else
					$this->ci->finances->addTransaction($uid, null, $sum, 3, 1, 0, null, null, $wallet);
                
				if($is_confirmation == 0)
					$this->ci->users->subFunds($_POST['sum'], $udi);
				return true;
            } catch (Exception $e) {
                $f = fopen('logs_ADV_out.txt', 'a+');
                fwrite($f, $e->getMessage()."\n\r".$e->getTraceAsString()."\n\r");
                fclose($f);
				return false;
            }
	}
	
	
	public function pe_get_bal() {
		require_once(APPPATH . 'third_party/payeer/cpayeer.php');
        $accountNumber = 'P81404839';
        $apiId   = '460612138';
        $apiKey   = 'GdBGDptYeuO1iDh6';

        $payeer = new CPayeer($accountNumber, $apiId, $apiKey);
        return $payeer->getBalance();
	}

	public function payeer($uid, $sum, $wallet, $is_confirmation = 0) {
		require_once(APPPATH . 'third_party/payeer/cpayeer.php');
        $accountNumber = 'P81404839';
        $apiId   = '460612138';
        $apiKey   = 'GdBGDptYeuO1iDh6';

        $payeer = new CPayeer($accountNumber, $apiId, $apiKey);

        if ($payeer->isAuth()) {
			$arTransfer = $payeer->transfer(array(
				'curIn' => 'USD', // счет списания 
				'sum' => $sum,  // Сумма получения 
				'curOut' => 'USD', // валюта получения  
				'to' => $wallet,  // Получатель
				'comment' => 'From TradeProfit',
            ));

            if(!empty($arTransfer["historyId"])) {
				if($is_confirmation > 0)
					$this->ci->finances->confirm_payment($is_confirmation);
				else
					$this->ci->finances->addTransaction($uid, null, $sum, 3, 1, 0, null, null, $wallet);
				
				if($is_confirmation == 0)
					$this->ci->users->subFunds($sum, $uid);
				return true;
            } else {
				return false;
            }

        } else {
			return false;
        }
	}
	
	public function coinpayments_get_bal() {
		$priv_api = '47D05bbb898cAC44c48f985f4724618b9785ac2Bf99782B465b677E4B64b3903';
        $pub_api = 'c24059eb5dbdb51897434d6cb573ba018cae7026ba8ac024091e69145777fc29';
		$eth_api_addr = 'https://www.coinpayments.net/api.php';
		$cmd = 'balances';

		$ipn_url = urlencode(base_url() . 'withdraw_cb');
		$str = 'version=1&cmd=' . $cmd . '&key=' . $pub_api;
		$hmac = hash_hmac('sha512', $str, $priv_api);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $eth_api_addr);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array('HMAC: ' . $hmac);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);
		curl_close ($ch);

		$ret = json_decode($server_output);

        return $ret ;
	}

	public function crypto($system, $uid, $sum, $wallet, $is_confirmation = 0) {

		// $f = fopen('ara_test.txt1', 'a+');

		require_once(APPPATH . 'third_party/simple_html_dom.php');

		
		$sett_arr = $this->ci->settings->get_settings();

		if($system == "ETH") {
			$code = 'ETH';

            $add = $sett_arr['com_ETH'];

    //         if(!$this->eth_wallet_valid($wallet)) {
				// $f = fopen('wd_log.txt', 'a+');
				// fwrite($f, 'Некорректный кошелек: ' . $wallet . "\r\n");
				// fclose($f);
				// return false;
    //         }
        }
		if($system == "BTC") {
			$code = 'BTC';

			$add = $sett_arr['com_BTC'];
			
			// if(!$this->btc_wallet_valid($wallet)) {
			// 	$f = fopen('wd_log.txt', 'a+');
			// 	fwrite($f, 'Некорректный кошелек: ' . $wallet . "\r\n");
			// 	fclose($f);
			// 	return false;
			// }
		}
		if($system == "LTC") {
			$code = 'LTC';

			$add = $sett_arr['com_LTC'];
			
			// if(!$this->ltc_wallet_valid($wallet)) {
			// 	$f = fopen('wd_log.txt', 'a+');
			// 	fwrite($f, 'Некорректный кошелек: ' . $wallet . "\r\n");
			// 	fclose($f);
			// 	return false;
			// }
		}
		if($system == "BCH") {
			$code = 'BCH';

			$add = $sett_arr['com_BCH'];

			//тут быстрого решения не нашел; юзер сам несет ответственность за правильность кошелька
		}

		if($system == "DASH") {
			$code = 'DASH';
			
			$add = $sett_arr['som_DASH'];

			//тут быстрого решения не нашел; юзер сам несет ответственность за правильность кошелька
		}

		// $f = fopen('ara_test.txt11', 'a+');

		$priv_api = '47D05bbb898cAC44c48f985f4724618b9785ac2Bf99782B465b677E4B64b3903';
        $pub_api = 'c24059eb5dbdb51897434d6cb573ba018cae7026ba8ac024091e69145777fc29';
		$eth_api_addr = 'https://www.coinpayments.net/api.php';
		$cmd = 'create_withdrawal';

		$full_out = $sum*1.00503;
        $sum = $full_out*0.995-$add;

        // $f = fopen('ara_test.txt111', 'a+');

		$ipn_url = urlencode(base_url() . 'withdraw_cb');
		$str = 'amount=' . $sum . '&currency=' . $code . '&version=1&cmd=' . $cmd . '&key=' . $pub_api . '&ipn_url=' . $ipn_url . '&address=' . $wallet . '&auto_confirm=1';
		$hmac = hash_hmac('sha512', $str, $priv_api);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $eth_api_addr);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array('HMAC: ' . $hmac);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);
		curl_close ($ch);

		// $f = fopen('ara_test.txt1111', 'a+');

		$ret = json_decode($server_output);
		if($ret->error != 'ok') {
			$f = fopen('coinpayments-error_log_OUT.txt', 'a+');
			fwrite($f, time() . ': ' . $ret->error . "\r\n");
			fwrite($f, '=====END OF REQUEST=====');
			fclose($f);
			return array(-2, $ret->error);
		}
		
		$f = fopen('coinpayments-send_OUT.txt', 'a+');
		fwrite($f, 'FIRST - '.$ret->result->id.' query string:' . $str . "\r\n");
		fwrite($f, 'hmac:' . $hmac . "\r\n");
		fwrite($f, "======END OF QUERY======\r\n\r\n");
		fwrite($f, $server_output);
		fwrite($f, "\r\n======END OF RESPONSE======\r\n\r\n");
		fclose($f);
			
		// $f = fopen('ara_test.txt4', 'a+');

		// if($is_confirmation > 0)
		// $this->ci->finances->confirm_payment($is_confirmation);
		$this->ci->finances->add_id_payment($is_confirmation, $ret->result->id);
		// else
		// 	$this->ci->finances->addTransaction($uid, null, $sum, 3, 1, 0, null, null, $wallet);
		
		// if($is_confirmation == 0)
		// 	$this->ci->users->subFunds($sum);
		return 1;
	}
	
	public function eth_wallet_valid($wallet) {
        if (!preg_match('/^(0x)?[0-9a-fA-F]{40}$/i', $wallet)) {
            return false;
        }
        return true;
    }
    public function btc_wallet_valid($wallet) {
        if (!preg_match('/^[1][a-km-zA-HJ-NP-Z1-9]{25,34}$/i', $wallet)) {
            return false;
        }
        return true;
    }
    public function ltc_wallet_valid($wallet) {
        if (!preg_match('/^L[a-zA-Z0-9]{26,33}$/i', $wallet)) {
            return false;
        }
        return true;
    }
	
}