<?php

namespace DeAquiNoSaleAPI;

use \Dotenv\Dotenv;

class Config
{
	private $origin;
    private $carpeta;
    private $rutaPublica = "";

    private $c;
    private $logger;
        
    public function __construct($c){
        $this->c = $c;
        $this->logger = $c->get('logger');
        $this->iniciar();
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");
    }

    public function iniciar(){
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");
        date_default_timezone_set('America/Santiago');//or change to whatever timezone you want
        //$this->logger->info(__CLASS__.":".__FUNCTION__."(); env: ".$this->c->get("settings")["env"]);

        $allowed = $this->c->get('settings')['origins'];
        //$allowed = array('https://www.rheemchile.com', 'https://rheem.club','https://admin.rheem.club'); 
        if(isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed)){
            $this->origin = $_SERVER['HTTP_ORIGIN'];
        }

        //Cargar variables de entorno
        $archivo = $this->c->get("settings")["env"].".env";
        //$this->logger->info(__CLASS__.":".__FUNCTION__."(); ".$archivo);
        $dotenv = Dotenv::create(__DIR__."/../",$archivo);
        $dotenv->load();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 
            'SECRET_KEY', 'CLIENGO_KEY', 'CLIENGO_TOKEN', 'BLUE_KEY', 
            'CARPETA', 'RUTA_PUBLICA']);

        $this->carpeta = $_SERVER['DOCUMENT_ROOT'].getenv("CARPETA");
        $this->rutaPublica = getenv("RUTA_PUBLICA");
    }
    
    public function getOrigin()
    {
        return $this->origin;
    }

    public function getCarpeta()
    {
        return $this->carpeta;
    }

    public function getRutaPublica()
    {
        return $this->rutaPublica;
    }
}
?>