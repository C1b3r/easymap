<?php
define('ROOT_PATH',dirname(__FILE__).'/');
//$start_time = microtime(true);
//needed for composers libraries
require_once(ROOT_PATH.'vendor/autoload.php');

use app\classes\Boot;
//initialize the application
new Boot();
//echo 'This page was generated in'.(number_format(microtime(true) - $start_time, 2,'.','')).'seconds';