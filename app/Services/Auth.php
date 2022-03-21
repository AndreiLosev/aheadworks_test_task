<?php

namespace App\Services;

use App\Repository;
use Illuminate\Contracts\Hashing\Hasher;
use App\Models;

class Auth
{
    private Repository\UserRepository $userRepository;
    private Hasher $hasher;
    private null|Models\User $currentUser;

    public function __construct(Repository\UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function authorization(string $login, string $password): false|string
    {
        $user = $this->userRepository->findUser($login);

        if (!$user) {
            return false;
        }



        $isValid = $this->hasher->check($password, $user->password);

        if (!$isValid) {
            return false;
        }

        $this->currentUser = $user;
        $this->currentUser->token = $this->tokenGenerate($this->currentUser);
        $this->currentUser->save();

        return $this->currentUser->token;
    }

    public function verification(string $token): bool
    {
        $user = $this->userRepository->userExists($token);

        if (empty($user)) {
            return false;
        }

        $this->currentUser = $user;

        return true;
    }

    public function logout(Models\User $user): void
    {
        $user->token = '';
        $user->save();
    }

    private function tokenGenerate(Models\User $user): string
    {
        $preparetionString = sprintf('%s_%s_%s', $user->id, $user->login, now());
        return $this->hasher->make($preparetionString);
    }

    public function getCurrentUser(): Models\User|null
    {
        return $this->currentUser;
    }
}