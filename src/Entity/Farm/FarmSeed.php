<?php

namespace App\Entity\Farm;

use App\Entity\Seed\Seed;
use App\Repository\Farm\FarmSeedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FarmSeedRepository::class)]
class FarmSeed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Farm $relatedFarm;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Seed $seed;

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $creationDatetime;

    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedFarm(): ?Farm
    {
        return $this->relatedFarm;
    }

    public function setRelatedFarm(?Farm $relatedFarm): static
    {
        $this->relatedFarm = $relatedFarm;

        return $this;
    }

    public function getSeed(): ?Seed
    {
        return $this->seed;
    }

    public function setSeed(?Seed $seed): static
    {
        $this->seed = $seed;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreationDatetime(): ?\DateTimeInterface
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime(\DateTimeInterface $creationDatetime): static
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }
}
