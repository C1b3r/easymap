<?php
namespace app\classes;

use app\controllers\Error_Controller;
defined('ROOT_PATH') or exit('Direct access forbidden');

require_once ROOT_PATH.'/config/conf.php';
//require_once ROOT_PATH.'../conf.php';
require_once ROOT_PATH.'/config/database.php';
// require_once ROOT_PATH.'/app/routes/web.php';

class Boot {

    function __construct()
    {
        $this->loadHelpers();
        $this->load();
    }
     //Function init Deprecated 
    public static function init()
    { 
        /*The same as Boot::loader
        if loader not static use new Self, when create object, loader will be load(class,controller and  model*/
         // spl_autoload_register(array('Boot','loader')); //before namespaces
        // spl_autoload_register(array('app\classes\Boot','loader'));
        // new Session;
        // new Boot();

    }
    //Function loader Deprecated 
    public static function loader($className)
    {
        //Separate index _ controller to array
        $path = explode('_',$className);
    //    var_dump($path);
        if (count($path) <= 1)
		{ 
			if (file_exists(CLASSES_PATH.'class.'.$className.'.php'))
			{
				require_once (CLASSES_PATH.'class.'.$className.'.php');
			}
		}
		else
		{  
            //0-index 1-controller o modal
			switch(strtolower($path[1]))
			{
				case "controller":
                    if (file_exists(CONTROLLER_PATH.$className.'.php'))
                    {
                        require_once CONTROLLER_PATH.$className.'.php';

                    }elseif(file_exists(CONTROLLER_ADMIN_PATH.$className.'.php')){

                        require_once CONTROLLER_ADMIN_PATH.$className.'.php';	

                    }else{
                        echo "no existe";
                    }
					
				break;
				case "model":
                    if (file_exists(MODEL_PATH.$className.'.php'))
                    {
                        require_once MODEL_PATH.$className.'.php';

                    }elseif(file_exists(MODEL_ADMIN_PATH.$className.'.php')){
                        
                        require_once MODEL_ADMIN_PATH.$className.'.php';	

                    }else{
                        echo "no existe el modelo ";
                    }
					
				break;
			}
		}
    }

    public function parseUrl()
    {
        //Get current url
        $url = $_SERVER["REQUEST_URI"];
        //If the proyect is in subfolder, i need clean url
        $clean_url = str_replace(CURRENT_DIRECTORY, "", $url );
        $url_components = parse_url($clean_url);
        //Parse url get me the path and query?= but i only need path /controller/action if exist

        if(isset($url_components['path']) && empty($url_components['path']))
        {
            return null;
        }else{
            return $url_components['path'];
        }
     
    }

    public function load()
    {
        // $url = isset($_GET['location']) ? $_GET['location'] : null;
        new Session();
        $url = $this->parseUrl();
		
		$controller = new InitController($url);

		try{
		     $controller->load();
		}
		catch(MyException $e)
		{
			$this->error($e->getMessage());
		}
    }

    private function error($message)
	{
		$controller = new Error_Controller();
		$controller->index($message,500);
		return false;
	}

    public function loadHelpers()
    {
        foreach (glob(ROOT_PATH.'app/helpers/*.php') as $filename) {
            require_once($filename);
        }

    }

}