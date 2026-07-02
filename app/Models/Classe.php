<?php

namespace App\Models;

use App\Traits\Timestampable;
use App\Exceptions\ValidationException;

// Classe encadré par un professeur
class Classe
{
    use Timestampable;
 
    private ?int $id = null;
    private string $nom;
    private string $codeInvitation;
    private int $professeurId;
    private bool $actif = true;
 
    public function __construct(string $nom, int $professeurId, ?string $codeInvitation = null)
    {
        $this->setNom($nom);
        $this->professeurId = $professeurId;
        $this->codeInvitation = $codeInvitation ?? $this->genererCode();
        $this->initTimestamps();
    }

    // code d'invitation
    private function genererCode(): string
    {
        return strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
    }
 
    public function getId(): ?int 
    { 
        return $this->id; 
    }
    public function getNom(): string 
    { 
        return $this->nom; 
    }
    public function getCodeInvitation(): string 
    { 
        return $this->codeInvitation; 
    }
    public function getProfesseurId(): int 
    { 
        return $this->professeurId; 
    }
    public function isActif(): bool 
    { 
        return $this->actif; 
    }
 
    public function setId(int $id): void 
    { 
        $this->id = $id; 
    }
 
    public function setNom(string $nom): void
    {
        $nom = trim($nom);
        if ($nom === '') {
            throw new ValidationException('Le nom de la classe ne peut pas être vide.');
        }
        $this->nom = $nom;
        $this->touch();
    }
 
    public function setCodeInvitation(string $code): void
    {
        $this->codeInvitation = strtoupper($code);
    }
 
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
        $this->touch();
    }
 
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code_invitation' => $this->codeInvitation,
            'professeur_id' => $this->professeurId,
            'actif'=> $this->actif,
        ];
    }
}