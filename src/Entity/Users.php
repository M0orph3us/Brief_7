<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
#[Vich\Uploadable]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/',
        match: true,
        message: 'Your password must contain a number, an uppercase letter and a special character',
    )]
    private ?string $password = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank]
    private ?string $username = null;

    #[ORM\Column]
    private ?bool $confirmed = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[Vich\UploadableField(mapping: 'profils', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;


    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Items>
     */
    #[ORM\OneToMany(targetEntity: Items::class, mappedBy: 'seller', orphanRemoval: true)]
    private Collection $sells;

    /**
     * @var Collection<int, Items>
     */
    #[ORM\ManyToMany(targetEntity: Items::class)]
    private Collection $favorites;

    /**
     * @var Collection<int, Items>
     */
    #[ORM\ManyToMany(targetEntity: Items::class, mappedBy: 'buyer')]
    private Collection $orders;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->sells = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = ["ROLE_USER"];

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): static
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    // \DateTimeImmutable $created_at
    public function setCreatedAt(): static
    {
        $timezone = new DateTimeZone('Europe/Paris');
        $this->created_at = new DateTimeImmutable('now', $timezone);

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

    public function serialize()
    {
        $this->imageFile = base64_encode($this->imageFile);
    }

    public function unserialize($serialized)
    {
        $this->imageFile = base64_decode($this->imageFile);
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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getSells(): Collection
    {
        return $this->sells;
    }

    public function addSell(Items $sell): static
    {
        if (!$this->sells->contains($sell)) {
            $this->sells->add($sell);
            $sell->setSeller($this);
        }

        return $this;
    }

    public function removeSell(Items $sell): static
    {
        if ($this->sells->removeElement($sell)) {
            // set the owning side to null (unless already changed)
            if ($sell->getSeller() === $this) {
                $sell->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Items $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(Items $favorite): static
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Items $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addBuyer($this);
        }

        return $this;
    }

    public function removeOrder(Items $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeBuyer($this);
        }

        return $this;
    }
}
