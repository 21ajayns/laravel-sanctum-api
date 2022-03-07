<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiSecretMissingException;
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
        $value = config('apisecret.api_secret');

        if ($request->hasHeader('api_secret') && $request->header('api_secret') === $value)
        {
             return $next($request);
        }
        throw new ApiSecretMissingException("Missing api header credentials");
    }
}
