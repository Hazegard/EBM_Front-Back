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
     *      array of articles
     */
    public static function queryArticleById(int $id): array {
        if (empty($id)) {
            return array();
        }
        return DBAccess::getInstance()->queryOne("SELECT * FROM ARTICLES WHERE ID=?", [$id]);
    }

}