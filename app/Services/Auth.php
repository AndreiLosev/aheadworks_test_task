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

        $preparetionString = sprintf('%s_%s_%s', $currentUser->id, $currentUser->login, now());
        $newToken = $this->hasher->make($preparetionString);
        $currentUser->token = $newToken;
        $currentUser->save();

        return $newToken;
    }

    public function verification(string $token): bool
    {
        return $this->userRepository->userExists($token);
    }
}