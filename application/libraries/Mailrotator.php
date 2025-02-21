<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailrotator {
    protected $ci;

    private $emails = array(
                            'belik.v666@gmail.com:de01c1d48db6c321c637457113ed80d5',
                            'elen.arubo04@gmail.com:P0kerGmail01',
                            'tivleb67@gmail.com:37fe2df934',
                            'evgeniy.dorofeyev@gmail.com:DorofeyevGmail'
                        );

    public function __construct()  {
        $this->ci =& get_instance();
        $this->ci->load->model('mail_model', 'mmodel');
    }

    public function send22($to, $subject, $message, $email_from = 'noreply@digifluxx.com') {


        include_once 'libmail.php';

        // $this->load->library('libmail');
        $m = new Mail('UTF-8'); // начинаем 
        $m->From( $email_from ); // от кого отправляется почта 
        // echo $arrOfMainData['MainMail'];
        $m->To( $to ); // кому адресованно
        // echo $arrOfData['eMail'];
        $m->Subject( $subject );
        $m->Organization( 'DIGIFLUXX' );
        // echo $arrOfMainData['NameOfProject'];

        // $In = 'HERE';

        $m->Body( $message, 'html' );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
        // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
        $m->Priority(3) ;    // приоритет письма
        $m->smtp_on( "mail.digifluxx.com", "noreply@digifluxx.com", "RG7Lutx8dr", 587 ); // если указана эта команда, отправка пойдет через SMTP

        // $m->smtp_on( "smtp.sendgrid.net", "spilloverfactory@gmail.com", "0BQESd8VydRS", 587 ) ; // если указана эта команда, отправка пойдет через SMTP
        $m->Send(); 
        // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
        echo $m->Get(); 
        // $this->ci->mmodel->update_table($email);
        return true;
    }

    public function send($to, $subject, $message, $email_from = 'noreply@digifluxx.com') {
        // $email = null;
        // $pass = '';
        // foreach ($this->emails as $e) {
        //     $creds = explode(':', $e);
        //     $adr = $creds[0];
        //     if($this->ci->mmodel->in_limit($adr)) {
        //         $email = $adr;
        //         $pass = $creds[1];
        //         break;
        //     }
        //     continue;
        // }
        // if($email == null) {
        //     $this->inform_admin();
        //     return false;
        // }

        // $this->ci->load->library('email');
        // $config['protocol'] = 'smtp';
        // $config['smtp_host'] = 'mail.folk-co.in';
        // $config['smtp_user'] = 'info@folk-co.in';
        // $config['smtp_pass'] = 'mZ0tN4Eaxf';
        // $config['smtp_port'] = '587';
        // $config['smtp_crypto'] = 'tsl';
        // $this->ci->email->initialize($config);
        // $this->ci->email->from('info@folk-co.in', 'info@folk-co.in');
        // $this->ci->email->to($to);
        // $this->ci->email->subject($subject);
        // $res = $this->ci->email->message($message);
        // $this->ci->email->set_newline("\r\n");
        // $res = $this->ci->email->send();

  //       $header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
  //       $header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('FOLK')))."?= <info@folk-co.in>\r\n"; 
  //       $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
  //       $header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('FOLK')))."?= <".$email_from.">\r\n";
  //       $header.="X-Priority: 3 (Normal)\r\n";
  //       $header.="Message-ID: <172562218.".date("YmjHis")."@folk-co.in>\r\n";
  //       $header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($to)))."?= <".$to.">\r\n";
  //       $header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
  //       $header.="MIME-Version: 1.0\r\n";
  //       $header.="Content-Type: text/plain; charset=utf-8\r\n";
  //       $header.="Content-Transfer-Encoding: 8bit\r\n";

  //       $text=$message;
  //       $smtp_conn = fsockopen("mail.folk-co.in", 25);
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"EHLO folk-co.in\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"AUTH LOGIN\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,base64_encode("info@folk-co.in")."\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,base64_encode("mZ0tN4Eaxf")."\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"MAIL FROM:info@folk-co.in\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"RCPT TO:".$to."\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"DATA\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
  //       $data = $this->get_data($smtp_conn);

  //       fputs($smtp_conn,"QUIT\r\n");
  //       $data = $this->get_data($smtp_conn);

		// // if($data)
		// // 	$this->ci->mmodel->update_table($email);
		// return $data;

        include_once 'libmail.php';

        // $this->load->library('libmail');
        $m = new Mail('UTF-8'); // начинаем 
        $m->From( $email_from ); // от кого отправляется почта 
        // echo $arrOfMainData['MainMail'];
        $m->To( $to ); // кому адресованно
        // echo $arrOfData['eMail'];
        $m->Subject( $subject );
        $m->Organization( 'DIGIFLUXX' );
        // echo $arrOfMainData['NameOfProject'];

        // $In = 'HERE';

        $m->Body( $message, 'html' );//"\n\r\n\rПосмотрите видео инструкцию 'Попление баланса и оплата программы'\n\rСсылка ".$arrOfMainData['link_for_reg'].
        // echo $arrOfMainData['SSL'].$arrOfMainData['NameOfSite'];
        $m->Priority(3) ;    // приоритет письма
        $m->smtp_on( "mail.digifluxx.com", "noreply@digifluxx.com", "RG7Lutx8dr", 587 ); // если указана эта команда, отправка пойдет через SMTP

        // $m->smtp_on( "smtp.sendgrid.net", "spilloverfactory@gmail.com", "0BQESd8VydRS", 587 ) ; // если указана эта команда, отправка пойдет через SMTP
        $m->Send(); 
        // mail('belik.v666@gmail.com', 'Тестовое письмо, очень нужно чтобы долшло.', 'Вот сюда должно прийти письмо, неужели дойдет с простой функции?');
        // echo $m->Get(); 
        // $this->ci->mmodel->update_table($email);
        return true;
    }

    public function get_data($smtp_conn) {
        $data="";
        while($str = fgets($smtp_conn,515)) {
            $data .= $str;
            if(substr($str,3,1) == " ") { break; }
        }
        return $data;
    }

    public function send2($to, $subject, $message, $email_from) {

        // $fqw = fopen('AAAAA_LOGS_MAIL_NEW.txt', 'a+');
        // fwrite($fqw, 'WORKED!');

        $header="Date: ".date("D, j M Y G:i:s")." +0700\r\n"; 
        $header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Tradeprofit')))."?= <info@tradeprofit.net>\r\n"; 
        $header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n"; 
        $header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('User')))."?= <".$email_from.">\r\n";
        $header.="X-Priority: 3 (Normal)\r\n";
        $header.="Message-ID: <172562218.".date("YmjHis")."@tradeprofit.net>\r\n";
        $header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('support')))."?= <".$to.">\r\n";
        $header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($subject)))."?=\r\n";
        $header.="MIME-Version: 1.0\r\n";
        $header.="Content-Type: text/plain; charset=utf-8\r\n";
        $header.="Content-Transfer-Encoding: 8bit\r\n";

        $text=$message;//"Привет, проверка связи. Попробуй ответить мне. Должно направить на am.shegar@mail.ru";
        $smtp_conn = fsockopen("mail.tradeprofit.net", 25);
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"EHLO tradeprofit.net\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"AUTH LOGIN\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,base64_encode("info@tradeprofit.net")."\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,base64_encode("0iNivjFR")."\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"MAIL FROM:info@tradeprofit.net\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"RCPT TO:".$to."\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"DATA\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        fputs($smtp_conn,"QUIT\r\n");
        fgets($smtp_conn,515);
        // $data = $this->get_data($smtp_conn);

        return true;

        // $this->ci->load->library('email');
        // $config['protocol'] = 'smtp';
        // $config['smtp_host'] = 'smtp.gmail.com';
        // $config['smtp_user'] = $email;
        // $config['smtp_pass'] = $pass;
        // $config['smtp_port'] = '465';
        // $config['smtp_crypto'] = 'ssl';
        // $this->ci->email->initialize($config);
        // $this->ci->email->from('info@tradeprofit.net', 'info@tradeprofit.net');
        // $this->ci->email->to($to);
        // $this->ci->email->subject($subject);
        // $res = $this->ci->email->message($message);
        // $this->ci->email->set_newline("\r\n");
        // $res = $this->ci->email->send();
        // if($res)
        //     $this->ci->mmodel->update_table($email);
        // return $res;
    }

    private function inform_admin() {
        $this->ci->load->library('email');
        $this->load->model('settings_model', 'settings');
        $settings = $this->settings->get_settings();
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $settings['smtp_host'];
        $config['smtp_user'] = $settings['smtp_user'];
        $config['smtp_pass'] = $settings['smtp_pass'];
        $config['smtp_port'] = $settings['smtp_port'];
        $this->email->initialize($config);
        $this->email->from($settings['smtp_user'], 'Trade Profit');
        $this->email->to('belik.v666@gmail.com');
        $this->email->subject($settings['site_name'] . ' - Нужно больше ящиков');
        $res = $this->email->message('У tradeprofit.info закончились ящики, нужны еще регистрации. Больше, больше ящиков!');
        $this->email->set_newline("\r\n");
        $this->email->send();
    }
}