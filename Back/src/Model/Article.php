<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 27/11/17
 * Time: 18:47
 */

/**
 * Class Article
 *      Model that handle request to the database on articles objects
 */
class Article {
    private function __construct() {}

    const ID = "ID";
    const TITLE = "TITLE";

    /**
     * Get the list of all articles
     * @return array
     *      List of Articles: ID => TITLE
     */
    public static function queryArticles(): array {
        return DBAccess::getInstance()->queryAll("SELECT * FROM ARTICLES");
    }

    /**
     * Get an article by his ID
     * @param int $id
     *      The id of the paragraph
     * @return array
     *      Associative array of the article
     */
    public static function queryArticleById(int $id): array {
        if (empty($id)) {
            return array();
        }
        return DBAccess::getInstance()->queryOne("SELECT * FROM ARTICLES WHERE ".Article::ID."=?", [$id]);
    }

    /**
     * Insert a new article in the database
     * @param string $title
     *      The title of the article to insert
     * @return array
     */
    public static function insertArticle(string $title): array {
        if (DBAccess::getInstance()->queryInsert("INSERT INTO ARTICLES (".Article::TITLE.") VALUE (?)", [$title])) {
            return Article::queryArticleById(DBAccess::getInstance()->getLastInserted());
        }
        return array();
    }

    /**
     * Delete the article by d, and all associated paragraphs
     * @param int $id
     *      The id of the article to delete
     * @return bool
     *      Deletion succeeded?
     */
    public static function queryDeleteArticleById(int $id){
        $sql = "DELETE FROM ARTICLES WHERE ".Article::ID."=?";
        return DBAccess::getInstance()->queryDelete($sql, [$id]);
    }

    /**
     * @param int $id
     *      The id of the article to update
     * @param string $title
     *      The new title of the article
     * @return array
     */
    public static function queryUpdateArticleById(int $id, string $title): array{
        $sql = "UPDATE ARTICLES SET ".Article::TITLE."=? WHERE ".Article::ID."=?";
        DBAccess::getInstance()->queryUpdate($sql, [$title, $id]);
        return self::queryArticleById($id);
    }
}