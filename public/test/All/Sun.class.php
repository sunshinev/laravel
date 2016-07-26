<?php
namespace All;
use All;
// use function All\User\smile;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2016/7/26
 * Time: 13:46
 */
class Sun {
    function __construct() {

    }

    function say() {
        $user = new All\User();
        $user->say();
    }
}