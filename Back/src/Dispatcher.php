<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 18:32
 */
require('Router.php');
require ('Controller.php');

$router = Router::getInstance();
$controller = new Controller();

/**
 * Create all the routes
 */
$router->addRoute('paragraph', 'GET',
    function ($id) use ($controller) {
        echo $controller->getParagraphWithArticleId($id);
    })
    ->addRoute('paragraph', 'POST',
        function () {
            echo "Ceci est un POST sur paragraph";
        })
    ->addRoute('paragraph', 'PATCH',
        function ($id, $params) use ($controller) {
            $params = json_decode($params, TRUE);
            echo $controller->updateParagraphWithId($id, $params['content']);
        })

    ->addRoute('listArticle', 'GET',
        function () use ($controller) {
            echo $controller->listArticles();
        })
    
    ->addRoute('article', 'GET',
        function ($id) use ($controller) {
            echo $controller->getArticle($id);
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
$uri = substr($_SERVER['REQUEST_URI'],8);
$result = $router->match($uri, $_SERVER['REQUEST_METHOD']);

/**
 * If no route found, show 404
 */
if(is_null($result)) {
    header("HTTP/1.1 404");
    echo "404";
}

/**
 * Execute the function with the parameters
 */
call_user_func_array($result['callback'], array($result['id'], $data));