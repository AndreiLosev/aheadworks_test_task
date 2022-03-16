<?php

namespace App\Services;

use App\Models;
use Illuminate\Contracts\Hashing\Hasher;


class Tiket
{
    private $tiket;
    private $hasher;

    public function __construct(Models\Ticket $tiket, Hasher $hasher)
    {
        $this->tiket = $tiket;
        $this->hasher = $hasher;
    }
}