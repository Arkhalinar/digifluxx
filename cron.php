<?php
exit();
file_put_contents('/home/admin/web/digifluxx.com/public_html/CRON_LOGS612.txt', file_get_contents('/home/admin/web/digifluxx.com/public_html/CRON_LOGS612.txt')." \n\r BEGIN_new3 ".time()." \n\r");//
$a = time();
//$url = "https://digifluxx.com/welcome/queue_start";
$url = "https://116.203.253.27/welcome/queue_start";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//для возврата результата в виде строки, вместо прямого вывода в браузер
$returned = curl_exec($ch);
$b = time();
file_put_contents('/home/admin/web/digifluxx.com/public_html/CRON_LOGS612.txt', file_get_contents('/home/admin/web/digifluxx.com/public_html/CRON_LOGS612.txt')." END_new3(".$returned." | ".curl_error($ch).") ".($b-$a)." \n\r\n\r");//
curl_close ($ch);
exit();


//file_put_contents('CRON_LOGS.txt', file_get_contents('CRON_LOGS.txt')." \n\r\n\r".time()." \n\r\n\r");//

// try{
//    file_put_contents('CRON_LOGS.txt', time()." \n\r\n\r");//
// } 
// //Перехватываем (catch) исключение, если что-то идет не так.
// catch (Exception $ex) {
//     //Выводим сообщение об исключении.
//     echo $ex->getMessage();
// }



exit();
/**
* @author       Asim Zeeshana
* @web         http://www.asim.pk/
* @date     13th May, 2009
* @copyright    No Copyrights, but please link back in any way
*/
 
/*
|---------------------------------------------------------------
| CASTING argc AND argv INTO LOCAL VARIABLES
|---------------------------------------------------------------
|
*/
$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];
 
// INTERPRETTING INPUT
if ($argc > 1 && isset($argv[1])) {
$_SERVER['PATH_INFO']   = $argv[1];
$_SERVER['REQUEST_URI'] = $argv[1];
} else {
$_SERVER['PATH_INFO']   = '/crons/index';
$_SERVER['REQUEST_URI'] = '/crons/index';
}
 
/*
|---------------------------------------------------------------
| PHP SCRIPT EXECUTION TIME ('0' means Unlimited)
|---------------------------------------------------------------
|
*/
set_time_limit(0);
 
require_once('index.php');
 
/* End of file test.php */
?>