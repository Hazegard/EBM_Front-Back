<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 19:34
 */

include_once('config.php');
class DBAccess {
    private $bdd = null;

    private function __construct() {
        try {
            global $host;
            global $dbname;
            global $username;
            global $password;
            $this->bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$username,$password);
            //$this->bdd = new PDO('mysql:host=localhost;dbname=Tp_Final;charset=utf8', 'root', 'mysql');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getmessage());
        }
    }
    //TODO Séparer en fonction de la ressource utilisée

    /**
     * Singleton Pattern to prevent the class from being instantiate more than once
     */
    private static $_instance = null;

    public static function getInstance(): DBAccess {
        if (is_null(self::$_instance)) {
            self::$_instance = new DBAccess();
        }
        return self::$_instance;
    }

    /**
     * @return array
     *      List of Articles: ID => TITLE
     */
    public function queryArticles(): array {
        $articles = $this->bdd->prepare("SELECT * FROM ARTICLES");
        return $articles->execute() ? $articles->fetchAll(PDO::FETCH_KEY_PAIR) : array();
    }

    public function queryParagraphs(): array {
        $paragraph = $this->bdd->prepare("SELECT * FROM PARAGRAPHE G");
        return $paragraph->execute() ? $paragraph->fetchAll(PDO::FETCH_ASSOC): array();
    }


    /**
     * @param int $id
     *      The id of the paragraph
     * @return array
     *      array of articles
     */
    public function queryArticleById(int $id): array {
        if (empty($id)) {
            return array();
        }
        $request = $this->bdd->prepare("SELECT * FROM ARTICLES WHERE ID=:ID");
        $request->bindParam(':ID', $id);
        return $request->execute() ? $request->fetch(PDO::FETCH_ASSOC) : array();
    }

    /**
     * @param int $id
     *      The id of the paragraph
     * @return array
     *      array of paragraphs
     */
    public function queryParagraphById(int $id) :array {
        if(empty($id)) {
            return array();
        }
        $request = $this->bdd->prepare("SELECT * FROM PARAGRAPHE WHERE ID=:ID ORDER BY PARAGRAPHE.POSITION");
        $request->bindParam(':ID',$id);
        return $request->execute()? $request->fetchAll(PDO::FETCH_ASSOC) : array();
    }

    /**
     * @param int $idArticle
     *      The id of the article
     * @return array
     *      All paragraph of the article, empty array if an error occurred
     */
    public function queryParagraphsByArticleId(int $idArticle): array {
        if (empty($idArticle)) {
            return array();
        }
        $request = $this->bdd->prepare("SELECT * FROM PARAGRAPHE WHERE ARTICLE_ID=:ID ORDER BY POSITION");
        $request->bindParam(':ID', $idArticle);
        return $request->execute()? $request->fetchAll(PDO::FETCH_ASSOC) : array();
    }

    /**
     * @param int $articleId
     *      The if of the article accosiated to the paragraph
     * @param int $position
     *      The position of the paragraph in the article
     * @return array
     */
    public function queryParagraphByArticleIdAndPosition(int $articleId, int $position): array {
        $request = $this->bdd->prepare("SELECT * FROM PARAGRAPHE WHERE ARTICLE_ID=:ARTICLEID AND POSITION=:POSITION");
        $request->bindParam(':ARTICLEID',$articleId);
        $request->bindParam(':POSITION', $position);
        return $request->execute()? $request->fetch(PDO::FETCH_ASSOC) : array();
    }

    /**
     * @param int $idPara
     *      The id of the paragraph to update
     * @param string $newContent
     *      The new content of the paragraph
     * @return int
     *      Number of row affected by the update, null if an error occurred
     */
    public function queryUpdateParagraphWithId(int $idPara,string $newContent): int {
        if (empty($idPara)) {
            return null;
        }
        $request = $this->bdd->prepare("UPDATE PARAGRAPHE SET CONTENT=:CONTENT WHERE ID=:ID");
        $request->bindParam(':CONTENT', $newContent);
        $request->bindParam(':ID', $idPara);
        return $request->execute() ? $request->rowCount() : null;
    }

    public function queryMoveparagraph(int $oldPos,int $newPos) {

    }
}
