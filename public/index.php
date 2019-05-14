<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';


use Core\Controller\FrontController;
use Tracy\Debugger;

Debugger::enable();
Debugger::$strictMode = true;

$test = new FrontController();

$test->run();

