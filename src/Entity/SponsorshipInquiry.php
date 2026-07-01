<?php

namespace App\Entity;

use App\Repository\SponsorshipInquiryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorshipInquiryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SponsorshipInquiry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPerson = null;

    #[ORM\Column(length: 180)]
    private ?string $corporateEmail = null;

    #[ORM\Column(length: 100)]
    private ?string $interestArea = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'New';

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    public function setContactPerson(string $contactPerson): static
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    public function getCorporateEmail(): ?string
    {
        return $this->corporateEmail;
    }

    public function setCorporateEmail(string $corporateEmail): static
    {
        $this->corporateEmail = $corporateEmail;

        return $this;
    }

    public function getInterestArea(): ?string
    {
        return $this->interestArea;
    }

    public function setInterestArea(string $interestArea): static
    {
        $this->interestArea = $interestArea;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
