<?php


namespace Core\Controller\Cookies;

use Firebase\JWT\JWT;

include_once '../app/config.php';

class Cookies
{

    protected $jwt;

    public function __construct()
    {
        $this->jwt = new JWT();
    }

    public function setCookies($name, $value, $time = null)
    {
        if($time === null){
            $time = time() + 3600;
        }
        setcookie($name, $value, $time, '/');
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
            self::setCookies($name,'',time() - 3600);
            return true;
        }
    }

    public function encodeJWT(int $id = null, string $name = null, string $email = null, string $image = null, int $level = null)
    {

        $key = JWT_KEY;

        $token = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'level' => $level
        );


        $jwt = $this->jwt->encode($token, $key);

        return $jwt;
    }

    public function decodeJWT($token)
    {
        if($token !== null){
            $decoded = $this->jwt->decode($token, JWT_KEY, array('HS256'));
            $decoded_array = (array)$decoded;
            return $decoded_array;
        }return false;
    }

    public function dataJWT($name, $value){

        $data = self::decodeJWT(self::getCookies($name));

        if(is_array($data)){
            if(isset($data[$value])){
                $value = filter_var($data[$value],FILTER_SANITIZE_SPECIAL_CHARS,FILTER_NULL_ON_FAILURE);
                return $value;
            }
        }return false;
    }
}