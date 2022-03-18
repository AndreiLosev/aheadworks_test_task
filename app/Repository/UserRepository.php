<?php

namespace App\Repository;

use App\Models;
class UserRepository
{
    private Models\User $user;

    public function __construct(Models\User $user)
    {
        $this->user = $user;
    }

    public function findUser(string $login): Models\User|false
    {
        $user = $this->user::where($this->user::login, $login)->first();

        if (empty($user)) {
            return false;
        }

        return $user;
    }

    public function userExists(string $token): Models\User|false
    {
        if ($token === '') {
            return false;
        }

        $user = $this->user::where($this->user::token, $token)->first();

        if (empty($user)) {
            return false;
        }

        return $user;
    }
}