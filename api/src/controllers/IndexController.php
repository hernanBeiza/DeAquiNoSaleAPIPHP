<?php
namespace DeAquiNoSaleAPI\controllers;

use DeAquiNoSaleAPI\models\IndexModel;

class IndexController 
{
	private $c;
	private $logger;

	public function __construct($c)
	{
		$this->c = $c;
		$this->logger = $c->get('logger');  
		//$this->logger->info(__CLASS__.":".__FUNCTION__."();");		
	}

	public function saludar($request, $response, $args)
	{
		$this->logger->info(__CLASS__.":".__FUNCTION__."();");
		$model = new IndexModel();
		$respuesta = $this->c->IndexDAO->saludar();
		//return $respuesta;
		$response->getBody()->write($respuesta);
		return $response;
	}

	function __destruct() {
		//$this->logger->info(__CLASS__.":".__FUNCTION__."();");      
	}

}
?>