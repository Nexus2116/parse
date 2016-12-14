<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 12:28 PM
 * Email: <Portnov21@gmail.com>
 */

use core\AutoLoader;
use template\Hdkinohit;

define('ROOTPATH', __DIR__);

require 'core/AutoLoader.php';
$autoLoader = new AutoLoader();
$autoLoader->register();

$hdkinohit = new Hdkinohit();
$hdkinohit->start();