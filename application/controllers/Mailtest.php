<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailtest extends CI_Controller {
    public function __construct() {
      // echo 1;
      // exit();
        parent::__construct();
    }
  
  public function index() {
      $this->load->library('email');
      $this->load->model('settings_model', 
'settings');
      $settings = $this->settings->get_settings();
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = $settings['smtp_host'];
      $config['smtp_user'] = $settings['smtp_user'];
      $config['smtp_pass'] = $settings['smtp_pass'];
      $config['smtp_port'] = '587'; #$settings['smtp_port'];
      $config['smtp_crypto'] = 'tls';
      $config['useragent'] = 'KMail/1.9';
      #$this->email->set_header('List-Unsubscribe', 'mailto:info@tradeprofit.net');
      $this->email->initialize($config);
      $this->email->from('admin@tradeprofit.net', 'admin@tradeprofit.net');//$settings['smtp_user'], 
//$settings['site_name'] );
      $this->email->to('am.shegar@mail.ru');
      $this->email->subject($settings['site_name'] . ' 
- Test your account');
      $res = $this->email->message('Hello! This email was sent just to inform you that your test account is ready. You may login now. Please feel free to contact us on any questions. Use info@tradeprofit.net to unsubscribe');
      $this->email->set_newline("\r\n");
    var_dump( $this->email->send());
    var_dump($this->email->print_debugger());
  }

  public function ReUs() {
    include_once 'libmail.php';

    // $to, $subject, $message, $email_from

    $to = 'belik.v666@gmail.com';
    $subject = 'Test';
    $message = "<b>HI!</b>";

    // $this->load->library('libmail');
    $m = new Mail('UTF-8'); // начинаем 
    $m->From( 'info@folk-co.in' ); // от кого отправляется почта 
    // echo $arrOfMainData['MainMail'];
    $m->To( $to ); // кому адресованно
    // echo $arrOfData['eMail'];
    $m->Subject( $subject );
    $m->Organization( 'ADS' );
    // echo $arrOfMainData['NameOfProject'];

    // $In = 'HERE';

    $m->Body( $message, 'html' );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
    // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
    $m->Priority(3) ;    // приоритет письма
    $m->smtp_on( "mail.betaproject.xyz", "info@betaproject.xyz", "5pabWlBpHf", 587 ); // если указана эта команда, отправка пойдет через SMTP

    // $m->smtp_on( "smtp.sendgrid.net", "spilloverfactory@gmail.com", "0BQESd8VydRS", 587 ) ; // если указана эта команда, отправка пойдет через SMTP
    $m->Send(); 
    // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
    // echo $m->Get(); 
    // $this->ci->mmodel->update_table($email);
    return true;
  }

  public function go() {
    $this->load->library('mailrotator');
    $this->lang->load('common_site', 'english');
    // $z = $this->mailrotator->send666('alex1web1@gmail.com','Проверка связи','Оно Работает!!!');
    // var_dump($z);

    $this->load->library('mailrotator');
        $usermail = 'tivleb67@gmail.com';
        $uid = 1;
        $encoded_link = $this->encode_params($uid, $usermail);

        $subject = 'TRAFFIC_STAR - ' . $this->lang->line('confirm_email');
        $message = sprintf($this->lang->line('confirmation_message'), '<br><br><a href="'.base_url() . 'index.php/verify/' . $encoded_link.'">'.base_url() . 'index.php/verify/' . $encoded_link.'</a><br><br>');
        var_dump($this->mailrotator->send($usermail, $subject, $message));
  }

  public function CheckMin() {

    // $user = $this->users->getUserById($this->session->uid);
      // $data['user_info'] = $user;

    $_POST['currency'] = 'BTC';
    $_POST['count_tokens'] = 23942.8092;

    $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();

    $UsBal = 0.00000000;

    $Price = bcmul(bcmul(bcdiv(1, $settings[$_POST['currency']], 8), $_POST['count_tokens'], 8), 0.5, 8);

    //$CountTok = bcmul(1.123, bcdiv($settings[$_POST['currency']], 0.5, 8), 8);

    //echo '1/ '.$settings[$_POST['currency']].' * '.$_POST['count_tokens'].' *0.5';

    // echo $settings[$_POST['currency']];

    echo $Price;

    //var_dump(bccomp($UsBal, $Price, 20));

    // if(bccomp($UsBal, $Price, 8) >= 0) {
    //  echo 1;
    // }else{
    //  echo 2;
    // }
  }

  public function get_data($smtp_conn) {
    $data="";
    while($str = fgets($smtp_conn,515)) {
      $data .= $str;
      if(substr($str,3,1) == " ") { break; }
    }
    return $data;
  }

  public function broken_test() {
    for($i = 0; $i < 2; $i++) {
      $i--;
    }
    echo 'end';
  }

  public function GetAddr($system) {
    switch ($system) {
            case 'Ethereum':
                $currency = 'ETH';
                break;
            case 'Bitcoin':
                $currency = 'BTC';
                break;
            case 'Bitcoin_Cash':
                $currency = 'BCH';
                break;
            case 'Litecoin':
                $currency = 'LTC';
                break;
            case 'Dash':
                $currency = 'DASH';
                break;
            default:
                $currency = 'BTC';
                break;
        }

        $priv_api = '47D05bbb898cAC44c48f985f4724618b9785ac2Bf99782B465b677E4B64b3903';
        $pub_api = 'c24059eb5dbdb51897434d6cb573ba018cae7026ba8ac024091e69145777fc29';


        $eth_api_addr = 'https://www.coinpayments.net/api.php';
        $cmd = 'get_callback_address';
        
        $ipn_url = urlencode(base_url() . 'payment_cb');
        $str = 'currency=' . $currency . '&version=1&cmd=' . $cmd . '&key=' . $pub_api . '&ipn_url=' . $ipn_url;
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
        if($ret->error != 'ok') {
            $f = fopen('coinpayments-error_log222.txt', 'a+');
            fwrite($f, time() . ': ' . $ret->error . "\r\n");
            fwrite($f, '=====END OF REQUEST=====');
            fclose($f);
             echo json_encode(array('err' => 1));
        }
        
        $addr = $ret->result->address;

        $f = fopen('coinpayments-send222.txt', 'a+');
        fwrite($f, 'query string:' . $str . "\r\n");
        fwrite($f, 'hmac:' . $hmac . "\r\n");
        fwrite($f, "======END OF QUERY======\r\n\r\n");
        fwrite($f, $server_output);
        fwrite($f, "\r\n======END OF RESPONSE======\r\n\r\n");
        fclose($f);

        echo json_encode(array('err' => 0, 'addr' => $addr,'curr' => $currency));
  }

  private function encode_params($uid, $usermail) {
        $str = $uid . '/' . $usermail;
        $encoded = base64_encode(base64_encode($str));
        return bin2hex($encoded . 'salt');
    }

  public function Test() {
    $this->load->library('mailrotator');

    $lang = 'english';
    $this->lang->load('common_site', $lang);

        $usermail = 'belik.v666@gmail.com';
        $encoded_link = $this->encode_params(1, $usermail);

        $subject = 'FOLK COIN - ' . $this->lang->line('confirm_email');
        $message = sprintf($this->lang->line('confirmation_message'), '<br><br><a href="'.base_url() . 'index.php/verify/' . $encoded_link.'">'.base_url() . 'index.php/verify/' . $encoded_link.'</a><br><br>');
        echo $this->mailrotator->send($usermail, $subject, $message);

        // $to = $usermail

        // include 'libmail.php';

        // // $to, $subject, $message, $email_from

        // // $this->load->library('libmail');
        // $m= new Mail('UTF-8'); // начинаем 
        // $m->From( 'info@folk-co.in' ); // от кого отправляется почта 
        // // echo $arrOfMainData['MainMail'];
        // $m->To( $to ); // кому адресованно
        // // echo $arrOfData['eMail'];
        // $m->Subject( $subject );
        // $m->Organization( 'FOLK' );
        // // echo $arrOfMainData['NameOfProject'];

        // // $In = 'HERE';

        // $m->Body( $message, 'html' );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
        // // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
        // $m->Priority(3) ;    // приоритет письма
        // $m->smtp_on( "smtp.sendgrid.net", "folkcoinico@gmail.com", "9dUxc5!t&5@K", 587 ) ; // если указана эта команда, отправка пойдет через SMTP
        // $m->Send(); 
  }

  public function HERE() {

    // if (function_exists('bcadd')) {
    //     echo "1";
    // } else {
    //     echo "2";
    // }

    // var_dump(bcsub(0.00213999, 0.00011111, 8));

    // exit();
    // folkcoinico@gmail.com
    // 9dUxc5!t&5@K
    // smtp.sendgrid.net

    $to = 'belik.v666@gmail.com';
    $subject = 'Support message';
    $message = 'This message is from support. Just look and save yout info';

     $header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
        $header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('FOLK')))."?= <info@betaproject.xyz>\r\n"; 
        $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
        $header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('FOLK')))."?= <info@betaproject.xyz>\r\n";
        $header.="X-Priority: 3 (Normal)\r\n";
        $header.="Message-ID: <172562218.".date("YmjHis")."@betaproject.xyz>\r\n";
        $header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($to)))."?= <".$to.">\r\n";
        $header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
        $header.="MIME-Version: 1.0\r\n";
        $header.="Content-Type: text/plain; charset=utf-8\r\n";
        $header.="Content-Transfer-Encoding: 8bit\r\n";

        $text=$message;
        $smtp_conn = fsockopen("mail.betaproject.xyz", 587);
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"EHLO betaproject.xyz\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"AUTH LOGIN\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,base64_encode("info@betaproject.xyz")."\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,base64_encode("5pabWlBpHf")."\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"MAIL FROM:info@betaproject.xyz\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"RCPT TO:".$to."\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"DATA\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
        $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"QUIT\r\n");
        $data = $this->get_data($smtp_conn);






    // folkcoinico@gmail.com
    // 9dUxc5!t&5@K
    // smtp.sendgrid.net


    // $this->load->model('mail_model', 'mmodel');
  //       $this->load->library('email');
  //       $config['protocol'] = 'smtp';
  //       $config['smtp_host'] = 'smtp.sendgrid.net';
  //       $config['smtp_user'] = 'folkcoinico@gmail.com';
  //       $config['smtp_pass'] = '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';
  //       $config['smtp_port'] = '465';
  //       $config['smtp_crypto'] = 'ssl';
  //       $this->email->initialize($config);
  //       $this->email->from('info@tradeprofit.net', 'info@tradeprofit.net');
  //       $this->email->to('tivleb67@gmail.com');
  //       $this->email->subject('Тестовое письмо!!');
  //       $res = $this->email->message('Проверка связи, проверка связи. Прийом.');
  //       $this->email->set_newline("\r\n");
  //       $res = $this->email->send();




    // include 'libmail.php';

    // // $this->load->library('libmail');
    // $m= new Mail('UTF-8'); // начинаем 
    // $m->From( 'info@betaproject.xyz' ); // от кого отправляется почта 
    // // echo $arrOfMainData['MainMail'];
    // $m->To( 'tivleb67@gmail.com' ); // кому адресованно
    // // echo $arrOfData['eMail'];
    // $m->Subject( "Тестовое письмо 11_21!" );
    // $m->Organization( 'FOLK' );
    // // echo $arrOfMainData['NameOfProject'];

    // $In = 'HERE';

    // $m->Body( "Поздравляем с регистрацией на Платформе FOLK! \n\r\n\r Ваши данные регистрации: \n\r\n\rВаш логин:alala\n\r\n\rВаш пароль:".$In." \n\r\n\r Подтвердите свою регистрацию, передя по ссылке https://?for=".$In."\n\r" );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
    // // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
    // $m->Priority(3) ;    // приоритет письма
    // $m->smtp_on( "mail.betaproject.xyz", "info@betaproject.xyz", "5pabWlBpHf", 465 ) ; // если указана эта команда, отправка пойдет через SMTP
    // $m->Send(); 
    // // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
    // var_dump($m->Get());
    





    // $un        = strtoupper(uniqid(time())); 
   //    $head      = "From: info@folk-co.in\n"; 
   //    $head     .= "To: tivleb67@gmail.com\n"; 
   //    $head     .= "Subject: Subject of this list is meeteng.\n"; 
   //    $head     .= "X-Mailer: PHPMail Tool\n"; 
   //    $head     .= "Reply-To: info@folk-co.in\n"; 
   //    $head     .= "Mime-Version: 1.0\n"; 
   //    $head     .= "Content-Type:multipart/mixed;"; 
   //    $head     .= "boundary=\"----------".$un."\"\n\n"; 
   //    $zag       = "------------".$un."\nContent-Type:text/html;\n"; 
   //    $zag      .= "Content-Transfer-Encoding: 8bit\n\nThis letter very important for us. Could u please answer for one question.\n\n"; 
   //    $zag      .= "------------".$un."\n"; 
   //    $zag      .= "Content-Type: application/octet-stream;"; 
      
   //    mail("tivleb67@gmail.com", "Subject: Subject of this list is meetemg", $zag, $head);




    // $this->ci =& get_instance();
  //       $this->ci->load->model('mail_model', 'mmodel');



    // $to = 'tivleb67@gmail.com';
    // $subject = 'Support message 121212';
    // $message = 'This message is from support. Just look and save yout info12121';

    


    // $this->ci->load->library('email');
  //       $config['protocol'] = 'smtp';
  //       $config['smtp_host'] = 'mail.folk-co.in';
  //       $config['smtp_user'] = 'info@folk-co.in';
  //       $config['smtp_pass'] = 'mZ0tN4Eaxf';
  //       $config['smtp_port'] = '587';
  //       $config['smtp_crypto'] = 'tsl';
  //       $this->ci->email->initialize($config);
  //       $this->ci->email->from('info@folk-co.in', 'info@folk-co.in');
  //       $this->ci->email->to($to);
  //       $this->ci->email->subject($subject);
  //       $res = $this->ci->email->message($message);
  //       $this->ci->email->set_newline("\r\n");
  //       $res = $this->ci->email->send();



    // include 'libmail.php';

    // // $this->load->library('libmail');
    // $m= new Mail('UTF-8'); // начинаем 
    // $m->From( 'info@folk-co.in' ); // от кого отправляется почта 
    // // echo $arrOfMainData['MainMail'];
    // $m->To( 'tivleb67@gmail.com' ); // кому адресованно
    // // echo $arrOfData['eMail'];
    // $m->Subject( "Тестовое письмо 11_21!" );
    // $m->Organization( 'FOLK' );
    // // echo $arrOfMainData['NameOfProject'];

    // $In = 'HERE';

    // $m->Body( "Поздравляем с регистрацией на Платформе BITCOINQ! \n\r\n\r Ваши данные регистрации: \n\r\n\rВаш логин:alala\n\r\n\rВаш пароль:".$In." \n\r\n\r Подтвердите свою регистрацию, передя по ссылке https://?for=".$In."\n\r" );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
    // // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
    // $m->Priority(3) ;    // приоритет письма
    // $m->smtp_on( "mail.folk-co.in", "info@folk-co.in", "mZ0tN4Eaxf", 587 ) ; // если указана эта команда, отправка пойдет через SMTP
    // $m->Send(); 
    // // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
    // echo $m->Get(); 



        // $this->load->model('mail_model', 'mmodel');
        // $this->load->library('email');
        // $config['protocol'] = 'IMAP';
        // $config['smtp_host'] = 'mail.tradeprofit.net';
        // $config['smtp_user'] = 'support@tradeprofit.net';
        // $config['smtp_pass'] = '9Zv5wtfW';
        // $config['smtp_port'] = '143';
        // $config['smtp_crypto'] = 'ssl';
        // $this->email->initialize($config);
        // $this->email->from('info@tradeprofit.net', 'info@tradeprofit.net');
        // $this->email->to('tivleb67@gmail.com');
        // $this->email->subject("Регистрация прошла успешно!");
        // $res = $this->email->message('his letter very important for us. Could u please answer for one question.');
        // $this->email->set_newline("\r\n");
        // $res = $this->email->send();

//    $lang['wallet_warning'] = 'ACHTUNG';
// $lang['wallet_updating']

    // $this->lang->load('common_site', 'german');
    // echo $this->lang->line('wallet_warning');
    // echo $this->lang->line('wallet_updating');

    //- регистраций от 5 до 20 в час
    // - сумма вклада от $10 до $100

    // - сумма вывода от 10% до 15% (или 13,5%)




    // $this->load->model('settings_model', 'settings');
    // $start_date = $this->settings->get_settings();
    // $a = rand(2, 10);
    // $b = rand(5, 50);
    // $c = round($b*rand(10, 15)/100);
    // $settings = $this->settings->updateFake($a+$start_date['Fake_us'], $b+$start_date['Fake_in'], $c+$start_date['Fake_out']);

    // $this->load->library('mailrotator');
    // $z = $this->mailrotator->send('support@tradeprofit.net','Проверка связи','Оно Работает!!!');
    // var_dump($z);

    // $this->& get_instance();
    // include 'libmail.php';

    // // $this->load->library('libmail');
    // $m= new Mail('UTF-8'); // начинаем 
    // $m->From( 'am.shegar@mail.ru' ); // от кого отправляется почта 
    // // echo $arrOfMainData['MainMail'];
    // $m->To( 'support@gmail.com' ); // кому адресованно
    // // echo $arrOfData['eMail'];
    // $m->Subject( "Тестовое письмо 11_21!" );
    // $m->Organization( 'Tradeprofite' );
    // // echo $arrOfMainData['NameOfProject'];

    // $part1 = rand(1, 100);
    // $part2 = rand(1, 100);
    // $part3 = rand(1, 100);
    // $part4 = rand(1, 100);
    // $part5 = rand(1, 100);
    // $part6 = rand(1, 100);
    // $part7 = rand(1, 100);
    // $part8 = rand(1, 100);
    // $part9 = rand(1, 100);
    // $part10 = rand(1, 100);
    // $part11 = rand(1, 100);
    // $part12 = rand(1, 100);
    // $part13 = rand(1, 100);
    // $part14 = rand(1, 100);
    // $part15 = rand(1, 100);

    // $In = $part1.$part2.$part3.$part4.$part5.$part6.$part7.$part8.$part9.$part10.$part11.$part12.$part13.$part14.$part15;

    // $m->Body( "Поздравляем с регистрацией на Платформе BITCOINQ! \n\r\n\r Ваши данные регистрации: \n\r\n\rВаш логин:alala\n\r\n\rВаш пароль:".$In." \n\r\n\r Подтвердите свою регистрацию, передя по ссылке https://?for=".$In."\n\r" );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
    // // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
    // $m->Priority(3) ;    // приоритет письма
    // $m->smtp_on( "mail.tradeprofit.net", "info@tradeprofit.net", "0iNivjFR", 143 ) ; // если указана эта команда, отправка пойдет через SMTP
    // $m->Send(); 
    // // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
    // echo $m->Get(); 

      // $un        = strtoupper(uniqid(time())); 
      // $head      = "From: info@tradeprofit.com\n"; 
      // $head     .= "To: belik.v666@gmail.com\n"; 
      // $head     .= "Subject: Subject of this list is meetemg.\n"; 
      // $head     .= "X-Mailer: PHPMail Tool\n"; 
      // $head     .= "Reply-To: am.shegar@mail.ru\n"; 
      // $head     .= "Mime-Version: 1.0\n"; 
      // $head     .= "Content-Type:multipart/mixed;"; 
      // $head     .= "boundary=\"----------".$un."\"\n\n"; 
      // $zag       = "------------".$un."\nContent-Type:text/html;\n"; 
      // $zag      .= "Content-Transfer-Encoding: 8bit\n\nThis letter very important for us. Could u please answer for one question.\n\n"; 
      // $zag      .= "------------".$un."\n"; 
      // $zag      .= "Content-Type: application/octet-stream;"; 
      
      // mail("tivleb67@gmail.com", "Subject: Subject of this list is meetemg", $zag, $head);

    // $this->load->library('email');

    // $config['protocol'] = 'sendmail';
    // $config['mailpath'] = '/usr/sbin/sendmail';
    // $config['charset'] = 'iso-8859-1';
    // $config['wordwrap'] = TRUE;

    // $this->email->initialize($config);

    // $this->email->from('info@tradeprofit.net', 'Tradeprofit');
    // $this->email->to('tivleb67@gmail.com');
    // // $this->email->cc('another@another-example.com');
    // // $this->email->bcc('them@their-example.com');

    // $this->email->subject('Успешная регистрация!');
    // $this->email->message('Спасибо что вы зарегестрировались на нашем сайте. Прошу вас сохранить данные от входа и никому их не выдавать. Ваши данные от входа: amshegar'."\n\r".'37fe2df934'."\n\r");

    // $this->email->send();




     //    $this->load->model('mail_model', 'mmodel');
      // $this->load->library('email');
     //    $config['protocol'] = 'smtp';
     //    $config['smtp_host'] = 'mail.tradeprofit.net';
     //    $config['smtp_user'] = 'support@tradeprofit.net';
     //    $config['smtp_pass'] = '9Zv5wtfW';
     //    $config['smtp_port'] = '587';
     //    $config['smtp_crypto'] = 'tls';
     //    $this->email->initialize($config);
     //    $this->email->from('info@tradeprofit.net', 'info@tradeprofit.net');
     //    $this->email->to('belik.v666@gmail.com');
     //    $this->email->subject('Тестовое письмо! Проверяем почту. Собираемся подкючать.');
     //    $res = $this->email->message('Это пиьсмо сгенерировано почтой для проверки работоспособности сервера без направления по smtp.');
     //    $this->email->set_newline("\r\n");
     //    $res = $this->email->send();

     //    var_dump($res);

    // if($res)
    //  // $this->mmodel->update_table($email);
    // return $res;
  }
}
