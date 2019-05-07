<?php

define('ROOT', dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

require_once ROOT . '/src/Controller/Controller.php';
require_once ROOT . '/src/Controller/FrontController.php';
require_once ROOT . '/src/Controller/PublicController/HomeController.php';
require_once ROOT . '/src/Controller/PublicController/ContactController.php';
require_once ROOT . '/src/Controller/PublicController/ArticlesController.php';
require_once ROOT . '/src/Controller/PublicController/LoginController.php';

require_once ROOT . '/src/Controller/AdminController/HomeController.php';

require_once ROOT . '/src/TwigAddon/TwigAdd.php';

use App\Controller\FrontController;
use Tracy\Debugger;

Debugger::enable();
Debugger::$strictMode = true;

$test = new FrontController();

$test->run();

