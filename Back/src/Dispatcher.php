<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 18:32
 */
require('Router.php');
require('Controller.php');

$router = Router::getInstance();
$controller = new Controller();

/**
 * Create all the routes
 */
$router->addRoute('~^/articles/?$~', 'GET',
    function () use ($controller) {
        echo $controller->listArticles();
    })
    ->addRoute('~^/articles/?$~', 'POST',
        function ($args) use ($controller) {
            $data = $args['DATA'];
            echo "Ceci est un post sur /articles/ avec comme json: ".($data);
        })
    ->addRoute('~^/articles/?$~', 'PUT',
        function ($args) use ($controller) {
            $data = $args['DATA'];
            echo "Ceci est un put sur /articles/ avec comme json: ".($data);
        })

    ->addRoute('~^/articles/(\d+)/?$~', 'GET',
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            echo $controller->getArticle($id);
        })
    ->addRoute('~^/articles/(\d+)/?$~','PATCH',
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            $data = $args['DATA'];
            echo "Ceci est un patch sur /articles/".$id."/ avec comme json : ".$data;
        })

    ->addRoute('~^/paragraphs/?$~', 'GET',
        function () use ($controller) {
            echo $controller->listParagraphs();
        })

    ->addRoute('~^/paragraphs/(\d+)/?$~', 'GET',
        function ($params) use ($controller) {
            $id = intval($params[0]);
            echo $controller->getParagraphById($id);
        })
    ->addRoute('~^/paragraphs/(\d+)/?$~','PATCH',
        function ($args) use ($controller) {
            $id = intval($args['PARAMS'][0]);
            $data = $args['DATA'];
            echo "Ceci est un patch sur /paragraphs/".$id."/ avec comme json : ".$data;
        })


    ->addRoute('~^/articles/(\d+)/paragraphs/?$~','GET',
        function($params) use ($controller) {
        $id = intval($params[0]);
        echo $controller->getParagraphsByArticleId($id);
    })

    ->addRoute('~^/articles/(\d+)/paragraphs/(\d+)/?$~','GET',
        function($params) use ($controller) {
        $articleId = intval($params[0]);
        $paragraphPosition = intval($params[1]);
        echo $controller->getParagraphByArticleIdAndPosition($articleId,$paragraphPosition);
        });

/**
 * Get incoming data from request, same as $_GET and $_POST but also works with PUT, PATCH and DELETE
 */
$data = file_get_contents('php://input');
/**
 * Get the function corresponding to the request
 */
$url1 = substr($_SERVER['REQUEST_URI'], 7);
$result = $router->match($url1, $_SERVER['REQUEST_METHOD']);

/**
 * If no route found, show 404
 */
if (is_null($result)) {
    echo 'No match';
    return cError::_404();
} else {
    /**
     * Execute the function with the parameters
     */
    $args = array('PARAMS'=>$result[1],'DATA'=>$data);
    call_user_func($result[0], $args);
}