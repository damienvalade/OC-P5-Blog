<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

use Core\Controller\Session\Session;
use Core\Controller\FrontController;
use Tracy\Debugger;

Debugger::enable();
Debugger::$strictMode = true;

$coockies = new Core\Controller\Cookies\Cookies();

$token = $coockies->encodeJWT('1','machin','truc','bidule','1');
$coockies->setCookies('user',$token);
$decode = $coockies->decodeJWT($token);
var_dump($decode);
var_dump($coockies->getCookies('user'));

$session = new Session();
$session->__construct();

$test = new FrontController();

$test->run();



