<?php
define('ROOT_PATH',dirname(__FILE__).'/');
//needed for composers libraries
require_once(ROOT_PATH.'vendor/autoload.php');

use app\classes\Boot;
//initialize the application
new Boot();
