<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services;

class Authoriztion extends Controller
{
    private Response $response;
    private Services\Auth $auth;

    public function __construct(Services\Auth $auth, Response $response)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    public function authorization(Request $request): Response
    {
        $login = $request->input('login');
        $password = $request->input('password');

        if (empty($login) || empty($password)) {
            return $this->response->setStatusCode($this->response::HTTP_UNAUTHORIZED);
        }

        $token = $this->auth->authorization($login, $password);

        if (!$token) {
            return $this->response->setStatusCode($this->response::HTTP_UNAUTHORIZED);
        }

        $this->response
            ->setStatusCode($this->response::HTTP_OK)
            ->setContent(['x-auth-token' => $token])
        ;

        return $this->response;
    }
}
