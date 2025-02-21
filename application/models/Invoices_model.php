<?php
class Invoices_model extends CI_Model {

    private $table_name = "btc_invoices";

    public $iduser;
    public $addr;
    public $payment_code;
    public $invoice;
    public $pay_sum;
	public $status;
	public $conf;
	
    public function __construct() {
        parent::__construct();
    }

    public function add_invoice($iduser, $addr, $code = null, $invoice = null, $sum = null, $wallet = '', $payment_code='', $invoice_const='') {
        $this->iduser = $iduser;
        $this->addr = $addr;
        $this->payment_code = $code;
        $this->currency = "BTC";
		$this->db->set('pay_date', 'NOW()', false);

        $query = $this->db->query("SELECT * FROM btc_invoices WHERE iduser=".$iduser." AND payment_code='".$code."' AND status IS NULL");
    
        if($query->num_rows() < 1) {
            $this->db->insert($this->table_name, $this);
        }
    }
    public function save_wallet($uid, $addr, $code) {
        $this->db->query("UPDATE users SET wallet_to_ref='".$addr."', private_wallet_id=".$code." WHERE id=".$uid);
    }
    public function add_invoice_blockchain($iduser, $addr, $wallet, $invoice_const) {
        $this->db->query("UPDATE users SET wallet_to_ref='".$addr."', Invoice_ref='".$invoice_const."', wallet_to_return='".$wallet."' WHERE id=".$iduser);
        $this->db->query("INSERT INTO `btc_invoices`(`iduser`, `currency`, `addr`, `invoice`, `pay_date`) VALUES (".$iduser.", 'BTC', '".$addr."', '".$invoice_const."', now())");
    }
    public function update_invoices_cp($user, $amount2,  $amount1,  $conf, $tx_hash, $status, $currency2) {
        // ($us_info[1], $_POST['amount2'],  $_POST['amount1'],  $_POST['received_confirms'], $_POST['txn_id'], $_POST['status']);
        // $query = $this->db->query("SELECT * FROM curs_btc");
        // $row_btc = $query->row_array();

        $f = fopen('A_cp_new_logs3.txt', 'a+');
        fwrite($f, " 11"."\n\r\n\r");

        if($status == 0) {
            fwrite($f, " 12"."\n\r\n\r");

            $query = $this->db->query("SELECT * FROM btc_invoices WHERE iduser=".$user." AND payment_code='".$tx_hash."' AND status=0 ORDER BY id ASC");
            $row = $query->row_array();

            fwrite($f, " 13"."\n\r\n\r");

            if($query->num_rows() > 0) {
                fwrite($f, " 14"."\n\r\n\r");
                $this->db->query("UPDATE btc_invoices SET pay_sum=".$amount2.", status=0, conf=0, payment_code='".$tx_hash."' WHERE id=".$user);
                fwrite($f, " 15"."\n\r\n\r");
            }else {
                fwrite($f, " 16"."\n\r\n\r");
                $this->db->query("INSERT INTO btc_invoices(`iduser`, `currency`, `addr`, `pay_sum`, `status`, `conf`, `payment_code`, `pay_date`) VALUES(".$user.", 'CP|".$currency2."', '".$amount1."', ".$amount2.", 0, 0, '".$tx_hash."', now())");
                fwrite($f, " 17"."\n\r\n\r");
            }
        }elseif($status == 1 ) {
            fwrite($f, " 18"."\n\r\n\r");
            $this->db->query("UPDATE btc_invoices SET status=1 WHERE payment_code='".$tx_hash."'");
            fwrite($f, " 19"."\n\r\n\r");
        }elseif($status == 100) {
            fwrite($f, " 20"."\n\r\n\r");
            $this->db->query("UPDATE btc_invoices SET conf=3, status=100 WHERE payment_code='".$tx_hash."'");
            fwrite($f, " 21"."\n\r\n\r");
            $this->db->query("UPDATE users SET amount_btc=amount_btc+".$amount1." WHERE id=".$user);
            fwrite($f, " 22"."\n\r\n\r");
            $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, '".$currency2."', ".$user.", 1, ".$amount1.", now())");
            fwrite($f, " 23"."\n\r\n\r");

            $this->db->query("UPDATE new_stat_for_admin SET Refill_From_CP=Refill_From_CP+".$amount1);
        }
    }
    public function update_invoices($user, $address,  $amount,  $conf, $tx_hash, $fee = 0) {
        $query = $this->db->query("SELECT * FROM curs_btc");
        $row_btc = $query->row_array();

        if($conf == 0) {
            $query = $this->db->query("SELECT * FROM btc_invoices WHERE iduser=".$user." AND addr='".$address."' AND status IS NULL ORDER BY id ASC");
            $row = $query->row_array();

            $this->db->query("UPDATE users SET wallet_to_ref='' WHERE id=".$user);

            if($query->num_rows() > 0) {
                $this->db->query("UPDATE btc_invoices SET pay_sum=".bcsub(bcdiv($amount, 100000000, 8), 0.00025, 8).", status=0, conf=0, payment_code='".$tx_hash."' WHERE id=".$row['id']);
            }else {
                $this->db->query("INSERT INTO btc_invoices(`iduser`, `currency`, `addr`, `pay_sum`, `status`, `conf`, `payment_code`, `pay_date`) VALUES(".$user.", 'BTC', '".$address."', ".bcsub(bcdiv($amount, 100000000, 8), 0.00025, 4).", 0, 0, '".$tx_hash."', now())");
            }
        }elseif($conf < 3) {
            $this->db->query("UPDATE btc_invoices SET conf=".$conf." WHERE payment_code='".$tx_hash."'");
        }elseif($conf == 3) {
            $this->db->query("UPDATE btc_invoices SET conf=3, status=100 WHERE payment_code='".$tx_hash."'");
            $this->db->query("UPDATE users SET amount_btc=amount_btc+".bcmul($row_btc['USD'], bcsub(bcdiv($amount, 100000000, 8), 0.00025, 8), 4)." WHERE id=".$user);
            $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, 'BTC', ".$user.", 1, ".bcmul($row_btc['USD'], bcsub(bcdiv($amount, 100000000, 8), 0.00025, 8), 4).", now())");

            $this->db->query("UPDATE new_stat_for_admin SET Refill_From_BTPS=Refill_From_BTPS+".bcmul($row_btc['USD'], bcsub(bcdiv($amount, 100000000, 8), 0.00025, 8), 4));
        }
    }
    public function update_invoices_pe($user,  $amount,  $tx_hash) {
        $this->db->query("INSERT INTO btc_invoices(`iduser`, `currency`, `addr`, `pay_sum`, `status`, `conf`, `payment_code`, `pay_date`) VALUES(".$user.", 'PE', '-', ".$amount.", 100, 0, '".$tx_hash."', now())");
        $this->db->query("UPDATE users SET amount_btc=amount_btc+".$amount." WHERE id=".$user);
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, 'PE', ".$user.", 1, ".$amount.", now())");

        $this->db->query("UPDATE new_stat_for_admin SET Refill_From_PE=Refill_From_PE+".$amount);
    }

    public function check_wal_status($uid, $wallet) {
        $query = $this->db->query("SELECT * FROM btc_invoices WHERE addr='".$wallet."' AND iduser=".$uid." AND status IS NOT NULL");
        if($query->num_rows() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function update_invoices_blockchain($invoice,  $amount,  $conf, $tx_hash) {
        $query = $this->db->query("SELECT * FROM btc_invoices WHERE invoice='".$invoice."'");
        $row_us = $query->row_array();

        if($conf == 0) {
            $this->db->query("UPDATE btc_invoices SET pay_sum=".bcdiv($amount, 100000000, 8).", status=0, conf=0, payment_code='".$tx_hash."' WHERE id=".$row_us['id']);
            $this->db->query("UPDATE users SET wallet_to_ref='', Invoice_ref='' WHERE id=".$row_us['iduser']);
        }elseif($conf < 3) {
            $this->db->query("UPDATE btc_invoices SET conf=".$conf." WHERE invoice='".$invoice."'");
        }elseif($conf == 3) {
            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row_us['iduser']);
            $row = $query->row_array();

            if(bccomp($amount, bcmul(0.001, 100000000, 8)) < 0) {
                $this->db->query("UPDATE btc_invoices SET conf=3, status=2 WHERE invoice='".$invoice."'");
            }else {
                $this->db->query("UPDATE btc_invoices SET conf=3, status=100 WHERE invoice='".$invoice."'");
                $this->db->query("UPDATE users SET amount_btc=amount_btc+".bcdiv($amount, 100000000, 8)." WHERE id=".$row_us['iduser']);
                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, 'BTC', ".$row_us['iduser'].", 1, ".bcdiv($amount, 100000000, 8).", now())");


                //check for bonus 2
                // $f = fopen('logs_bonus_2.txt', 'a+');
                // fwrite($f, 'Begin'."\n\r");

                // fwrite($f, json_encode($row)."\n\r");

                if($row['bonus2_status'] != 1) {

                    // fwrite($f, "IN \n\r");

                    $query = $this->db->query("SELECT * FROM settings");
                    $row_setts = $query->row();

                    // fwrite($f, json_encode($row_setts)." \n\r");

                    $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=2 AND idreceiver=".$row_us['iduser']);
                    $row_count_income = $query->row();

                    // fwrite($f, json_encode($row_count_income)." \n\r");

                    if($row_count_income->sum >= $row_setts->bonus2_wal) {

                        // fwrite($f, "IN 2 \n\r");

                        $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".$row_setts->price_for_bonus2.", bonus2_status=2 WHERE id=".$row_us['iduser']);

                        // fwrite($f, "IN 3 \n\r");

                        $this->db->query("INSERT INTO payments(type, currency, idreceiver, idsender, status, amount, actiondate) VALUES(1902, 'BTC', ".$row_us['iduser'].", ".$row_us['iduser'].", 1, ".$row_setts->price_for_bonus2.", now())");

                        // fwrite($f, "IN 4 \n\r");
                    }

                }


                $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s ORDER BY Lvl ASC");
                foreach ($query->result_array() as $row1) {
                    $result[] = $row1;
                }

                $LvlRef = array();
                for($i = 0; $i < count($result); $i++) {
                    $LvlRef[$result[$i]['Lvl']+0] = $result[$i]['Percent'];
                }

                if($row['idsponsor'] != NULL) {

                    //рефферальные
                    //Начинаем с 1-го уровня и задаем флаг
                    $cont = true;
                    $lvl = 1;

                    while($cont) {

                        //проверяем есть ли в конфигах лвл больше или равно нашему
                        $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s WHERE Lvl>=".$lvl);
                        if($query->num_rows() > 0) {

                            //если есть гонимся дале
                            //смотрим спонсора выше на 1 лвл

                            if($row['idsponsor'] == NULL) {
                                $cont = false;
                                continue;    
                            }

                            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row['idsponsor']);
                            $row = $query->row_array();
                            //тут смотрим, есть ли в вынутом сверху массиве текущий уровень
                            if(array_key_exists($lvl, $LvlRef)) {

                                if($row['Count_ref_lvl'] < $lvl ) {
                                    $lvl++;
                                    continue;
                                }

                                //если есть делаем начисления
                                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul(bcdiv($amount, 100000000, 8), bcdiv( $LvlRef[$lvl], 100, 2), 8).", bonus_".$lvl."_count=bonus_".$lvl."_count+".bcdiv($amount, 100000000, 8)." WHERE id=".$row['id']);
                                $this->db->query("INSERT INTO payments(type, btc_address, currency, idreceiver, idsender, status, amount, actiondate) VALUES(38, '22', 'BTC', ".$row['id'].", ".$row_us['iduser'].", 1, ".bcmul(bcdiv($amount, 100000000, 8), bcdiv( $LvlRef[$lvl], 100, 2), 8).", now())");

                                if(bccomp(bcadd($row['bonus_'.$lvl.'_count'], bcdiv($amount, 100000000, 8), 8), 0.02, 8) >= 0 && $row['bonus1_status'] == 0) {
                                    $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+0.005, bonus1_status=2 WHERE id=".$row['id']);
                                    $this->db->query("INSERT INTO payments(type, currency, idreceiver, idsender, status, amount, actiondate) VALUES(1902, 'BTC', ".$row['id'].", ".$row_us['iduser'].", 1, 0.005, now())");
                                }
                            }
                            $lvl++;

                        }else {
                            //ели нет сбрасываем флаг
                            $cont = false;
                        }

                    }

                }
            }
        }
    }

    public function get_wal_to_ref($iduser) {
        $query = $this->db->query("SELECT * FROM users WHERE id=".$iduser);
        $row = $query->row_array();

        if($row['wallet_to_ref'] != '') {
            return $row['wallet_to_ref'];
        }else {
            return false;
        }
    }

    public function get_invoice_by_id($id) {
        return $this->db->get_where($this->table_name, array('id' => $id))->row_array();
    }

    public function get_invoice_by_invoice($invoice) {
        return $this->db->get_where($this->table_name, array('invoice' => $invoice))->row_array();
    }
	
    public function get_invoice_by_pay_code($tx_hash) {
        return $this->db->get_where($this->table_name, array('payment_code' => $tx_hash))->row_array();
    }

	public function get_invoice_by_code($code) {
        return $this->db->where(array('payment_code' => "'" . $code . "'", 'status is null or status ' => ''), NULL, false)->get($this->table_name)->row_array();
    }
	
	public function get_invoice_by_address($addr) {
        return $this->db->where(array('addr' => "'" . $addr . "'", '(conf is null or conf < ' => '100)'), NULL, false)->get($this->table_name)->row_array();
    }
	
	public function update_invoice($code) {
		$data['status'] = 1;
		$this->db->where('payment_code', $code)->update($this->table_name, $data);
	}
	
	public function update_invoice_conf($arr) {
		$this->db->where('addr', $arr['addr'])->update($this->table_name, $arr);
	}
	
	public function check_payment($wallet) {
		$res = $this->db->get_where($this->table_name, array('addr' => $wallet))->row_array();
		if($res['conf'] >= 100)
			return true;
		return false;
	}
}