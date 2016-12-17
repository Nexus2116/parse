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
class People extends Model
{

    /* @var string */
    public static $table = 'people';

    /**
     * @param $people
     * @return bool
     */
    public static function hasPeople($people)
    {
        return boolval(self::findAll(['name' => $people])->rowCount());
    }

}