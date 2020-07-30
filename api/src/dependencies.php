<?php

$container = $app->getContainer();

// view renderer
/*
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};
*/

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    $handler = new Monolog\Handler\RotatingFileHandler($settings["path"],100, $settings["level"], true, 0664);
    # '/' in date format is treated like '/' in directory path
    # so Y/m/d-filename will create path: eg. 2017/07/21-filename.log
    //$handler->setFilenameFormat('{date}-{filename}', 'Y/m/d');
    # so Y/m-filename will create path: eg. 2017/07-filename.log    
    $handler->setFilenameFormat('{date}-{filename}', 'Y/m');

    $logger->pushHandler($handler);
    return $logger;
};

// Llave de autentificación, ahora en settings
// $container['secret'] = 'HAHiperKey';

// Configuración
$container['Config'] = function ($c) {
    return new \DeAquiNoSaleAPI\Config($c);
};
// Sessión
/*
$container['Session'] = function ($c) {
    return new \DeAquiNoSaleAPI\Session($c);
};
*/
// Manejar errores, exceptiones try catch
/*
$container['errorHandler'] = function ($c) {
    return new \DeAquiNoSaleAPI\CustomExceptionHandler();
};
*/

// DAOs
$container['DBDAO'] = function ($c) {
    return new \DeAquiNoSaleAPI\daos\DBDAO($c);
};
$container['SecretoDAO'] = function ($c) {
    return new \DeAquiNoSaleAPI\daos\SecretoDAO($c);
};
$container['IndexDAO'] = function ($c) {
    return new \DeAquiNoSaleAPI\daos\IndexDAO($c);
};

// Models
$container['IndexModel'] = function ($c) {
    return new \DeAquiNoSaleAPI\models\IndexModel();
};
$container['SecretoModel'] = function ($c) {
    return new \DeAquiNoSaleAPI\models\SecretoModel();
};

// Controllers
$container['IndexController'] = function ($c) {
    return new \DeAquiNoSaleAPI\controllers\IndexController($c);
};
$container['SecretoController'] = function ($c) {
    return new \DeAquiNoSaleAPI\controllers\SecretoController($c);
};