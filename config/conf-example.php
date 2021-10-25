<?php 
defined('ROOT_PATH') or exit('Direct access forbidden');
//database
define("DB_HOST", "");
define("DB_USER", "");
define("DB_NAME", "");
define("DB_CHARSET", "utf8");
define("DB_PREFIX", "mymap_");
//path's
define('WEB_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ?  'https' : 'http');
define('WEB_PATH',WEB_PROTOCOL.'://'.$_SERVER["SERVER_NAME"].'/');
define('CURRENT_DIRECTORY',dirname($_SERVER['PHP_SELF'])); //if proyect is in subfolder
define('COMPLETE_WEB_PATH',WEB_PROTOCOL.'://'.$_SERVER["SERVER_NAME"].CURRENT_DIRECTORY.'/');
define('VIEW_PATH',ROOT_PATH.'app/views/');
define('CONTROLLER_PATH',ROOT_PATH.'app/controllers/');
define('MODEL_PATH',ROOT_PATH.'app/model/');
define('CLASSES_PATH',ROOT_PATH.'app/classes/');
define('PUBLIC_PATH',ROOT_PATH.'app/public/');
define('PUBLIC_WEB_PATH',COMPLETE_WEB_PATH.'resources/');
define('ADMIN_EMAIL','');
define('DEBUG_IP','');
define('DEBUG_ENVIRONMENT',TRUE);
