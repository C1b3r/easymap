<?php
define('ROOT_PATH',dirname(__FILE__).'/');
//needed for composers libraries
require_once(ROOT_PATH.'vendor/autoload.php');
//initialize the application
require_once ROOT_PATH.'/app/classes/class.boot.php'; 
Boot::init();
