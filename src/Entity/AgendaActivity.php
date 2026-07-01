<?php

namespace App\Entity;

use App\Repository\AgendaActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaActivityRepository::class)]
class AgendaActivity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: EventDay::class, inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?EventDay $eventDay = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(targetEntity: VenueRoom::class, inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?VenueRoom $room = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Speaker>
     */
    #[ORM\ManyToMany(targetEntity: Speaker::class, inversedBy: 'activities')]
    #[ORM\JoinTable(name: 'agenda_activity_speaker')]
    private Collection $speakers;

    public function __construct()
    {
        $this->speakers = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEventDay(): ?EventDay
    {
        return $this->eventDay;
    }

    public function setEventDay(?EventDay $eventDay): static
    {
        $this->eventDay = $eventDay;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getRoom(): ?VenueRoom
    {
        return $this->room;
    }

    public function setRoom(?VenueRoom $room): static
    {
        $this->room = $room;

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

    /**
     * @return Collection<int, Speaker>
     */
    public function getSpeakers(): Collection
    {
        return $this->speakers;
    }

    public function addSpeaker(Speaker $speaker): static
    {
        if (!$this->speakers->contains($speaker)) {
            $this->speakers->add($speaker);
        }

        return $this;
    }

    public function removeSpeaker(Speaker $speaker): static
    {
        $this->speakers->removeElement($speaker);

        return $this;
    }
}
