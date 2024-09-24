<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Playlist')]
    private ?User $User = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la playlist ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de la playlist ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Nom = null;

    /**
     * @var Collection<int, Musique>
     */
    #[ORM\ManyToMany(targetEntity: Musique::class, inversedBy: 'playlists')]
    private Collection $Musique;

    public function __construct()
    {
        $this->Musique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Musique>
     */
    public function getMusique(): Collection
    {
        return $this->Musique;
    }

    public function addMusique(Musique $musique): static
    {
        if (!$this->Musique->contains($musique)) {
            $this->Musique->add($musique);
        }

        return $this;
    }

    public function removeMusique(Musique $musique): static
    {
        $this->Musique->removeElement($musique);

        return $this;
    }
}
