<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 17:53
 */

require ('Route.php');

class Router {

    /**
     * Singleton Pattern to prevent class from being instantiated more thane once
     */
    private static $_instance = null;

    private function __construct(){}

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    private $routes = array();

    /**
     *  Add a new route to the Router
     * @param $path : The action to handle (ex: 'paragraph' to handle /v1/paragraph/
     * @param $method : The request method to handle (
     * @param $callback : The function use to handle the request
     */
    public function addRoute($path, $method, $callback){
        $this->routes[] = new Route($path, $method, $callback);
    }

    /**
     * Used to match incomming request [url, method] with registered routes
     * @param $url : The url of request '/v1/{action}/{id}
     * @param $method : The method of the request [GET|POST|PUT|PATCH|DELETE]
     * @return array : [callback function, id]
     * If not route match the URL, @return 404
     */
    public function match($url, $method){
        /**
         * Extract the data from the url received
         */
        $explodedUrl = explode("/",$url);
        $action = $explodedUrl[2];
        $id = $explodedUrl[3];

        /**
         * Try to match the current request with registered routes
         */
        foreach ($this->routes as $route){
            if($action==$route->getMatch() && $method==$route->getMethod()){
                /**
                 * If a route if found, return the callback and the id
                 */
                return array('callback' =>$route->getCallback(), 'id' =>$id);
            }
        }
        /**
         * If no route is found, return 404 error
         */
        return array('callback' => function (){echo "404";}, 'id' => null);
    }
}