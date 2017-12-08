<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 19/11/17
 * Time: 11:48
 */

require('DBAccess.php');
require('Error.php');
require('Model/Article.php');
require('Model/Paragraphs.php');

/**
 * Class Controller
 *      Class the handle the action called by the dispatcher
 */
class Controller {

    // TODO : singleton ?
    function __construct()     {
    }

    /**
     * @return string
     *      Json of all articles {id , title}, or error message if no articles are found
     */
    function listArticlesWithParagraphs(): string {
        $articles = Article::queryArticles();
        $paragraph = Paragraphs::queryParagraphs();
        if (is_null($articles)) {
            return cError::_204();
        }
        http_response_code(200);
        $arts = array();
        foreach ($articles as $key => $article) {
            $arts[$article['ID']] = array('ID' => $article['ID'], 'TITLE' => $article['TITLE'], 'CONTENT' => array());
        }

        foreach ($paragraph as $para) {
//            print_r($articles[$para['ARTICLE_ID']]);
            array_push($arts[$para['ARTICLE_ID']]['CONTENT'], $para);
        }
        $arts = array_values($arts);
        return json_encode($arts, true);
    }

    function listArticles(): string {
        $articles = Article::queryArticles();
        return json_encode($articles);
    }
    /**
     * @param int $idArticle
     *      The id of the article
     * @return string
     *      Json of the article {id, title, paragraph}
     */
    function getArticle(int $idArticle): string {
        if (empty($idArticle)) {
            return cError::_400("ARTICLE_ID");
        }
        $article = Article::queryArticleById($idArticle);
        $paragraphs = Paragraphs::queryParagraphsByArticleId($idArticle);
        if (empty($article)) {
            return cError::_204();
        }
        $article['CONTENT'] = $paragraphs;
        http_response_code(200);
        return json_encode($article);
    }

    /**
     * @return string
     *      Json of all paragraphs, or error message if not found
     */
    function listParagraphs(): string {
        $paragraph = Paragraphs::queryParagraphs();
        if (empty($paragraph)) {
            return cError::_204();
        }
        http_response_code(200);
        return json_encode($paragraph);
    }

    /**
     * @param int $id
     *      The id of the pararaph
     * @return string
     *      Json of the paragraph
     */
    function getParagraphById(int $id): string {
        if (empty($id)) {
            return cError::_400("ID");
        }
        $paragraph = Paragraphs::queryParagraphById($id);
        if (empty($paragraph)) {
            return cError::_204();
        }
        http_response_code(200);
        return json_encode($paragraph);
    }

    /**
     * @param int $articleId
     *      The id of the requested paragraph
     * @return string
     *      Json of the paragraph if found, json of error message
     */
    function getParagraphsByArticleId(int $articleId): string {
        if (empty($articleId)) {
            return cError::_400("ARTICLE_ID");
        }
        $query = Paragraphs::queryParagraphsByArticleId($articleId);
        if (empty($query)) {
            return cError::_404();
        }
        http_response_code(200);
        return json_encode($query);
    }

    /**
     * @param int $articleId
     *      The article associated to the paragraph
     * @param int $position
     *      The position of the paragraph in the article
     * @return string
     *      Json of the paragraph
     */
    function getParagraphByArticleIdAndPosition(int $articleId, int $position): string {
        if (empty($articleId)) {
            return cError::_400("ARTICLE_ID");
        }
        if(empty($position)){
            return cError::_400("POSITION");
        }
        $query = Paragraphs::queryParagraphByArticleIdAndPosition($articleId, $position);
        if (empty($query)) {
            return cError::_404();
        }
        http_response_code(200);
        return json_encode($query);
    }

    /**
     * @param int $idPara
     *      Id of the paragraph to update
     * @param string $newContent
     *      Content of the paragraph
     * @return string
     *      Message to inform if the request was succeeded
     */
    function updateParagraphWithId(int $idPara, string $newContent): string {
        if (empty($idPara)) {
            return cError::_400("ID");
        }
        $query = Paragraphs::queryUpdateParagraphWithId($idPara, $newContent);
        if (is_null($query)) {
            return cError::_204();
        }
        http_response_code(200);
        return json_encode(["message" => "updated successfully"]);
    }

    /**
     * @param string $title
     *      The title of the new article
     * @return string
     *      Error message if an error occurred, or json of the created article
     */
    function insertNewArticle(string $title): string {
        if(empty($title)){
            return cError::_400("TITLE");
        }
        $query = Article::insertArticle($title);
        if(is_null($query)) {
            return cError::_400("");
        }
        http_response_code(201);
        return json_encode($query);
    }

    /**
     * Insert a new paragraph at a position
     * @param int $idArticle
     *      The id of the article
     * @param string $newContent
     *      The content of the new paragraph
     * @param float $position
     *      The position where the new paragraph must be inserted
     * @return string
     *      Json of the new paragraph
     */
    function insertNewParagraphInArticle(int $idArticle, string $newContent, float $position):string {
        if(empty($idArticle)){
            return cError::_400("ARTICLE_ID");
        }
        http_response_code(201);
        return json_encode(Paragraphs::insertParagraphInArticle($idArticle, $newContent, $position));
    }

    /**
     * Delete an article and his paragraphs by id
     * @param int $id
     *      The id of the article to delete
     * @return string
     *      Json of success / failure
     */
    function deleteArticleById(int $id){
        if(empty($id)){
            return cError::_400("ID");
        }
        if(Article::queryDeleteArticleById($id)){

            return json_encode("Deleted");
        } else {
            http_response_code(400);
            return json_encode("Failed");
        }
    }
}