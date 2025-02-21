<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
	
	public function look($num) {
		switch ($num) {
			case '1':
				$path = 'Coin_distribution.png';
				break;
			case '2':
				$path = 'FOLK_COIN.png';
				break;
			case '3':
				$path = 'FOLK_COIN_ROAD_MAP.png';
				break;
			case '4':
				$path = 'ICO_START.png';
				break;
			case '5':
				$path = 'pp.png';
				break;
			case '6':
				$path = 'Sale_stages.png';
				break;
		}
		echo '<img src="https://folk-co.in/assets/img/'.$path.'">';
	}

	public function go() {
		$this->load->library('mailrotator');
		$z = $this->mailrotator->send('support@tradeprofit.net','Проверка связи','Оно Работает!!!');
		var_dump($z);
	}

	public function get_data($smtp_conn) {
		$data="";
		while($str = fgets($smtp_conn,515)) {
			$data .= $str;
			if(substr($str,3,1) == " ") { break; }
		}
		return $data;
	}

	
}
