<?php

namespace App\Models;

use App\Traits\Timestampable;
use App\Exceptions\ValidationException;

// represente le travail rendu par un étudiant, avec sa note, et correction

class Rendu
{
    use Timestampable;

    private ?int $id = null;
    private int $devoirId;
    private int $etudiantId;
    private ?string $fichier;
    private ?string $commentaire;
    private ?float $note = null;
    private ?string $correction = null;

    public function __construct(int $devoirId, int $etudiantId, ?string $fichier = null, ?string $commentaire = null)
    {
        $this->devoirId = $devoirId;
        $this->etudiantId = $etudiantId;
        $this->fichier = $fichier;
        $this->commentaire = $commentaire;
        $this->initTimestamps();
    }

    public function getId(): ?int 
    { 
        return $this->id;
    }
    public function getDevoirId(): int 
    { 
        return $this->devoirId; 
    }
    public function getEtudiantId(): int 
    { 
        return $this->etudiantId; 
    }
    public function getFichier(): ?string 
    { 
        return $this->fichier; 
    }
    public function getCommentaire(): ?string 
    { 
        return $this->commentaire; 
    }
    public function getNote(): ?float 
    { 
        return $this->note; 
    }
    public function getCorrection(): ?string 
    { 
        return $this->correction; 
    }

    public function setId(int $id): void 
    { 
        $this->id = $id; 
    }
    public function setFichier(string $fichier): void 
    { 
        $this->fichier = $fichier; $this->touch(); 
    }

    // Note
    public function setNote(float $note): void
    {
        if ($note < 0 || $note > 20) {
            throw new ValidationException('La note doit être comprise entre 0 et 20.');
        }
        $this->note = $note;
        $this->touch();
    }

    public function setCorrection(string $correction): void
    {
        $this->correction = trim($correction);
        $this->touch();
    }

    // correction
    public function estCorrige(): bool
    {
        return $this->note !== null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'devoir_id' => $this->devoirId,
            'etudiant_id' => $this->etudiantId,
            'fichier' => $this->fichier,
            'commentaire' => $this->commentaire,
            'note' => $this->note,
            'correction' => $this->correction,
        ];
    }
}