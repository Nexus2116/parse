<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 12:44 PM
 * Email: <Portnov21@gmail.com>
 */

namespace models;

use \core\Model;

/**
 * Class Model
 * @package models
 */
class Genre extends Model
{

    /* @var string */
    public static $table = 'genre';

    /**
     * @param $genre
     * @return bool
     */
    public static function hasGenre($genre)
    {
        return boolval(self::findAll(['genre' => $genre])->rowCount());
    }

}