<?php

namespace App\Models;

use App\Traits\Timestampable;
use App\Exceptions\ValidationException;

class User
{
    use Timestampable;

    private ?int $id = null;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private string $role = 'etudiant';
    private bool $actif = true;

    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        ?string $password = null,
        string $role = 'etudiant'
    ) {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->setRole($role);

        if ($password !== null) {
            $this->setPassword($password);
        }

        $this->initTimestamps();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNomComplet(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
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
            throw new ValidationException('Le nom ne peut pas être vide.');
        }
        $this->nom = $nom;
        $this->touch();
    }

    public function setPrenom(string $prenom): void
    {
        $prenom = trim($prenom);
        if ($prenom === '') {
            throw new ValidationException('Le prénom ne peut pas être vide.');
        }
        $this->prenom = $prenom;
        $this->touch();
    }

    public function setEmail(string $email): void
    {
        $email = trim(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("L'adresse email '{$email}' n'est pas valide.");
        }
        $this->email = $email;
        $this->touch();
    }

    /**
     * Hash automatiquement le mot de passe en clair avant de le stocker.
     * Jamais de mot de passe en clair en mémoire au-delà de cette méthode.
     */
    public function setPassword(string $plainPassword): void
    {
        if (strlen($plainPassword) < 8) {
            throw new ValidationException('Le mot de passe doit contenir au moins 8 caractères.');
        }
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
        $this->touch();
    }

    // réinjecter un hash déjà existant sans le re-hasher
    public function setPasswordHash(string $hash): void
    {
        $this->password = $hash;
    }

    public function setRole(string $role): void
    {
        $rolesValides = ['admin', 'professeur', 'etudiant'];
        if (!in_array($role, $rolesValides, true)) {
            throw new ValidationException("Le rôle '{$role}' n'est pas valide.");
        }
        $this->role = $role;
        $this->touch();
    }

    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
        $this->touch();
    }

    // Verification mot de pass
    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }

    // retour de données
    public function getDashboard(): array
    {
        return [
            'message' => 'Tableau de bord générique — à redéfinir par sous-classe',
        ];
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'nom'    => $this->nom,
            'prenom' => $this->prenom,
            'email'  => $this->email,
            'role'   => $this->role,
            'actif'  => $this->actif,
        ];
    }
}