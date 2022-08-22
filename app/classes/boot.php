<?php
namespace app\classes;

use app\controllers\Error_Controller;
use app\classes\Controller;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

defined('ROOT_PATH') or exit('Direct access forbidden');

require_once ROOT_PATH.'/config/conf.php';
//require_once ROOT_PATH.'../conf.php';
require_once ROOT_PATH.'/config/database.php';
// require_once ROOT_PATH.'/app/routes/web.php';

class Boot 
{
    //https://www.php.net/manual/es/language.oop5.properties.php no compatible con 7.3
    // public static Boot $app;
    public static $app;
    public $perro;
    public $validation, //my class validation
           $validator, //validator laravel
           $router,
           $loader,
		   $translator,
           $capsule,
           $session,
           $container,
           $events,
           $request; //pasar todo a esta variable o dejarlo tal y como esta en el new
    // public ?Controller $controller = null;
    // public Router $router;

    function __construct()
    {
        self::$app = $this;
        // $this->router = new Router();
        // $this->loadUrls();
        $this->init();
        $this->loadHelpers();
        $this->load();
    }
    public function init()
    { 
        new Session();
        $this->loader = new FileLoader(new Filesystem, '/lang');
		$this->translator = new Translator($this->loader, 'es');
        $this->validation = new Validation();
        $this->validator = $this->validation->validation;
        /*The same as Boot::loader
        if loader not static use new Self, when create object, loader will be load(class,controller and  model*/
         // spl_autoload_register(array('Boot','loader')); //before namespaces
        // spl_autoload_register(array('app\classes\Boot','loader'));
        // new Session;
        // new Boot();

    }
    public function loadUrls()
    {
        $router = $this->router;
        if (file_exists(ROOT_PATH.'/routes/web.php'))
        {
            require_once ROOT_PATH.'/routes/web.php';
        }else{
            throw new MyException('Not routes files found',__FUNCTION__,0);
        }
        require_once ROOT_PATH.'/app/routing/internalRouting.php';
        
        $router->any('{path?}', function() {
            throw new MyException(); //404
            } )->where('path', '(.*)');

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

        // $url = $this->parseUrl();
		
		// $controller = new InitController($url);

		try{
        // Create a request from server variables, and bind it to the container; optional
        // Create a service container
        $this->container = new Container;
        $this->request = Request::capture();
        $this->container->instance('Illuminate\Http\Request', $this->request);

        // Using Illuminate/Events/Dispatcher here (not required); any implementation of
        // Illuminate/Contracts/Event/Dispatcher is acceptable
        $this->events = new Dispatcher($this->container);

        // Create the router instance
        $this->router = new Router($this->events, $this->container);

        // Global middlewares
        // $globalMiddleware = [
        //     \App\Middleware\StartSession::class,
        // ];

        // Array middlewares
        $routeMiddleware = [
            'admin' => \app\routing\middlewares\Authenticate::class,
        ];

        // Load middlewares to router
        foreach ($routeMiddleware as $key => $middleware) {
            $this->router->aliasMiddleware($key, $middleware);
        }
        // Load the routes
        $this->loadUrls();

        // Create the redirect instance
        \Helper::redirect($this->router->getRoutes(), $this->request);
        // $redirect = new Redirector(new UrlGenerator());

        // use redirect
        // return $redirect->home();
        // return $redirect->back();
        // return $redirect->to('/');

        // Dispatch the request through the router
        $response = $this->router->dispatch($this->request);

        // Send the response back to the browser
        $response->send();
		    //  $controller->load();
		    //  $this->router->resolve();
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