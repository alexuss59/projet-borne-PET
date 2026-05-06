<?php

namespace App\Controllers;

// ARMY : RM s'assure que cette zone est protégée (Zone sécurisée)
class Dashboard extends BaseController
{
    public function index()
    {
        // Je récupère l'objet session pour vérifier les droits d'accès
        $session = session();

        // Contrôle d'accès : Si le témoin "isLoggedIn" est absent
        if (!$session->get('isLoggedIn')) {
            // Suga bloque l'entrée et redirige vers le login (racine)
            return redirect()->to('/');
        }

        // Si l'utilisateur est bien connecté (V et Jimin valident)
        // IMPORTANT : Change 'acceuil' par une vue de tableau de bord
        // Pour l'instant, on met 'welcome_message' pour tester l'accès
        return view('welcome_message'); 
    }
}