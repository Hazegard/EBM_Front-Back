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

    function __construct()     {
    }

    /**
     * List all articles with their paragraphs
     * @return string
     *      Json of all articles {id , title, paragraphs},  or error message if no articles are found
     */
    function listArticlesWithParagraphs(): string {
        $articles = Article::queryArticles();
        $paragraph = Paragraphs::queryParagraphs();
        if (is_null($articles)) {
            return cError::_204("No articles found");
        }
        http_response_code(200);
        $arts = array();
        foreach ($articles as $key => $article) {
            $arts[$article['ID']] = array('ID' => $article['ID'], 'TITLE' => $article['TITLE'], 'CONTENT' => array());
        }

        foreach ($paragraph as $para) {
            array_push($arts[$para['ARTICLE_ID']]['CONTENT'], $para);
        }
        $arts = array_values($arts);
        return json_encode($arts, true);
    }

    /**
     * List all articles
     * @return string
     *      Json of all articles
     */
    function listArticles(): string {
        $articles = Article::queryArticles();
        return json_encode($articles);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the article {id, title, paragraph}
     */
    function getArticle($args): string {
        $params = $args[RouterUtils::URL_PARAMS];
        $idArticle = $params[0];
        if(is_numeric($idArticle)){
            $idArticle = intval /* //TODO Change to check only integer and not floats */($idArticle);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if (empty($idArticle)) {
            return cError::_400("ARTICLE_ID is missing");
        }
        $article = Article::queryArticleById($idArticle);
        $paragraphs = Paragraphs::queryParagraphsByArticleId($idArticle);
        if (empty($article)) {
            return cError::_404("No article with the ID ".$idArticle." found");
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
            return cError::_204("");
        }
        http_response_code(200);
        return json_encode($paragraph);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the paragraph
     */
    function getParagraphById($args): string {
        $params = $args[RouterUtils::URL_PARAMS];
        $id = $params[0];
        if(is_numeric($id)){
            $id = intval /* //TODO Change to check only integer and not floats */($id);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if (empty($id)) {
            return cError::_400("ID  is missing");
        }
        $paragraph = Paragraphs::queryParagraphById($id);
        if (empty($paragraph)) {
            return cError::_404();
        }
        http_response_code(200);
        return json_encode($paragraph);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the paragraph if found, json of error message
     */
    function getParagraphsByArticleId($args): string {
        $params = $args[RouterUtils::URL_PARAMS];
        $articleId = $params[0];
        if(is_numeric($articleId)){
            $articleId = intval /* //TODO Change to check only integer and not floats */($articleId);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if (empty($articleId)) {
            return cError::_400("ARTICLE_ID  is missing");
        }
        $query = Paragraphs::queryParagraphsByArticleId($articleId);
        if (empty($query)) {
            return cError::_404();
        }
        http_response_code(200);
        return json_encode($query);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the paragraph
     */
    function getParagraphByArticleIdAndPosition($args): string {
        $params = $args[RouterUtils::URL_PARAMS];
        $articleId = $params[0];
        $position = $params[1];
        if(is_numeric($articleId)){
            $articleId = intval /* //TODO Change to check only integer and not floats */($articleId);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if(is_numeric($position)){
            $position = intval /* //TODO Change to check only integer and not floats */($position);
        } else {
            return cError::_400("The POSITION must be a float/ingeter ??"); //TODO Changer pour float?
        }
        if (empty($articleId)) {
            return cError::_400("ARTICLE_ID  is missing");
        }
        if(empty($position)){
            return cError::_400("POSITION  is missing");
        }
        $query = Paragraphs::queryParagraphByArticleIdAndPosition($articleId, $position);
        if (is_null($query)) {
            return cError::_404("Article not found with ID=".$articleId);
        }
        http_response_code(200);
        return json_encode($query);
    }

    /**
     * @param int $idPara
     *      Id of the paragraph to update
     * @param string $newContent
     *      Content of the paragraph
     * @param float $newPosition
     * @param int $idArticle
     * @return string
     *      Message to inform if the request was succeeded
     */
    function fullUpdateParagraphWithId(int $idPara, string $newContent, float $newPosition, int $idArticle): string {
        if(is_numeric($idPara)){
            $idPara = intval /* //TODO Change to check only integer and not floats */($idPara);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if (empty($idPara)) {
            return cError::_400("ID  is missing");
        }
        if(empty($newContent)) {
            return cError::_400("CONTENT is missing");
        }
        if(empty($idArticle)){
            return cError::_400("ARTICLE_ID is missing");
        }
        if(empty($newPosition)){
            return cError::_400("POSITION is missing");
        }
        $query = Paragraphs::queryUpdateFullParagraphWithId($idPara, $newContent, $newPosition, $idArticle);
        if (is_null($query)) {
            return cError::_204();
        }
        http_response_code(200);
        return json_encode(["message" => "updated successfully"]);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the updated paragraph
     */
    function partialUpdateParagraphWithId($args): string {
        $data = $args[RouterUtils::BODY_DATA];
        $params = $args[RouterUtils::URL_PARAMS];
        $newPosition = array_key_exists(Paragraphs::POSITION, $data)? $data[Paragraphs::POSITION]:0;
        $idArticle = array_key_exists(Paragraphs::IDARTICLE, $data)? $data[Paragraphs::IDARTICLE]:-1;
        $idArticle = ctype_digit($idArticle)?intval($idArticle):0;
        $newContent = array_key_exists(Paragraphs::CONTENT, $data)? $data[Paragraphs::CONTENT]:'';
        $idPara = $params[0];
        $idPara = ctype_digit($idPara)?intval($idPara):0;
        return json_encode(Paragraphs::queryUpdateParagraphWithId($idPara, $newContent,$newPosition,$idArticle));
    }

    /**
     * @param $args
     *      Arguments of the request
     * @return string
     *      Error message if an error occurred, or json of the created article
     */
    function insertNewArticle($args): string {
        $data = $args[RouterUtils::BODY_DATA];
        $title = array_key_exists(Article::TITLE, $data)? $data[Article::TITLE]:'';
        if($title===''){
            return cError::_400("TITLE  is missing");
        }
        $query = Article::insertArticle($title);
        if(is_null($query)) {
            return cError::_400("An error occurred");
        }
        http_response_code(201);
        return json_encode($query);
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the new paragraph
     */
    function insertNewParagraphInArticle($args):string {
        $data = $args[RouterUtils::BODY_DATA];
        $params = $args[RouterUtils::URL_PARAMS];
        $idArticle = $params[0];
        $position = array_key_exists(Paragraphs::POSITION, $data)?$data[Paragraphs::POSITION]:0;
        $position = is_numeric($position)? floatval($position):-1;
        $newContent = array_key_exists(Paragraphs::CONTENT, $data)? $data[Paragraphs::CONTENT] : '';
        if(is_numeric($idArticle)){
            $idArticle = intval /* //TODO Change to check only integer and not floats */($idArticle);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if($position == -1){
            return cError::_400("POSITION must be a number");
        }
        if($idArticle===0){
            return cError::_400("ARTICLE_ID  is missing");
        }
        if($newContent===''){
            return cError::_400("CONTENT is missing");
        }
        http_response_code(201);
        return json_encode(Paragraphs::insertParagraphInArticle($idArticle, $newContent, $position));
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of success / failure
     */
    function deleteArticleById($args):string {
        $params = $args[RouterUtils::URL_PARAMS];
        $id = $params[0];
        if(is_numeric($id)){
            $id = intval /* //TODO Change to check only integer and not floats */($id);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if(empty($id)){
            return cError::_400("ID  is missing");
        }

        if(empty(Article::queryArticleById($id))){
            return cError::_404("No article with the ID ".$id." found");
        }
        if(Article::queryDeleteArticleById($id)){
            http_response_code(200);
            return json_encode(array("Response"=> "Successfully deleted article with ID ".$id));
        } else {
            http_response_code(400);
            return json_encode(array("Response"=> "Failed to delete article with ID ".$id));
        }
    }

    /**
     * Delete a paragraph by id
     * @param $args
     *      The id of the paragraph to delete
     * @return string
     *      Json of success / failure
     */
    function deleteParagraphById($args): string{
        $params = $args[RouterUtils::URL_PARAMS];
        $id = $params[0];
        if(is_numeric($id)){
            $id = intval /* //TODO Change to check only integer and not floats */($id);
        } else {
            return cError::_400("The ID must be an integer");
        }
        if(empty($id)){
            return cError::_400("ID  is missing");
        }
        if(empty(Paragraphs::queryParagraphById($id))){
            return cError::_404("No paragraph with the ID ".$id." found");
        }
        if(Paragraphs::queryDeleteParagraphById($id)){
            http_response_code(200);
            return json_encode("true");
        } else {
            http_response_code(400);
            return json_encode("false");
        }
    }

    /**
     * @param $args
     *      Incoming arguments
     * @return string
     *      Json of the updated article
     */
    function updateArticleById($args): string{
        $params = $args[RouterUtils::URL_PARAMS];
        $data = $args[RouterUtils::BODY_DATA];

        $id = $params[0];
        $title = array_key_exists(Article::TITLE, $data) ? $data[Article::TITLE] : '';
        if($title === '' ){
            return cError::_400("TITLE is missing");
        }
        return json_encode(Article::queryUpdateArticleById($id, $title));
    }
}