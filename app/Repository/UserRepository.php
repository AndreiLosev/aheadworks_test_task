<?php

namespace App\Repository;

use App\Models;
use Illuminate\Container\Container;

class UserRepository
{
    private Models\User $user;
    private Container $container;

    public function __construct(Models\User $user, Container $container)
    {
        $this->user = $user;
        $this->container = $container;
    }

    public function findUser(string $login): Models\User|false
    {
        $user = $this->user::where($this->user::login, $login)->first();

        if (empty($user)) {
            return false;
        }

        $this->container->singleton(Models\User::class, fn($app) => $user);

        return $this->container->make(Models\User::class);
    }

    public function userExists(string $token): bool
    {
        $user = $this->user::where($this->user::token, $token)->first();

        if (empty($user)) {
            return false;
        }

        $this->container->singleton(Models\User::class, fn($app) => $user);

        return true;
    }
}