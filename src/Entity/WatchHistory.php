<?php

namespace App\Entity;

use App\Repository\WatchHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchHistoryRepository::class)]
class WatchHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastWatchedAt = null;

    #[ORM\Column]
    private ?int $numberOfViews = null;

    #[ORM\ManyToOne(inversedBy: 'watchHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $watcher = null;

    #[ORM\ManyToOne(inversedBy: 'watchHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastWatchedAt(): ?\DateTimeImmutable
    {
        return $this->lastWatchedAt;
    }

    public function setLastWatchedAt(\DateTimeImmutable $lastWatchedAt): static
    {
        $this->lastWatchedAt = $lastWatchedAt;

        return $this;
    }

    public function getNumberOfViews(): ?int
    {
        return $this->numberOfViews;
    }

    public function setNumberOfViews(int $numberOfViews): static
    {
        $this->numberOfViews = $numberOfViews;

        return $this;
    }

    public function getWatcher(): ?User
    {
        return $this->watcher;
    }

    public function setWatcher(?User $watcher): static
    {
        $this->watcher = $watcher;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }
}
