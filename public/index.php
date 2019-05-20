<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

use Core\Controller\Session\Session;
use Core\Controller\FrontController;
use Tracy\Debugger;

Debugger::enable();
Debugger::$strictMode = true;

$session = new Session();
$session->__construct();

$test = new FrontController();

$test->run();

