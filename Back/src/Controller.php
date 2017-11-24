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
    function listArticles(): string {
        $articles = DBAccess::getInstance()->queryArticles();
        $paragraph = DBAccess::getInstance()->queryParagraph();
        if(is_null($articles)) {
            http_response_code(204);
            return json_encode(['message'=>'No articles found :(']);
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
        $article = DBAccess::getInstance()->queryArticleById($idArticle);
        $paragraphs = DBAccess::getInstance()->queryParagraphsWithArticleId($idArticle);
        if(empty($article) ) {
            return _400();
        }
        $article['CONTENT'] = $paragraphs;
        http_response_code(200);
        return json_encode($article);
    }

    /**
     * @param int $articleId
     *      The id of the requested paragraph
     * @return string
     *      Json of the paragraph if found, json of error message
     */
    function getParagraphWithArticleId(int $articleId): string  {
        if(empty($articleId)){
            return _400();
        }
        $query = DBAccess::getInstance()->queryParagraphsWithArticleId($articleId);
        if(empty($query)) {
            http_response_code(404);
            return json_encode(['message'=>'no resource found']);
        }
        if(is_null($query)) {
            http_response_code(400);
            return json_encode(['message'=>'unable to complete request']);
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
            return _400();
        }
        $query = DBAccess::getInstance()->queryUpdateParagraphWithId($idPara, $newContent);
        if(is_null($query)) {
            http_response_code(400);
            return json_encode(['message'=>'unable to complete request']);
        }
        if($query ==0) {
            http_response_code(404);
            return json_encode(['message'=>"No resource found"]);
        }
        http_response_code(200);
        return json_encode(["message"=>"updated successfully"]);

    }
}