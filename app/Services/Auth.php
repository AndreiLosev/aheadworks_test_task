<?php

namespace App\Services;

use App\Repository;
use Illuminate\Contracts\Hashing\Hasher;
use App\Models;

class Auth
{
    private Repository\UserRepository $userRepository;
    private Hasher $hasher;

    public function __construct(Repository\UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function authorization(string $login, string $password): false|string
    {
        $currentUser = $this->userRepository->findUser($login);

        if (!$currentUser) {
            return false;
        }

        $isValid = $this->hasher->check($password, $currentUser->password);

        if (!$isValid) {
            return false;
        }

        $currentUser->token = $this->tokenGenerate($currentUser);
        $currentUser->save();

        return $currentUser->token;
    }

    public function verification(string $token): bool
    {
        return $this->userRepository->userExists($token);
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
}