<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 19:34
 */

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
            return json_encode($articles->fetchAll(PDO::FETCH_ASSOC));
        };
        return json_encode(['Erreur', '0']);
    }


}
