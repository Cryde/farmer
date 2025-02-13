<?php

namespace App\Entity\Security;

use App\Entity\Player\Farmer;
use App\Repository\Security\AccessTokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
#[ORM\Index(name: 'token_index', fields: ['token'])]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $creationDatetime;

    #[ORM\Column(length: 255)]
    private string $token;

    #[ORM\ManyToOne] // ManyToOne because later we could have multiple worlds (and we would have one token per world per player)
    #[ORM\JoinColumn(nullable: false)]
    private Farmer $relatedFarmer;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $expirationDatetime;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreationDatetime(): \DateTimeInterface
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime(\DateTimeInterface $creationDatetime): static
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }

    public function getRelatedFarmer(): Farmer
    {
        return $this->relatedFarmer;
    }

    public function setRelatedFarmer(Farmer $relatedFarmer): static
    {
        $this->relatedFarmer = $relatedFarmer;

        return $this;
    }

    public function getExpirationDatetime(): \DateTimeInterface
    {
        return $this->expirationDatetime;
    }

    public function setExpirationDatetime(\DateTimeInterface $expirationDatetime): static
    {
        $this->expirationDatetime = $expirationDatetime;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->expirationDatetime > new \DateTime();
    }
}
