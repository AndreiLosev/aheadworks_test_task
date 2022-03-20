<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models;
class NewTiket extends Mailable
{
    use Queueable, SerializesModels;

    private Models\Ticket $tiket;

    public function setData(Models\Ticket $tiket): self
    {
        $this->tiket = $tiket;

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->tiket->user_email, $this->tiket->user_name)
            ->with('messeges', $this->tiket->messages->map(fn(Models\Message $i) => $i->content))
            ->view('emails.tiket')
        ;
    }
}
