<?php

namespace App\Services;

use App\Repository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Hashing\Hasher;

class Auth
{
    private Repository\UserRepository $userRepository;
    private Request $request;
    private Hasher $hasher;

    public function __construct(Repository\UserRepository $userRepository, Request $request, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->hasher = $hasher;
    }

    public function authentication(string $login, string $password): false|string
    {
        $currentUser = $this->userRepository->findUser($login, $password);

        if (!$currentUser) {
            return false;
        }

        $preparetionString = sprintf('%s_%s_%s', $currentUser->id, $currentUser->login, now());
        $newToken = $$this->hasher->hash($preparetionString);
        $currentUser->token = $newToken;
        $currentUser->save();

        return $newToken;
    }

    public function verification(string $token): bool
    {
        return $this->userRepository->userExists($token);
    }
}