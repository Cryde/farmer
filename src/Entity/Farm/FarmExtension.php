<?php

namespace App\Entity\Farm;

use App\Entity\Extension\Extension;
use App\Repository\Farm\FarmExtensionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FarmExtensionRepository::class)]
class FarmExtension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $externalId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Farm $farm;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Extension $extension;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $creationDatetime;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $level;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getFarm(): Farm
    {
        return $this->farm;
    }

    public function setFarm(Farm $farm): static
    {
        $this->farm = $farm;

        return $this;
    }

    public function getExtension(): Extension
    {
        return $this->extension;
    }

    public function setExtension(Extension $extension): static
    {
        $this->extension = $extension;

        return $this;
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

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }
}
