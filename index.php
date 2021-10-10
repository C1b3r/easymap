<?php
//Create constant with case sensitive
define('ROOT_PATH',dirname(__FILE__).'/',true);

require_once ROOT_PATH.'/app/classes/class.boot.php'; 
Boot::init();
