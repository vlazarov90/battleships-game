<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 13:13
 */

namespace Libs;


class Session
{
    /**
     * Start session
     */
    private static function start()
    {
        session_start();
    }

    /**
     * Save value in session
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function write($key, $value)
    {
        if(!is_string($key)){
            throw new \Exception(__FUNCTION__." expects parameter 1 to be string, ".gettype($key)." given");
        }

        if(!isset($_SESSION)){
            self::start();
        }

        $_SESSION[$key] = $value;

        return $value;
    }

    /**
     * Remove value from session
     * @param $key
     * @throws \Exception
     */
    public static function remove($key)
    {
        if(!is_string($key)){
            throw new \Exception(__FUNCTION__." expects parameter 1 to be string, ".gettype($key)." given");
        }

        if(!isset($_SESSION)){
            self::start();
        }

        unset($_SESSION[$key]);
    }

    /**
     * Read from session
     * @param $key
     * @return null
     * @throws \Exception
     */
    public static function read($key)
    {
        if(!is_string($key)){
            throw new \Exception(__FUNCTION__." expects parameter 1 to be string, ".gettype($key)." given");
        }

        if(!isset($_SESSION)){
            self::start();
        }

        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Destroy session
     */
    public static function destroy()
    {
        session_destroy();
    }
}