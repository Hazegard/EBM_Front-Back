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

    private function __construct() {}

    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    private $routes = array();

    /**
     *  Add a new route to the Router
     * @param string $path
     *      The action to handle (ex: 'paragraph' to handle /v1/paragraph/
     * @param string $method
     *      The request method to handle (
     * @param callable $callback
     *      The function use to handle the request
     * @return $this
     */
    public function addRoute($path, $method, $callback) {
        $this->routes[] = new Route($path, $method, $callback);
        return $this;
    }

    /**
     * Used to match incoming request [url, method] with registered routes
     * @param string $url
     *      The url of request '/v1/{resource}/{id}
     * @param string $method
     *      The method of the request [GET|POST|PUT|PATCH|DELETE]
     * @return array
     *      [callback function, id], If not route match the URL, @return null
     */
    // TODO : sortir l'id de match pour le mettre dans le dispatcher
    public function match($url, $method) {
        /**
         * Extract the data from the url received
         */
        $explodedUrl = explode("/",$url);
        $action = $explodedUrl[0];
        $id = $explodedUrl[1];

        /**
         * Try to match the current request with registered routes
         */
        foreach ($this->routes as $route) {
            if($action==$route->getMatch() && $method==$route->getMethod()) {
                /**
                 * If a route is found, return the callback and the id
                 */
                return array('callback' =>$route->getCallback(), 'id' =>$id);
            }
        }
        /**
         * If no route is found, return null
         */
        return null;
    }
}
