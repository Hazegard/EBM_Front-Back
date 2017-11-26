<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 25/11/17
 * Time: 10:57
 */

/**
 * Class cError : handle the errors and send it to the user
 */
class cError {
    private function __construct() {}

    /**
     * @return string
     *      Error 204
     */
    public static function _204(): string {
        http_response_code(204);
        return "";
    }

    /**
     * @return string
     *      Error 400
     */
    public static function _400(): string {
        http_response_code(400);
        return "";
    }

    /**
     * @return string
     *      Error 404
     */
    public static function _404(): string {
        http_response_code(404);
        return "";
    }
}