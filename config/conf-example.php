<?php 
defined('ROOT_PATH') or exit('Direct access forbidden');
//I recommend moving the conf.php file out of the domain accessible folder for security reasons, you can change manually in boot.php line
//database
define("DB_HOST", "");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
define("DB_CHARSET", "utf8mb4");
define("DB_COLLATION", "utf8mb4_unicode_ci");
define("DB_PREFIX", "mymap_");
define("ADMIN_FOLDER", "admin"); //For security reasons, it stronglly recomended change admin folder and the value of this variable
define("APP_ENV", "develop");

define('ADMIN_EMAIL','');
define('DEBUG_IP','');
define('DEBUG_ENVIRONMENT',TRUE); //Change this to false if you upload to production/real server