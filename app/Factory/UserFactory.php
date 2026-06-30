<?php

namespace App\Factory;

use App\Models\User;
use App\Models\Professeur;
use App\Models\Etudiant;
use App\Models\Admin;
use App\Exceptions\ValidationException;

// decide quelle classe instancier
class UserFactory
{
    // creation objet user
    public static function createFromArray(array $data): User
    {
        $user = match ($data['role'] ?? null) {
            'professeur' => new Professeur(
                $data['nom'],
                $data['prenom'],
                $data['email']
            ),
            'etudiant' => new Etudiant(
                $data['nom'],
                $data['prenom'],
                $data['email']
            ),
            'admin' => new Admin(
                $data['nom'],
                $data['prenom'],
                $data['email']
            ),
            default => throw new ValidationException(
                "Rôle inconnu : '" . ($data['role'] ?? 'non défini') . "'"
            ),
        };

        // On réinjecte les champs qui ne passent pas par le constructeur
        if (isset($data['id'])) {
            $user->setId((int) $data['id']);
        }
        if (isset($data['password'])) {
            $user->setPasswordHash($data['password']);
        }
        if (isset($data['actif'])) {
            $user->setActif((bool) $data['actif']);
        }
        if (isset($data['created_at'])) {
            $user->setCreatedAt($data['created_at']);
        }
        if (isset($data['updated_at'])) {
            $user->setUpdatedAt($data['updated_at']);
        }

        return $user;
    }

    // creation de nouvel utilisateur
    public static function createNew(
        string $nom,
        string $prenom,
        string $email,
        string $password,
        string $role
    ): User {
        return match ($role) {
            'professeur' => new Professeur($nom, $prenom, $email, $password),
            'etudiant' => new Etudiant($nom, $prenom, $email, $password),
            'admin' => new Admin($nom, $prenom, $email, $password),
            default => throw new ValidationException("Rôle invalide : '{$role}'"),
        };
    }
}