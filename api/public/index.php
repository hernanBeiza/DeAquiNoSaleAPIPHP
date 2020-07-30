<?php
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './../vendor/autoload.php';

ini_set('date.timezone', 'America/Santiago');

$app = (new DeAquiNoSaleAPI\App())->get();

$app->run();