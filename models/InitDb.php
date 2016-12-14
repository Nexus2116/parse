<?php

/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 12:40 PM
 * Email: <Portnov21@gmail.com>
 */

namespace models;

/**
 * Class InitDb
 * @package models
 */
class InitDb
{

    /** @var \PDO $pdo */
    protected $pdo;

    /**
     * InitDb constructor.
     */
    public function __construct()
    {
        $db = require_once ROOTPATH . '/config/db.php';
        $this->pdo = new \PDO("mysql:host={$db['host']};dbname={$db['dbname']}", $db['user'], $db['password']);
    }

}