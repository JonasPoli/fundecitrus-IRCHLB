<?php

namespace App\Entity;

use App\Repository\FaqCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaqCategoryRepository::class)]
class FaqCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $position = 0;

    /**
     * @var Collection<int, FaqItem>
     */
    #[ORM\OneToMany(targetEntity: FaqItem::class, mappedBy: 'category', cascade: ['persist', 'remove'])]
    private Collection $faqs;

    public function __construct()
    {
        $this->faqs = new ArrayCollection();
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
     * @return Collection<int, FaqItem>
     */
    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function addFaq(FaqItem $faq): static
    {
        if (!$this->faqs->contains($faq)) {
            $this->faqs->add($faq);
            $faq->setCategory($this);
        }

        return $this;
    }

    public function removeFaq(FaqItem $faq): static
    {
        if ($this->faqs->removeElement($faq)) {
            // set the owning side to null (unless already changed)
            if ($faq->getCategory() === $this) {
                $faq->setCategory(null);
            }
        }

        return $this;
    }
}
