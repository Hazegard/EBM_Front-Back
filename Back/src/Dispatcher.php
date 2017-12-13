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
//require('Model/Article.php');
//require ('Model/Paragraphs.php');
$router = Router::getInstance();
$controller = new Controller();

/**
 * Create all the routes
 */
$router->addRoute('~^/articles(\?paragraphs=(\w+))?$~', Router::GET,
    function ($args) use ($controller) {
        if (isset($args[RouterUtils::URL_PARAMS][1]) && $args[RouterUtils::URL_PARAMS][1] == 'true') {
            RouterUtils::response($controller->listArticlesWithParagraphs());
        } else {
            RouterUtils::response($controller->listArticles());
        }
    })


    ->addRoute('~^/articles/?$~', Router::POST,
        function ($args) use ($controller) {
            RouterUtils::response($controller->insertNewArticle($args));
        })


    ->addRoute('~^/articles/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getArticle($args));
        })
    ->addRoute('~^/articles/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            RouterUtils::response($controller->deleteArticleById($args));
        })
    ->addRoute('~^/articles/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            // TODO
            $id = $args[RouterUtils::URL_PARAMS][0];
            $data = $args[RouterUtils::BODY_DATA];
            RouterUtils::response($controller->updateArticleById($args));
//            RouterUtils::response("Ceci est un patch sur /articles/" . $id . "/ avec comme json : " . $data);
        })


    ->addRoute('~^/paragraphs/?$~', Router::GET,
        function () use ($controller) {
            RouterUtils::response($controller->listParagraphs());
        })


    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getParagraphById($args));
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            RouterUtils::response($controller->deleteParagraphById($args));
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            RouterUtils::response($controller->partialUpdateParagraphWithId($args));
        })


    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getParagraphsByArticleId($args));
        })
    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::POST,
        function ($args) use ($controller) {
            RouterUtils::response($controller->insertNewParagraphInArticle($args));
        })


    ->addRoute('~^/articles/(\d+)/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getParagraphByArticleIdAndPosition($args));
        });

/**
 * Get incoming data from request, same as $_GET and $_POST but also works with PUT, PATCH and DELETE
 */
$data = RouterUtils::getBodyData();

/**
 * Get the function corresponding to the request
 */
$url = RouterUtils::extractRealApiRoute($_SERVER['REQUEST_URI']);
$result = $router->match($url, $_SERVER['REQUEST_METHOD']);

/**
 * If no route found, show 404
 */
if (RouterUtils::isRouteFound($result)) {
    RouterUtils::executeRoute($result, $data);
} else {
    echo cError::_404();
}