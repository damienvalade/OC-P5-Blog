<?php

namespace Core\Session;

class Session
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function createSession(int $id, string $name, string $email = null, string $image = null, int $level = null)
    {
        $_SESSION['user'] = [

            'id' => $id,
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'level' => $level

        ];
    }


    public static function destroySession()
    {
        $_SESSION = array();
        session_destroy();
    }

    public static function isLogged()
    {
        if (array_key_exists('user', $_SESSION))
        {
            if (!empty($_SESSION['user']))
            {
                return true;
            }return false;
        }return false;
    }

    public static function setError(string $error)
    {
        $_SESSION['error'] = $error;
    }

    public static function userId()
    {
        return self::isLogged() === false ? null : $_SESSION['user']['id'];
    }

    public static function userName()
    {
        return self::isLogged() === false ? null : $_SESSION['user']['name'];
    }

    public static function userEmail()
    {
        return self::isLogged() === false ? null : $_SESSION['user']['email'];
    }

    public static function userImage()
    {
        return self::isLogged() === false ? null : $_SESSION['user']['image'];
    }

    public static function userLevel()
    {
        return self::isLogged() === false ? null : $_SESSION['user']['level'];
    }


}