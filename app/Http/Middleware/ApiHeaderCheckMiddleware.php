<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiSecretException;
use Closure;
use Exception;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config as FacadesConfig;

class ApiHeaderCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $value = config('apisecret.api-secret');

        if ($request->hasHeader('api-secret'))
        {
            if ($request->header('api-secret') === $value)
            {
                return $next($request);
            }
            else
            {
                throw new ApiSecretException("Invalid key");
            }
        }
        else
        {
            throw new ApiSecretException("Invalid header");
        } 
    }
}