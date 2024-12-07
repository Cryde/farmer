<?php

namespace App\Builder\Entity\Security;

use App\Entity\Player\Farmer;
use App\Entity\Security\AccessToken;

class AccessTokenBuilder
{
    public function build(Farmer $farmer, string $token, \DateTimeInterface $expirationDatetime): AccessToken
    {
        return (new AccessToken())
            ->setToken($token)
            ->setRelatedFarmer($farmer)
            ->setExpirationDatetime($expirationDatetime);
    }
}
