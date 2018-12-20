<?php

/* |Definitions| */
define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('PROJECT_SOURCE', '/apiStructure'); // domain.xx/PROJECT_SOURCE
define('PROJECT_LIBS', PROJECT_ROOT . PROJECT_SOURCE);
define('PROJECT_LINK', 'http://localdev' . PROJECT_SOURCE);

/* [Instance des classes] */
require PROJECT_LIBS.'/vendor/autoload.php';

/* {Appel des classes} */
$security = new \App\Protection\Security();
$settings = new \App\Configuration\Settings();
$router = new App\Init\Routes\Router('url');

/* |Definitions| */
define('PROJECT_NAME', $settings->getName());

/* #Routes# */
require PROJECT_LIBS.'/init/routes.php';

/* ~Run~ */
$router->run();
