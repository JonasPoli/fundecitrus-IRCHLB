<?php

namespace App\Entity;

use App\Repository\RegistrationBatchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationBatchRepository::class)]
class RegistrationBatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?int $position = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $hlbPrice = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $iocvPrice = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $fullPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $periodText = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getHlbPrice(): ?string
    {
        return $this->hlbPrice;
    }

    public function setHlbPrice(?string $hlbPrice): static
    {
        $this->hlbPrice = $hlbPrice;

        return $this;
    }

    public function getIocvPrice(): ?string
    {
        return $this->iocvPrice;
    }

    public function setIocvPrice(?string $iocvPrice): static
    {
        $this->iocvPrice = $iocvPrice;

        return $this;
    }

    public function getFullPrice(): ?string
    {
        return $this->fullPrice;
    }

    public function setFullPrice(?string $fullPrice): static
    {
        $this->fullPrice = $fullPrice;

        return $this;
    }

    public function getPeriodText(): ?string
    {
        return $this->periodText;
    }

    public function setPeriodText(?string $periodText): static
    {
        $this->periodText = $periodText;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}
