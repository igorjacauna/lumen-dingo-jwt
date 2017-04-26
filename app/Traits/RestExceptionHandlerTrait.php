<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch(true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
            case $this->isHttpNotFoundException($e):
                $retval = $this->endPointNotFound();
                break;
            default:
                $retval = $this->badRequest($e->getMessage(), $e->getCode(), ($e->getCode() > 200 && $e->getCode() < 1000) ? $e->getCode() : 400);
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message='Bad request', $code=0, $statusCode=400)
    {
        if(!$code)$code=500;
        return $this->jsonResponse([
            'error' => $message,
            'code' => $code
        ], $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message='Record not found', $code=0, $statusCode=404)
    {
        if(!$code)$code=Errors::GENERIC_ERROR;
        return $this->jsonResponse([
            'error' => $message,
            'code' => $code
        ], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload=null, $statusCode=404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    /**
     * Determines if the given exception is an Http not found
     *
     * @param  Exception $e [description]
     * @return boolean      [description]
     */
    protected function isHttpNotFoundException(Exception $e)
    {
        return $e instanceof NotFoundHttpException;
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function endPointNotFound($message='Endpoint not found', $code=0, $statusCode=404)
    {
        if(!$code)$code=Errors::GENERIC_ERROR;
        return $this->jsonResponse([
            'error' => $message,
            'code' => $code
        ], $statusCode);
    }

}
