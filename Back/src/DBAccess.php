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
     * @return array
     *      List of Articles: ID => TITLE
     */
    public function queryListArticles() {
        $articles = $this->bdd->prepare("SELECT * FROM ARTICLES");
        return $articles->execute() ? $articles->fetchAll(PDO::FETCH_ASSOC): null;
    }

    /**
     * @param int $idArticle
     *      The id of the article
     * @return array
     *      All paragraph of the article, null if an error occurred
     */
    public function queryParagraphsWithArticleId($idArticle){
        if(empty($idArticle)){
            return null;
        }
        $request = $this->bdd->prepare("SELECT * FROM PARAGRAPHE WHERE ARTICLE_ID=:ID ORDER BY ID");
        $request->bindParam(':ID',$idArticle);
        return $request->execute()? $request->fetchAll(PDO::FETCH_ASSOC): null;
    }

    /**
     * @param int $idPara
     *      The id of the paragraph to update
     * @param string $newContent
     *      The new content of the paragraph
     * @return string
     *      Number of row affected by the update, null if an error occurred
     */
    public function queryUpdateParagraphWithId($idPara, $newContent){
        if(empty($idPara)){
            return _400();
        }
        $request = $this->bdd->prepare("UPDATE PARAGRAPHE SET CONTENT=:CONTENT WHERE ID=:ID");
        $request->bindParam(':CONTENT',$newContent);
        $request->bindParam(':ID',$idPara);
        return $request->execute()?$request->rowCount(): null;
    }
}
