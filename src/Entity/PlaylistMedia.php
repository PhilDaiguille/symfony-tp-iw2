<?php

namespace App\Entity;

use App\Repository\PlaylistMediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistMediaRepository::class)]
class PlaylistMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $addedAt = null;

    #[ORM\ManyToOne(inversedBy: 'playlistMedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?playlist $playlist = null;

    /**
     * @var Collection<int, media>
     */
    #[ORM\OneToMany(targetEntity: media::class, mappedBy: 'playlistMedia')]
    private Collection $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeImmutable $addedAt): static
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getPlaylist(): ?playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Collection<int, media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setPlaylistMedia($this);
        }

        return $this;
    }

    public function removeMedium(media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getPlaylistMedia() === $this) {
                $medium->setPlaylistMedia(null);
            }
        }

        return $this;
    }
}
