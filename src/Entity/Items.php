<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
#[Vich\Uploadable]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subcategories $subcategory = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Conditions $status = null;

    #[ORM\ManyToOne(inversedBy: 'sells')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $seller = null;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'orders')]
    private Collection $buyer;



    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->buyer = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->created_at = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }


    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setItem($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getItem() === $this) {
                $comment->setItem(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSubcategory(): ?Subcategories
    {
        return $this->subcategory;
    }

    public function setSubcategory(?Subcategories $subcategory): static
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getStatus(): ?Conditions
    {
        return $this->status;
    }

    public function __toString()
    {
        return $this->status;
    }

    public function setStatus(?Conditions $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSeller(): ?Users
    {
        return $this->seller;
    }

    public function setSeller(?Users $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function serialize()
    {
        $this->imageFile = base64_encode($this->imageFile);
    }

    public function unserialize($serialized)
    {
        $this->imageFile = base64_decode($this->imageFile);
    }

    /**
     * @return Collection<int, Users>
     */
    public function getBuyer(): Collection
    {
        return $this->buyer;
    }

    public function addBuyer(Users $buyer): static
    {
        if (!$this->buyer->contains($buyer)) {
            $this->buyer->add($buyer);
        }

        return $this;
    }

    public function removeBuyer(Users $buyer): static
    {
        $this->buyer->removeElement($buyer);

        return $this;
    }
}