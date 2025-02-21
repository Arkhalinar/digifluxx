<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<?php
	if(isset($_POST['paysys']) && ($_POST['paysys'] == 'PE' || $_POST['paysys'] == 'ADV') && isset($_POST['amount']) && is_numeric($_POST['amount'])) {

		$uid = $_SESSION['uid'];

		$amount = str_replace(',', '.', $_POST['amount']);
		$amount = number_format($amount, 2, '.', '');

		$message = 'traffic-star balance refill';

		switch ($_POST['paysys']) {
			case 'PE':
				$pe_shop = '714271948';//self::$pay_info['Payeer']['SHOP_ID'];
				$pe_orderid = time().'_'.$uid;
				$pe_curr = 'USD';//self::$pay_info['Payeer']['CURRENCY'];
				$pe_desc = base64_encode($message);
				$pe_key = '37fe2df934';//self::$pay_info['Payeer']['KEY_FOR_REFILL'];
				$pe_amount = $amount;

				$arHash = array(
				    $pe_shop,
				    $pe_orderid,
				    $pe_amount,
				    $pe_curr,
				    $pe_desc,
				    $pe_key
				);

				$pe_sign = strtoupper(hash('sha256', implode(":", $arHash)));
				echo '<form id="pay_form" method="post" action="https://payeer.com/merchant/" style="display:none;">
						<input type="hidden" name="m_shop" value="'.$pe_shop.'">
						<input type="hidden" name="m_orderid" value="'.$pe_orderid.'">
						<input type="hidden" name="m_amount" value="'.$pe_amount.'">
						<input type="hidden" name="m_curr" value="'.$pe_curr.'">
						<input type="hidden" name="m_desc" value="'.$pe_desc.'">
						<input type="hidden" name="m_sign" value="'.$pe_sign.'">
						<input type="submit" name="m_process" value="send" />
					</form>
					<script>$("#pay_form").submit();</script>';
				break;
			case 'ADV':
				$adv_mail = '';//self::$pay_info['ADVCash']['MAIN_MAIL'];
				$adv_sci_name = '';//self::$pay_info['ADVCash']['SCI_NAME'];
				$adv_curr = '';//self::$pay_info['ADVCash']['CURRENCY'];
				$adv_sci_pass = '';//self::$pay_info['ADVCash']['SCI_PASS'];
				$adv_order_id = time().'_'.$uid;
				$adv_amount = $amount;

				$arHash = array(
				    $adv_mail,
				    $adv_sci_name,
				    $adv_curr,
				    $adv_sci_pass,
				    $adv_order_id
				);

				$adv_sign =  hash('sha256', implode(":", $arHash));
				echo '<form id="pay_form" action="https://wallet.advcash.com/sci/" method="POST" style="display:none;">
							<input type="hidden" id="PayID" name="ac_account_email" value="'.$adv_mail.'">
							<input type="hidden" name="ac_sci_name" value="'.$adv_sci_name.'">
							<input type="hidden" name="ac_currency" value="'.$adv_curr.'">
							<input type="hidden" name="ac_comments" value="'.$message.'">
							<input type="hidden" name="ac_order_id" value="'.$adv_order_id.'">
							<input type="hidden" name="ac_sign" value="'.$adv_sign.'">
							<input type="hidden" name="ac_amount" value="'.$adv_amount.'">
							<input type="submit" name="ac_pay" value="send">
						</form>
						<script>$("#pay_form").submit();</script>';
				break;
		}
	}
?>