<?php
namespace DeAquiNoSaleAPI;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class App
{
    /**
     * Stores an instance of the Slim application.
     *
     * @var \Slim\App
     */
    private $app;

    public function __construct() {

        //$app = new \Slim\App;

        $settings = require __DIR__ . '/settings.php';

        $app = new \Slim\App($settings);

        require __DIR__ . '/../src/dependencies.php';

        //Configurar todo
        $app->getContainer()["Config"]->iniciar();
        
        require __DIR__ . '/../src/middleware.php';

        $this->app = $app;

        require __DIR__ . '/../src/routes.php';

    }

    /**
     * Get an instance of the application.
     *
     * @return \Slim\App
     */
    public function get()
    {
        return $this->app;
    }
    
}