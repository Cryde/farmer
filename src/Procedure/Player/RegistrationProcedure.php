<?php

namespace App\Procedure\Player;

use App\ApiResource\Player\Register;
use App\Builder\Api\Player\RegisterBuilder;
use App\Builder\Entity\Farmer\FarmerEntityBuilder;
use App\Builder\Entity\Security\AccessTokenBuilder;
use App\Contract\Generator\AccessTokenGeneratorInterface;
use App\Model\Api\Register\Register as RegisterApi;
use Doctrine\ORM\EntityManagerInterface;

readonly class RegistrationProcedure
{
    public function __construct(
        private AccessTokenGeneratorInterface $accessTokenGenerator,
        private FarmerEntityBuilder    $farmerEntityBuilder,
        private AccessTokenBuilder     $accessTokenBuilder,
        private EntityManagerInterface $entityManager,
        private RegisterBuilder        $registerBuilder
    ) {
    }

    public function register(Register $registerModel): RegisterApi
    {
        $token = $this->accessTokenGenerator->generate();
        $farmer = $this->farmerEntityBuilder->build(mb_strtoupper($registerModel->username));
        $this->entityManager->persist($farmer);
        $accessToken = $this->accessTokenBuilder->build($farmer, $token, new \DateTime('+ 2 months')); // todo set expiration related to a reset world
        $this->entityManager->persist($accessToken);
        $this->entityManager->flush();

        return $this->registerBuilder->build($farmer, $token);
    }
}