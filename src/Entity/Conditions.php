<?php

namespace App\Entity;

use App\Repository\ConditionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionsRepository::class)]
class Conditions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $state = null;

    /**
     * @var Collection<int, Items>
     */
    #[ORM\OneToMany(targetEntity: Items::class, mappedBy: 'conditions')]
    private Collection $item;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(Items $item): static
    {
        if (!$this->item->contains($item)) {
            $this->item->add($item);
            $item->setConditions($this);
        }

        return $this;
    }

    public function removeItem(Items $item): static
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getConditions() === $this) {
                $item->setConditions(null);
            }
        }

        return $this;
    }
}
