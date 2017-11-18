<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 18:32
 */


require('Router.php');
require('DBAccess.php');
$router = Router::getInstance();

/**
 * Create all the routes
 */
$router->addRoute('paragraph', 'GET',
    function ($id, $params) {
        echo DBAccess::getInstance()->getParagraphsWithArticleId($id);
    })
    ->addRoute('paragraph', 'POST',
        function () {
            echo "Ceci est un POST sur paragraph";
        })
    ->addRoute('paragraph', 'PATCH',
        function ($id, $params) {
            $params = json_decode($params, TRUE);
            echo DBAccess::getInstance()->updateParagraphWithId($id, $params["content"]);
        })
    ->addRoute('listArticle', 'GET',
        function () {
            echo DBAccess::getInstance()->getArticles();
        })
    ->addRoute('article', 'GET',
        function ($id, $params) {
            echo "Ceci est un GET sur article " . $id . " avec comme json:" . $params;
        })
    ->addRoute('article', 'POST',
        function ($id, $params) {
            echo "Ceci est un POST sur article " . $id . " avec comme json:" . $params;
        })
    ->addRoute('article', 'PATCH',
        function ($id, $params) {
            echo "Ceci est un PATCH sur article " . $id . " avec comme json:" . $params;
        })
    ->addRoute('article', 'PUT',
        function ($id, $params) {
            echo "Ceci est un PUT sur article " . $id . " avec comme json:" . $params;
        });

/**
 * Get incoming data from request
 */
$data = file_get_contents('php://input');

/**
 * Get the function corresponding to the request
 */
$result = $router->match($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

/**
 * Execute the function with the parameters
 */
call_user_func_array($result['callback'], array($result['id'], $data));