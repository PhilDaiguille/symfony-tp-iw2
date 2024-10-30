<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(enumType: CommentStatusEnum::class)]
    private ?CommentStatusEnum $status = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childComments')]
    private ?self $parentComment = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentComment')]
    private Collection $childComments;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $publisher = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'author')]
    private Collection $authorComment;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?media $media = null;

    public function __construct()
    {
        $this->childComments = new ArrayCollection();
        $this->authorComment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getParentComment(): ?self
    {
        return $this->parentComment;
    }

    public function setParentComment(?self $parentComment): static
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildComments(): Collection
    {
        return $this->childComments;
    }

    public function addChildComment(self $childComment): static
    {
        if (!$this->childComments->contains($childComment)) {
            $this->childComments->add($childComment);
            $childComment->setParentComment($this);
        }

        return $this;
    }

    public function removeChildComment(self $childComment): static
    {
        if ($this->childComments->removeElement($childComment)) {
            // set the owning side to null (unless already changed)
            if ($childComment->getParentComment() === $this) {
                $childComment->setParentComment(null);
            }
        }

        return $this;
    }

    public function getPublisher(): ?User
    {
        return $this->publisher;
    }

    public function setPublisher(?User $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAuthorComment(): Collection
    {
        return $this->authorComment;
    }

    public function addAuthorComment(User $authorComment): static
    {
        if (!$this->authorComment->contains($authorComment)) {
            $this->authorComment->add($authorComment);
            $authorComment->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorComment(User $authorComment): static
    {
        if ($this->authorComment->removeElement($authorComment)) {
            // set the owning side to null (unless already changed)
            if ($authorComment->getAuthor() === $this) {
                $authorComment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getMedia(): ?media
    {
        return $this->media;
    }

    public function setMedia(?media $media): static
    {
        $this->media = $media;

        return $this;
    }
}
