<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/7/2016
 * Time: 10:42
 */

namespace Libs;


class Request
{
    /**
     * Get param from post
     * @param $key
     * @return mixed
     */
    public static function getPostParam($key)
    {
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }

        return null;
    }
}