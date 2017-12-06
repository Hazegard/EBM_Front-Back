<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 10:35
 */

/**
 * Class Route
 */
class Route {
    private $callback;
    private $regex;
    private $method;

    /**
     * Route constructor.
     * @param string $regex
     *      The field that the route must regex
     * @param string $method
     *      The method that the route must regex
     * @param callable $callback
     *      The function return by the route
     */
    public function __construct(string $regex,string $method,callable $callback) {
        $this->regex = $regex;
        $this->method = $method;
        $this->callback = $callback;
    }

    /**
     * @return string
     *      Return the regex to match
     */
    public function getRegex(): string {
        return $this->regex;
    }

    /**
     * @return string
     *      Return the http method to regex
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return callable
     *      Return the callback function
     */
    public function getCallback(): callable {
        return$this->callback;
    }
}