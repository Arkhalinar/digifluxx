<?php
	//$postData = file_get_contents('php://input');
exit();
	$postData = '{"id":2739953,"type":"deposit","crypto_address":{"id":1575229,"currency":"BTC","address":"32ED6rARAz8VyGVxabisVR2WjC9LWjaZGu","tag":null,"foreign_id":"uid:376"},"currency_sent":{"currency":"BTC","amount":"0.00098592"},"currency_received":{"currency":"BTC","amount":"0.00098592","amount_minus_fee":"0.00097804"},"transactions":[{"id":2041039,"currency":"BTC","transaction_type":"blockchain","type":"deposit","address":"32ED6rARAz8VyGVxabisVR2WjC9LWjaZGu","tag":null,"amount":"0.00098592","txid":"80b1c7aa6742704e216025bc284c1b206e54b71a94ed52fea9c9358b712e8f5d","riskscore":"0.00","confirmations":"2"}],"fees":[{"type":"deposit","currency":"BTC","amount":"0.00000788"}],"error":"Transaction locked with code: 500","status":"confirmed"}';

if(!empty($postData)) {
	$data = json_decode($postData);

	if (json_last_error() === JSON_ERROR_NONE) {
	    
		$user = 'admin_digifluxx';
		$pass = '532a43e252725ccc739fee90a4768936';
		$host = 'localhost';
		$DBname = 'admin_digifluxx';

		$dsn = 'mysql:host='.$host.';dbname='.$DBname.';charset=utf8';

		$opt = array(
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES   => false
		);

		$_SERVER['HTTP_X_PROCESSING_SIGNATURE'] = '92762c747406da2c8bb4ac5a914acac5a2e9af71bb9d9222afdb17b649fa22e1509e04373ad5b4f1fc46552dd515f05807d3fb3e3710a709e88cd139df0ac8c4';

		$DBdes = new PDO($dsn, $user, $pass, $opt);
		$DBdes->query("INSERT INTO `btc_logs`(`type`, `info_head`, `info_body`, `date`) VALUES ('Coinpaids34', '".$_SERVER['HTTP_X_PROCESSING_SIGNATURE']."','".json_encode($data)."',now())");

		$secr_key = 'KLPjibxKTnaoQazFi6ZlErXmkFQe4EAcJQGfcSFnUdidsX19VZRBBuA7oDZ2CvGD';
		$signature = hash_hmac('sha512', $postData, $secr_key);

		if($signature === $_SERVER['HTTP_X_PROCESSING_SIGNATURE'] && $data->currency_received->currency == 'BTC' && $data->status == 'confirmed') {

			$StringWithUserId = $data->crypto_address->foreign_id;
        	$ArrayWithUserId = explode(':', $StringWithUserId);
        	if($ArrayWithUserId[0] == 'uid') {
        		$uid = $ArrayWithUserId[1];
        	}else {
        		exit();
        	}

        	$hash = $data->transactions[0]->txid;
        	$id1 = $data->id;
			$id2 = $data->crypto_address->id;
			$id3 = $data->transactions[0]->id;

			$res = $DBdes->query("SELECT id FROM payments WHERE type=2 AND idreceiver=".$uid." AND hash_pe='".$hash.'_'.$id1.'_'.$id2.'_'.$id3."'");
	        if($res->rowCount() < 1) {

	        	$res = $DBdes->query("SELECT Credits FROM curs_btc WHERE Cur='BTC'");
	        	$ArrayOfCurses = $res->fetch(PDO::FETCH_ASSOC);

	        	$RealSum = $data->currency_received->amount;
	        	$sum = round($ArrayOfCurses['Credits']/(1/$RealSum), 0);

	        	$DBdes->query("UPDATE users SET amount_btc=amount_btc+".$sum." WHERE id=".$uid);

	        	// echo "INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, hash_pe, actiondate) VALUES(2, 'BTC', ".$uid.", 1, ".$sum.", 'real sum = ".$RealSum."', '".$hash.'_'.$id1.'_'.$id2.'_'.$id3."', now())";exit();

	            $DBdes->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, hash_pe, actiondate) VALUES(2, 'BTC', ".$uid.", 1, ".$sum.", 'real sum = ".$RealSum."', '".$hash.'_'.$id1.'_'.$id2.'_'.$id3."', now())");

	        }

		}
	}
}
?>