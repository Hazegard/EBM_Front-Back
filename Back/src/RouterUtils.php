<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 26/11/17
 * Time: 11:48
 */

/**
 * Class RouterUtils
 * Tools to facilitate the use of the Router
 */
class RouterUtils {

    private function __construct(){}

    /**
     * @param string $url
     *      The input url, ex: /api/v1/articles/2/paragraphs/1
     * @return string
     *      url used for routing the API, ex: /articles/2/paragraphs/1
     */
    static function extractRealApiRoute(string $url): string{
        $temp = explode('/', $url);
        array_shift($temp);
        array_shift($temp);
        array_shift($temp);
        return '/'.implode('/',$temp);
    }

    /**
     * Get the body data of the incoming request
     * @return array
     *      Associative array corresponding to the json in the body of the request
     */
    static function getBodyData():array {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Test to check if the router found a valid route
     * @param array $result
     *      The array return by the getMatch() method
     *      [callable, $params]
     * @return bool
     */
    static function isRouteFound(array $result): bool {
        if(empty($result)) {
            echo 'No match';
            echo cError::_404();
            return false;
        } else {
            return true;
        }
    }

    //TODO : Write phpDoc

    /**
     * Execute the callback corresponding to the route
     * @param array $result
     *      [callable, $params]
     * @param array $data
     *      Array corresponding to the json of the body of the incoming request
     */
    static function executeRoute(array $result,array $data){
        $args = array('PARAMS'=>$result[1], 'DATA'=>$data);
        call_user_func($result[0], $args);
    }
}