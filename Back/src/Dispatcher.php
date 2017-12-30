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

/**
 * @api {get} /api/v1/articles Request all articles
 * @apiName GetArticles
 * @apiGroup AllArticles
 *
 * @apiSuccess  {Number}    ID      Id of the article
 * @apiSuccess  {String}    TITLE   Title of the article
 *
 * @apiSuccessExample   Success-Response:
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "ID": 1,
 *              "TITLE" : "Lorem Ipsum"
 *          },
 *          {
 *              "ID": 2,
 *              "TITLE" : "The game"
 *          },
 *          ...
 *      ]
 */
/**
 * @api {get} /api/v1/articles?paragraphs=true Request all articles with their paragraphs
 * @apiName GetArticlesWithParagraphs
 * @apiGroup AllArticles
 *
 * @apiSuccess  {Number}    ID                  Id of the article
 * @apiSuccess  {String}    TITLE               Title of the article
 * @apiSuccess  {Object[]}  CONTENT             List of paragraphs
 * @apiSuccess  {Number}    CONTENT.ID          Id of the article patched
 * @apiSuccess  {String}    CONTENT.TITLE       Title of the article patched
 * @apiSuccess  {Number}    CONTENT.POSITION    The position of the paragraph in the article
 * @apiSuccess  {Number}    CONTENT.ARTICLE_ID  The Id of the article associated to the paragraph
 *
 * @apiSuccessExample   Success-Response:
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "ID": 1,
 *              "TITLE" : "Lorem Ipsum",
 *              "CONTENT": [
 *                      {
 *                          "ID": 1,
 *                          "CONTENT": "Lorem ipsum dolor sit amet.",
 *                          "POSITION": 1,
 *                          "ARTICLE_ID": 1
 *                      },
 *                      {
 *                          "ID": 2,
 *                          "CONTENT": "Ut enim ad minim veniam.",
 *                          "POSITION": 2,
 *                          "ARTICLE_ID": 1
 *                      },
 *                      ...
 *          },
 *          {
 *              "ID": 2,
 *              "TITLE" : "The game",
 *              "CONTENT" : [
 *                      {
 *                          "ID": 3,
 *                          "CONTENT": "Perdu !",
 *                          "POSITION": 1,
 *                          "ARTICLE_ID": 2
 *                      },
 *                      ...
 *          },
 *          ...
 *      ]
 */

$router->addRoute('~^/articles(\?paragraphs=(\w+))?$~', Router::GET,
    function ($args) use ($controller) {
        if (isset($args[RouterUtils::URL_PARAMS][1]) && $args[RouterUtils::URL_PARAMS][1] == 'true') {

            RouterUtils::response($controller->listArticlesWithParagraphs());
        } else {
            RouterUtils::response($controller->listArticles());
        }
    })


    /**
     * @api {post} /api/v1/articles Insert a new Article
     * @apiName AddArticle
     * @apiGroup AllArticles
     *
     * @apiParam    {String}    TITLE   The Title of article to create
     *
     * @apiSuccess  {Number}    ID      Id of the article created
     * @apiSuccess  {String}    TITLE   Title of the article created
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *      {
     *          "ID": 1,
     *          "TITLE" : "Lorem Ipsum"
     *      }
     */
    ->addRoute('~^/articles/?$~', Router::POST,
        function ($args) use ($controller) {
            RouterUtils::response($controller->insertNewArticle($args));
        })

    /**
     * @api {get} /api/v1/articles/:id  request Article information
     * @apiName GetArticle
     * @apiGroup Article
     *
     * @apiSuccess  {Number}    ID      Id of the article
     * @apiSuccess  {String}    TITLE   Title of the article
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *      {
     *          "ID": 1,
     *          "TITLE" : "Lorem Ipsum"
     *      }
     *
     * @apiError ArticleNotFound No article with the ID <code>ID</code> found
     */
    ->addRoute('~^/articles/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getArticle($args));
        })

    /**
     * @api {delete} /api/v1/articles/:id   Delete an article
     * @apiName DeleteArticle
     * @apiGroup Article
     *
     * @apiSuccess  {Number}    ID      Id of the deleted article
     *
     * @apiSuccessExample  201 Success-Response:
     *      HTTP/1.1 201 OK
     *      {
     *          "Response": "Successfully deleted article with ID <code>ID</code>",
     *      }
     *
     * @apiError ArticleNotFound No article with the ID <code>ID</code> found
     *
     * @apiErrorExample {json} Error-Response:
     *      HTTP/1.1 404 Not Found
     *          {
     *              "Error": "No article with the ID <code>ID</code> found"
     *          }
     *
     * @apiError ArticleNotFound Failed to delete article with the ID <code>ID</code> found
     *
     */
    ->addRoute('~^/articles/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            RouterUtils::response($controller->deleteArticleById($args));
        })

    /**
     * @api {patch} /api/v1/articles/:id Modify an article
     * @apiName PatchArticle
     * @apiGroup Article
     *
     *
     * @apiParam    {String}    TITLE   The Title of article to patch
     *
     * @apiSuccess  {Number}    ID      Id of the article patched
     * @apiSuccess  {String}    TITLE   Title of the article patched
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *      {
     *          "ID": 1,
     *          "TITLE" : "Lorem Ipsum"
     *      }
     *
     */
    ->addRoute('~^/articles/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            RouterUtils::response($controller->updateArticleById($args));
        })

    /**
     * @api {get} /api/v1/paragraphs request all paragraphs
     * @apiName GetParagraphs
     * @apiGroup AllParagraphs
     *
     * @apiSuccess  {Number}    ID          Id of the paragraph
     * @apiSuccess  {String}    CONTENT     Content of the article
     * @apiSuccess  {Number}    POSITION    The position of the paragraph in the article
     * @apiSuccess  {Number}    ARTICLE_ID  The Id of the article associated to the paragraph
     *
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 200 OK
     *      [
     *          {
     *              "ID": 1,
     *              "CONTENT": "Lorem ipsum dolor sit amet.",
     *              "POSITION": 1,
     *              "ARTICLE_ID": 1
     *          },
     *          {
     *              "ID": 2,
     *              "CONTENT": "Ut enim ad minim veniam.",
     *              "POSITION": 2,
     *              "ARTICLE_ID": 1
     *          },
     *          ...
     *      ]
     */
    ->addRoute('~^/paragraphs/?$~', Router::GET,
        function () use ($controller) {
            RouterUtils::response($controller->listParagraphs());
        })

    /**
     * @api {get} /api/v1/paragraphs/:id Request a paragraph
     * @apiName GetParagraphs
     * @apiGroup AllParagraphs
     *
     * @apiSuccess  {Number}    ID          Id of the paragraph
     * @apiSuccess  {String}    CONTENT     Content of the article
     * @apiSuccess  {Number}    POSITION    The position of the paragraph in the article
     * @apiSuccess  {Number}    ARTICLE_ID  The Id of the article associated to the paragraphe
     *
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *              "ID": 1,
     *              "CONTENT": "Lorem ipsum dolor sit amet.",
     *              "POSITION": 1,
     *              "ARTICLE_ID": 1
     *      }
     */
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getParagraphById($args));
        })


    /**
     * @api {delete} /api/v1/paragraphs/:id   Delete a paragraph
     * @apiName DeleteParagraph
     * @apiGroup Paragraph
     *
     * @apiSuccess  {Number}    ID          Id of the deleted paragraph
     *
     * @apiSuccessExample  201 Success-Response:
     *      HTTP/1.1 201 OK
     *      {
     *          "Response: "Successfully deleted paragraph with ID <code>ID</code>",
     *      }
     *
     * @apiError ArticleNotFound No paragraph with the ID <code>ID</code> found
     *
     * @apiErrorExample {json} Error-Response:
     *      HTTP/1.1 404 Not Found
     *          {
     *              "Error": "No paragraph with the ID <code>ID</code> found"
     *          }
     *
     * @apiError ArticleNotFound Failed to delete paragraph with the ID <code>ID</code> found
     *
     */
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::DELETE,
        function ($args) use ($controller) {
            RouterUtils::response($controller->deleteParagraphById($args));
        })


    /**
     * @api {patch} /api/v1/paragraphs/:id Modify a paragraph
     * @apiName PatchParagraph
     * @apiGroup Paragraph
     *
     * @apiParam    {Number}     ID             Optional Id of the paragraph patched
     * @apiParam    {String}     CONTENT        Optional Content of the paragraph patched
     * @apiParam    {Number}     POSITION       Optional position of the paragraph in the article
     * @apiParam    {Number}     ARTICLE_ID     Optional Id of the article associated to the paragraph
     *
     *
     * @apiSuccess {Number}     ID              Id of the article patched
     * @apiSuccess {String}     TITLE           Title of the article patched
     * @apiSuccess {Number}     POSITION        The position of the paragraph in the article
     * @apiSuccess {Number}     ARTICLE_ID      The Id of the article associated to the paragraph
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *          {
     *              "ID": 2,
     *              "CONTENT": "Ut enim ad minim veniam.",
     *              "POSITION": 2,
     *              "ARTICLE_ID": 1
     *          }
     *
     */
    ->addRoute('~^/paragraphs/(\d+)/?$~', Router::PATCH,
        function ($args) use ($controller) {
            RouterUtils::response($controller->partialUpdateParagraphWithId($args));
        })


    /**
     * @api {get} /api/v1/articles/:idA/paragraphs Request all paragraphs of the article
     * @apiName GetParagraphsOfArticle
     * @apiGroup Paragraphs
     *
     *
     * @apiSuccess  {Number}    ID          Id of the paragraph
     * @apiSuccess  {String}    CONTENT     Content of the paragraph
     * @apiSuccess  {Number}    POSITION    The position of the paragraph in the article
     * @apiSuccess  {Number}    ARTICLE_ID  The Id of the article associated to the paragraph
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *          [
     *              {
     *                  "ID": 2,
     *                  "CONTENT": "Ut enim ad minim veniam.",
     *                  "POSITION": 2,
     *                  "ARTICLE_ID": 1
     *              },
     *              ...
     *          ]
     *
     */
    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::GET,
        function ($args) use ($controller) {
            RouterUtils::response($controller->getParagraphsByArticleId($args));
        })


    /**
     * @api {post} /api/v1/articles/:idA/paragraphs Add a new paragraph in the article
     * @apiName AddParagraph
     * @apiGroup Paragraph
     *
     * @apiParam    {String}    CONTENT     Content of the paragraph patched
     * @apiParam    {Number}    POSITION    Optional position of the paragraph in the article (if empty, the paragraph is added at the end of the article)
     * @apiParam    {Number}    ARTICLE_ID  Id of the article associated to the paragraph
     *
     * @apiSuccess  {Number}    ID          Id of the article
     * @apiSuccess  {String}    TITLE       Title of the article
     * @apiSuccess  {Number}    POSITION    The position of the paragraph in the article
     * @apiSuccess  {Number}    ARTICLE_ID  The Id of the article associated to the paragraph
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *          [
     *              {
     *                  "ID": 2,
     *                  "CONTENT": "Ut enim ad minim veniam.",
     *                  "POSITION": 2,
     *                  "ARTICLE_ID": 1
     *              },
     *              ...
     *          ]
     *
     */
    ->addRoute('~^/articles/(\d+)/paragraphs/?$~', Router::POST,
        function ($args) use ($controller) {
            RouterUtils::response($controller->insertNewParagraphInArticle($args));
        })

    /**
     * @api {get} /api/v1/articles/:idA/paragraphs/:pos Get the pos-ian paragraph of the article
     * @apiName GetParagraph
     * @apiGroup Paragraph
     *
     * @apiSuccess  {Number}    ID          Id of the article patched
     * @apiSuccess  {String}    TITLE       Title of the article patched
     * @apiSuccess  {Number}    POSITION    The position of the paragraph in the article
     * @apiSuccess  {Number}    ARTICLE_ID  The Id of the article associated to the paragraph
     *
     * @apiSuccessExample   Success-Response:
     *      HTTP/1.1 201 OK
     *          [
     *              {
     *                  "ID": 2,
     *                  "CONTENT": "Ut enim ad minim veniam.",
     *                  "POSITION": 2,
     *                  "ARTICLE_ID": 1
     *              },
     *              ...
     *          ]
     *
     */
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
    RouterUtils::response(cError::_404("No route found"));
}