<?php

namespace App\Models;

use App\Traits\Timestampable;
use App\Exceptions\ValidationException;

// Support du cours publié par le professeur
class Cours
{
    use Timestampable;

    private ?int $id = null;
    private string $titre;
    private string $description;
    private ?string $fichier = null;
    private int $classeId;

    public function __construct(string $titre, string $description, int $classeId)
    {
        $this->setTitre($titre);
        $this->description = trim($description);
        $this->classeId = $classeId;
        $this->initTimestamps();
    }

    public function getId(): ?int 
    { 
        return $this->id; 
    }
    public function getTitre(): string 
    { 
        return $this->titre; 
    }
    public function getDescription(): string 
    { 
        return $this->description; 
    }
    public function getFichier(): ?string 
    { 
        return $this->fichier; 
    }
    public function getClasseId(): int 
    { 
        return $this->classeId; 
    }

    public function setId(int $id): void 
    { 
        $this->id = $id; 
    }

    public function setTitre(string $titre): void
    {
        $titre = trim($titre);
        if ($titre === '') {
            throw new ValidationException('Le titre du cours ne peut pas être vide.');
        }
        $this->titre = $titre;
        $this->touch();
    }

    public function setDescription(string $description): void
    {
        $this->description = trim($description);
        $this->touch();
    }

    public function setFichier(?string $nomFichier): void
    {
        $this->fichier = $nomFichier;
        $this->touch();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'fichier' => $this->fichier,
            'classe_id' => $this->classeId,
        ];
    }
}