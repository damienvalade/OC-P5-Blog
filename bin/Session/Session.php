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

    public static function setError(string $type, string $error)
    {
        $_SESSION['error'] = [
            $type => $error
        ];
    }

    public static function setValidate(string $type, string $message)
    {
        $_SESSION['validate'] = [
            $type => $message
        ];
    }

    public static function isAdmin()
    {
        if(self::isLogged())
        {
            if($_SESSION['user']['level'] === 1)
            {
                return true;
            }
        }else { return false; }
    }

    public static function isEditor()
    {
        if(self::isLogged())
        {
            if($_SESSION['user']['level'] === 2)
            {
                return true;
            }
        }else { return false; }
    }

    public static function isRegistered()
    {
        if(self::isLogged())
        {
            if($_SESSION['user']['level'] === 3)
            {
                return true;
            }
        }else { return false; }

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