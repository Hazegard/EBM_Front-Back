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
            $data = $args[RouterUtils::BODY_DATA];
            $title = array_key_exists(Article::TITLE,$data)? $data[Article::TITLE]:"";
            RouterUtils::response($controller->insertNewArticle($title));
        })
    ->addRoute('~^/articles/?$~', Router::PUT,
        function ($args) use ($controller) {
            $data = $args[RouterUtils::BODY_DATA];
            echo "Ceci est un put sur /articles/ avec comme json: " . ($data);
        })


    ->addRoute('~^/articles/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            $id = $args[RouterUtils::URL_PARAMS][0];
            RouterUtils::response($controller->getArticle($id));
        })
    ->addRoute('~^/articles/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            $id = $args[RouterUtils::URL_PARAMS][0];
            RouterUtils::response($controller->deleteArticleById($id));
        })
    ->addRoute('~^/articles/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            $id = $args[RouterUtils::URL_PARAMS][0];
            $data = $args[RouterUtils::BODY_DATA];
            RouterUtils::response("Ceci est un patch sur /articles/" . $id . "/ avec comme json : " . $data);
        })


    ->addRoute('~^/paragraphs/?$~', Router::GET,
        function () use ($controller) {
            RouterUtils::response($controller->listParagraphs());
        })


    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            $params = $args[RouterUtils::URL_PARAMS];
            $id = $params[0];
            RouterUtils::response($controller->getParagraphById($id));
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            $params = $args[RouterUtils::URL_PARAMS];
            $id = $params[0];
            RouterUtils::response($controller->deleteParagraphById($id));
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            RouterUtils::response($controller->partialUpdateParagraphWithId($args));
        })


    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::GET,
        function ($args) use ($controller) {
            $id = $args[RouterUtils::URL_PARAMS][0];
            RouterUtils::response($controller->getParagraphsByArticleId($id));
        })
    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::POST,
        function ($args) use ($controller) {
            $idArticle = $args[RouterUtils::URL_PARAMS][0];
            $data = $args[RouterUtils::BODY_DATA];
            $newContent = $data[Paragraphs::CONTENT];
            $position = isset($data[Paragraphs::POSITION])?$data[Paragraphs::POSITION] : null;
            RouterUtils::response($controller->insertNewParagraphInArticle($idArticle, $newContent, $position));
        })


    ->addRoute('~^/articles/(\d+)/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            $articleId = $args[RouterUtils::URL_PARAMS][0];
            $paragraphPosition = $args[RouterUtils::URL_PARAMS][1];
            RouterUtils::response($controller->getParagraphByArticleIdAndPosition($articleId, $paragraphPosition));
        })


    ->addRoute('~^/test/?$~', Router::GET, function () use ($controller) {
        RouterUtils::response($controller->test());
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