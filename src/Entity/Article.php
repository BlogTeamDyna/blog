<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Commentary::class, orphanRemoval: true)]
    private Collection $commentaries;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'articles')]
    private Collection $tag_id;

    #[ORM\ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
        $this->tag_id = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Commentary>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setArticle($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getArticle() === $this) {
                $commentary->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTagId(): Collection
    {
        return $this->tag_id;
    }

    public function addTagId(Tag $tagId): self
    {
        if (!$this->tag_id->contains($tagId)) {
            $this->tag_id->add($tagId);
        }

        return $this;
    }

    public function removeTagId(Tag $tagId): self
    {
        $this->tag_id->removeElement($tagId);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
