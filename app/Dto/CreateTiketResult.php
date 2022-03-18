<?php

namespace App\Dto;


class CreateTiketResult
{
    public bool $isSucsses;
    public \Throwable $error;
    public bool $isClientError;
}
