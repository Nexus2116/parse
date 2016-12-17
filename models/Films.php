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
class Films extends Model
{

    /* @var string */
    public static $table = 'films';

    /**
     * @param $title_hash
     * @return bool
     */
    public static function hasTitle($title_hash)
    {
        return boolval(self::findAll(['title_hash' => $title_hash])->rowCount());
    }


}