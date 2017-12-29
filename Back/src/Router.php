<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 17:53
 */

require ('Route.php');

/**
 * Class Router that store all routes of the application
 * And is called to math a route with the incoming request
 */
class Router {

    const GET    = "GET";
    const POST   = 'POST';
    const PATCH  = 'PATCH';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    /**
     * Singleton Pattern to prevent class from being instantiated more thane once
     */
    private static $_instance = null;

    private function __construct() {}

    public static function getInstance():Router {
        if(is_null(self::$_instance)) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    private $routes = array();

    /**
     *  Add a new route to the Router
     * @param string $regex
     *      The regex to handle (ex: '~^/articles/?$~' to handle /api/v1/articles/
     * @param string $method
     *      The request method to handle (
     * @param callable $callback
     *      The function use to handle the request
     * @return $this
     */
    public function addRoute(string $regex,string $method,callable $callback): Router {
        $this->routes[] = new Route($regex, $method, $callback);
        return $this;
    }

    /**
     * Used to match incoming request [url, method] with registered routes
     * @param string $url
     *      The url of request '/v1/{resource}/{id}
     * @param string $method
     *      The method of the request [GET|POST|PUT|PATCH|DELETE]
     * @return array
     *      array that contain [callback function, [expract parameters from the regex]], If not route match the URL, @return null
     */
    public function match(string $url,string $method): array {
        /**
         * Try to match the current request with registered routes
         */
        foreach ($this->routes as $route) {
            if(preg_match($route->getRegex(),$url,$params) && $method==$route->getMethod()) {
                /**
                 * If a route is found, return the callback and the id
                 */
                array_shift($params);
                return [$route->getCallback(), $params];
            }
        }
        /**
         * If no route is found, return empty array
         */
        return array();
    }
}
