<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 19:34
 */

require ('DBUtils.php');
class DBAccess {
    private $bdd = null;

    private function __construct() {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=Tp_Final;charset=utf8', 'root', 'mysql');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getmessage());
        }
    }

    /**
     * Singleton Pattern to prevent the class from being instantiate more than once
     */
    private static $_instance = null;
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new DBAccess();
        }
        return self::$_instance;
    }

    /**
     * @return string : Json Encoded list of Articles: ID and TITLE
     */
    public function getArticles() {
        $articles = $this->bdd->prepare("SELECT * FROM ARTICLES");
        if ($articles->execute()) {
            header("HTTP/1.0 200");
            return fetchToJson($articles);
//            return json_encode($articles->fetchAll(PDO::FETCH_ASSOC));
        };
        header("HTTP/1.0 204");
        return json_encode(['message'=>'No articles found :(']);
    }

    /**
     * @param $idArticle : The id of the article
     * @return string json of all paragraph of the article
     */
    public function getParagraphsWithArticleId($idArticle){
        $request = $this->bdd->prepare("SELECT * FROM PARAGRAPHE WHERE ARTICLE_ID=:ID ORDER BY ID");
        $request->bindParam(':ID',$idArticle);
        if($request->execute()){
            header("HTTP/1.0 200");
            return fetchToJson($request);
        }
        header("HTTP/1.0 400");
        return json_encode(['message'=>'unable to complete request']);
    }

    /**
     * @param $idPara : The id of the paragraph to update
     * @param $newContent : The new content of the paragraph
     * @return string : message to inform if success or failure
     */
    public function updateParagraphWithId($idPara, $newContent){
        if(empty($idPara)){
            header("HTTP/1.0 400");
            return json_encode(['message'=>"An id must be provided"]);
        }
        echo $newContent;
        $request = $this->bdd->prepare("UPDATE PARAGRAPHE SET CONTENT=:CONTENT WHERE ID=:ID");
        $request->bindParam(':CONTENT',$newContent);
        $request->bindParam(':ID',$idPara);
        if($request->execute()){
            header("HTTP/1.0 200");
            return json_encode(["message"=>"updated successfully"]);
        }
        header("HTTP/1.0 400");
        return json_encode(['message'=>'unable to complete request']);
    }
}
