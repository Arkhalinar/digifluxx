<?php
class Comp_model extends CI_Model {

    private $table_name = "compaign";

    public $struct_info;
    public $struct_info_linear;

    public $title_russian;
    public $title_english;
    public $title_german;
    public $title_hungar;
    public $body_text_russian;
    public $body_text_english;
    public $body_text_german;
    public $body_text_hungar;

    public function __construct() {
        parent::__construct();
    }


    public function clean_qual_stat() {
        $f = fopen('CRON_LOG_CLEAN_QUAL.txt', 'a+');
        $str = file_get_contents('CRON_LOG_CLEAN_QUAL.txt');

        if(time()-$str >= 86400) {
            $this->db->query("UPDATE users SET isqualified_comp=0, isqualified_banner=0");   
        }

        file_put_contents('CRON_LOG_CLEAN_QUAL.txt', time());
    }








    public function BuildStructureFromRegData() {
        exit();
        $query = $this->db->query("SELECT u.tarif as tarif, u.idsponsor as idsponsor, u.id as id, u.login as login, u.amount_btc as amount_btc FROM payments as p INNER JOIN users as u ON p.idsender=u.id WHERE p.type=2220 ORDER BY u.regdate ASC");

        foreach ($query->result_array() as $row) {
            // echo 1;
            // echo $row['regdate'].'<br>';
            // $this->BuyLvl($row, 1, 'binar');
            $this->BuyLvlTrinar_New($row);

        }
    }
    public function get_answers() {
        $query = $this->db->query("SELECT * FROM saved_answers");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[$row['type']][$row['lang']][$row['number']] = $row['answer'];
        }

        return $result;
    }
    public function save_answers($arr) {
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_1']."' WHERE lang='russian' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_2']."' WHERE lang='russian' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_3']."' WHERE lang='russian' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_4']."' WHERE lang='russian' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ru_5']."' WHERE lang='russian' AND number=5 AND type=".$_POST['type']);

        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_1']."' WHERE lang='english' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_2']."' WHERE lang='english' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_3']."' WHERE lang='english' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_4']."' WHERE lang='english' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_en_5']."' WHERE lang='english' AND number=5 AND type=".$_POST['type']);

        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_1']."' WHERE lang='german' AND number=1 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_2']."' WHERE lang='german' AND number=2 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_3']."' WHERE lang='german' AND number=3 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_4']."' WHERE lang='german' AND number=4 AND type=".$_POST['type']);
        $this->db->query("UPDATE saved_answers SET answer='".$arr['answ_ger_5']."' WHERE lang='german' AND number=5 AND type=".$_POST['type']);
    }







    /*
        tarifs operations
    */
    public function BuyTarif($uid, $num) {
        $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row();

            $tarifs = $this->getTarInfo();

            if(bccomp($row->amount_btc, $tarifs[$num]['Price_to_buy'], 4) >= 0) {
                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$tarifs[$num]['Price_to_buy'].", tarif=".($num+1).", date_st_tarif='".time()."' WHERE id=".$uid);
                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(1913, 'BTC', ".$uid.", 1, ".$tarifs[$num]['Price_to_buy'].", '".($num+1)."', now())");
                return array('tarif_name' => $tarifs[$num]['Name'].' ( '.$tarifs[$num]['Duration'], 'main_bal' => rtrim(rtrim(number_format(bcsub($row->amount_btc, $tarifs[$num]['Price_to_buy'], 4), 4, '.', ''), "0"), "."));
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    public function getTarInfo2() {
        $query = $this->db->query("SELECT * FROM tarifs");
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }
    public function update_tarif_setts($arr) {
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';
        // exit();

        $this->db->query("UPDATE `tarifs` SET `Name`='".$_POST['Name_1']."', `Duration`=".$_POST['Duration_1'].", `Max_out`=".$_POST['Max_out_1'].", `Perc_click`=".$_POST['Perc_click_1'].", `mail_click`=".$_POST['mail_click_1'].", `clink_click`=".$_POST['clink_click_1'].", `Count_ref_lvl`=".$_POST['Count_ref_lvl_1'].", `Price_to_buy`=".$_POST['Price_to_buy_1'].", `prize_125x125`=".$_POST['prize_125x125_1'].", `prize_300x250`=".$_POST['prize_300x250_1'].", `prize_468x60`=".$_POST['prize_468x60_1'].", `prize_728x90`=".$_POST['prize_728x90_1']." WHERE ID=1");

        $this->db->query("UPDATE `tarifs` SET `Name`='".$_POST['Name_2']."', `Duration`=".$_POST['Duration_2'].", `Max_out`=".$_POST['Max_out_2'].", `Perc_click`=".$_POST['Perc_click_2'].", `mail_click`=".$_POST['mail_click_2'].", `clink_click`=".$_POST['clink_click_2'].", `Count_ref_lvl`=".$_POST['Count_ref_lvl_2'].", `Price_to_buy`=".$_POST['Price_to_buy_2'].", `prize_125x125`=".$_POST['prize_125x125_2'].", `prize_300x250`=".$_POST['prize_300x250_2'].", `prize_468x60`=".$_POST['prize_468x60_2'].", `prize_728x90`=".$_POST['prize_728x90_2']." WHERE ID=2");

        $this->db->query("UPDATE `tarifs` SET `Name`='".$_POST['Name_3']."', `Duration`=".$_POST['Duration_3'].", `Max_out`=".$_POST['Max_out_3'].", `Perc_click`=".$_POST['Perc_click_3'].", `mail_click`=".$_POST['mail_click_3'].", `clink_click`=".$_POST['clink_click_3'].", `Count_ref_lvl`=".$_POST['Count_ref_lvl_3'].", `Price_to_buy`=".$_POST['Price_to_buy_3'].", `prize_125x125`=".$_POST['prize_125x125_3'].", `prize_300x250`=".$_POST['prize_300x250_3'].", `prize_468x60`=".$_POST['prize_468x60_3'].", `prize_728x90`=".$_POST['prize_728x90_3'].", Marketing=".$_POST['marketing_3'].", marketing_status=".$_POST['marketing_status_3']." WHERE ID=3");

        $this->db->query("UPDATE `tarifs` SET `Name`='".$_POST['Name_4']."', `Duration`=".$_POST['Duration_4'].", `Max_out`=".$_POST['Max_out_4'].", `Perc_click`=".$_POST['Perc_click_4'].", `mail_click`=".$_POST['mail_click_4'].", `clink_click`=".$_POST['clink_click_4'].", `Count_ref_lvl`=".$_POST['Count_ref_lvl_4'].", `Price_to_buy`=".$_POST['Price_to_buy_4'].", `prize_125x125`=".$_POST['prize_125x125_4'].", `prize_300x250`=".$_POST['prize_300x250_4'].", `prize_468x60`=".$_POST['prize_468x60_4'].", `prize_728x90`=".$_POST['prize_728x90_4']." WHERE ID=4");

    }
    public function update_tarif_setts2($arr) {
        $this->db->query("UPDATE `lvl_mark_sett` SET price1= ".$arr['bprice1'].", price2= ".$arr['bprice2'].", price3= ".$arr['bprice3'].", price4= ".$arr['bprice4'].", price5= ".$arr['bprice5'].", price6= ".$arr['bprice6'].", price7= ".$arr['bprice7'].", price8= ".$arr['bprice8']."  WHERE ID=2");
    }
    public function update_tarif_setts3($arr) {
        $this->db->query("UPDATE `percent_of_linear_mark` SET `price_for_place`=".$arr['bprice_for_place'].", `price1`=".$arr['bprice1'].", `price2`=".$arr['bprice2'].", `price3`=".$arr['bprice3'].", `price4`=".$arr['bprice4'].", `price5`=".$arr['bprice5'].", `price6`=".$arr['bprice6'].", `price7`=".$arr['bprice7'].", `price8`=".$arr['bprice8'].", `price9`=".$arr['bprice9'].", `price10`=".$arr['bprice10'].", `price11`=".$arr['bprice11'].", `price12`=".$arr['bprice12'].", `price13`=".$arr['bprice13'].", `price14`=".$arr['bprice14'].", `price15`=".$arr['bprice15']." WHERE ID=1");
    }
    public function update_tarif_setts4($arr) {
        $this->db->query("UPDATE `setts_of_mark_with_lvl_limit` SET `price1`=".$arr['bprice1'].", `count_place_default1`=".$arr['bcount_price_default1'].", `price_place1`=".$arr['bprice_place1'].", `price2`=".$arr['bprice2'].", `count_place_default2`=".$arr['bcount_price_default2'].", `price_place2`=".$arr['bprice_place2'].", `price3`=".$arr['bprice3'].", `count_place_default3`=".$arr['bcount_price_default3'].", `price_place3`=".$arr['bprice_place3'].", `price_in`=".$arr['bprice_in']." WHERE ID=1");
    }
    /*
        end tarifs operations
    */


    /*
        binar\trinar operations

        1111 - мгновенное начисление в случае если уровень выше чем продаваемый
        1112 - перевод с замороженного счета на рекламный для автопокупки следующего уровня
        1113 - покупка уровня в тринаре
        1114 - покупка уровня в бинаре
        1115 - разблокирование и начисление накоплений для перехода
        1116 - разблокирование и начисление покупки уровня

        предусмотреть покупку у вышестоящих НАД админом, а так же ограничение по высшему уровню в плане начислений
    */
    public function getTarInfo() {

        $query = $this->db->query("SELECT * FROM tarifs");
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    

    public function getStructsInfoLinear() {
        $query = $this->db->query("SELECT * FROM percent_of_linear_mark");
        $this->struct_info_linear = $query->row_array();
    }
    public function BuyLinear($id){
        //взяли инфу о структуре
        $this->getStructsInfoLinear();


        //взяли инфу о пользователе
        $query = $this->db->query("SELECT tarif, idsponsor, id, login, amount_btc FROM users WHERE id=".$id);
        $row_us = $query->row_array();

        $query = $this->db->query("SELECT * FROM tarifs WHERE ID=2");
        $row_us_t2 = $query->row_array();

        $query = $this->db->query("SELECT * FROM tarifs WHERE ID=3");
        $row_us_t3 = $query->row_array();



        if( $row_us['tarif'] != 3 ) {
            if(bccomp($row_us['amount_btc'], $row_us_t3['Price_to_buy']) >= 0) {

                // $this->struct_info_linear['price_for_place']

                if($row_us['tarif'] == 1) {

                    $this->Buy($id, 1, 'binar');

                    $system_money = $row_us_t3['Price_to_buy']-$row_us_t2['Price_to_buy']-$this->struct_info_linear['price_for_place'];

                    $out_money = $row_us_t3['Price_to_buy']-$row_us_t2['Price_to_buy'];

                }else {

                    $system_money = $row_us_t3['Price_to_buy']-$this->struct_info_linear['price_for_place'];

                    $out_money = $row_us_t3['Price_to_buy'];

                }

                //заплатили, сохранили
                $type = 2222;

                // var_dump($this->struct_info_linear);exit();

                // echo "INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('".$type."', 'USD', 0, ".$id.", 1, ".$this->struct_info['price_for_place'].", '".time()."')";exit();

                $this->db->query("INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('".$type."', 'USD', 0, ".$id.", 1, ".$this->struct_info_linear['price_for_place'].", now())");

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$out_money.", bal_show_125x125=bal_show_125x125+".$row_us_t3['prize_125x125'].", bal_show_300x250=bal_show_300x250+".$row_us_t3['prize_300x250'].", bal_show_468x60=bal_show_468x60+".$row_us_t3['prize_468x60'].", bal_show_728x90=bal_show_728x90+".$row_us_t3['prize_728x90'].", tarif=3 WHERE id=".$id);

                $this->db->query("UPDATE new_stat_for_admin SET Buy_Vip=Buy_Vip+".$out_money);

                // echo "UPDATE percent_of_linear_mark SET system_money_for_in=system_money_for_in+".$system_money;

                //     exit();
                $this->db->query("UPDATE percent_of_linear_mark SET system_money_for_in=system_money_for_in+".$system_money);

                //покупаем уровень
                $this->BuyLvlLinear($row_us);

                return array('error' => 0);
            }else {
                return array('error' => 1); //не хватает средств
            }
        }else {
            return array('error' => 2); //некорректный уровень
        }
    }
    public function BuyLvlLinear($us_info) {
        //начинаем процесс покупки\оплаты
        $this->StartBuyingLinear($us_info);
    }
    public function StartBuyingLinear($us_info) {
        //распределение

        $f = fopen('LINEAR_LOGS.txt', 'a+');
        fwrite($f, 'BEGIN'."\n\r\n\r");

        for($i = 1; $i <= 15; $i++) {
            if($us_info['idsponsor'] != NULL) {
                $query = $this->db->query("SELECT * FROM users WHERE id=".$us_info['idsponsor']);

                fwrite($f, $i.' "SELECT * FROM users WHERE id="'.$us_info['idsponsor']."\n\r\n\r");

                $rowUp = $query->row_array();



                if($rowUp['tarif'] == 3) {
                    fwrite($f, $i.' "UPDATE refs_refills_from_linear_mark SET refs"'.$i.'"=refs"'.$i.'"+"'.($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).'" WHERE uid="'.$us_info['idsponsor']."\n\r\n\r");

                    $this->db->query("UPDATE refs_refills_from_linear_mark SET refs".$i."=refs".$i."+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100))." WHERE uid=".$us_info['idsponsor']);

                    fwrite($f, $i.' "UPDATE users SET add_amount_btc=add_amount_btc+"'.($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).'" WHERE id="'.$us_info['idsponsor']."\n\r\n\r");


                    $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100))." WHERE id=".$us_info['idsponsor']);

                    $this->db->query("UPDATE new_stat_for_admin SET Refills_from_vip=Refills_from_vip+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)));

                    fwrite($f, $i.' "UPDATE user_statistics SET vip=vip+"'.($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).'", all_money=all_money+"'.($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).'" WHERE uid="'.$us_info['idsponsor']."\n\r\n\r");

                    $this->db->query("UPDATE user_statistics SET vip=vip+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).", all_money=all_money+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100))." WHERE uid=".$us_info['idsponsor']);

                    fwrite($f, $i."INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('3333', 'USD', ".$us_info['idsponsor'].", 0, 1, ".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).", '".time()."')"."\n\r\n\r");

                    $this->db->query("INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('3333', 'USD', ".$us_info['idsponsor'].", 0, 1, ".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)).", now())");
                }else {
                    fwrite($f, $i."UPDATE percent_of_linear_mark SET system_money=system_money+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100))."\n\r\n\r");

                    $this->db->query("UPDATE percent_of_linear_mark SET system_money=system_money+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)));
                }

                $us_info['idsponsor'] = $rowUp['idsponsor'];
            }else{
                fwrite($f, $i."UPDATE percent_of_linear_mark SET system_money=system_money+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100))."\n\r\n\r");

                $this->db->query("UPDATE percent_of_linear_mark SET system_money=system_money+".($this->struct_info_linear['price_for_place']*($this->struct_info_linear['price'.$i]/100)));
            }

        }
    }
    public function get_full_linar_info($uid) {
        $query = $this->db->query("SELECT * FROM refs_refills_from_linear_mark WHERE uid=".$uid);
        if($query->num_rows() == 0) {
            $res = array(
                'refs1' => 0,
                'refs2' => 0,
                'refs3' => 0,
                'refs4' => 0,
                'refs5' => 0,
                'refs6' => 0,
                'refs7' => 0,
                'refs8' => 0,
                'refs9' => 0,
                'refs10' => 0,
                'refs11' => 0,
                'refs12' => 0,
                'refs13' => 0,
                'refs14' => 0,
                'refs15' => 0
            );
        }else {
            $res = $query->row_array();
        }

        $query = $this->db->query("SELECT * FROM percent_of_linear_mark");
        $perc_linear_mark = $query->row_array();

        $query = $this->db->query("SELECT COUNT(*) as countlvl1 FROM refferal_structure WHERE id1=".$uid);
        $res1 = $query->row_array();
        // if(isset($_GET['allo'])) {
        //     echo "SELECT COUNT(*) as countlvl1 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id1=".$uid;exit();
        // }
        $query1 = $this->db->query("SELECT COUNT(*) as countlvl1 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id1=".$uid);
        $res11 = $query1->row_array();
        $res1['active1'] = $res11['countlvl1'];
        $res1['possible1'] = bcmul($res1['countlvl1'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price1'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl2 FROM refferal_structure WHERE id2=".$uid);
        $res2 = $query->row_array();
        $query2 = $this->db->query("SELECT COUNT(*) as countlvl2 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id2=".$uid);
        $res12 = $query2->row_array();
        $res2['active2'] = $res12['countlvl2'];
        $res2['possible2'] = bcmul($res2['countlvl2'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price2'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl3 FROM refferal_structure WHERE id3=".$uid);
        $res3 = $query->row_array();
        $query3 = $this->db->query("SELECT COUNT(*) as countlvl3 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id3=".$uid);
        $res13 = $query3->row_array();
        $res3['active3'] = $res13['countlvl3'];
        $res3['possible3'] = bcmul($res3['countlvl3'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price3'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl4 FROM refferal_structure WHERE id4=".$uid);
        $res4 = $query->row_array();
        $query4 = $this->db->query("SELECT COUNT(*) as countlvl4 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id4=".$uid);
        $res14 = $query4->row_array();
        $res4['active4'] = $res14['countlvl4'];
        $res4['possible4'] = bcmul($res4['countlvl4'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price4'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl5 FROM refferal_structure WHERE id5=".$uid);
        $res5 = $query->row_array();
        $query5 = $this->db->query("SELECT COUNT(*) as countlvl5 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id5=".$uid);
        $res15 = $query5->row_array();
        $res5['active5'] = $res15['countlvl5'];
        $res5['possible5'] = bcmul($res5['countlvl5'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price5'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl6 FROM refferal_structure WHERE id6=".$uid);
        $res6 = $query->row_array();
        $query6 = $this->db->query("SELECT COUNT(*) as countlvl6 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id6=".$uid);
        $res16 = $query6->row_array();
        $res6['active6'] = $res16['countlvl6'];
        $res6['possible6'] = bcmul($res6['countlvl6'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price6'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl7 FROM refferal_structure WHERE id7=".$uid);
        $res7 = $query->row_array();
        $query7 = $this->db->query("SELECT COUNT(*) as countlvl7 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id7=".$uid);
        $res17 = $query7->row_array();
        $res7['active7'] = $res17['countlvl7'];
        $res7['possible7'] = bcmul($res7['countlvl7'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price7'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl8 FROM refferal_structure WHERE id8=".$uid);
        $res8 = $query->row_array();
        $query8 = $this->db->query("SELECT COUNT(*) as countlvl8 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id8=".$uid);
        $res18 = $query8->row_array();
        $res8['active8'] = $res18['countlvl8'];
        $res8['possible8'] = bcmul($res8['countlvl8'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price8'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl9 FROM refferal_structure WHERE id9=".$uid);
        $res9 = $query->row_array();
        $query9 = $this->db->query("SELECT COUNT(*) as countlvl9 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id9=".$uid);
        $res19 = $query9->row_array();
        $res9['active9'] = $res19['countlvl9'];
        $res9['possible9'] = bcmul($res9['countlvl9'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price9'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl10 FROM refferal_structure WHERE id10=".$uid);
        $res10 = $query->row_array();
        $query10 = $this->db->query("SELECT COUNT(*) as countlvl10 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id10=".$uid);
        $res100 = $query10->row_array();
        $res10['active10'] = $res100['countlvl10'];
        $res10['possible10'] = bcmul($res10['countlvl10'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price10'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl11 FROM refferal_structure WHERE id11=".$uid);
        $res11 = $query->row_array();
        $query11 = $this->db->query("SELECT COUNT(*) as countlvl11 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id11=".$uid);
        $res101 = $query11->row_array();
        $res11['active11'] = $res101['countlvl11'];
        $res11['possible11'] = bcmul($res11['countlvl11'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price11'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl12 FROM refferal_structure WHERE id12=".$uid);
        $res12 = $query->row_array();
        $query12 = $this->db->query("SELECT COUNT(*) as countlvl12 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id12=".$uid);
        $res102 = $query12->row_array();
        $res12['active12'] = $res102['countlvl12'];
        $res12['possible12'] = bcmul($res12['countlvl12'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price12'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl13 FROM refferal_structure WHERE id13=".$uid);
        $res13 = $query->row_array();
        $query13 = $this->db->query("SELECT COUNT(*) as countlvl13 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id13=".$uid);
        $res103 = $query13->row_array();
        $res13['active13'] = $res103['countlvl13'];
        $res13['possible13'] = bcmul($res13['countlvl13'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price13'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl14 FROM refferal_structure WHERE id14=".$uid);
        $res14 = $query->row_array();
        $query14 = $this->db->query("SELECT COUNT(*) as countlvl14 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id14=".$uid);
        $res104 = $query14->row_array();
        $res14['active14'] = $res104['countlvl14'];
        $res14['possible14'] = bcmul($res14['countlvl14'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price14'], 100, 2), 4));

        $query = $this->db->query("SELECT COUNT(*) as countlvl15 FROM refferal_structure WHERE id15=".$uid);
        $res15 = $query->row_array();
        $query15 = $this->db->query("SELECT COUNT(*) as countlvl15 FROM refferal_structure as r INNER JOIN users as u ON u.id=r.uid WHERE u.tarif=3 AND r.id15=".$uid);
        $res105 = $query15->row_array();
        $res15['active15'] = $res105['countlvl15'];
        $res15['possible15'] = bcmul($res15['countlvl15'], bcmul($perc_linear_mark['price_for_place'], bcdiv($perc_linear_mark['price15'], 100, 2), 4));

        return array_merge($res, $res1, $res2, $res3, $res4, $res5, $res6, $res7, $res8, $res9, $res10, $res11, $res12, $res13, $res14, $res15);
    }




    public function BuyTrinar($id){

        //взяли инфу о структуре
        //$this->getStructsInfo($strname);



        //взяли инфу о пользователе
        $query = $this->db->query("SELECT tarif, idsponsor, id, login, amount_btc FROM users WHERE id=".$id);
        $row_us = $query->row_array();

        $query = $this->db->query("SELECT * FROM tarifs WHERE ID=4");
        $row_us_t = $query->row_array();

        //взяли инфу об актуальном уровне
        // $query = $this->db->query("SELECT Lvl FROM ".$strname." WHERE Login='".$row_us['login']."'");
        // if($query->num_rows() > 0) {
        //     $row_lvl = $query->row_array();
        // }else {
        //     $row_lvl['Lvl'] = 0;
        // }

        // if( $lvl == $row_lvl['Lvl'] + 1 ) {
            if(bccomp($row_us['amount_btc'], $row_us_t['Price_to_buy']) >= 0) {

                //заплатили, сохранили
                // if($lvl == 1) {

                    if($row_us['tarif'] == 3) {
                        $tarif = 3;
                    }else {
                        $tarif = 4;
                    }

                    $this->db->query("UPDATE users SET amount_btc=amount_btc-".$row_us_t['Price_to_buy'].", bal_show_125x125=bal_show_125x125+".$row_us_t['prize_125x125'].", bal_show_300x250=bal_show_300x250+".$row_us_t['prize_300x250'].", bal_show_468x60=bal_show_468x60+".$row_us_t['prize_468x60'].", bal_show_728x90=bal_show_728x90+".$row_us_t['prize_728x90'].", tarif=".$tarif." WHERE id=".$id);

                    // $this->db->query("UPDATE new_stat_for_admin SET Buy_Premium=Buy_Premium+".$this->struct_info['price'.$lvl]);
                // }else {
                //     $this->db->query("UPDATE users SET amount_btc=amount_btc-".$this->struct_info['price'.$lvl]." WHERE id=".$id);
                // }

                // if($strname == 'trinar') {
                //     $type = 1113;
                // }else {
                    $type = 2220;
                // }

                $this->db->query("INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('".$type."', 'USD', 0, ".$id.", 1, ".$row_us_t['Price_to_buy'].", now())");

                // //покупаем уровень
                $this->BuyLvlTrinar_New($row_us);

                return array('error' => 0);
            }else {
                return array('error' => 1); //не хватает средств
            }
        // }else {
        //     return array('error' => 2); //некорректный уровень
        // }
    }
    public function BuyLvlTrinar_New($row_us) {

        $query = $this->db->query("SELECT * FROM trinar_10lvl WHERE Login='".$row_us['login']."'");

        if($query->num_rows() < 1) {
            //если уровень первый встаем в структуру

            $IDUp = $this->WhoIsInTrinar_New($row_us);
            $place = $this->getPlaceTrinar_New($IDUp);

            $this->addToTrinar_New($row_us['login'], $place);
        }
        //начинаем процесс покупки\оплаты
        $this->StartTrinarLvling($row_us);
    }
    public function WhoIsInTrinar_New($us_info) {
        $query = $this->db->query("SELECT * FROM trinar_10lvl WHERE Login=(SELECT login FROM users WHERE id=".$us_info['idsponsor'].")");
        if($query->num_rows() > 0) {
            $info = $query->row_array();
            return $info['ID'];
        }else {
            $query = $this->db->query("SELECT * FROM users WHERE id=".$us_info['idsponsor']);
            $us_info = $query->row_array();

            return $this->WhoIsInTrinar_New($us_info);
        }
    }
    public function getPlaceTrinar_New($begin) {
        $a = 3;
        $b = 2;

        if($begin != 1) {

            $res = $this->db->query("SELECT LvlInMatrix, NumberInLvl FROM trinar_10lvl WHERE ID=$begin");
            $arr = $res->row_array();

            $StartLvl = $arr['LvlInMatrix'];
            $NumberInLvl = $arr['NumberInLvl'];

        }

        do {
            
            if(!isset($StartLvl) && !isset($Lvl)){
                
                $Lvl = 0;
                $AddStr = '';
            
            }elseif($begin != 1) {

                if(!isset($Lvl)) {

                    $Lvl = $StartLvl;
                    $min = $NumberInLvl;

                }else {

                    $min = $min*$a-$b;

                }

                $diff = $Lvl-$StartLvl;
                $max = $NumberInLvl*pow($a, $diff);
                                        
                $AddStr = " AND NumberInLvl>=".$min." AND NumberInLvl<=".$max." ORDER BY NumberInLvl ASC";

            }

            $res = $this->db->query("SELECT * FROM trinar_10lvl WHERE UnderCount<".$a." AND LvlInMatrix=$Lvl".$AddStr);
            $count = $res->num_rows();
            $Lvl++;

        }while($count == 0);

        $arr = $res->row_array();

        return $arr;
    }
    public function addToTrinar_New($login, $place) {
        if($place['UnderCount'] == 0) {
            $NumberInLvl = $place['NumberInLvl']*3-2;
        }elseif($place['UnderCount'] == 1) {
            $NumberInLvl = $place['NumberInLvl']*3-1;
        }elseif($place['UnderCount'] == 2) {
            $NumberInLvl = $place['NumberInLvl']*3;
        }

        $this->db->query("INSERT INTO trinar_10lvl(`Login`, `UpperId`, `LvlInMatrix`, `NumberInLvl`, `DateOfIn`) VALUES ('".$login."', ".$place['ID'].", ".($place['LvlInMatrix']+1).", ".$NumberInLvl.", '".time()."')");
        $this->db->query("UPDATE trinar_10lvl SET UnderCount=UnderCount+1 WHERE ID=".$place['ID']);
    }
    public function StartTrinarLvling($us_info) {
        $query = $this->db->query("SELECT * FROM percent_of_trinar_mark");
        $info_of_percent = $query->row_array();

        $query = $this->db->query("SELECT t.*, u.id as uidd FROM trinar_10lvl as t INNER JOIN users as u ON t.Login=u.login WHERE t.ID=(SELECT t2.UpperId FROM trinar_10lvl as t2 WHERE t2.Login='".$us_info['login']."')");
        if($query->num_rows() > 0) {
            $info = $query->row_array();
            for($i = 1; $i <= 10; $i++) {
                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".(10*($info_of_percent['price'.$i]/100))." WHERE login='".$info['Login']."'");

                $this->db->query("UPDATE user_statistics SET trinar_refs=trinar_refs+".(10*($info_of_percent['price'.$i]/100)).", all_money=all_money+".(10*($info_of_percent['price'.$i]/100))." WHERE uid=".$info['uidd']);

                $this->db->query("INSERT INTO `payments`(`type`, `currency`, `idreceiver`, `idsender`, `status`, `amount`, `actiondate`) VALUES ('2121', 'USD', ".$info['uidd'].", ".$us_info['id'].", 1, ".(10*($info_of_percent['price'.$i]/100)).", now())");

                $this->db->query("UPDATE trinar_10lvl SET ref".$i."=ref".$i."+".(10*($info_of_percent['price'.$i]/100))." WHERE Login='".$info['Login']."'");

                $query = $this->db->query("SELECT t.*, u.id as uidd FROM trinar_10lvl as t INNER JOIN users as u ON t.Login=u.login WHERE t.ID=(SELECT t2.UpperId FROM trinar_10lvl as t2 WHERE t2.Login='".$info['Login']."')");
                if($query->num_rows() > 0) {
                    $info = $query->row_array();
                }else {
                    $query = $this->db->query("SELECT t.*, u.id as uidd FROM trinar_10lvl as t INNER JOIN users as u ON t.Login=u.login WHERE t.ID=1");
                    $info = $query->row_array();
                }
            }
        }
    }
    public function get_full_new_trinar_info($uid) {
        $query = $this->db->query("SELECT * FROM trinar_10lvl WHERE Login=(SELECT login FROM users WHERE id=".$uid.")");

        // echo "SELECT * FROM trinar_10lvl WHERE Login=(SELECT login FROM users WHERE id=".$uid.")";exit();
        
        if($query->num_rows() > 0) {

            $us_info = $query->row_array();

            $min = $us_info['NumberInLvl']*3-2;
            $max = $us_info['NumberInLvl']*3;
            $curlvl = $us_info['LvlInMatrix']+1;

            for($i = 1; $i <= 10; $i++) {
                $query = $this->db->query("SELECT * FROM trinar_10lvl WHERE LvlInMatrix=".$curlvl." AND NumberInLvl>=".$min." AND NumberInLvl<=".$max);
                $us_info['countlvl'.$i] = $query->num_rows();
                $curlvl += 1;
                $min = $min*3-2;
                $max = $max*3;
            }

            return $us_info;
        }else {
            $us_info = array(
                'countlvl1' => 0,
                'countlvl2' => 0,
                'countlvl3' => 0,
                'countlvl4' => 0,
                'countlvl5' => 0,
                'countlvl6' => 0,
                'countlvl7' => 0,
                'countlvl8' => 0,
                'countlvl9' => 0,
                'countlvl10' => 0,
                'ref1' => 0,
                'ref2' => 0,
                'ref3' => 0,
                'ref4' => 0,
                'ref5' => 0,
                'ref6' => 0,
                'ref7' => 0,
                'ref8' => 0,
                'ref9' => 0,
                'ref10' => 0
            );
            return $us_info;
        }
    }





    public function getBansForShow($arr, $conf = array('lang' => 'all')) {

        /*
            $arr:
                'text_ad'
                'ban_ad':
                    '125x125'
                    '300x250'
                    '468x60'
                    '728x90'
        */

        // if(isset($_GET['allali'])) {
        //   var_dump(func_num_args());
        //   var_dump($conf);
        //   exit();
        // }

        if(!isset($conf) || !is_array($conf)) {
            
            $conf = array('lang' => 'all');

        }elseif(!is_string($conf['lang']) || $conf['lang'] == NULL) {
            $conf = array('lang' => 'all');

        }elseif($conf['lang'] != 'all' && $conf['lang'] != 'russian' && $conf['lang'] != 'german' && $conf['lang'] != 'english') {
            $conf = array('lang' => 'all');


        }



        $result = array();
        
        if(count($arr['ban_ad']) > 0) {
            $result['125x125'] = array();
            // $result['300x50'] = array();
            $result['300x250'] = array();
            // $result['300x600'] = array();
            $result['468x60'] = array();
            // $result['728x90'] = array();

            if($arr['ban_ad']['125x125'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='125x125' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['125x125']);

                foreach ($query->result_array() as $row) {
                    $result['125x125'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE banners SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['125x125']) < $arr['ban_ad']['125x125']) {

                    $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='125x125' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['125x125']-count($result['125x125'])));

                    foreach ($query->result_array() as $row) {
                        $result['125x125'][] = $row;
                    }

                    $this->db->query("UPDATE banners SET seen=0 WHERE format='125x125'");

                }
            }

            if($arr['ban_ad']['300x250'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='300x250' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['300x250']);

                foreach ($query->result_array() as $row) {
                    $result['300x250'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE banners SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['300x250']) < $arr['ban_ad']['300x250']) {

                    $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='300x250' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['300x250']-count($result['300x250'])));

                    foreach ($query->result_array() as $row) {
                        $result['300x250'][] = $row;
                    }

                    $this->db->query("UPDATE banners SET seen=0 WHERE format='300x250'");

                }
            }

            if($arr['ban_ad']['468x60'] > 0) {
                $arr_id = array();

                $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='468x60' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['468x60']);

                foreach ($query->result_array() as $row) {
                    $result['468x60'][] = $row;
                    $arr_id[] = $row['ID'];
                }

                if(count($arr_id) > 0) {
                    $this->db->query('UPDATE banners SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
                    $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
                }else {
                    $last_add_str = '';
                }

                if(count($result['468x60']) < $arr['ban_ad']['468x60']) {

                    $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='468x60' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['468x60']-count($result['468x60'])));

                    foreach ($query->result_array() as $row) {
                        $result['468x60'][] = $row;
                    }

                    $this->db->query("UPDATE banners SET seen=0 WHERE format='468x60'");

                }
            }

            // if($arr['ban_ad']['728x90'] > 0) {
            //     $arr_id = array();

            //     $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='728x90' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['ban_ad']['728x90']);

            //     foreach ($query->result_array() as $row) {
            //         $result['728x90'][] = $row;
            //         $arr_id[] = $row['ID'];
            //     }

            //     if(count($arr_id) > 0) {
            //         $this->db->query('UPDATE banners SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE count-current_count>0 AND ID IN ('.implode(', ', $arr_id).')');
            //         $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
            //     }else {
            //         $last_add_str = '';
            //     }

            //     if(count($result['728x90']) < $arr['ban_ad']['728x90']) {

            //         $query = $this->db->query("SELECT * FROM banners WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND format='728x90' AND (count-current_count>0 OR cont_type=3) AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['ban_ad']['728x90']-count($result['728x90'])));

            //         foreach ($query->result_array() as $row) {
            //             $result['728x90'][] = $row;
            //         }

            //         $this->db->query("UPDATE banners SET seen=0 WHERE format='728x90'");

            //     }

            // }
        }

        if($arr['text_ad'] > 0) {
            $result['text_ad'] = array();

            $arr_id = array();

            $query = $this->db->query("SELECT * FROM text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND count-current_count>0 AND Status=1 AND seen=0 ORDER BY RAND() ASC LIMIT ".$arr['text_ad']);

            foreach ($query->result_array() as $row) {
                $result['text_ad'][] = $row;
                $arr_id[] = $row['ID'];
            }

            if(count($arr_id) > 0) {
                $this->db->query('UPDATE text_ad SET seen=1, show_for_stat=show_for_stat+1, current_count=current_count+1 WHERE ID IN ('.implode(', ', $arr_id).')');
                $last_add_str = ' AND ID NOT IN ('.implode(', ', $arr_id).')';
            }else {
                $last_add_str = '';
            }

            if(count($result['text_ad']) < $arr['text_ad']) {

                $query = $this->db->query("SELECT * FROM text_ad WHERE Activity=1 AND (lang='all' OR lang='".$conf['lang']."') AND count-current_count>0 AND Status=1 AND seen=1".$last_add_str." ORDER BY RAND() ASC LIMIT ".($arr['text_ad']-count($result['text_ad'])));

                foreach ($query->result_array() as $row) {
                    $result['text_ad'][] = $row;
                }

                $this->db->query("UPDATE text_ad SET seen=0");

            }

        }

        return $result;
    }





    /*
        banner operations
    */
    public function ch_ban_state($uid, $id, $type) {
        // echo "UPDATE compaign SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid;exit();
        $this->db->query("UPDATE banners SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;
    }
    public function update_banner_conf($uid, $idb, $lang) {
        $this->db->query("UPDATE banners SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);
    }
    public function up_count_ban($id, $type) {
        if($type == 'text') {
            $query = $this->db->query("SELECT * FROM text_ad WHERE count-current_count>0 AND ID=".$this->db->escape_str($id));
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE text_ad SET click_for_stat=click_for_stat+1 WHERE ID=".$id);
            }
        }else {
            $query = $this->db->query("SELECT * FROM banners WHERE count-current_count>0 AND id=".$this->db->escape_str($id));
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE banners SET click_for_stat=click_for_stat+1 WHERE id=".$id);
            }
        }
    }
    public function add_spec_code($format, $code) {
        $this->db->query("INSERT INTO banners(uid, bnr, cont_type, url, format, type, Status, Date) VALUES(1, '".base64_encode($code)."', 3, '', '".$format."', 0, 1, ".time().")");
    }
    public function buy_ads($uid, $type2, $size2, $count) {

        // echo 555;
        // exit();

        $type_of_buy = $type2;

        // if($type2 == 1) {
        //     $type = 'click';
        //     $type2 = 456;
        // }else {
            $type = 'show';
            $type2 = 457;
        // }

        if($type_of_buy == 0) {

            $query = $this->db->query("SELECT * FROM ads_setts");
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            $Price = bcmul($arr['Price_'.$type.'_'.$size2], $count, 4);

            // var_dump($Price);exit();

            $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$Price." AND id=".$uid);
            if($query->num_rows() > 0) {

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$Price.", bal_".$type."_".$size2."=bal_".$type."_".$size2."+".$count." WHERE id=".$uid."");

                $this->db->query("UPDATE new_stat_for_admin SET Banner_buy_sum=Banner_buy_sum+".$Price);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(".$type2.", 'BTC', ".$uid.", 1, ".$Price.", '".$count."', now())");

                foreach ($query->result_array() as $row) {
                    $arr = $row;
                }

                $arr_sett = $this->get_setts();

                $LvlRef2 = array();
                for($i = 0; $i < count($arr_sett[225]); $i++) {
                    $LvlRef2[$arr_sett[225][$i]['Lvl']+0] = $arr_sett[225][$i]['Percent'];
                }

                $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
                $row = $query->row_array();

                if($row['idsponsor'] != NULL) {
                    //рефферальные
                    //Начинаем с 1-го уровня и задаем флаг
                    $cont = true;
                    $lvl = 1;

                    while($cont) {

                        //проверяем есть ли в конфигах лвл больше или равно нашему
                        $query = $this->db->query("SELECT * FROM refs_refills5 WHERE Lvl>=".$lvl);
                        if($query->num_rows()) {

                            //если есть гонимся дале
                            //смотрим спонсора выше на 1 лвл

                            if($row['idsponsor'] == NULL) {
                                $cont = false;
                                continue;    
                            }

                            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row['idsponsor']);

                            $row = $query->row_array();

                            //тут смотрим, есть ли в вынутом сверху массиве текущий уровень
                            if(array_key_exists($lvl, $LvlRef2)) {

                                if($row['Count_ref_lvl'] < $lvl ) {
                                    $lvl++;
                                    continue;
                                }

                                //если есть делаем начисления
                                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE id=".$row['id']);

                                $this->db->query("UPDATE new_stat_for_admin SET Banner_buy_ref=Banner_buy_ref+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4));

                                $this->db->query("INSERT INTO payments(type, btc_address, currency, idreceiver, idsender, status, amount, actiondate) VALUES(38, '3', 'BTC', ".$row['id'].", ".$uid.", 1, ".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", now())");

                                $this->db->query("UPDATE user_statistics SET refs_banner=refs_banner+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", all_money=all_money+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE uid=".$row['id']);

                            }
                            $lvl++;
                        }else {
                            //ели нет сбрасываем флаг
                            $cont = false;
                        }

                    }

                }

                return array('new_bal' => bcsub($arr['amount_btc'], $Price, 8));
            }else {
                return false;
            }

        }elseif($type_of_buy == 1 || $type_of_buy == 2 || $type_of_buy == 3 || $type_of_buy == 4) {
            $query = $this->db->query("SELECT * FROM special_buying");
            $arr = array();
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }

            $Price = $arr[$type_of_buy-1]['price'];
            $count = $arr[$type_of_buy-1]['count'];

            // exit();

            $query = $this->db->query("SELECT * FROM users WHERE amount_btc>=".$Price." AND id=".$uid);
            if($query->num_rows() > 0) {

                $this->db->query("UPDATE users SET amount_btc=amount_btc-".$Price.", bal_".$type."_".$size2."=bal_".$type."_".$size2."+".$count." WHERE id=".$uid."");

                $this->db->query("UPDATE new_stat_for_admin SET Banner_packet_buy_sum=Banner_packet_buy_sum+".$Price);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, hash_pe, actiondate) VALUES(".$type2.", 'USD', ".$uid.", 1, ".$Price.", '".$count."', now())");

                foreach ($query->result_array() as $row) {
                    $arr = $row;
                }

                $arr_sett = $this->get_setts();

                $LvlRef2 = array();
                for($i = 0; $i < count($arr_sett[225]); $i++) {
                    $LvlRef2[$arr_sett[225][$i]['Lvl']+0] = $arr_sett[225][$i]['Percent'];
                }

                $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
                $row = $query->row_array();

                if($row['idsponsor'] != NULL) {
                    //рефферальные
                    //Начинаем с 1-го уровня и задаем флаг
                    $cont = true;
                    $lvl = 1;

                    while($cont) {

                        //проверяем есть ли в конфигах лвл больше или равно нашему
                        $query = $this->db->query("SELECT * FROM refs_refills5 WHERE Lvl>=".$lvl);
                        if($query->num_rows()) {

                            //если есть гонимся дале
                            //смотрим спонсора выше на 1 лвл

                            if($row['idsponsor'] == NULL) {
                                $cont = false;
                                continue;    
                            }

                            $query = $this->db->query("SELECT u.*, t.* FROM users as u INNER JOIN tarifs as t ON u.tarif=t.ID WHERE u.id=".$row['idsponsor']);

                            $row = $query->row_array();

                            //тут смотрим, есть ли в вынутом сверху массиве текущий уровень
                            if(array_key_exists($lvl, $LvlRef2)) {

                                if($row['Count_ref_lvl'] < $lvl ) {
                                    $lvl++;
                                    continue;
                                }

                                //если есть делаем начисления
                                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE id=".$row['id']);

                                $this->db->query("UPDATE new_stat_for_admin SET Banner_packet_buy_ref=Banner_packet_buy_ref+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4));

                                $this->db->query("INSERT INTO payments(type, btc_address, currency, idreceiver, idsender, status, amount, actiondate) VALUES(38, '4', 'BTC', ".$row['id'].", ".$uid.", 1, ".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", now())");

                                $this->db->query("UPDATE user_statistics SET refs_banner=refs_banner+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4).", all_money=all_money+".bcmul($Price, bcdiv( $LvlRef2[$lvl], 100, 2), 4)." WHERE uid=".$row['id']);

                            }
                            $lvl++;
                        }else {
                            //ели нет сбрасываем флаг
                            $cont = false;
                        }

                    }

                }

                return array('new_bal' => bcsub($arr['amount_btc'], $Price, 8));
            }else {
                return false;
            }
        }
    }
    public function ch_ban_type_ad($uid, $id, $setts) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            $future_new_bal = $result['count']-$result['current_count'];
            if($result['type_of_ad'] == 0) {
                $new_type = 1;
                $new_bal = ceil($future_new_bal*1/$setts['inside_outside_curs']);
            }else {
                $new_type = 0;
                $new_bal = $future_new_bal*$setts['inside_outside_curs'];
            }
            $this->db->query("UPDATE banners SET type_of_ad=".$new_type.", current_count=0, count=".$new_bal." WHERE ID=".$id." AND uid=".$uid);
            return ['new_bal' => $new_bal, 'future_new_bal' => $future_new_bal];
        }else {
            return false;
        }
    }
    public function update_bn_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function copy_ban($uid, $id) {

        $result = $this->db->query("SELECT * FROM banners WHERE ID=".$id." AND uid=".$uid);

        if($result->num_rows() > 0) {
            $ban_info = $result->row_array();

            $this->db->query("INSERT INTO banners(uid, bnr, cont_type, type_of_ad, url, format, lang, Status, type, Date) VALUES(".$uid.", '".$ban_info['bnr']."', ".$ban_info['cont_type'].", ".$ban_info['type_of_ad'].", '".$ban_info['url']."', '".$ban_info['format']."', '".$ban_info['lang']."', ".$ban_info['Status'].", ".$ban_info['type'].", ".time().")");
            return $this->db->insert_id();
        }
        exit();
    }
    public function add_new_ban($uid, $name, $url, $size, $type_ad, $lang, $cont_type) {

        if($cont_type == 1) {
            $this->db->query("INSERT INTO banners(uid, bnr, cont_type, type_of_ad, url, format, lang, Status, type, Date) VALUES(".$uid.", '".$name."', 1, ".$type_ad.", '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$size."', '".$lang."', 1, 2, ".time().")");
        }elseif($cont_type == 2) {
            $this->db->query("INSERT INTO banners(uid, bnr, cont_type, type_of_ad, url, format, lang, Status, type, Date) VALUES(".$uid.", '".json_encode($name, JSON_UNESCAPED_UNICODE)."', 2, ".$type_ad.", '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$size."', '".$lang."', 1, 2, ".time().")");
        }
        return $this->db->insert_id();
    }
    public function ch_old_ban($id, $uid, $name, $url, $cont_type, $lang) {

        if($cont_type == 'file') {
            $type = 1;
        }else {
            $type = 2;
        }

        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            $arr = $row;
        }

        if($row['cont_type'] == 1 && $name != NULL) {
            unlink($arr['bnr']);
        }

        if($cont_type == NULL) {
            $cont_type_str = '';
        }else {
            $cont_type_str = "cont_type=".$type.",";
        }

        if( $name != NULL ) {
            $this->db->query("UPDATE banners SET bnr='".$name."', url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', ".$cont_type_str." lang='".$lang."' WHERE ID=".$id);
        }else {
            $this->db->query("UPDATE banners SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', ".$cont_type_str." lang='".$lang."' WHERE ID=".$id);
        }
    }
    public function del_b($uid, $id) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            //$this->db->query("UPDATE users SET amount_btc=amount_btc+".($arr['count']-$arr['current_count'])." WHERE id=".$uid."");

            $this->db->query("DELETE FROM banners WHERE ID=".$id);
        }
    }
    public function take_my_bans($uid, $st, $fm, $od) {

        // echo $st;
        // echo '<br>';
        // echo $fm;
        // echo '<br>';
        // echo $od;

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($fm) {
            case 'f_1':
                $str_f = "format='125x125'";
                $search_arr[] = $str_f;
                break;
            case 'f_2':
                $str_f = "format='300x250'";
                $search_arr[] = $str_f;
                break;
            case 'f_3':
                $str_f = "format='468x60'";
                $search_arr[] = $str_f;
                break;
            case 'f_4':
                $str_f = "format='728x90'";
                $search_arr[] = $str_f;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
            case '':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM banners WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_bnr($id) {
        // echo "UPDATE banners SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE banners SET status=1 WHERE ID=".$id);
    }
    public function del_bnr($id) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            if($row['cont_type'] != 3) {

                if($arr['type'] == 1)  {
                    $type = 'click';
                }else {
                    $type = 'show';
                }

                //$this->db->query("UPDATE users SET bal_".$type."_".$arr['format']."=bal_".$type."_".$arr['format']."+".$arr['count']." WHERE id=".$arr['uid']."");

            }

            $this->db->query("DELETE FROM banners WHERE ID=".$id);
        }
    }
    public function cancel_bnr($id, $riason) {
        $this->db->query("UPDATE banners SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);
    }

    public function accept_adv($id, $sum) {
        $query = $this->db->query("SELECT * FROM temp_adv_pay WHERE id=".$id);
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        $query = $this->db->query("SELECT * FROM curs_btc WHERE Cur='EUR'");
        $result2 = array();
        foreach ($query->result_array() as $row) {
            $result2[] = $row;
        }

        $this->db->query("UPDATE users SET amount_btc=amount_btc+".round(bcmul($sum, $result2[0]['Credits'], 2))." WHERE id=".$result[0]['uid']);
        $this->db->query("UPDATE temp_adv_pay SET status=1 WHERE id=".$id);
        $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, actiondate) VALUES(2, 'EUR', ".$result[0]['uid'].", 1, ".round(bcmul($sum, $result2[0]['Credits'], 2)).", 'for ".$sum." EUR buying ".round(bcmul($sum, $result2[0]['Credits'], 2))."', now())");
    }
    public function take_all_advs($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM temp_adv_pay as t1 INNER JOIN users as t2 ON t1.uid=t2.id ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_advs_total_count() {

        $query = $this->db->query("SELECT * FROM temp_adv_pay as t1 INNER JOIN users as t2 ON t1.uid=t2.id");

        return $query->num_rows();
    }




    public function take_all_bans($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_bans_total_count() {

        $query = $this->db->query("SELECT * FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_bans_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_bans_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_ban_for_look($uid) {
        $query = $this->db->query("SELECT * FROM banners WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_ban_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_ban_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_ban($uid, $ID, $url) {
        $this->db->query("UPDATE banners SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_ban($uid, $ID, $bal, $shows) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // $this->db->query("UPDATE users SET amount_btc=amount_btc-".$bal." WHERE id=".$uid);
            $this->db->query("UPDATE banners SET count=count+".$shows." WHERE ID=".$ID);
            
            // $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, actiondate) VALUES(457, 'PCT', ".$uid.", 1, ".$bal.", 'buying ".$shows." shows(ban)', now())");

            return true;
        }else {
            return false;
        }
    }
    public function take_bans($id) {
        $query = $this->db->query("SELECT * FROM banners WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end banner operations
    */


    /*
        vid_ad operations
    */
    public function ch_vid_ad_state($uid, $id, $type) {
        
        $this->db->query("UPDATE vid_ad SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;

    }
    public function update_vid_ad_conf($uid, $idb, $lang) {

        $this->db->query("UPDATE vid_ad SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);

    }
    public function update_vid_ad_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function add_new_vid_ad($uid, $url, $lang) {

        $this->db->query("INSERT INTO vid_ad(uid, url, lang, Date) VALUES(".$uid.", '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$lang."', ".time().")");
        return $this->db->insert_id();
    }
    public function ch_old_vid_ad($id, $uid, $url, $lang) {

        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            $arr = $row;
        }

        $this->db->query("UPDATE vid_ad SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0, lang='".$lang."' WHERE ID=".$id);
    }
    public function del_vid_ad($uid, $id) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            //$this->db->query("UPDATE vid_ad SET amount_btc=amount_btc+".($arr['count']-$arr['current_count'])." WHERE id=".$uid."");

            $this->db->query("DELETE FROM vid_ad WHERE ID=".$id);
        }
    }
    public function take_my_vid_ad($uid, $st, $od) {

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM vid_ad WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_vid_ad($id) {
        // echo "UPDATE banners SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE vid_ad SET status=1 WHERE ID=".$id);
    }
    public function del_vid_ads($id) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            //$this->db->query("UPDATE users SET amount_btc=amount_btc+".$arr['count']." WHERE id=".$arr['uid']."");
            $this->db->query("DELETE FROM vid_ad WHERE ID=".$id);
        }
    }
    public function cancel_vid_ad($id, $riason) {

        $this->db->query("UPDATE vid_ad SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);

    }
    public function take_all_vid_ad($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_vid_ad_total_count() {

        $query = $this->db->query("SELECT * FROM vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_vid_ad_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_vid_ad_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM vid_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_vid_ad_for_look($uid) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_vid_ad_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_vid_ad_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_vid_ad($uid, $ID, $url) {
        $this->db->query("UPDATE banners SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_vid_ad($uid, $ID, $bal) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // $this->db->query("UPDATE users SET amount_btc=amount_btc-".$bal." WHERE id=".$uid);
            $this->db->query("UPDATE vid_ad SET balance=balance+".$bal." WHERE ID=".$ID);

            return true;
        }else {
            return false;
        }
    }
    public function take_vid_ad($id) {
        $query = $this->db->query("SELECT * FROM vid_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end vid_ad operations
    */


    /*
        text_ad operations
    */
    public function ch_text_ad_state($uid, $id, $type) {
        
        $this->db->query("UPDATE text_ad SET Activity=".$type." WHERE ID=".$id." AND uid=".$uid);
        return true;

    }
    public function ch_text_type_ad($uid, $id, $setts) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            $future_new_bal = $result['count']-$result['current_count'];
            if($result['type_of_ad'] == 0) {
                $new_type = 1;
                $new_bal = ceil($future_new_bal*1/$setts['inside_outside_curs']);
            }else {
                $new_type = 0;
                $new_bal = $future_new_bal*$setts['inside_outside_curs'];
            }
            $this->db->query("UPDATE text_ad SET type_of_ad=".$new_type.", current_count=0, count=".$new_bal." WHERE ID=".$id." AND uid=".$uid);
            return ['new_bal' => $new_bal, 'future_new_bal' => $future_new_bal];
        }else {
            return false;
        }
    }
    public function copy_text($uid, $id) {

        $result = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id." AND uid=".$uid);

        if($result->num_rows() > 0) {
            $ban_info = $result->row_array();

            $this->db->query("INSERT INTO text_ad(uid, type_of_ad, head, body, url, lang, Date) VALUES(".$uid.", ".$ban_info['type_of_ad'].", '".$ban_info['head']."', '".$ban_info['body']."', '".$ban_info['url']."', '".$ban_info['lang']."', ".time().")");
            return $this->db->insert_id();
        }
        exit();
    }
    public function update_text_ad_conf($uid, $idb, $lang) {

        $this->db->query("UPDATE text_ad SET lang='".$lang."' WHERE ID=".$idb." AND uid=".$uid);

    }
    public function update_text_ad_prices($arr) {

        $this->db->query("UPDATE `ads_setts` SET `Price_click_125x125`=".$arr['Price_click_125x125'].", `Price_show_125x125`=".$arr['Price_show_125x125'].", `Price_click_300x50`=".$arr['Price_click_300x50'].", `Price_show_300x50`=".$arr['Price_show_300x50'].", `Price_click_300x250`=".$arr['Price_click_300x250'].", `Price_show_300x250`=".$arr['Price_show_300x250'].", `Price_click_300x600`=".$arr['Price_click_300x600'].", `Price_show_300x600`=".$arr['Price_show_300x600'].", `Price_click_468x60`=".$arr['Price_click_468x60'].", `Price_show_468x60`=".$arr['Price_show_468x60'].", `Price_click_728x90`=".$arr['Price_click_728x90'].", `Price_show_728x90`=".$arr['Price_show_728x90']);
    }
    public function add_new_text_ad($uid, $type_of_ad, $head, $body, $url, $lang) {

        $this->db->query("INSERT INTO text_ad(uid, type_of_ad, head, body, url, lang, Date) VALUES(".$uid.", ".$type_of_ad.", '".$head."', '".$body."', '".json_encode($url, JSON_UNESCAPED_UNICODE)."', '".$lang."', ".time().")");
        return $this->db->insert_id();
    }
    public function ch_old_text_ad($id, $uid, $head, $body, $url, $lang) {

        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            $arr = $row;
        }

        $this->db->query("UPDATE text_ad SET head='".$head."', body='".$body."', url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0, lang='".$lang."' WHERE ID=".$id);
    }
    public function del_text_ad($uid, $id) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id." AND uid=".$uid);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            if($row['cont_type'] == 1) {
                unlink($arr['bnr']);
            }

            //$this->db->query("UPDATE text_ad SET amount_btc=amount_btc+".($arr['count']-$arr['current_count'])." WHERE id=".$uid."");

            $this->db->query("DELETE FROM text_ad WHERE ID=".$id);
        }
    }
    public function take_my_text_ad($uid, $st, $od) {

        $search_arr = array();

        switch ($st) {
            case 's_2':
                $str_s = 'Status=0';
                $search_arr[] = $str_s;
                break;
            case 's_1':
                $str_s = 'Status=1';
                $search_arr[] = $str_s;
                break;
            case 's_3':
                $str_s = 'Status=2';
                $search_arr[] = $str_s;
                break;
        }

        switch ($od) {
            case 'o_1':
                $str_o = "ASC";
                break;
            case 'o_2':
                $str_o = "DESC";
                break;
            case '':
                $str_o = "DESC";
                break;
        }

        if(count($search_arr) > 1) {
            $addstr = ' AND '.$search_arr[0].' AND '.$search_arr[1];
        }elseif(count($search_arr) == 1) {
            $addstr = ' AND '.$search_arr[0];
        }else{
            $addstr = '';
        }

        // echo $addstr;exit();

        $query = $this->db->query("SELECT * FROM text_ad WHERE uid=".$uid." ".$addstr." ORDER BY ID ".$str_o);

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function acc_text_ad($id) {
        // echo "UPDATE banners SET status=1 WHERE ID=".$id;exit();
        $this->db->query("UPDATE text_ad SET status=1 WHERE ID=".$id);
    }
    public function del_text_ads($id) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id);
        
        if(count($query->result_array()) > 0) {
            
            foreach ($query->result_array() as $row) {
                $arr = $row;
            }

            $this->db->query("DELETE FROM text_ad WHERE ID=".$id);
        }
    }
    public function cancel_text_ad($id, $riason) {

        $this->db->query("UPDATE text_ad SET status=2, Comment='".$this->db->escape_str($riason)."' WHERE ID=".$id);

    }
    public function take_all_text_ad($start) {
        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0 ORDER BY t1.ID DESC LIMIT $start, $count");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_text_ad_total_count() {

        $query = $this->db->query("SELECT * FROM text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id WHERE t1.Status=0");

        return $query->num_rows();
    }
    public function take_all_text_ad_search($start, $type, $val) {

        if($type == 'Status' && $val == 1) {
            $addstr = 'DESC';
        }elseif($type == 'Status' && $val == 0) {
            $addstr = 'ASC';
        }else {
            $addstr = 'DESC';
        }

        $search_query = "";

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $count = 20;

        $query = $this->db->query("SELECT t1.*, t2.login as login, t2.u_lang as language FROM text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count");

        // echo "SELECT t1.*, t2.login as login, t2.u_lang as language FROM banners as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query." ORDER BY t1.ID ".$addstr." LIMIT $start, $count";exit();

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function get_text_ad_total_count_search($start, $type, $val) {

        if($type == 'login' || $type == 'language') {
            if($type == 'language') {
                $type = 'u_lang';
            }
            $search_query = " WHERE t2.".$type."='".$val."' ";
        }elseif($type == 'url') {
            $search_query = " WHERE t1.".$type."='\"".$val."\"' ";
        }elseif($type == 'format') {
            $search_query = " WHERE t1.".$type."='".$val."' ";
        }else {
            $search_query = " WHERE t1.".$type."=".$val." ";
        }

        $query = $this->db->query("SELECT * FROM text_ad as t1 INNER JOIN users as t2 ON t1.uid=t2.id".$search_query);

        return $query->num_rows();
    }
    public function take_text_ad_for_look($uid) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE status=1 AND Clicked_by NOT LIKE '%|".$uid."|%' ORDER BY current_clicks ASC");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }

        return $result;
    }
    public function check_text_ad_for_look($uid, $id){
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id." AND status=1 AND current_clicks<Clicks AND Clicked_by NOT LIKE '%|".$uid."|%'");

        $result = array();

        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        if(count($result) < 1) {
            return false;
        }else {
            return $result;
        }
    }
    public function check_text_ad_lord($uid, $id) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id." AND uid=".$uid);
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    public function ch_text_ad($uid, $ID, $url) {
        $this->db->query("UPDATE banners SET url='".json_encode($url, JSON_UNESCAPED_UNICODE)."', Status=0 WHERE uid=".$uid." AND ID=".$ID);
    }
    public function up_bal_text_ad($uid, $ID, $bal, $shows) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$ID." AND uid=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // $this->db->query("UPDATE users SET amount_btc=amount_btc-".$bal." WHERE id=".$uid);
            $this->db->query("UPDATE text_ad SET count=count+".$shows." WHERE ID=".$ID);

            // $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, btc_address, actiondate) VALUES(457, 'PCT', ".$uid.", 1, ".$bal.", 'buying ".$shows." shows(text)', now())");

            return true;
        }else {
            return false;
        }
    }
    public function take_text_ad($id) {
        $query = $this->db->query("SELECT * FROM text_ad WHERE ID=".$id);

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end text_ad operations
    */



     /*
        bonus operations
    */
    public function update_bonus_setts($arr) {
        $this->db->query("UPDATE `settings` SET `bonus2_wal`=".$arr['bonus2_wal'].", `price_for_bonus2`=".$arr['price_for_bonus2']);
    }
    public function update_time_bonus_setts($arr) {
        $this->db->query("UPDATE `settings` SET `type_bonus_main`=".$arr['type_bonus_main'].", `type_count_bonus_main`='".$arr['type_count_bonus_main']."', `count_bonus_main`=".$arr['count_bonus_main'].", `type_time_before_show_bonus`='".$arr['type_time_before_show_bonus']."', `time_before_show_bonus`=".$arr['time_before_show_bonus']);
    }
    public function update_link_bonus_setts($str) {

        if($str == 1) {
            $numb = rand();
            $path = md5($numb);
            $this->db->query("UPDATE `settings` SET `state_link_bonus_main`=1, path_link_bonus_main='".$path."'");
        }else {
            $this->db->query("UPDATE `settings` SET `state_link_bonus_main`=0, path_link_bonus_main=''");
        }
    }
    /*
        end bonus operations
    */



    /*
        fin and setts operations operations
    */
    public function saveWalToRet($uid, $wallet) {
        $this->db->query("UPDATE users SET wallet_to_return='".$wallet."' WHERE id=".$uid);
    }
    public function ch_st_main($val) {
        $this->db->query("UPDATE settings SET status_bonus_main=".$val);
    }
    public function ch_st_cab($val) {
        $this->db->query("UPDATE settings SET status_bonus_cab=".$val);   
    }
    public function get_info_bonus2($uid) {
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=2 AND idreceiver=".$uid);
        $row = $query->row();

        $query = $this->db->query("SELECT * FROM settings");
        $row2 = $query->row();

        return array( "all_income" => $row->sum, "need_to_get_bon" => $row2->bonus2_wal, "gift" => $row2->price_for_bonus2);
    }
    public function getBal($uid) {
        $query = $this->db->query("SELECT amount_btc FROM users WHERE id=".$uid);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            echo rtrim(rtrim(number_format($result['amount_btc'], 8, '.', ''), "0"), ".");
        }else {
            echo 0;
        }
    }
    public function TransferToAnotherBalance($uid, $sum) {
        $query = $this->db->query("SELECT * FROM users WHERE id=".$uid);
        if($query->num_rows() > 0) {
            $row = $query->row_array();
            if(bccomp($row['add_amount_btc'], $sum, 8) >= 0) {

                @$sum = $sum + 0;

                $this->db->query("UPDATE users SET add_amount_btc=add_amount_btc-".$sum.", amount_btc=amount_btc+".$sum." WHERE id=".$uid);

                // $this->db->query("UPDATE new_stat_for_admin SET Transfered_from_main_to_add=Transfered_from_main_to_add+".$sum);

                $this->db->query("INSERT INTO payments(type, currency, idreceiver, status, amount, actiondate) VALUES(2, 'PCT', ".$uid.", 1, ".$sum.", now())");

                $result = array('ads_bal' => rtrim(rtrim(number_format(bcadd($row['amount_btc'], $sum, 4), 4, '.', ''), "0"), "."), 'main_bal' => rtrim(rtrim(number_format(bcsub($row['add_amount_btc'], $sum, 4), 4, '.', ''), "0"), "."));
                $row_us = $row;

                return $result;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    public function getStatForMain() {
        $result = array();
        $result['count'] = 0;
        $result['price_all'] = 0;

        $query = $this->db->query("SELECT max(Perc_click) as max, min(Perc_click) as min FROM tarifs");
        $row = $query->row();
        $max = $row->max;
        $min = $row->min;

        $query = $this->db->query("SELECT * FROM compaign");

        foreach ($query->result_array() as $row) {

            $result['count']++;
            @$result['price_all'] = rtrim(rtrim(number_format($result['price_all'], 4, '.', ''), "0"), ".") + bcmul($time_ints[$row['Duration']], bcdiv($max, 100, 2), 4) + 0;
        }

        $result['max_satoshi_per_click'] = 0;

        $result['min_satoshi_per_click'] = 0;

        return $result;
    }
    public function get_fin_setts() {

        $query = $this->db->query("SELECT * FROM fin_sets");
        foreach ($query->result_array() as $row) {
            $result = $row;
        }

        return $result;
    }
    public function get_setts() {
        $result[1] = array();
        $result[2] = array();
        $result[3] = array();
        $result[4] = array();
        $result[5] = array();

        $query = $this->db->query("SELECT * FROM ads_setts");
        foreach ($query->result_array() as $row) {
            $result[1] = $row;
        }

        //рефские за клики по компаниям
        $query = $this->db->query("SELECT * FROM refs_refills ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[2][] = $row;
        }

        //рефские за клики по письмам
        $query = $this->db->query("SELECT * FROM refs_refills2 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[222][] = $row;
        }

        //рефские за оплату компаний
        $query = $this->db->query("SELECT * FROM refs_refills3 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[223][] = $row;
        }

        //рефские за оплату писем
        $query = $this->db->query("SELECT * FROM refs_refills4 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[224][] = $row;
        }

        //рефские за покупку показов
        $query = $this->db->query("SELECT * FROM refs_refills5 ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[225][] = $row;
        }

        $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s ORDER BY Lvl ASC");
        foreach ($query->result_array() as $row) {
            $result[23][] = $row;
        }

        return $result;
    }
    public function getFinStat($uid) {
        $result[1] = array();
        $result[2] = array();
        $result[3] = array();
        $result[4] = array();
        $result[5] = array();

        //всего заработано
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE (type=33 OR type=38) AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[1] = $row;
        }
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=38 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[2] = $row;
        }
        $query = $this->db->query("SELECT sum(amount) as sum FROM payments WHERE type=33 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[3] = $row;
        }
        $query = $this->db->query("SELECT COUNT(*) as count FROM payments WHERE type=33 AND idreceiver=".$uid);
        foreach ($query->result_array() as $row) {
            $result[4] = $row;
        }
        $query = $this->db->query("SELECT COUNT(*) as count FROM compaign WHERE Clicked_by LIKE '%|".$uid."|%'");
        foreach ($query->result_array() as $row) {
            $result[5] = $row;
        }

        return $result;
    }
    public function update_setts($arr) {
        $this->db->query("UPDATE `ads_setts` SET `Perc`=".$arr['Perc']);
    }
    public function update_setts_clink($arr) {
        $this->db->query("UPDATE `ads_setts` SET `PriceShowclinks`=".$arr['PriceShowclinks']);
    }
    public function update_time($arr) {
        $ids = json_decode($arr['arr_ids2']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM time_ints WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `time_ints` SET `Count`=".$_POST['Count_'.$ids[$i]].", `Price`=".$_POST['Price_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Count_'.$y]) ) {
            $this->db->query("INSERT INTO `time_ints` (ID, Count, Price) VALUES(".$y.", ".$_POST['Count_'.$y].", ".$_POST['Price_'.$y].")");
            $y++;
        }
    }
    public function update_refs($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }

    public function update_refs2($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills2 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills2` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills2` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs3($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills3 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills3` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills3` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs4($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills4 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills4` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills4` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }
    public function update_refs5($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills5 WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills5` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills5` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            $y++;
        }
    }

    public function update_refs_cs($arr) {
        $ids = json_decode($arr['arr_ids']);
        for($i = 0; $i < count($ids); $i++) {
            $query = $this->db->query("SELECT * FROM refs_refills_buy_c_and_s WHERE ID=".$ids[$i]);
            if($query->num_rows() > 0) {
                $this->db->query("UPDATE `refs_refills_buy_c_and_s` SET `Lvl`=".$_POST['Lvl_'.$ids[$i]].", `Percent`=".$_POST['Percent_'.$ids[$i]]." WHERE ID=".$ids[$i]);
            }
        }
        $y = max($ids)+1;
        while( isset($_POST['Lvl_'.$y]) ) {
            $this->db->query("INSERT INTO `refs_refills_buy_c_and_s` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")");
            // echo "INSERT INTO `refs_refills` (ID, Lvl, Percent) VALUES(".$y.", ".$_POST['Lvl_'.$y].", ".$_POST['Percent_'.$y].")";exit();
            $y++;
        }
    }
    public function delete_refs($id) {
        $this->db->query("DELETE FROM `refs_refills` WHERE ID=".$id);
    }
    public function delete_refs_cs($id) {
        $this->db->query("DELETE FROM `refs_refills_buy_c_and_s` WHERE ID=".$id);
    }
    public function delete_time($id) {
        $this->db->query("DELETE FROM `time_ints` WHERE ID=".$id);
    }
    public function take_ads_sett() {
        $query = $this->db->query("SELECT * FROM ads_setts");

        $result = array();

        foreach ($query->result_array() as $row) {
            return $row;
        }
    }
    /*
        end fin and setts operations operations
    */


    
    public function cr_mail_files() {
        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='english'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_eng.txt', 'a+');
        fwrite($f, $str_to);

        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='german'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_ger.txt', 'a+');
        fwrite($f, $str_to);

        $str_to = '';
        $query = $this->db->query("SELECT * FROM users WHERE u_lang='russian'");
        foreach ($query->result_array() as $row) {
            $str_to .= $row['email']."\n\r";
        }
        $f = fopen('ads_mail_rus.txt', 'a+');
        fwrite($f, $str_to);
    }
    public function add_sup_mess($em, $sub, $mess) {
        $this->db->query("INSERT INTO supp_mess(email, subject, mess, date) VALUES('".json_encode($em, JSON_UNESCAPED_UNICODE)."', '".json_encode($sub, JSON_UNESCAPED_UNICODE)."', '".json_encode($mess, JSON_UNESCAPED_UNICODE)."', ".time().")");
    }


}
?>