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
     * @param $match : the field that the route must match
     * @param $method : the method that the route must match
     * @param $callback : The function return by the route
     */
    public function __construct($match, $method, $callback) {
        $this->match = $match;
        $this->method = $method;
        $this->callback = $callback;
    }

    public function getMatch(){
        return $this->match;
    }

    public function getMethod(){
        return $this->method;
    }
    public function getCallback(){
        return$this->callback;
    }
}