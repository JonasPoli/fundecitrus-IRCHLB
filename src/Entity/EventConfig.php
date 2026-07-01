<?php

namespace App\Entity;

use App\Repository\EventConfigRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventConfigRepository::class)]
class EventConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 100)]
    private ?string $eventDates = null;

    #[ORM\Column(length: 255)]
    private ?string $locationName = null;

    #[ORM\Column(length: 255)]
    private ?string $addressStreet = null;

    #[ORM\Column(length: 255)]
    private ?string $addressNeighborhood = null;

    #[ORM\Column(length: 100)]
    private ?string $addressCity = null;

    #[ORM\Column(length: 20)]
    private ?string $addressZipCode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $googleMapsUrl = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $heroDescription = null;

    #[ORM\ManyToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Image $heroImage = null;

    #[ORM\Column(length: 180)]
    private ?string $supportEmail = null;

    #[ORM\Column(length: 50)]
    private ?string $supportPhone = null;

    #[ORM\Column(length: 50)]
    private ?string $whatsappNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedinUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeUrl = null;

    #[ORM\ManyToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Image $prospectusFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getEventDates(): ?string
    {
        return $this->eventDates;
    }

    public function setEventDates(string $eventDates): static
    {
        $this->eventDates = $eventDates;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->locationName;
    }

    public function setLocationName(string $locationName): static
    {
        $this->locationName = $locationName;

        return $this;
    }

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(string $addressStreet): static
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    public function getAddressNeighborhood(): ?string
    {
        return $this->addressNeighborhood;
    }

    public function setAddressNeighborhood(string $addressNeighborhood): static
    {
        $this->addressNeighborhood = $addressNeighborhood;

        return $this;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function setAddressCity(string $addressCity): static
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    public function getAddressZipCode(): ?string
    {
        return $this->addressZipCode;
    }

    public function setAddressZipCode(string $addressZipCode): static
    {
        $this->addressZipCode = $addressZipCode;

        return $this;
    }

    public function getGoogleMapsUrl(): ?string
    {
        return $this->googleMapsUrl;
    }

    public function setGoogleMapsUrl(string $googleMapsUrl): static
    {
        $this->googleMapsUrl = $googleMapsUrl;

        return $this;
    }

    public function getHeroDescription(): ?string
    {
        return $this->heroDescription;
    }

    public function setHeroDescription(string $heroDescription): static
    {
        $this->heroDescription = $heroDescription;

        return $this;
    }

    public function getHeroImage(): ?Image
    {
        return $this->heroImage;
    }

    public function setHeroImage(?Image $heroImage): static
    {
        $this->heroImage = $heroImage;

        return $this;
    }

    public function getSupportEmail(): ?string
    {
        return $this->supportEmail;
    }

    public function setSupportEmail(string $supportEmail): static
    {
        $this->supportEmail = $supportEmail;

        return $this;
    }

    public function getSupportPhone(): ?string
    {
        return $this->supportPhone;
    }

    public function setSupportPhone(string $supportPhone): static
    {
        $this->supportPhone = $supportPhone;

        return $this;
    }

    public function getWhatsappNumber(): ?string
    {
        return $this->whatsappNumber;
    }

    public function setWhatsappNumber(string $whatsappNumber): static
    {
        $this->whatsappNumber = $whatsappNumber;

        return $this;
    }

    public function getLinkedinUrl(): ?string
    {
        return $this->linkedinUrl;
    }

    public function setLinkedinUrl(?string $linkedinUrl): static
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    public function getInstagramUrl(): ?string
    {
        return $this->instagramUrl;
    }

    public function setInstagramUrl(?string $instagramUrl): static
    {
        $this->instagramUrl = $instagramUrl;

        return $this;
    }

    public function getYoutubeUrl(): ?string
    {
        return $this->youtubeUrl;
    }

    public function setYoutubeUrl(?string $youtubeUrl): static
    {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    public function getProspectusFile(): ?Image
    {
        return $this->prospectusFile;
    }

    public function setProspectusFile(?Image $prospectusFile): static
    {
        $this->prospectusFile = $prospectusFile;

        return $this;
    }
}
