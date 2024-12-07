<?php

namespace App\Model\Api\Register;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\ApiResource\Farmer\Farmer;
use App\ApiResource\Player\Register as RegisterApi;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [])]
#[Get(uriTemplate: 'farmer/register/{id}', openapi: false, read: false)]
class Register
{
    public string $id;
    #[Groups(RegisterApi::REGISTER)]
    public string $token;
    #[ApiProperty(genId: false)]
    #[Groups(RegisterApi::REGISTER)]
    public Farmer $farmer;
}