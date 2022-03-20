<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Log\LogManager;
use Illuminate\Mail\Mailer;
use App\Models;
use App\Mail;

class AfterCreateTiket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Models\Ticket $tiket;
    private Mail\NewTiket $tiketMail;

    public function __construct(
        Models\Ticket $tiket,
        Mail\NewTiket $tiketMail,
    ) {
        $this->tiket = $tiket;
        $this->tiketMail = $tiketMail;
    }

    public function handle(Mailer $mailer , HttpClient $httpClient, LogManager $logManager): void
    {
        $mailer->send($this->tiketMail);

        $res = $httpClient
            ->accept('application/json')
            ->post('https://reqres.in/api/user', [
                'login' => $this->tiket->user_name,
                'password' => $this->tiket->user_email,
            ])
        ;
        $logManager->info($res);
    }
}
