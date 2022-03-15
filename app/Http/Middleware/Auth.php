<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services;


class Auth
{

    private Services\Auth $auth;
    private Response $response;

    public function __construct(Services\Auth $auth, Response $response)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('x-auth-token');

        if (empty($token)) {
            return $this->response->setStatusCode($this->response::HTTP_UNAUTHORIZED);
        }

        if (!$this->auth->verification($token)) {
            return $this->response->setStatusCode($this->response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
