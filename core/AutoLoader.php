<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 1:22 PM
 * Email: <Portnov21@gmail.com>
 */

namespace core;


/**
 * Class AutoLoader
 * @package core
 */
class AutoLoader
{
    /**
     *
     */
    public function register()
    {
        spl_autoload_register([$this, 'autoLoader']);
    }

    /**
     * @param $name
     */
    public function autoLoader($name)
    {
        $file = ROOTPATH . '/' . str_replace('\\', '/', $name) . '.php';
        if (file_exists($file))
            include_once $file;
    }

}