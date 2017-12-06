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

    const ID = "ID";
    const CONTENT = "CONTENT";
    const POSITION = "POSITION";
    const IDARTICLE = "ARTICLE_ID";
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
        return DBAccess::getInstance()->queryOne("SELECT * FROM PARAGRAPHES WHERE ".Paragraphs::ID."=?", [$id]);
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
        return DBAccess::getInstance()->queryAll("SELECT * FROM PARAGRAPHES WHERE ".Paragraphs::ID."=?", [$articleId]);
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
        return DBAccess::getInstance()->queryOne(
            "SELECT * FROM PARAGRAPHES WHERE ".Paragraphs::IDARTICLE."=? AND  ".Paragraphs::POSITION."=?",
            [$articleId, $position]);
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
        $sql = "UPDATE PARAGRAPHES SET";
        if(!is_null($newContent)) {
            $sql = $sql." ".Paragraphs::CONTENT."=?";
            $params = array_push($params, $newContent);
        }
        if(!is_null($newPos) && !is_null($newContent)) {
            $sql = $sql . " , ";
        }
        if(!is_null($newPos)) {
            $sql = $sql . " ".Paragraphs::POSITION."=? ";
            $params = array_push($params, $newPos);
        }
        return DBAccess::getInstance()->queryUpdate($sql, $params);
    }

    /**
     * Get the position of the last paragraph in the article
     * @param int $idArticle
     *      The id of the article
     * @return array
     *      Array that containing the position, or empty array if no paragraphs
     */
    public static function getCurrentMaxPositionOfArticle(int $idArticle){
        return DBAccess::getInstance()->queryOne(
            "SELECT POSITION FROM PARAGRAPHES WHERE " . Paragraphs::IDARTICLE . " = ? ORDER BY "
            . Paragraphs::POSITION . " DESC LIMIT 1", [$idArticle]);
    }

    /**
     * Insert a new paragraph at a position
     * @param int $idArticle
     *      The id of the article
     * @param string $newContent
     *      The content of the new paragraph
     * @param float|null $position
     *      The position where the paragraph must be inserted
     * @return array
     *      Array of the new paragraph if insertion succeed, empty array if failed
     */
    public static function insertParagraphInArticle(int $idArticle, string $newContent, float $position = null): array {
        if (is_null($position)) {
            $position = ceil(self::getCurrentMaxPositionOfArticle($idArticle)[self::POSITION]);
            empty($position) ?
                $position = 1 :
                $position += 1;
        }

        if (DBAccess::getInstance()->queryInsert(
            "INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (?,?,?) ",
            [$newContent, $position, $idArticle])) {
            return Paragraphs::queryParagraphById(DBAccess::getInstance()->getLastInserted());
        }
        return array();
    }

}