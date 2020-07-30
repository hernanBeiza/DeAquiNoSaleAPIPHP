<?php

// Configuración para CORS y sesiones
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    //$this->logger->info("add / ");
    $origins = $this->get('settings')['origins'];
    //$this->logger->info($_SERVER['HTTP_ORIGIN']);
    if(isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $origins)){
        $origin = $_SERVER['HTTP_ORIGIN'];
    }
    //Obtener desde las settings el origin con permiso para consultar
    //$origin = $this->get('settings')['origin'];
    //$this->logger->info($origin);
    // Para que la aplicación cliente pueda acceder al nombre, filename, el servidor debe exponer el header "Content-Disposition"
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', $origin)
        ->withHeader('Access-Control-Allow-Credentials', 'true')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Expose-Headers', 'Content-Disposition')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Rutas
$app->get('/', \IndexController::class . ':saludar');

/*
// Login
$app->post('/login', \UsuarioController::class . ':login');
// Verificar
$app->get('/verificar', \UsuarioController::class . ':verificar');
$app->post('/verificar', \UsuarioController::class . ':verificar');
// Logout
$app->post('/logout', \UsuarioController::class . ':logout');
*/

/* Secretos */
// Obtener secretos filtrados por página
$app->get('/secreto/pagina/{pagina}', \SecretoController::class . ':obtener');
// Obtener un secreto específico
$app->get('/secreto/{idsecreto}', \SecretoController::class . ':obtenerConID');
// Guardar un secreto en la DB
$app->post('/secreto', \SecretoController::class . ':guardar');
// Editar un secreto según idsecreto
$app->put('/secreto/{idsecreto}', \SecretoController::class . ':editar');
// Borrar un secreto de la db
$app->delete('/secreto/{idsecreto}', \SecretoController::class . ':eliminar');

//http://docs.slimframework.com/request/body/slim-3-how-to-get-all-get-put-post-variables
//http://stackoverflow.com/questions/32668186/