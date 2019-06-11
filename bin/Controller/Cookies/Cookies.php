<?php


namespace Core\Controller\Cookies;

use Firebase\JWT\JWT;

include_once '../app/config.php';

class Cookies
{

    public function setCookies($name, $value, $time = '')
    {

        setcookie($name, $value, time() + 3600, '/');
    }

    public function getCookies($name)
    {

        $return = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);

        return $return;
    }

    public function unsetCookies($name)
    {
        $unset = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);

        if($unset !== null){
            unset($unset);
            setcookie($name, '', time() - 3600);
        }
    }

    public function encodeJWT(int $id, string $name, string $email = null, string $image = null, int $level = null)
    {

        $key = JWT_KEY;

        $token = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'level' => $level
        );


        $jwt = JWT::encode($token, $key);

        return $jwt;
    }

    public function decodeJWT($token)
    {

        $decoded = JWT::decode($token, JWT_KEY, array('HS256'));
        $decoded_array = (array)$decoded;

        return $decoded_array;
    }
}