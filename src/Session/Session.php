<?php

namespace App\Session;

class Session
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function createSession(int $id, string $name, string $email, string $image, int $level)
    {
        $_SESSION['user'] = [

            'id' => $id,
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'level' => $level

        ];
    }

    public function destroySession()
    {
        $_SESSION = array();
        session_destroy();
    }

    public function isLogged()
    {
        if (array_key_exists('user', $_SESSION))
        {
            if (!empty($_SESSION['user']))
            {
                return true;
            }return false;
        }return false;
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