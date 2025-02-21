<?php
	
// $user = 'digifluxxcom';
// $pass = '!00Oy6hm';
// $host = 'localhost';
// $DBname = 'digifluxx_system';

// $dsn = 'mysql:host='.$host.';dbname='.$DBname.';charset=utf8';

// $opt = array(
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false
// );

// $DBdes = new PDO($dsn, $user, $pass, $opt);
// echo time().'<br>';
// for($a = 0; $a <= 500; $a++) {
// 	for($i = 0; $i <= 1000; $i++) {
// 		$DBdes->query("SELECT id FROM users WHERE id=".$i);
// 	}
// }
// echo time().'<br>';
// exit();



// N - {"id":2495657,"type":"deposit","crypto_address":{"id":1321128,"currency":"TBTC","address":"2NEsCUYuTVmefYqESDEW3zh4REU3EgwrvmL","tag":null,"foreign_id":"uid:666"},"currency_sent":{"currency":"TBTC","amount":"0.02942315"},"currency_received":{"currency":"TBTC","amount":"0.02942315","amount_minus_fee":"0.02918777"},"transactions":[{"id":1774238,"currency":"TBTC","transaction_type":"blockchain","type":"deposit","address":"2NEsCUYuTVmefYqESDEW3zh4REU3EgwrvmL","tag":null,"amount":"0.02942315","txid":"69e7d9d52f00240ca7e5ed8ec0b2973b902a620c768c5f6c477cb206b975e134","confirmations":"1"}],"fees":[{"type":"deposit","currency":"TBTC","amount":"0.00023538"}],"error":null,"status":"confirmed"}

// H - {"X-Processing-Signature":"3a08f609e23ce598a48417b3142f605d6b37e6beb5986ebaf3962477ffaa19724c659d84e9e76197706dab1e92890d9fe56de0dcf4efcc8f0f2dc9d4215c37f3","X-Processing-Key":"VAvkh3uWfTXET9RW48hFn7wuPpb6JRhn","User-Agent":"GuzzleHttp\/6.3.3 curl\/7.64.0 PHP\/7.3.8","Host":"digifluxx.com"}

$postData = file_get_contents('php://input');
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

		$DBdes = new PDO($dsn, $user, $pass, $opt);
		$DBdes->query("INSERT INTO `btc_logs`(`type`, `info_head`, `info_body`, `date`) VALUES ('Coinpaids_after_fix', '".$_SERVER['HTTP_X_PROCESSING_SIGNATURE']."','".json_encode($data)."',now())");

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
	            $DBdes->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, hash_pe, actiondate) VALUES(2, 'BTC', ".$uid.", 1, ".$sum.", 'real sum = ".$RealSum."', '".$hash.'_'.$id1.'_'.$id2.'_'.$id3."', now())");

	        }

		}
	}
}

?>