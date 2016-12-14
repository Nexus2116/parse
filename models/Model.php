<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 12:44 PM
 * Email: <Portnov21@gmail.com>
 */

namespace models;


/**
 * Class Model
 * @package models
 */
class Model extends InitDb
{
    /**
     * @var string
     */
    public $table = '';

    /**
     * @param array $arr
     * @return bool|string
     */
    public function insert(array $arr = [])
    {
        if (empty($arr) || !$this->table)
            return false;

        $keys = array_keys($arr);
        $statement = $this->pdo->prepare("INSERT INTO {$this->table} (" . join(',', $keys) . ") VALUES (:" . join(',:', $keys) . ")");
        if ($statement->execute($arr))
            return $this->pdo->lastInsertId();


        return false;
    }
}