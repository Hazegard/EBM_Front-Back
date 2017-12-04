<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 27/11/17
 * Time: 19:38
 */

/**
 * Class Paragraphs
 *      Model that handle request to the database on paragraphs objects
 */
class Paragraphs {

    private function __construct() {}

    /**
     * Get the list of all paragraphs
     * @return array
     *      List of paragraphs ID => CONTENT
     */
    public static function queryParagraphs(): array {
        return DBAccess::getInstance()->queryAll("SELECT * FROM PARAGRAPHES");
    }

    /**
     * Get a paragraph by his ID
     * @param int $id
     *      The id of the paragraph
     * @return array
     *      array of paragraphs
     */
    public static function queryParagraphById(int $id): array {
        if (empty($id)) {
            return array();
        }
        return DBAccess::getInstance()->queryOne("SELECT * FROM PARAGRAPHES WHERE ID=?", [$id]);
    }

    /**
     * Get all paragraphs associated the an article by the article ID
     * @param int $articleId
     *      The id of the article
     * @return array
     *      All paragraph of the article, empty array if an error occurred
     */
    public static function queryParagraphsByArticleId(int $articleId): array {
        if (empty($articleId)) {
            return array();
        }
        return DBAccess::getInstance()->queryAll("SELECT * FROM PARAGRAPHES WHERE ARTICLE_ID=?", [$articleId]);
    }

    /**
     * Get a paragraph by his position in an article
     * @param int $articleId
     *      The if of the article associated to the paragraph
     * @param int $position
     *      The position of the paragraph in the article
     * @return array
     */
    public static function queryParagraphByArticleIdAndPosition(int $articleId, int $position): array {
        if (empty($articleId) || empty($position)) {
            return array();
        }
        return DBAccess::getInstance()->queryOne("SELECT * FROM PARAGRAPHES WHERE ARTICLE_ID=? AND POSITION=?", [$articleId, $position]);
    }

    /**
     * Update the content of a paragraph by his ID
     * @param int $idPara
     *      The id of the paragraph to update
     * @param string $newContent
     *      The new content of the paragraph
     * @param float $newPos
     *      The position of the new paragraph
     * @return int
     *      Number of row affected by the update, null if an error occurred
     */
    public static function queryUpdateParagraphWithId(int $idPara, string $newContent='', float $newPos = null): int {
        if (empty($idPara)) {
            return null;
        }
        $params = array();
        $sql = "UPDATE PARAGRAPHE SET";
        if(!is_null($newContent)) {
            $sql = $sql." CONTENT=?";
            $params = array_push($params, $newContent);
        }
        if(!is_null($newPos) && !is_null($newContent)) {
            $sql = $sql . " , ";
        }
        if(!is_null($newPos)) {
            $sql = $sql . "POSITION=? ";
            $params = array_push($params, $newPos);
        }
        return DBAccess::getInstance()->queryUpdate($sql, $params);
//        return DBAccess::getInstance()->queryUpdate("UPDATE PARAGRAPHE SET CONTENT=? WHERE ID=?", [$newContent, $idPara]);
    }

}