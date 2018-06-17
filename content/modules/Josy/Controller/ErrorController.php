<?php
namespace Josy\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    public function exceptionAction(FlattenException $exception)
    {

        $msg = 'Something went wrong! (' . $exception->getMessage() . ')';
        return $this->render("Default/error.html",array(
            "message"=>$msg,
            "statusCode"=> $exception->getStatusCode()
        ));
    }
}