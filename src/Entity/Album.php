<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'album ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de l'album ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Nom = null;

    /**
     * @var Collection<int, Musique>
     */
    #[ORM\ManyToMany(targetEntity: Musique::class, inversedBy: 'Id_Album')]
    private Collection $Album;

    #[ORM\ManyToOne(inversedBy: 'Album')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artiste $Id_Artiste = null;

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
     * @return Collection<int, Musique>
     */
    public function getAlbum(): Collection
    {
        return $this->Album;
    }

    public function addAlbum(Musique $album): static
    {
        if (!$this->Album->contains($album)) {
            $this->Album->add($album);
        }

        return $this;
    }

    public function removeAlbum(Musique $album): static
    {
        $this->Album->removeElement($album);

        return $this;
    }

    public function getIdArtiste(): ?Artiste
    {
        return $this->Id_Artiste;
    }

    public function setIdArtiste(?Artiste $Id_Artiste): static
    {
        $this->Id_Artiste = $Id_Artiste;

        return $this;
    }
}
