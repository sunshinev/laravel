<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/7/26
 * Time: 13:40
 */
class Loader {
    static function loadClass($class) {
        $class = strtr($class,'\\','/');
        include $class.'.class.php';
    }
}