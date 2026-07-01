<?php

namespace App\Entity;

use App\Repository\SpeakerAgendaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeakerAgendaRepository::class)]
class SpeakerAgenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $eventDateText = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 150)]
    private ?string $timeLocationText = null;

    #[ORM\ManyToOne(targetEntity: Speaker::class, inversedBy: 'personalAgendas')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Speaker $speaker = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventDateText(): ?string
    {
        return $this->eventDateText;
    }

    public function setEventDateText(string $eventDateText): static
    {
        $this->eventDateText = $eventDateText;

        return $this;
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

    public function getTimeLocationText(): ?string
    {
        return $this->timeLocationText;
    }

    public function setTimeLocationText(string $timeLocationText): static
    {
        $this->timeLocationText = $timeLocationText;

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
