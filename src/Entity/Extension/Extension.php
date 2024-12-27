<?php

namespace App\Entity\Extension;

use App\Enum\Extension\ExtensionType;
use App\Repository\Extension\ExtensionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtensionRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME', fields: ['type'])]
class Extension
{
    // todo add max items per farm ? add max level ?
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(enumType: ExtensionType::class)]
    private ExtensionType $type;

    #[ORM\Column]
    private bool $isUpdatable;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ExtensionType
    {
        return $this->type;
    }

    public function setType(ExtensionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isUpdatable(): ?bool
    {
        return $this->isUpdatable;
    }

    public function setIsUpdatable(bool $isUpdatable): static
    {
        $this->isUpdatable = $isUpdatable;

        return $this;
    }
}
