<?php
namespace DeAquiNoSaleAPI\models;

class SecretoModel
{
	private $idSecreto;
	private $mensaje;
	private $fecha;
	private $valid;

  public function __construct() {

	}    

  /**
   * @return mixed
   */
  public function getIdSecreto()
  {
      return $this->idSecreto;
  }

  /**
   * @param mixed $idSecreto
   *
   * @return self
   */
  public function setIdSecreto($idSecreto)
  {
      $this->idSecreto = $idSecreto;

      return $this;
  }

  /**
   * @return mixed
   */
  public function getMensaje()
  {
      return $this->mensaje;
  }

  /**
   * @param mixed $mensaje
   *
   * @return self
   */
  public function setMensaje($mensaje)
  {
      $this->mensaje = $mensaje;

      return $this;
  }

  /**
   * @return mixed
   */
  public function getFecha()
  {
      return $this->fecha;
  }

  /**
   * @param mixed $fecha
   *
   * @return self
   */
  public function setFecha($fecha)
  {
      $this->fecha = $fecha;

      return $this;
  }

  /**
   * @return mixed
   */
  public function getValid()
  {
      return $this->valid;
  }

  /**
   * @param mixed $valid
   *
   * @return self
   */
  public function setValid($valid)
  {
      $this->valid = $valid;

      return $this;
  }


  public function toJSON() 
  {
    return [
    'idsecreto' => $this->idSecreto,
    'mensaje' => $this->mensaje,
    'fecha' => $this->fecha,
    'valid' => $this->valid,
    ];
  }

}
?>