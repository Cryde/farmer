<?php

namespace App\Entity\Farm;

use App\Enum\Transaction\TransactionDirection;
use App\Enum\Transaction\TransactionType;
use App\Factory\Transaction\MooCurrencyFactory;
use App\Repository\Farm\FarmTransactionRepository;
use Brick\Money\Money;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FarmTransactionRepository::class)]
class FarmTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private string $externalId;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Farm $relatedFarm;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $creationDatetime;

    #[ORM\Column(enumType: TransactionDirection::class)]
    private TransactionDirection $direction;

    #[ORM\Column(enumType: TransactionType::class)]
    private TransactionType $type;

    #[ORM\Column(type: Types::BIGINT)]
    private string $amount;

    #[ORM\Column(length: 10)]
    private string $currencyCode;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    public function __construct()
    {
        $this->creationDatetime = new \DateTimeImmutable();
    }

    public function getId(): ?int
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

    public function getRelatedFarm(): Farm
    {
        return $this->relatedFarm;
    }

    public function setRelatedFarm(Farm $relatedFarm): static
    {
        $this->relatedFarm = $relatedFarm;

        return $this;
    }

    public function getCreationDatetime(): \DateTimeImmutable
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime(\DateTimeImmutable $creationDatetime): static
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }

    public function getDirection(): TransactionDirection
    {
        return $this->direction;
    }

    public function setDirection(TransactionDirection $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getType(): TransactionType
    {
        return $this->type;
    }

    public function setType(TransactionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): Money
    {
        return Money::ofMinor($this->amount, MooCurrencyFactory::create());
    }

    public function setAmount(Money $amount): static
    {
        $this->amount = (string) $amount->getMinorAmount()->toInt();
        $this->currencyCode = $amount->getCurrency()->getCurrencyCode();

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): static
    {
        $this->currencyCode = $currencyCode;

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
}
