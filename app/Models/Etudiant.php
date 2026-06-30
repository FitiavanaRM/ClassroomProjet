<?php

namespace App\Models;

class Etudiant extends User
{
    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        ?string $password = null
    ) {
        parent::__construct($nom, $prenom, $email, $password, 'etudiant');
    }

    // rejoindre la classe via l'invitation
    public function rejoindreClasse(string $codeInvitation): void
    {
        
    }

    // objet qui presente la rendu du devoir de l'etudiant
    public function rendreDevoir(int $devoirId, string $cheminFichier, ?string $commentaire = null): Rendu
    {
        return new Rendu($devoirId, $this->getId(), $cheminFichier, $commentaire);
    }

    public function getDashboard(): array
    {
        return [
            'role' => 'etudiant',
            'nom_complet' => $this->getNomComplet(),
            'mes_classes' => [],
            'devoirs_a_rendre' => [],
            'mes_notes' => [],
            'message_accueil' => "Bienvenue {$this->getNomComplet()}, voici vos devoirs en attente.",
        ];
    }
}