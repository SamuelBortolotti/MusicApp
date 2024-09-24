<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'artiste ne peut pas être vide.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "Le nom de l'artiste ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Nom = null;

    /**
     * @var Collection<int, Album>
     */
    #[ORM\OneToMany(targetEntity: Album::class, mappedBy: 'Id_Artiste', orphanRemoval: true)]
    private Collection $Album;

    public function __construct()
    {
        $this->Album = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Album>
     */
    public function getAlbum(): Collection
    {
        return $this->Album;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->Album->contains($album)) {
            $this->Album->add($album);
            $album->setIdArtiste($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->Album->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getIdArtiste() === $this) {
                $album->setIdArtiste(null);
            }
        }

        return $this;
    }
}
