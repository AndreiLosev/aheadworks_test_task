<?php

namespace App\Services;

use App\Models;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Connection;
use App\Dto;
class Tiket
{
    private Models\Ticket $tiket;
    private Models\Message $message;
    private Models\ServerCredentials $serverCredentials;
    private Models\User $user;
    private Hasher $hasher;
    private Connection $conn;

    public function __construct(
        Models\Ticket $tiket,
        Models\Message $message,
        Models\ServerCredentials $serverCredentials,
        Models\User $user,
        Hasher $hasher,
        Connection $conn,
    ) {
        $this->tiket = $tiket;
        $this->message = $message;
        $this->serverCredentials = $serverCredentials;
        $this->user = $user;
        $this->hasher = $hasher;
        $this->conn = $conn;
    }

    public function createTikent(Dto\Tiket $tiket, Dto\Message $message, ?Dto\ServerCredentials $serverCredentials): Dto\CreateTikentResult
    {
        try {
            $this->conn->beginTransaction();

            $this->serverCredentials->ftp_login = $this->hasher->make($serverCredentials->ftp_login ?? '');
            $this->serverCredentials->ftp_password = $this->hasher->make($serverCredentials->ftp_password ?? '');

            $this->message->content = $message->content;
            $this->message->author()->associate($this->user->role);

            if (empty($serverCredentials->ftp_login) && empty($serverCredentials->ftp_password)) {
                $this->message->serverCredentials()->save($this->serverCredentials);
            }

            $this->tiket->uid = $tiket->uid;
            $this->tiket->subject = $tiket->subject;
            $this->tiket->user_name = $tiket->user_name;
            $this->tiket->user_email = $tiket->user_email;
            $this->tiket->messages()->save($this->message);
            $this->tiket->save();

            $this->conn->commit();

            $result = new Dto\CreateTikentResult();
            $result->isSucsses = true;

        } catch (\Throwable $e) {
            $this->conn->rollBack();
            $result = new Dto\CreateTikentResult();
            $result->isSucsses = false;
            $result->errorMessage = $e->getMessage();
        }

        return $result;
    }
}