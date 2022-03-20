<?php

namespace App\Dto;

use App\Models;

class CreateTiketResult
{
    public bool $isSucsses;
    public \Throwable $error;
    public bool $isClientError;
}
