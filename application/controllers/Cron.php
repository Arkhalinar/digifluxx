<?php
defined('BASEPATH') OR exit('No direct script access allowed');


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class Cron extends CI_Controller {
  public function __construct() {
    parent::__construct();
  }
  public function cron_start() {
    // ini_set('max_execution_time', 900);

  	// exit();

    $this->load->model('Marketing_model', 'mark');
    // $f = fopen('CRON_LOGS612.txt', 'a+');
    
    $a = time();
    // fwrite($f, 'BEGIN '.$a."\n\r");

    file_put_contents('CRON_LOGS612.txt', file_get_contents('CRON_LOGS612.txt')." \n\r BEGIN_new ".time()." \n\r");//

    $this->mark->queue_take();
    $b = time();

    file_put_contents('CRON_LOGS612.txt', file_get_contents('CRON_LOGS612.txt')." END_new ".($b-$a)." \n\r\n\r");//
    // fwrite($f, 'END time:'.."sec \n\r\n\r");
  }
}
