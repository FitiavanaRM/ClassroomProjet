<?php

namespace App\Models;

use App\Traits\Timestampable;
use App\Exceptions\ValidationException;
use DateTime;

// devoir à rendre avec une date limite

class Devoir
{
    use Timestampable;

    private ?int $id = null;
    private string $titre;
    private string $consigne;
    private DateTime $dateLimite;
    private int $classeId;

    public function __construct(string $titre, string $consigne, string $dateLimite, int $classeId)
    {
        $this->setTitre($titre);
        $this->setConsigne($consigne);
        $this->setDateLimite($dateLimite);
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
    public function getConsigne(): string 
    { 
        return $this->consigne; 
    }
    public function getDateLimite(): DateTime 
    { 
        $this->dateLimite; 
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
            throw new ValidationException('Le titre du devoir ne peut pas être vide.');
        }
        $this->titre = $titre;
        $this->touch();
    }

    public function setConsigne(string $consigne): void
    {
        $consigne = trim($consigne);
        if ($consigne === '') {
            throw new ValidationException('La consigne ne peut pas être vide.');
        }
        $this->consigne = $consigne;
        $this->touch();
    }

    public function setDateLimite(string|DateTime $date): void
    {
        $this->dateLimite = is_string($date) ? new DateTime($date) : $date;
        $this->touch();
    }

    // indique si la date limite est dépassée
    public function estExpire(): bool
    {
        return $this->dateLimite < new DateTime();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'consigne' => $this->consigne,
            'date_limite' => $this->dateLimite->format('Y-m-d H:i:s'),
            'classe_id' => $this->classeId,
        ];
    }
}