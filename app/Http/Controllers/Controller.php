<?php

namespace App\Http\Controllers;

use App\Traits\ApiExceptionTrait;
use Laravel\Lumen\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers;
use Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Controller extends BaseController
{
    use Helpers;
    use ApiExceptionTrait;

    protected function handle_access($needle_level)
    {
        $user_level = Auth::user()->level;
        if(!($user_level & $needle_level)) {
            throw new AccessDeniedHttpException('Access denied to user ' . Auth::user()->name);
        }
    }
}
