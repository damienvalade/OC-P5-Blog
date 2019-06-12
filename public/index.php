<?php

require_once '../vendor/autoload.php';

use Core\Controller\FrontController;
use Tracy\Debugger;

Debugger::enable();
Debugger::$strictMode = true;

$test = new FrontController();

$test->run();



