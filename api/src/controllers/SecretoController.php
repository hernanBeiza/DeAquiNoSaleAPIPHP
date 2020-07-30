<?php
namespace DeAquiNoSaleAPI\controllers;

use DeAquiNoSaleAPI\models\SecretoModel;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class SecretoController 
{
	private $c;
	private $logger;

	public function __construct($c)
	{
		$this->c = $c;
		$this->logger = $c->get('logger');  
		//$this->logger->info(__CLASS__.":".__FUNCTION__."();");		
	}

	public function obtener($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");

	  $pag = $args["pagina"];

		if(!isset($pag)){
			$pag = 1;
		} else {
			if($pag<0){
				$pag = 1;
			} else {
				$pag--;
			}
		}

		$respuesta = $this->c->SecretoDAO->obtener($pag);
		if($respuesta["result"]){
			$secretos = array();
			foreach ($respuesta["secretos"] as $secreto) {
				array_push($secretos, $secreto->toJSON());
			}
			$respuesta["secretos"] = $secretos;
		}
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->withJson($respuesta);
	}

	public function obtenerConID($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");

	  $idsecreto = $args["idsecreto"];

		$enviar = true;
		$errores = "Le faltó:";
		if($idsecreto==null){
			$enviar = false;
			$errores.="\nEscoger el secreto";
		}

		if($enviar){
			$model = new SecretoModel();
			$model->setIdSecreto($idsecreto);
			$respuesta = $this->c->SecretoDAO->obtenerConID($model);
			if($respuesta["result"]){
				$secreto = $respuesta["secreto"]->toJSON();
				$respuesta["secreto"] = $secreto;
			}
		}
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->withJson($respuesta);
	}

	public function guardar($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");

		if(isset($request)){
			$data = $request->getParsedBody();
		} else {
			$respuesta = array("result"=>false,"errores"=>"Le faltó enviar los datos");
		}

		$enviar = true;
		$errores = "Le faltó escribir:";

		if($data["mensaje"]==null){
			$enviar = false;
			$errores.="<br/>Texto de tu secreto";
		}

		if($enviar){
			$secretoModel = new SecretoModel();
			$secretoModel->setMensaje($data["mensaje"]);
			$respuesta = $this->c->SecretoDAO->guardar($secretoModel);
		} else {
			$respuesta = array("result"=>false, "errores"=>$respuesta["errores"]);
		}
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->withJson($respuesta);
	}

	public function editar($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");
		if(isset($request)){
			$data = $request->getParsedBody();
		} else {
			$respuesta = array("result"=>false,"errores"=>"Te faltó enviar los datos");
		}

		$enviar = true;
		$errores = "Le faltó escribir:";
		if(isset($args)){
			$idsecreto = $args["idsecreto"];
		} else {
			$errores ="<br/> Id del secreto";
		}

		if($data["mensaje"]==null){
			$enviar = false;
			$errores.="<br/>Mensaje";
		}
		if($data["valid"]==null){
			$enviar = false;
			$errores.="<br/>Valid";
		}
		if($enviar){
			$secretoModel = new SecretoModel();
			$secretoModel->setIdSecreto($idsecreto);
			$secretoModel->setMensaje($data["mensaje"]);
			$secretoModel->setValid((int)$data["valid"]);
			$respuesta = $this->c->SecretoDAO->editar($secretoModel);
		} else {
			$respuesta = array("result"=>false, "errores"=>$errores);
		}

		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->withJson($respuesta);
	}

	public function eliminar($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");

		if(isset($args)){
			$idsecreto = $args["idsecreto"];
		} else {
			$respuesta = array("result"=>false,"errores"=>"Le faltó enviar los datos");
		}
		$enviar = true;
		$errores = "Le faltó:";
		if($idsecreto==null){
			$enviar = false;
			$errores.="n\Escoger el secreto";
		}
		if($enviar){
			$secretoModel = new SecretoModel();
			$secretoModel->setIdSecreto($idsecreto);
			$respuesta = $this->c->SecretoDAO->eliminar($secretoModel);
		} else {
			$respuesta = array("result"=>false, "errores"=>$errores);
		}
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->withJson($respuesta);
	}

	function __destruct() {
		//$this->logger->info(__CLASS__.":".__FUNCTION__."();");      
	}

}
?>