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
require ('Model/Paragraphs.php');
/**
 * Class Controller
 *      Class the handle the action called by the dispatcher
 */
class Controller {

    // TODO : singleton ?
    function __construct() {}

    /**
     * @return string
     *      Json of all articles {id , title}, or error message if no articles are found
     */
    function listArticles(): string {
        $articles = Article::queryArticles();
        $paragraph = Paragraphs::queryParagraphs();
        if(is_null($articles)) {
            return cError::_204();
        }
        http_response_code(200);

        foreach ($articles as $key=>$article){
            $articles[$key] = array('ID'=> $key, 'TITLE' => $article, 'CONTENT' => array());
        }

        foreach ($paragraph as $para) {
                array_push($articles[$para['ARTICLE_ID']]['CONTENT'], $para);
        }
        $articles = array_values($articles);
        return json_encode($articles, true);
    }

    /**
     * @param int $idArticle
     *      The id of the article
     * @return string
     *      Json of the article {id, title, paragraph}
     */
    function getArticle(int $idArticle): string {
        if(empty($idArticle)) {
            return cError::_400();
        }
        $article = Article::queryArticleById($idArticle);
        $paragraphs = Paragraphs::queryParagraphsByArticleId($idArticle);
        if(empty($article) ) {
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
    function listParagraphs():string {
        $paragraph = Paragraphs::queryParagraphs();
        if(empty($paragraph)){
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
    function getParagraphById(int $id):string {
        if(empty($id)) {
            return cError::_400();
        }
        $paragraph = Paragraphs::queryParagraphById($id);
        if(empty($paragraph)) {
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
    function getParagraphsByArticleId(int $articleId): string  {
        if(empty($articleId)){
            return cError::_400();
        }
        $query = Paragraphs::queryParagraphsByArticleId($articleId);
        if(empty($query)) {
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
        if(empty($articleId) || empty($position)) {
            return cError::_400();
        }
        $query = Paragraphs::queryParagraphByArticleIdAndPosition($articleId,$position);
        if(empty($query)){
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
    function updateParagraphWithId(int $idPara,string $newContent): string {
        if(empty($idPara)) {
            return cError::_400();
        }
        $query = Paragraphs::queryUpdateParagraphWithId($idPara,$newContent);
        if(is_null($query)) {
            return cError::_204();
        }
        http_response_code(200);
        return json_encode(["message"=>"updated successfully"]);

    }
}