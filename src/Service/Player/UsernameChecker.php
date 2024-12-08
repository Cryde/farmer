<?php

namespace App\Service\Player;
class UsernameChecker
{
    public function isValid(string $username): bool
    {
        if (preg_match("/^[A-Za-z][A-Za-z0-9-]+$/", $username)) {
            return true;
        }

        return false;
    }
}