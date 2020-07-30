<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// https://github.com/tuupola/slim-jwt-auth
// https://arjunphp.com/secure-web-services-using-jwt-slim3-framework/
// 
$app->add(new \Slim\Middleware\JwtAuthentication([
    //"path" => "/api",
    "logger" => $container["logger"],
    "path" => [
		],
    "ignore" => ["/secreto"],
    "secret" => getenv("SECRET_KEY"),
    "algorithm" => $container["settings"]["codification"],
		"attribute" => "jwt",
    "secure" => false,
    "callback" => function ($request, $response, $arguments) use ($container) {
			error_log("middleware callback");

			foreach ($request as $key => $value) {
				error_log($key." ".$value);
			}

			foreach ($response as $key => $value) {
				error_log($key." ".$value);
			}
    },
	    "error" => function ($request, $response, $arguments) {
			error_log("middleware error");

			foreach ($arguments as $key => $value) {
				error_log($key." ".$value);
			}

			foreach ($request as $key => $value) {
				error_log($key." ".$value);
			}

			foreach ($response as $key => $value) {
				error_log($key." ".$value);
			}

	    //return new UnauthorizedResponse($arguments["message"], 401);
	    $errores = $arguments["message"];
	    if($arguments["message"]=="Expired token"){
	    	$errores = "Debes iniciar sesión nuevamente";
	    }
			$respuesta = array(
				"result"=>false,
				"errores"=>$errores
			);

			return $response
				->withStatus(401)
				->withHeader("Content-Type", "application/json")
				->withJson($respuesta);
			}
]));

//https://github.com/tuupola/slim-jwt-auth/issues/25
//Si llega el "token" por parámetro GET o POST
$app->add(function($request, $response, $next) {
    if(isset($request->getQueryParams()["token"])){
		$token = $request->getQueryParams()["token"];
		error_log("middleware GET token ".$token);

    } else if (isset($request->getParsedBody()["token"])){
		$token = $request->getParsedBody()["token"];
		error_log("middleware POST token ".$token);
    }

    if (false === empty($token)) {
        $request = $request->withHeader("Authorization", "Bearer {$token}");
    }
    /*
	$headers = $request->getHeaders();
	foreach ($headers as $name => $values) {
		$linea =  $name . ": " . implode(", ", $values);
		error_log($linea);
	}
	*/
    return $next($request, $response);
});