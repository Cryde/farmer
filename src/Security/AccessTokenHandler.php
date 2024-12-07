<?php

namespace App\Security;

use App\Repository\Security\AccessTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private AccessTokenRepository $repository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $token = $this->repository->findOneBy(['token' => $accessToken]);
        if (null === $token || !$token->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        return new UserBadge($token->getRelatedFarmer()->getUsername());
    }
}