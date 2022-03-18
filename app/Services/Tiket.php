<?php

namespace App\Services;

use App\Models;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\QueryException;
use Illuminate\Database\Connection;
use App\Dto;
use App\Services;
use Error;
use RuntimeException;

class Tiket
{
    private Models\Ticket $tiket;
    private Models\Message $message;
    private Models\ServerCredentials $serverCredentials;
    private Services\Auth $auth;
    private Hasher $hasher;
    private Connection $conn;

    public function __construct(
        Models\Ticket $tiket,
        Models\Message $message,
        Models\ServerCredentials $serverCredentials,
        Services\Auth $auth,
        Hasher $hasher,
        Connection $conn,
    ) {
        $this->tiket = $tiket;
        $this->message = $message;
        $this->serverCredentials = $serverCredentials;
        $this->auth = $auth;
        $this->hasher = $hasher;
        $this->conn = $conn;
    }

    public function createTikent(Dto\Tiket $tiket, Dto\Message $message, ?Dto\ServerCredentials $serverCredentials): Dto\CreateTiketResult
    {
        $result = new Dto\CreateTiketResult();

        try {
            $this->conn->beginTransaction();

            $this->tiket->uid = $tiket->uid;
            $this->tiket->subject = $tiket->subject;
            $this->tiket->user_name = $tiket->user_name;
            $this->tiket->user_email = $tiket->user_email;
            $this->tiket->save();

            $this->message->content = $message->content;
            $autor = $this->auth->getCurrentUser();
            $this->message->author()->associate($autor->role);
            $this->tiket->messages()->save($this->message);

            if (!empty($serverCredentials->ftp_login) && !empty($serverCredentials->ftp_password)) {
                $this->serverCredentials->ftp_login = $this->hasher->make($serverCredentials->ftp_login);
                $this->serverCredentials->ftp_password = $this->hasher->make($serverCredentials->ftp_password);
                $this->message->serverCredentials()->save($this->serverCredentials);
            }

            $this->conn->commit();
            $result->isSucsses = true;

        } catch (\Throwable $e) {

            $this->conn->rollBack();
            $result->isSucsses = false;
            $result->error = $e;
            $result->isClientError = $this->isDuplicatUidException($e);
        }

        return $result;
    }

    private function isDuplicatUidException(\Throwable $e): bool
    {
        return $e instanceof QueryException
            && $e->getCode() === "23000"
            && strripos($e->getMessage(), 'tickets.tickets_uid_unique')
        ;
    }
}