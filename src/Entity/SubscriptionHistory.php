<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $endAt = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: user::class, mappedBy: 'subscriptionHistory')]
    private Collection $subscriptionId;

    public function __construct()
    {
        $this->subscriptionId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getSubscriptionId(): Collection
    {
        return $this->subscriptionId;
    }

    public function addSubscriptionId(user $subscriptionId): static
    {
        if (!$this->subscriptionId->contains($subscriptionId)) {
            $this->subscriptionId->add($subscriptionId);
            $subscriptionId->setSubscriptionHistory($this);
        }

        return $this;
    }

    public function removeSubscriptionId(user $subscriptionId): static
    {
        if ($this->subscriptionId->removeElement($subscriptionId)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionId->getSubscriptionHistory() === $this) {
                $subscriptionId->setSubscriptionHistory(null);
            }
        }

        return $this;
    }
}
