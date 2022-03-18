<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services;
use App\Dto;
use App\Models;


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
            'uid' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'user_email' => ['required', 'string'],
            'message' => ['required', 'string'],
            'ftp_login' => ['string', 'nullable'],
            'ftp_password' => ['string', 'nullable'],
        ]);

        $tiket = new Dto\Tiket();
        $tiket->uid = $validated['uid'];
        $tiket->subject = $validated['subject'];
        $tiket->user_name = $validated['user_name'];
        $tiket->user_email = $validated['user_email'];

        $message = new Dto\Message();
        $message->content = $validated['message'];

        $serverCredentials = new Dto\ServerCredentials();
        $serverCredentials->ftp_login = $validated['ftp_login'];
        $serverCredentials->ftp_password = $validated['ftp_password'];



        return $this->response;
    }
}
