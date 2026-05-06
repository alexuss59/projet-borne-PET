<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Msupermarche;
use App\Models\Mbons;

class BonsAchat extends ResourceController
{
    protected $format = 'json';

    public function genererBon()
    {
        // 1. Récupération du jeton envoyé dans le Header "Authorization"
        $tokenEnvoie = $this->request->getHeaderLine('Authorization');

        if (empty($tokenEnvoie)) {
            return $this->failUnauthorized('Header Authorization manquant.');
        }

        // 2. Vérification du supermarché dans la BDD
        $mSuper = new Msupermarche();
        
        // CORRECTION FINALE : Utilisation du nom exact de ta colonne BDD
        $supermarche = $mSuper->where('jeton_api_super', $tokenEnvoie)->first();

        if (!$supermarche) {
            return $this->failUnauthorized("Accès refusé : Jeton invalide.");
        }

        // 3. Récupération des données du Body (Postman)
        $id_supermarche = $this->request->getPost('id_supermarche');
        $nb_bouteilles   = $this->request->getPost('nb_bouteilles');

        if (!$id_supermarche || !$nb_bouteilles) {
            return $this->fail("Données incomplètes (id_supermarche ou nb_bouteilles).");
        }

        // 4. Insertion du bon d'achat via le modèle Mbons
        $mBons = new Mbons();
        try {
            $nouveauBon = $mBons->creerBon($id_supermarche, $nb_bouteilles);

            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Bon d\'achat généré avec succès',
                'details' => $nouveauBon
            ]);
            
        } catch (\Exception $e) {
            return $this->failServerError('Erreur lors de la création : ' . $e->getMessage());
        }
    }
}