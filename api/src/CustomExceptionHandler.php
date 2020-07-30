<?php
namespace DeAquiNoSaleAPI;

class CustomExceptionHandler
{

    public function __invoke($request, $response, $exception)
    {
        $errors['errors'] = $exception->getMessage();
        $errors['responseCode'] = 500;
        return $response
            ->withStatus(500)
            ->withJson($errors);

    }
}
?>