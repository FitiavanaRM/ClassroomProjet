<?php

namespace App\Models;

class Admin extends User
{
    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        ?string $password = null
    ) {
        parent::__construct($nom, $prenom, $email, $password, 'admin');
    }

    // active ou desactive le compte des Users
    public function changerStatutUtilisateur(User $user, bool $actif): void
    {
        $user->setActif($actif);
    }

    // Dashboard
    public function getDashboard(): array
    {
        return [
            'role'=> 'admin',
            'nom_complet' => $this->getNomComplet(),
            'total_utilisateurs' => 0,
            'total_classes' => 0,
            'message_accueil' => "Bienvenue {$this->getNomComplet()}, voici les statistiques de la plateforme.",
        ];
    }
}