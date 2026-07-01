<?php

namespace App\Entity;

use App\Repository\SpeakerPaperRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeakerPaperRepository::class)]
class SpeakerPaper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $callDetails = null;

    #[ORM\ManyToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Image $pdfFile = null;

    #[ORM\ManyToOne(targetEntity: Speaker::class, inversedBy: 'papers')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Speaker $speaker = null;

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

    public function getCallDetails(): ?string
    {
        return $this->callDetails;
    }

    public function setCallDetails(string $callDetails): static
    {
        $this->callDetails = $callDetails;

        return $this;
    }

    public function getPdfFile(): ?Image
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?Image $pdfFile): static
    {
        $this->pdfFile = $pdfFile;

        return $this;
    }

    public function getSpeaker(): ?Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker(?Speaker $speaker): static
    {
        $this->speaker = $speaker;

        return $this;
    }
}
