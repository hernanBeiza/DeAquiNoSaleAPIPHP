<?php
namespace DeAquiNoSaleAPI\daos;

//Configuración y variables de entorno
use \Dotenv\Dotenv;

class DBDAO 
{
    private $c;
    private $logger;
    
    private $host = "";
    private $user = '';
    private $password = '';
    private $db = '';
    public $resultadosPorPagina = 10;

    public $mysqli;
    
    public function __construct($c){
        $this->c = $c;
        $this->logger = $c->get('logger');  
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        $this->iniciar();
        $this->conectar();
    }
    
    public function iniciar(){
        $this->logger->info(__CLASS__.":".__FUNCTION__."();");
        //Configuración y variables de entorno
        /*
        $dotenv = Dotenv::create(__DIR__."./../../");
        $dotenv->load();
        */
        /*
        $this->logger->info(getenv('DB_USER'));
        $this->logger->info($_ENV['DB_USER']);
        $this->logger->info($_SERVER['DB_USER']);
        */
        /*
        $archivo = $this->c->get("settings")["env"].".env";
        $dotenv = Dotenv::create(__DIR__."/../../",$archivo);
        $dotenv->load();
        */
        $this->host=getenv("DB_HOST");
        $this->user = getenv("DB_USER");
        $this->password = getenv("DB_PASSWORD");
        $this->db = getenv("DB_NAME");
    }

    public function conectar() {
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        $this->mysqli = new \MySQLi($this->host, $this->user, $this->password, $this->db);
        /* Cambiar el conjunto de caracteres a utf8 */
        if (!$this->mysqli->set_charset("utf8")) {
            //$this->logger->info(__CLASS__.":".__FUNCTION__."(); Error cargando el conjunto de caracteres utf8: ".$this->mysqli->error);
        } else {
            //$this->logger->info(__CLASS__.":".__FUNCTION__."(); Conjunto de caracteres actual: ". $this->mysqli->character_set_name());
        }
        /* Revisar conexión */
        if (mysqli_connect_errno()) {
            //logPHP(basename(__FILE__, '.php'),"Error de conexión: %s\n", mysqli_connect_error());
            exit();
        }
    }

    public function desconectar() {
        //$this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        if(isset($this->mysqli)){
            if (mysqli_close($this->mysqli)) {
                //logPHP(basename(__FILE__, '.php'),"Conexión cerrada");
                unset($this->host);
                unset($this->user);
                unset($this->password);
                unset($this->db);           
                unset($this->mysqli);
            } else {
                //logPHP(basename(__FILE__, '.php'),"Conexión no cerrada. Ya estaba cerrada");
            }                       
        } else {
            //logPHP(basename(__FILE__, '.php'),"Conexión no cerrada. Ya estaba cerrada");
        }
    }

    function __destruct() {
       // $this->logger->info(__CLASS__.":".__FUNCTION__."();");        
        $this->desconectar();
    }

}

?>