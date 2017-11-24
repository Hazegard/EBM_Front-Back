<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 19/11/17
 * Time: 11:48
 */

require('DBAccess.php');
class Controller {
    // TODO : singleton ?
    function __construct() {}

    /**
     * @return string
     *      Json of all articles {id , title}, or error message if no articles are found
     */
    function listArticles() {
        $query = DBAccess::getInstance()->queryListArticles();
        if(is_null($query)) {
            header("HTTP/1.1 204");
            return json_encode(['message'=>'No articles found :(']);
        }
        header("HTTP/1.1 200");
        return json_encode($query);
    }

    /**
     * @param int $idArticle
     *      The id of the article
     * @return string
     *      Json of the article {id, title, paragraph}
     */
    function getArticle($idArticle) {
        $article = DBAccess::getInstance()->queryArticle($idArticle);
        $paragraphs = DBAccess::getInstance()->queryParagraphsWithArticleId($idArticle);
        if(empty($article) || empty($paragraphs)) {
            return _400();
        }
        // TODO : les paragraphes peuvent être nuls !
        $article['PARAGRAPH'] = $paragraphs;
        header("HTTP/2.0 200");
        return json_encode($article);
    }

    /**
     * @param int $articleId
     *      The id of the requested paragraph
     * @return string
     *      Json of the paragraph if found, json of error message
     */
    function getParagraphWithArticleId($articleId) {
        if(empty($articleId)){
            return _400();
        }
        $query = DBAccess::getInstance()->queryParagraphsWithArticleId($articleId);
        if(empty($query)) {
            header("HTTP/1.1 404");
            return json_encode(['message'=>'no resource found']);
        }
        if(is_null($query)) {
            header("HTTP/1.1 400");
            return json_encode(['message'=>'unable to complete request']);
        }
        header("HTTP/1.1 200");
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
    function updateParagraphWithId($idPara, $newContent) {
        if(empty($idPara)) {
            return _400();
        }
        $query = DBAccess::getInstance()->queryUpdateParagraphWithId($idPara, $newContent);
        if(is_null($query)) {
            header("HTTP/1.1 400");
            return json_encode(['message'=>'unable to complete request']);
        }
        if($query ==0) {
            header("HTTP/1.1 404");
            return json_encode(['message'=>"No resource found"]);
        }
        header("HTTP/1.1 200");
        return json_encode(["message"=>"updated successfully"]);

    }
}