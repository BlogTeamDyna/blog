<?php

declare(strict_types=1);

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
// OK Supprimer la BDD et la recréer
// Installer la librairie gedmo, configurer gedmo dans config/package/...yaml
// Use gedmo (namespace)
// Créer une nouvelle propriété created_at(type::datetime)
// Jouer les migrations
// Ajouter l'annotation timestampble 
// Créer les getter et setter 

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{


    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING)]

    private string $title;

    #[ORM\Column(type: Types::STRING)]
    private string $description;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private $created_at;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable]
    private $updated;

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
        return $this->created_at;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function __toString()
    {
        return $this->title;
    }
}
