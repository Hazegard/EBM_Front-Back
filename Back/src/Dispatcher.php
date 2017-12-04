<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 18:32
 */
require('Router.php');
require('Controller.php');
require('RouterUtils.php');
$router = Router::getInstance();
$controller = new Controller();

/**
 * Create all the routes
 */
$router->addRoute('~^/articles/?$~', Router::GET,
    function () use ($controller) {
        echo $controller->listArticles();
    })
    ->addRoute('~^/articles/?$~', Router::POST,
        function ($args) use ($controller) {
            $data = $args['DATA'];
            echo "Ceci est un post sur /articles/ avec comme json: ".print_r($data);
        })
    ->addRoute('~^/articles/?$~', Router::PUT,
        function ($args) use ($controller) {
            $data = $args['DATA'];
            echo "Ceci est un put sur /articles/ avec comme json: ".($data);
        })

    ->addRoute('~^/articles/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            echo $controller->getArticle($id);
        })
    ->addRoute('~^/articles/(\d+)/?$~',Router::PATCH,
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            $data = $args['DATA'];
            echo "Ceci est un patch sur /articles/".$id."/ avec comme json : ".$data;
        })

    ->addRoute('~^/paragraphs/?$~', Router::GET,
        function () use ($controller) {
            echo $controller->listParagraphs();
        })

    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::GET,
        function ($params) use ($controller) {
            $id = intval($params[0]);
            echo $controller->getParagraphById($id);
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~',Router::PATCH,
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            $data = $args['DATA'];
            echo "Ceci est un patch sur /paragraphs/".$id."/ avec comme json : ".$data;
        })

    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::GET,
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            echo $controller->getParagraphsByArticleId($id);
        })

    ->addRoute('~^/articles/(\d+)/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            $articleId = intval($args['PARAMS'][0]);
            $paragraphPosition = intval($args['PARAMS'][1]);
            echo $controller->getParagraphByArticleIdAndPosition($articleId, $paragraphPosition);
        });

/**
 * Get incoming data from request, same as $_GET and $_POST but also works with PUT, PATCH and DELETE
 */
$data = RouterUtils::getBodyData();

/**
 * Get the function corresponding to the request
 */
$url= RouterUtils::extractRealApiRoute($_SERVER['REQUEST_URI']);
$result = $router->match($url, $_SERVER['REQUEST_METHOD']);

/**
 * If no route found, show 404
 */
if(RouterUtils::isRouteFound($result)){
    RouterUtils::executeRoute($result, $data);
} else {
    echo cError::_404();
}