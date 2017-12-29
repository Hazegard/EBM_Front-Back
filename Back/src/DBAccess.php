<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 17/11/17
 * Time: 19:34
 */

include_once('config.php');

/**
 * Class DBAccess
 *      Handle the connexion to the database, and the requests
 */
class DBAccess {
    private $bdd = null;

    private function __construct() {
        try {
            global $host;
            global $dbname;
            global $username;
            global $password;
            $this->bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8',$username,$password);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getmessage());
        }
    }

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

    public function getLastInserted(){
        return $this->bdd->lastInsertId();
    }

    /**
     * Prepare and execute a query that should return more than one row
     * @param string $sql
     *      The sql statement
     * @param array $values
     *      The values to bind to the sql statement
     *      The values in the statement and in the array must be in the same order
     * @param int $fetch_method
     *      Method to fetch the result, PDO::FETCH_ASSOC by default
     * @return array
     *      Result of the query fetched
     */
    public function queryAll(string $sql,array $values=array(), int $fetch_method=PDO::FETCH_ASSOC):array {
        $query = $this->bdd->prepare($sql);
        return $query->execute($values)? $query->fetchAll($fetch_method) : array();
    }

    /**
     * Prepare and execute a query that should return only one row
     * @param string $sql
     *      The sql statement
     * @param array $values
     *      The values to bind to the sql statement
     *      The values in the statement and in the array must be in the same order
     * @param int $fetch_method
     *      Method to fetch the result, PDO::FETCH_ASSOC by default
     * @return array
     *      Result of the query fetched
     */
    public function queryOne(string $sql,array $values=array(), int $fetch_method=PDO::FETCH_ASSOC):array {
        $query = $this->bdd->prepare($sql);
        $return = $query->execute($values) ? $query->fetch($fetch_method) : array();
        return $return === false ? array() : $return;
    }

    /**
     * Prepare and execute an update query
     * @param string $sql
     *      The sql statement
     * @param array $values
     *      The values to bind to the sql statement
     *      The values in the statement and in the array must be in the same order
     * @return int|null
     *      Number of row affected by the update, null if error
     */
    public function queryUpdate(string $sql, array $values):int{
        $query = $this->bdd->prepare($sql);
        return $query->execute($values)? $query->rowCount() : 0;
    }

    /**
     * Prepare and execute insert query
     * @param string $sql
     *      The query to execute
     * @param array $values
     *      The values to bind to the sql statement
     *      The values in the statement and in the array must be in the same order
     * @return bool
     *      True if the insert wes successful, false otherwise
     */
    public function queryInsert(string $sql, array $values):bool {
        $query = $this->bdd->prepare($sql);
        return $query->execute($values);
    }

    /**
     * Prepare and execute the delete statement
     * @param string $sql
     *      The query to execute
     * @param array $values
     *      The values to bind to the sql statement
     *      The values in the statement and in the array must be in the same order
     * @return bool
     *      True if deletion was completed, false otherwise
     */
    public function queryDelete(string $sql, array $values):bool {
        $query = $this->bdd->prepare($sql);
        return $query->execute($values);
    }

}
