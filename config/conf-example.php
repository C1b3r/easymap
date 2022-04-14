<?php 
defined('ROOT_PATH') or exit('Direct access forbidden');
//database
define("DB_HOST", "");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
define("DB_CHARSET", "utf8mb4");
define("DB_COLLATION", "utf8mb4_unicode_ci");
define("DB_PREFIX", "mymap_");
define("ADMIN_FOLDER", "admin"); //For security reasons, it stronglly recomended change admin folder and the value of this variable

//path's
define('WEB_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ?  'https' : 'http');
define('WEB_PATH',WEB_PROTOCOL.'://'.$_SERVER["SERVER_NAME"].'/');
define('CURRENT_DIRECTORY',dirname($_SERVER['PHP_SELF'])); //if proyect is in subfolder
define('COMPLETE_WEB_PATH',WEB_PROTOCOL.'://'.$_SERVER["SERVER_NAME"].CURRENT_DIRECTORY.'/');
define('COMPLETE_WEB_PATH_ADMIN',WEB_PROTOCOL.'://'.$_SERVER["SERVER_NAME"].CURRENT_DIRECTORY.'/'.ADMIN_FOLDER.'/');
define('VIEW_PATH',ROOT_PATH.'app/views/');
define('VIEW_FORM_PATH',ROOT_PATH.'app/views/forms/');
define('CONTROLLER_PATH',ROOT_PATH.'app/controllers/');
define('CONTROLLER_ADMIN_PATH',ROOT_PATH.'app/controllers/admincontrollers/');
define('MODEL_PATH',ROOT_PATH.'app/model/');
define('MODEL_ADMIN_PATH',ROOT_PATH.'app/model/adminmodels/');
define('CLASSES_PATH',ROOT_PATH.'app/classes/');
define('PUBLIC_PATH',ROOT_PATH.'app/public/');
define('PUBLIC_WEB_PATH',COMPLETE_WEB_PATH.'resources/');
define('CURRENT_DOMAIN',$_SERVER["SERVER_NAME"]);
define('ADMIN_EMAIL','');
define('DEBUG_IP','');
define('DEBUG_ENVIRONMENT',TRUE); //Change this to false if you upload to production/real server
define('LOG_PATH',ROOT_PATH.'logs/');

//map configuration
define('MAP_RESOURCES', array(
    'css'=> array(
    'leaflet/leaflet.css',
    'https://unpkg.com/leaflet-geosearch@3.6.0/dist/geosearch.css',
    ),
    'js' => array(
    'leaflet/leaflet.js',
    'https://unpkg.com/leaflet-geosearch@3.6.0/dist/geosearch.umd.js'
    )
    )
);