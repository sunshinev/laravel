<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/7/26
 * Time: 13:40
 */
// include 'loader.php';

spl_autoload_register(function ($class) {
    $class = strtr($class,'\\','/');
    include $class.'.class.php';
});

use All\Sun;
$sun = new Sun();
$sun->say();
