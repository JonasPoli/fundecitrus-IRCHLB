<?php

namespace App\Entity;

use App\Repository\VenueRoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenueRoomRepository::class)]
class VenueRoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacity = null;

    /**
     * @var Collection<int, AgendaActivity>
     */
    #[ORM\OneToMany(targetEntity: AgendaActivity::class, mappedBy: 'room')]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, AgendaActivity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(AgendaActivity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setRoom($this);
        }

        return $this;
    }

    public function removeActivity(AgendaActivity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getRoom() === $this) {
                $activity->setRoom(null);
            }
        }

        return $this;
    }
}
