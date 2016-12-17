<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 16/12/16
 * Time: 9:30 PM
 * Email: <Portnov21@gmail.com>
 */

namespace core;

/**
 * Class Model
 * @package core
 */
abstract class Model
{
    /** @var \PDO $pdo */
    protected $pdo;

    /* @var string */
    protected static $table = '';

    /** InitDb constructor. */
    public function __construct()
    {
        $this->pdo = $this->pdo();
    }

    /* @return \PDO */
    private static function pdo()
    {
        static $pdo;
        if (empty($pdo)) {
            $db = require_once ROOTPATH . '/config/db.php';
            $pdo = new \PDO("mysql:host={$db['host']};dbname={$db['dbname']}", $db['user'], $db['password']);
        }

        return $pdo;
    }

    /**
     * @param array $condition
     * @return \PDOStatement
     */
    public static function findAll(array $condition = [])
    {
        $where = '';
        if ($condition) {
            $where = 'WHERE ';

            $where .= join(' AND ', array_map(function ($k) {
                return $k . '=:' . $k;
            }, array_keys($condition)));
        }

        $statement = self::pdo()->prepare('SELECT * FROM ' . static::$table . ' ' . $where);
        $statement->execute($condition);

        return $statement;
    }

    /**
     * @param array $condition
     * @return bool|int
     */
    public static function save(array $condition = [])
    {
        if (empty($condition))
            return false;

        $keys = array_keys($condition);
        $statement = self::pdo()->prepare('INSERT INTO ' . static::$table . ' (' . join(',', $keys) . ') VALUES (:' . join(',:', $keys) . ')');
        $statement->execute($condition);

        return intval(self::pdo()->lastInsertId());
    }
}