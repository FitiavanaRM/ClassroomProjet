<?php

namespace App\Models;

class Professeur extends User
{
    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        ?string $password = null
    ) {
        parent::__construct($nom, $prenom, $email, $password, 'professeur');
    }

    // creation nouvel objet Cours rattaché à ce 
    public function creerCours(string $titre, string $description, int $classeId): Cours
    {
        return new Cours($titre, $description, $classeId);
    }

    // creation devoir
    public function creerDevoir(string $titre, string $consigne, string $dateLimite, int $classeId): Devoir
    {
        return new Devoir($titre, $consigne, $dateLimite, $classeId);
    }

    // note
    public function noterDevoir(Rendu $rendu, float $note, ?string $correction = null): void
    {
        $rendu->setNote($note);
        if ($correction !== null) {
            $rendu->setCorrection($correction);
        }
    }

    public function getDashboard(): array
    {
        return [
            'role' => 'professeur',
            'nom_complet' => $this->getNomComplet(),
            'mes_classes' => [],
            'devoirs_a_corriger'=> [],
            'message_accueil' => "Bienvenue {$this->getNomComplet()}, voici vos classes.",
        ];
    }
}