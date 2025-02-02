<?php

namespace App\Entity\Seed;

use App\Factory\Transaction\MooCurrencyFactory;
use App\Repository\Seed\SeedRepository;
use Brick\Money\Money;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeedRepository::class)]
class Seed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    private string $externalId;

    #[ORM\Column]
    private int $baseCostPrice;

    #[ORM\Column]
    private int $baseSalePrice;

    #[ORM\Column(length: 10)]
    private string $currencyCode;

    public function getId(): ?int
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

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getBaseCostPrice(): Money
    {
        return Money::ofMinor($this->baseCostPrice, MooCurrencyFactory::create());
    }

    public function setBaseCostPrice(Money $baseCostPrice): static
    {
        $this->baseCostPrice = $baseCostPrice->getMinorAmount()->toInt();
        $this->currencyCode = $baseCostPrice->getCurrency()->getCurrencyCode();

        return $this;
    }

    public function getBaseSalePrice(): Money
    {
        return Money::ofMinor($this->baseSalePrice, MooCurrencyFactory::create());
    }

    public function setBaseSalePrice(Money $baseSalePrice): static
    {
        $this->baseSalePrice = $baseSalePrice->getMinorAmount()->toInt();
        $this->currencyCode = $baseSalePrice->getCurrency()->getCurrencyCode();

        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): static
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }
}
