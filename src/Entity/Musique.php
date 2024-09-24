<?php

namespace App\Entity;

use App\Repository\MusiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MusiqueRepository::class)]
class Musique
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la musique ne peut pas être vide.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom de la musique ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $Nom = null;
    
    #[ORM\Column(type: Types::STRING)]
    private ?string $Duree = null;

    /**
     * @var Collection<int, Album>
     */
    #[ORM\ManyToMany(targetEntity: Album::class, mappedBy: 'Album')]
    private Collection $Id_Album;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\ManyToMany(targetEntity: Playlist::class, mappedBy: 'Musique')]
    private Collection $playlists;

    public function __construct()
    {
        $this->Id_Album = new ArrayCollection();
        $this->playlists = new ArrayCollection();
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

    public function getDuree(): ?string
    {
        return $this->Duree;
    }

    public function setDuree(string $Duree): static
    {
        $this->Duree = $Duree;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getIdAlbum(): Collection
    {
        return $this->Id_Album;
    }

    public function addIdAlbum(Album $idAlbum): static
    {
        if (!$this->Id_Album->contains($idAlbum)) {
            $this->Id_Album->add($idAlbum);
            $idAlbum->addAlbum($this);
        }

        return $this;
    }

    public function removeIdAlbum(Album $idAlbum): static
    {
        if ($this->Id_Album->removeElement($idAlbum)) {
            $idAlbum->removeAlbum($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->addMusique($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeMusique($this);
        }

        return $this;
    }
}
