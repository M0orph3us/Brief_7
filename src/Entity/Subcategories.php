<?php

namespace App\Entity;

use App\Repository\SubcategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubcategoriesRepository::class)]
class Subcategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $subcategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubcategory(): ?string
    {
        return $this->subcategory;
    }

    public function setSubcategory(string $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }
}
