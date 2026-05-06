<?php
namespace App\Models;
use CodeIgniter\Model;

class Mbons extends Model {
    protected $DBGroup    = 'supermarche'; 
    protected $table      = 'bon_achat_super'; 
    protected $primaryKey = 'id_super'; 
    
    // Liste exacte des colonnes de ta table locale
    protected $allowedFields = [
        'code_barre', 
        'valeur', 
        'date_creation', 
        'date_validite', 
        'date_utilisation'
    ];

    /**
     * Calcule le checksum EAN-13 et génère le code complet
     */
    public function genererEAN13()
    {
        // 1. On génère 12 chiffres. Le premier est fixé à '3'.
        // mt_rand pour 11 chiffres restants
        $code12 = '3' . str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);

        // 2. Calcul du chiffre de contrôle (Modulo 10)
        $somme = 0;
        for ($i = 0; $i < 12; $i++) {
            // Positions impaires (0, 2, 4...) : poids 1
            // Positions paires (1, 3, 5...) : poids 3
            $somme += ($i % 2 === 0) ? (int)$code12[$i] : (int)$code12[$i] * 3;
        }

        $reste = $somme % 10;
        $checksum = ($reste === 0) ? 0 : 10 - $reste;

        // 3. On retourne les 13 chiffres
        return $code12 . $checksum;
    }

    /**
     * Crée un bon d'achat et l'insère en base
     */
    public function creerBon($id_super, $nb_bouteilles)
    {
        $codeBarre = $this->genererEAN13();
        
        // Calcul de la valeur : 0.02€ par bouteille
        $valeur = $nb_bouteilles * 0.02;

        $data = [
            'code_barre'    => $codeBarre,
            'valeur'        => $valeur,
            'date_creation' => date('Y-m-d H:i:s'),
            // Valide 3 mois (90 jours)
            'date_validite' => date('Y-m-d H:i:s', strtotime('+3 months')),
            'date_utilisation' => null,
            'id_super'      => $id_super
        ];

        // Insertion dans la table
        if ($this->insert($data)) {
            return $data;
        } else {
            throw new \Exception("Erreur lors de l'insertion du bon.");
        }
    }
}