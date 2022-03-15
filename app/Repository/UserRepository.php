<?php

namespace App\Repository;

use App\Models;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    private Models\User $user;

    public function __construct(Models\User $user)
    {
        $this->user = $user;
    }

    public function findUser(string $login, string $password): Models\User|false
    {
        $user = $this->user::where($this->user::login, $login)
            ->where($this->user::password, $password)
            ->first()
        ;

        if (empty($user)) {
            return false;
        }

        return $user;
    }

    public function userExists(string $token): bool
    {
        return $this->user::where($this->user::token, $token)->exists();
    }
}