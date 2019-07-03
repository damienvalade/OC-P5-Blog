<?php

namespace Core\View\Twig;

use Core\Controller\Cookies\Cookies;
use Core\Controller\Session\Session;
use Core\Model\Database\Database;
use Core\Model\Model;
use http\Cookie;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigAdd
 * @package Core\View\Twig
 */
class TwigAdd extends AbstractExtension
{

    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * TwigAdd constructor.
     */
    public function __construct()
    {
        $this->cookies = new Cookies();
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('currentUrl', array($this, 'currentUrl')),
            new TwigFunction('pathPost', array($this, 'pathPost')),
            new TwigFunction('errors', array($this, 'errors')),
            new TwigFunction('isLogged', array($this, 'isLogged')),
            new TwigFunction('userName', array($this, 'userName')),
            new TwigFunction('userImage', array($this, 'userImage')),
            new TwigFunction('userLevel', array($this, 'userLevel')),
            new TwigFunction('userId', array($this, 'userId')),
            new TwigFunction('validate', array($this, 'validate')),
            new TwigFunction('authorized', array($this, 'authorized')),
            new TwigFunction('spaceReplace', array($this, 'spaceReplace'))
        );
    }

    /**
     * @param string|null $url
     * @return string
     */
    public function currentUrl(string $url = null)
    {

        $side = filter_input(INPUT_GET, 'side');
        $rubric = filter_input(INPUT_GET, 'rubric');
        $request = filter_input(INPUT_GET, 'request');

        if ($side !== null) {
            $pageCurrent = 'side=' . $side;
        } else {
            $pageCurrent = 'side=public';
        }

        if($rubric !== null)
        {
            $pageCurrent .= '&rubric=' . $rubric;
        }

        if($request !== null)
        {
            $pageCurrent .= '&request=' . $request;
        }

        if ($pageCurrent === $url) {
            return ' active';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function pathPost()
    {

        $side = filter_input(INPUT_GET, 'side');
        $rubric = filter_input(INPUT_GET, 'rubric');
        $request = filter_input(INPUT_GET, 'request');
        $id_path = filter_input(INPUT_GET, 'id');
        $name_path = filter_input(INPUT_GET, 'name');

        if ($side !== null) {
            $pathPost = '/' . $side;
        }

        if($rubric !== null)
        {
            $pathPost .= '/' . $rubric;
        }

        if($request !== null)
        {
            $pathPost .= '/' . $request;
        }

        if ($name_path !== null) {
            $pathPost .= '/' . $name_path .'-'.$id_path;
        }elseif ($id_path !== null) {
            $pathPost .= '/' . $id_path;
        }

        return $pathPost;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function errors($page)
    {
        $error = $this->cookies->getCookies($page);

        if ($error !== false) {
            $this->cookies->unsetCookies($page);
            return $error;
        }
    }

    /**
     * @param string $page
     * @return mixed
     */
    public function validate(string $page)
    {
        $validate = $this->cookies->getCookies($page);

        if ($validate !== false) {
            $this->cookies->unsetCookies($page);
            return $validate;
        }
    }

    /**
     * @return string
     */
    public function isLogged()
    {
        if ($this->cookies->dataJWT('user','id') !== false) {
            return '';
        }return 'hidden';
    }


    /**
     * @return string
     */
    public function userName()
    {
        return $this->cookies->dataJWT('user','name') !== false ? ucfirst($this->cookies->dataJWT('user','name')) : '';
    }

    /**
     * @return bool|mixed|string
     */
    public function userImage()
    {
        return $this->cookies->dataJWT('user','image') !== false ? $this->cookies->dataJWT('user','image') : '';
    }

    /**
     * @return string
     */
    public function userLevel()
    {
        return $this->cookies->dataJWT('user','level') !== false ? ucfirst($this->cookies->dataJWT('user','level')) : '';
    }

    /**
     * @return string
     */
    public function userId()
    {
        $user = $this->cookies->dataJWT('user','name');
        $database = new Model();

        $id_user = $database->read('users', $user, 'name', false);

        if($id_user[0]['id'] !== null){
            return $id_user[0]['id'];
        }
    }


    /**
     * @param string $toReplace
     * @return mixed
     */
    public function spaceReplace(string $toReplace){
        if(isset($toReplace)){
            $return = str_replace('-','_',$toReplace);
            $return = str_replace(' ','_',$return);
            return $return ;
        }
    }
}
