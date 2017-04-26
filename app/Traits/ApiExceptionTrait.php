<?php

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;	        //403
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;	            //400
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;	            //409
use Symfony\Component\HttpKernel\Exception\GoneHttpException;	                //410
use Symfony\Component\HttpKernel\Exception\HttpException;	                    //500
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;	        //411
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;	    //405
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;	        //406
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;	            //404
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;	    //412
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;	//428
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;	    //503
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;	    //429
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;	        //401
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;	//415

trait ApiExceptionTrait
{
    protected function accessDenied($message = null, $code = 0, \Exception $previous = null)
    {
        throw new AccessDeniedHttpException($message, $previous, $code);
    }

    protected function badRequest($message = null, $code = 0, \Exception $previous = null)
    {
        throw new BadRequestHttpException($message, $previous, $code);
    }

    protected function conflict($message = null, $code = 0, \Exception $previous = null)
    {
        throw new ConflictHttpException($message, $previous, $code);
    }

    protected function gone($message = null, $code = 0, \Exception $previous = null)
    {
        throw new GoneHttpException($message, $previous, $code);
    }

    protected function exception($message = null, $code = 0, \Exception $previous = null)
    {
        throw new HttpException($message, $previous, $code);
    }

    protected function lengthRequired($message = null, $code = 0, \Exception $previous = null)
    {
        throw new LengthRequiredHttpException($message, $previous, $code);
    }

    protected function methodNotAllowed($message = null, $code = 0, \Exception $previous = null)
    {
        throw new MethodNotAllowedHttpException($message, $previous, $code);
    }

    protected function notAcceptable($message = null, $code = 0, \Exception $previous = null)
    {
        throw new NotAcceptableHttpException($message, $previous, $code);
    }

    protected function notFound($message = null, $code = 0, \Exception $previous = null)
    {
        throw new NotFoundHttpException($message, $previous, $code);
    }

    protected function preconditionFailed($message = null, $code = 0, \Exception $previous = null)
    {
        throw new PreconditionFailedHttpException($message, $previous, $code);
    }

    protected function PreconditionRequired($message = null, $code = 0, \Exception $previous = null)
    {
        throw new PreconditionRequiredHttpException($message, $previous, $code);
    }

    protected function serviceUnavailable($message = null, $code = 0, \Exception $previous = null)
    {
        throw new ServiceUnavailableHttpException($message, $previous, $code);
    }

    protected function tooManyRequests($message = null, $code = 0, \Exception $previous = null)
    {
        throw new TooManyRequestsHttpException($message, $previous, $code);
    }

    protected function unauthorized($message = null, $code = 0, \Exception $previous = null)
    {
        throw new UnauthorizedHttpException($message, $previous, $code);
    }

    protected function unsupportedMediaType($message = null, $code = 0, \Exception $previous = null)
    {
        throw new UnsupportedMediaTypeHttpException($message, $previous, $code);
    }
}