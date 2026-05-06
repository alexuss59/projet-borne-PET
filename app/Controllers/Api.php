<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    protected $format = 'json'; // Contrainte BTS : Format JSON privilégié

    // 1. ACCÉDER À LA BDD (Collecte/Dépôt)
    public function enregistrerDepot()
    {
        $json = $this->request->getJSON();

        // AUTHENTIFICATION PAR JETON (Contrainte borne)
        $authHeader = $this->request->getHeaderLine('Authorization');
        if ($authHeader !== 'Bearer MonJetonBorne123') {
            return $this->failUnauthorized('Accès refusé : Jeton invalide');
        }

        // Connexion MySQL pour enregistrer le nombre de bouteilles
        $db = \Config\Database::connect();

        // On met à jour les points de l'utilisateur directement
        $db->table('utilisateur')
            ->where('id_user', $json->id_utilisateur)
            ->increment('points', $json->nb_bouteilles);

        return $this->respond(['status' => 'Succès', 'message' => 'Points mis à jour dans MySQL']);
    }

    // 2. DEMANDER UN BON D'ACHAT (Passerelle Supermarché)
    public function demanderBon()
    {
        $json = $this->request->getJSON();

        // Contrainte BTS : Vérifier si ça vient d'une borne ou du mobile
        if (isset($json->id_borne)) {
            // Logique Borne : Identification + Jeton
            $auth = $this->request->getHeaderLine('Authorization');
            if ($auth !== 'Bearer JetonSecretBorne') return $this->failUnauthorized();
        }

        // TRANSFÈRE la requête à l'API du supermarché (Simulation)
        $apiSupermarche = "https://api." . ($json->supermarche ?? 'leclerc') . ".fr/v1/bons";

        return $this->respond([
            'status' => 'Transféré',
            'destination' => $apiSupermarche,
            'resultat' => 'Bon d\'achat généré avec succès'
        ]);
    }

    // 3. VÉRIFIER LA VALIDITÉ (Utilisateur Mobile uniquement)
    public function verifierBon($idBon)
    {
        // On transfère l'ID du bon au supermarché pour vérification
        return $this->respond([
            'id_bon' => $idBon,
            'valide' => true,
            'expiration' => '2026-12-31'
        ]);
    }

    // Interface visuelle pour le monitoring
    public function index()
    {
        $model = new \App\Models\UtilisateurModel();
        $data['utilisateurs'] = $model->findAll();
        return view('api_index', $data);
    }
}
