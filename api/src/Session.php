<?php

namespace DeAquiNoSaleAPI;

use DeAquiNoSaleAPI\Models\UsuarioModel;

class Session
{

    private $c;
    private $logger;
        
    public function __construct($c){
        $this->c = $c;
        $this->logger = $c->get('logger');  
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");        
    }

    public function verificar($request, $response, $args){
        $this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        
        /*
        foreach ($_SESSION as $key => $value) {
            $this->logger->info($key." ".$value);
        }
        */

        if(isset($_SESSION["idusuario"]) && isset($_SESSION["nombre"]) && isset($_SESSION["token"])){

            $this->logger->info(__CLASS__.":".__FUNCTION__."(); Existe sessión"); 
            return true;

        } else {

            $this->logger->info(__CLASS__.":".__FUNCTION__."(); No existe sessión");        
            return false;
        }
    }

    public function config($usuarioModel,$token){
        $this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        /*
        foreach ($_SESSION as $key => $value) {
            $this->logger->info($key." ".$value);
        }
        */
        $_SESSION["idusuario"] = $usuarioModel->getIdusuario();
        $_SESSION["nombre"] = $usuarioModel->getNombre();
        $_SESSION["token"] = $token;
    }

    public function destruir(){
        // remove all session variables
        session_unset(); 
        // destroy the session 
        session_destroy(); 
    }

}
?>