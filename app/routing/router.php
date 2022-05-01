<?php
namespace app\routing;

use app\classes\Boot;
use app\classes\MyException;
use app\classes\View as ViewClass;

class Router
{
    private Request $request;
    private Response $response;
    private array $routeMap = [];
    public array $routeAlias = [];
    private ViewClass $viewClass;
    private String $lastVerb = "";

    // public function __construct(Request $request, Response $response)
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->viewClass = new ViewClass();
    }

    public function get(string $url, $callback, $alias = "")
    {
        $this->routeMap['get'][$this->request->cleanURL($url)] = $callback;
        $this->lastVerb = 'get';
        if(!empty($alias)){
            $this->routeAlias[$alias] = array_key_last($this->routeMap['get']);
        }
        return $this;
    }

    /**
     * @param url
     * @param callback función de llamada asociada a la url
     * @param alias opcional si se requiere poner un alias a la ruta
     */
    public function post(string $url, $callback, $alias = "")
    {
        $this->routeMap['post'][$this->request->cleanURL($url)] = $callback;
        $this->lastVerb = 'post';
        if(!empty($alias)){
            $this->routeAlias[$alias] = array_key_last($this->routeMap['post']);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getRouteMap($method): array
    {
        return $this->routeMap[$method] ?? [];
    }

    public function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        // Trim slashes
        $url = $this->request->cleanURL($url);
        // $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

        $routeParams = false;

        // Start iterating registed routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = $this->request->cleanURL($route);
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;
        if (!$callback) {

            $callback = $this->getCallback();

            if ($callback === false) {
                //lanzo excepción y la invoco con / para indicar que está fuera del espacio de nombres
                throw new MyException('Controller method not found: '.$callback,0);
            }
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {

            $controller = new $callback[0];
            $controller->action = $callback[1];
            // Application::$app->controller = $controller;
            Boot::$app->controller = $controller;
            // $middlewares = $controller->getMiddlewares();
            // foreach ($middlewares as $middleware) {
            //     $middleware->execute();
            // }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        // return Application::$app->view->renderView($view, $params);
        return $this->viewClass->render($view, $params);
    }

    public function renderViewOnly($view, $params = [])
    {
        // return Application::$app->view->renderViewOnly($view, $params);
        // return  $this->viewClass->renderViewOnly($view, $params);
    }

      /**
       * @param alias opcional si se requiere poner un alias a la ruta
     */
    public function name($alias)
    {
        // $this->action['as'] = isset($this->action['as']) ? $this->action['as'].$name : $name;

        // $this->routeAlias[$alias] = array_key_last($this->routeMap);
        $this->routeAlias[$alias] = array_key_last($this->routeMap[$this->lastVerb]);
        return $this;
    }


}