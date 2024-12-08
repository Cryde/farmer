<?php

namespace App\ApiResource\Player;

use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Entity\Player\Farmer;
use App\Model\Api\Register\Register as RegisterOutput;
use App\State\Processor\Player\RegisterProcessor;
use App\Validator\Player\Username;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: 'farmer/register',
    openapi: new Operation(tags: ['Farmer']),
    normalizationContext: ['groups' => [Register::REGISTER]],
    output: RegisterOutput::class,
    processor: RegisterProcessor::class,
)]
#[UniqueEntity(
    fields: ['username'],
    message: 'This username is already taken.',
    entityClass: Farmer::class,
    errorPath: 'username',
)]
class Register
{
    public const REGISTER = 'register';

    #[Assert\Length(min: 3, max: 25)]
    #[Username]
    public string $username;
}