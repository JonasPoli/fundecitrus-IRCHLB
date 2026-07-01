<?php

namespace App\Entity;

use App\Repository\HomeBannerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeBannerRepository::class)]
class HomeBanner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $eventDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255)]
    private ?string $mainTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $button1Text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $button1Link = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $button2Text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $button2Link = null;

    #[ORM\ManyToOne(targetEntity: Image::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Image $image = null;

    #[ORM\Column]
    private ?int $position = 0;

    #[ORM\Column]
    private ?bool $isActive = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventDate(): ?string
    {
        return $this->eventDate;
    }

    public function setEventDate(string $eventDate): static
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getMainTitle(): ?string
    {
        return $this->mainTitle;
    }

    public function setMainTitle(string $mainTitle): static
    {
        $this->mainTitle = $mainTitle;

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(?string $description1): static
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getButton1Text(): ?string
    {
        return $this->button1Text;
    }

    public function setButton1Text(?string $button1Text): static
    {
        $this->button1Text = $button1Text;

        return $this;
    }

    public function getButton1Link(): ?string
    {
        return $this->button1Link;
    }

    public function setButton1Link(?string $button1Link): static
    {
        $this->button1Link = $button1Link;

        return $this;
    }

    public function getButton2Text(): ?string
    {
        return $this->button2Text;
    }

    public function setButton2Text(?string $button2Text): static
    {
        $this->button2Text = $button2Text;

        return $this;
    }

    public function getButton2Link(): ?string
    {
        return $this->button2Link;
    }

    public function setButton2Link(?string $button2Link): static
    {
        $this->button2Link = $button2Link;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
