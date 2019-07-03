<?php


namespace Core\Controller\Cookies;

use Firebase\JWT\JWT;

include_once '../app/config.php';

/**
 * Class Cookies
 * @package Core\Controller\Cookies
 */
class Cookies
{

    /**
     * @var JWT
     */
    protected $jwt;


    /**
     * Cookies constructor.
     */
    public function __construct()
    {
        $this->jwt = new JWT();
    }

    /**
     * @param string $name
     * @param string $value
     * @param string|null $time
     */
    public function setCookies(string $name, string $value, string $time = null)
    {
        if($time === null){
            $time = time() + 3600;
        }
        setcookie($name, $value, $time, '/');
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getCookies(string $name)
    {

        $return = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);

        return $return;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function unsetCookies(string $name)
    {
        $unset = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);

        if($unset !== null){
            unset($unset);
            self::setCookies($name,'',time() - 3600);
            return true;
        }
    }

    /**
     * @param int|null $id_user
     * @param string|null $name
     * @param string|null $email
     * @param string|null $image
     * @param int|null $level
     * @return string
     */
    public function encodeJWT(int $id_user = null, string $name = null, string $email = null, string $image = null, int $level = null)
    {

        $key = JWT_KEY;

        $token = array(
            'id' => $id_user,
            'name' => $name,
            'email' => $email,
            'image' => $image,
            'level' => $level
        );


        $jwt = $this->jwt->encode($token, $key);

        return $jwt;
    }

    /**
     * @param $token
     * @return array|bool
     */
    public function decodeJWT($token)
    {
        if($token !== null){
            $decoded = $this->jwt->decode($token, JWT_KEY, array('HS256'));
            $decoded_array = (array)$decoded;
            return $decoded_array;
        }return false;
    }

    /**
     * @param string $name
     * @param string $value
     * @return bool|string|mixed
     */
    public function dataJWT(string $name, string $value){

        $data = self::decodeJWT(self::getCookies($name));

        if(is_array($data)){
            if(isset($data[$value])){
                $value = filter_var($data[$value],FILTER_SANITIZE_SPECIAL_CHARS,FILTER_NULL_ON_FAILURE);
                return $value;
            }
        }return false;
    }
}
