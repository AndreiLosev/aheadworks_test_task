<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services;


class TiketController extends Controller
{
    private Services\Tiket $tiketServis;
    private Response $response;

    public function __construct(Services\Tiket $tiketServis, Response $response)
    {
        $this->tiketServis = $tiketServis;
        $this->response = $response;
    }

    public function create(Request $request): Response
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        return $this->response;
    }
}
