<?php
namespace DeAquiNoSaleAPI\daos;
use DeAquiNoSaleAPI\daos\DBDAO;
use DeAquiNoSaleAPI\models\SecretoModel;

class SecretoDAO extends DBDAO
{
	private $c;
	private $logger;

	public function __construct($c){
    parent::__construct($c);
		$this->c = $c;
		$this->logger = $c->get('logger');
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");
	}

	public function obtener($pagina) {
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");
    $mysqli = $this->mysqli;
		$pag = $pagina*$this->resultadosPorPagina;

    $sql = "SELECT * FROM secreto WHERE valid = 1 ORDER BY idsecreto DESC LIMIT ".$pag.",".$this->resultadosPorPagina;
    $this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    
    $result = $mysqli->query($sql);// or die($mysqli->error.__LINE__);
    $secretos = array();
    if($mysqli->error){
      $this->logger->info(__CLASS__.":".__FUNCTION__."();". $mysqli->error);        
      $info = array(
        "result"=>false,
        "errores"=>"Hubo un error al tratar de obtener los datos. Intenta más tarde");
    } else {
      if($result->num_rows > 0) {
        while($fila = $result->fetch_assoc()) {
          $modelo = new SecretoModel();
          $modelo->setIdSecreto((int)$fila['idsecreto']);
          $modelo->setMensaje($fila['mensaje']);
          $modelo->setFecha($fila['fecha']);
          $modelo->setValid((int)$fila['valid']);
          array_push($secretos, $modelo);
        }
        $result->close();

        $result2 = $this->obtenerTotalDePaginas();

        $info = array(
          "result"=>true,
          "secretos"=>$secretos,
          "total"=>$result2["totalPaginas"],
          "mensajes"=>"Se encontrados secretos.",
        );
      } else {
        $info = array(
          "result"=>false,
          "secretos"=>null,
          "errores"=>"No hay secretos aún."
        );
      }
    }

    return $info;
	}

  public function obtenerConID(SecretoModel $secretoModel) {
    $this->logger->info(__CLASS__.":".__FUNCTION__."();");
    $mysqli = $this->mysqli;
    $sql = "SELECT * FROM secreto WHERE idsecreto = ".$secretoModel->getIdSecreto();
    $this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    
    $result = $mysqli->query($sql);// or die($mysqli->error.__LINE__);
    if($mysqli->error){
      $this->logger->info(__CLASS__.":".__FUNCTION__."();". $mysqli->error);        
      $info = array(
        "result"=>false,
        "errores"=>"Hubo un error al tratar de obtener los datos. Intenta más tarde");
    } else {
      if($result->num_rows > 0) {
        while($fila = $result->fetch_assoc()) {
          $secreto = new SecretoModel();
          $secreto->setIdSecreto((int)$fila['idsecreto']);
          $secreto->setMensaje($fila['mensaje']);
          $secreto->setFecha($fila['fecha']);
          $secreto->setValid((int)$fila['valid']);
        }
        $result->close();
        $info = array(
          "result"=>true,
          "secreto"=>$secreto,
          "mensajes"=>"Se encontró secreto",
        );
      } else {
        $info = array(
          "result"=>false,
          "secreto"=>null,
          "errores"=>"No hay secreto con ese id."
        );
      }
    }

    return $info;
  }

  public function guardar(SecretoModel $secreto)
  {
    $this->logger->info(__CLASS__.":".__FUNCTION__."();");
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO secreto (mensaje) ";
    $sql.= "VALUES ('".$mysqli->real_escape_string($secreto->getMensaje())."')";
    $this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);
    $result = $mysqli->query($sql);// or die($mysqli->error.__LINE__);
    if($mysqli->error){
      $info = array(
        "result"=>false,
        "errores"=>"Hubo un error al tratar de guardar tu secreto. Intenta de nuevo en un ratito más ^^");
    } else {
      if($result) {
        $info = array(
          "result"=>true,
          "idsecreto"=>$mysqli->insert_id,
          "mensajes"=>"Tu secreto ha sido publicado");
      } else {
        $info = array(
          "result"=>false,
          "errores"=>"Tu secreto no se ha podido guardado. Intenta más tarde");
      }
    }
    return $info;
  }

	public function editar(SecretoModel $secreto) {
    $this->logger->info(__CLASS__.":".__FUNCTION__."();");
    $mysqli = $this->mysqli;
    $sql = "UPDATE secreto SET mensaje='".$mysqli->real_escape_string($secreto->getMensaje())."', valid=".$secreto->getValid()." WHERE idsecreto = ". $secreto->getIdSecreto();    
    $this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    $result = $mysqli->query($sql);// or die($mysqli->error.__LINE__);
    if($mysqli->error){
      $info = array(
        "result"=>false,
        "errores"=>"Hubo un error al tratar de editar tu secreto. Intenta de nuevo en un ratito más ^^");
    } else {
      if($result) {
        $info = array(
          "result"=>true,
          "mensajes"=>"Tu secreto se ha actualizado correctamente ^^");
      } else {
        $info = array(
          "result"=>false,
          "errores"=>"Tu secreto no se pudo actualizar. Intenta de nuevo en un ratito más ^^");
      }
    }
    return $info;
	}

	public function eliminar(SecretoModel $secretoModel) {
    $this->logger->info(__CLASS__.":".__FUNCTION__."();");
    $mysqli = $this->mysqli;
    $sql = "DELETE FROM secreto WHERE idsecreto = ". $secretoModel->getIdSecreto();
    $this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    $result = $mysqli->query($sql);// or die($mysqli->error.__LINE__);
    if($mysqli->error){
      $info = array(
        "result"=>false,
        "errores"=>"Hubo un error al tratar de eliminar los datos de tu secreto. Intenta más tarde");
    } else {
      if($result) {
        if($mysqli->affected_rows>0){
          $info = array(
            "result"=>true,
            "mensajes"=>"Tu secreto ha sido eliminado correctamente");
        } else {
          $info = array(
            "result"=>false,
            "errores"=>"Tu secreto no se ha podido eliminar. Intenta más tarde");
        }
      } else {
        $info = array(
          "result"=>false,
          "errores"=>"Tu secreto no se ha podido eliminar. Intenta más tarde");
      }
    }
    return $info;        
	}

  /**
   * Retorna la cantidad de paginas que hay
   * @return [type]               [description]
   */
  private function obtenerTotalDePaginas(){
    $mysqli = $this->mysqli;
    $sql = "SELECT CEIL(COUNT(*)/".$this->resultadosPorPagina.") as totalPaginas FROM secreto WHERE valid = 1";
    //$this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    $result = $mysqli->query($sql) or die($mysqli->error.__LINE__);
    if($result) {
      $fila = $result->fetch_assoc();
      $totalPaginas = (int)$fila['totalPaginas'];
      return array('result' => true, 'mensajes' => 'Total de páginas encontrado','totalPaginas' => $totalPaginas);
    } else {
      return array('result' => false, 'errores' => 'No se pudo obtener el total de páginas');
    }
  }

  /**
   * Obtener el total de mensajes
   * @param SecretoModel $secretoModel 
   * @return array result: true|false mensajes:string con resultado de la búsqueda
   */
  private function obtenerTotalDeSecretos(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(*) as totalContactos FROM secreto WHERE valid = 1";
    //$this->logger->info(__CLASS__.":".__FUNCTION__."();". $sql);        
    $result = $mysqli->query($sql) or die($mysqli->error.__LINE__);
    if($result) {
      $fila = $result->fetch_assoc();
      $totalSecretos = (int)$fila['totalSecretos'];
      return array('result' => true, 'mensajes' => 'Total de secretos encontrado','totalSecretos' => $totalSecretos);
    } else {
      return array('result' => false, 'errores' => 'No se pudo obtener el total de secretos');
    }
  }

	function __destruct() {
	 //$this->logger->info(__CLASS__.":".__FUNCTION__."();");      
	}

}
?>