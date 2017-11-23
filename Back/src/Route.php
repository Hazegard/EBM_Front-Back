<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 10:35
 */

class Route {
    private $callback;
    private $match;
    private $method;

    /**
     * Route constructor.
     * @param string $match
     *      The field that the route must match
     * @param string $method
     *      The method that the route must match
     * @param callable $callback
     *      The function return by the route
     */
    public function __construct($match, $method, $callback) {
        $this->match = $match;
        $this->method = $method;
        $this->callback = $callback;
    }

    /**
     * @return string
     *      Return the path to match
     */
    public function getMatch() {
        return $this->match;
    }

    /**
     * @return string
     *      Return the http method to match
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return callable
     *      Return the callback function
     */
    public function getCallback() {
        return$this->callback;
    }
}