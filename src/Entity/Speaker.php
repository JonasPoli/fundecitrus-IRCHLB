<?php

namespace App\Entity;

use App\Repository\SpeakerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeakerRepository::class)]
class Speaker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Image::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Image $image = null;

    #[ORM\Column(length: 255)]
    private ?string $institution = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $department = null;

    #[ORM\Column(length: 255)]
    private ?string $shortBio = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedinUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebookUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whatsappUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scholarUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lattesUrl = null;

    #[ORM\Column(type: Types::JSON)]
    private array $researchAreas = [];

    #[ORM\Column]
    private ?bool $isFeatured = null;

    #[ORM\Column]
    private ?int $position = 0;

    /**
     * @var Collection<int, SpeakerPaper>
     */
    #[ORM\OneToMany(targetEntity: SpeakerPaper::class, mappedBy: 'speaker', cascade: ['persist', 'remove'])]
    private Collection $papers;

    /**
     * @var Collection<int, SpeakerAgenda>
     */
    #[ORM\OneToMany(targetEntity: SpeakerAgenda::class, mappedBy: 'speaker', cascade: ['persist', 'remove'])]
    private Collection $personalAgendas;

    /**
     * @var Collection<int, AgendaActivity>
     */
    #[ORM\ManyToMany(targetEntity: AgendaActivity::class, mappedBy: 'speakers')]
    private Collection $activities;

    public function __construct()
    {
        $this->papers = new ArrayCollection();
        $this->personalAgendas = new ArrayCollection();
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(string $institution): static
    {
        $this->institution = $institution;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getShortBio(): ?string
    {
        return $this->shortBio;
    }

    public function setShortBio(string $shortBio): static
    {
        $this->shortBio = $shortBio;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

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

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function setFacebookUrl(?string $facebookUrl): static
    {
        $this->facebookUrl = $facebookUrl;

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

    public function getWhatsappUrl(): ?string
    {
        return $this->whatsappUrl;
    }

    public function setWhatsappUrl(?string $whatsappUrl): static
    {
        $this->whatsappUrl = $whatsappUrl;

        return $this;
    }

    public function getScholarUrl(): ?string
    {
        return $this->scholarUrl;
    }

    public function setScholarUrl(?string $scholarUrl): static
    {
        $this->scholarUrl = $scholarUrl;

        return $this;
    }

    public function getLattesUrl(): ?string
    {
        return $this->lattesUrl;
    }

    public function setLattesUrl(?string $lattesUrl): static
    {
        $this->lattesUrl = $lattesUrl;

        return $this;
    }

    public function getResearchAreas(): array
    {
        return $this->researchAreas;
    }

    public function setResearchAreas(array $researchAreas): static
    {
        $this->researchAreas = $researchAreas;

        return $this;
    }

    public function isFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(bool $isFeatured): static
    {
        $this->isFeatured = $isFeatured;

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

    /**
     * @return Collection<int, SpeakerPaper>
     */
    public function getPapers(): Collection
    {
        return $this->papers;
    }

    public function addPaper(SpeakerPaper $paper): static
    {
        if (!$this->papers->contains($paper)) {
            $this->papers->add($paper);
            $paper->setSpeaker($this);
        }

        return $this;
    }

    public function removePaper(SpeakerPaper $paper): static
    {
        if ($this->papers->removeElement($paper)) {
            // set the owning side to null (unless already changed)
            if ($paper->getSpeaker() === $this) {
                $paper->setSpeaker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SpeakerAgenda>
     */
    public function getPersonalAgendas(): Collection
    {
        return $this->personalAgendas;
    }

    public function addPersonalAgenda(SpeakerAgenda $personalAgenda): static
    {
        if (!$this->personalAgendas->contains($personalAgenda)) {
            $this->personalAgendas->add($personalAgenda);
            $personalAgenda->setSpeaker($this);
        }

        return $this;
    }

    public function removePersonalAgenda(SpeakerAgenda $personalAgenda): static
    {
        if ($this->personalAgendas->removeElement($personalAgenda)) {
            // set the owning side to null (unless already changed)
            if ($personalAgenda->getSpeaker() === $this) {
                $personalAgenda->setSpeaker(null);
            }
        }

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
            $activity->addSpeaker($this);
        }

        return $this;
    }

    public function removeActivity(AgendaActivity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            $activity->removeSpeaker($this);
        }

        return $this;
    }
}
