<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;

class Login extends BaseController
{
    // RM : Point d'entrée (Page de démarrage)
    public function index()
    {
        // Suga : On vérifie si l'ID est en session
        if (session()->has('user_id')) {
            return redirect()->to(base_url('voir-acceuil'));
        }
        return view('Demarrage');
    }

    public function loginForm()
    {
        return view('connexion');
    }

    public function connexion()
    {
        return view('creation_compte');
    }

    // Suga : Logique de vérification manuelle pour éviter le crash Shield
    public function verifier()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        
        // Jin : On va chercher dans les tables de Shield manuellement
        $user = $db->table('users')
            ->select('users.id, users.username, auth_identities.secret, auth_identities.secret2 as password')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->where('auth_identities.secret', $login)
            ->get()
            ->getRow();

        // RM : On vérifie le mot de passe (Shield utilise password_hash)
        if ($user && password_verify($password, $user->password)) {
            // J-Hope : On crée la session nous-mêmes
            session()->set([
                'user_id'    => $user->id,
                'user_name'  => $user->username,
                'user_email' => $user->secret,
                'isLoggedIn' => true
            ]);
            return redirect()->to(base_url('voir-acceuil'));
        }

        return redirect()->to(base_url('login'))->with('error', 'Identifiant ou mot de passe incorrect');
    }

    // J-Hope : Sauvegarde du profil sans passer par auth()
    public function sauvegarderProfil()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to(base_url('/'));

        $db = \Config\Database::connect();
        $newPwd  = $this->request->getPost('new_password');
        $confPwd = $this->request->getPost('conf_password');

        $dataUser = [
            'username' => $this->request->getPost('prenom') . ' ' . $this->request->getPost('nom'),
        ];

        $db->table('users')->where('id', $userId)->update($dataUser);

        if (!empty($newPwd)) {
            if ($newPwd !== $confPwd) {
                return redirect()->back()->with('error', "Les mots de passe ne correspondent pas");
            }
            // Suga : On hache le mot de passe comme le ferait Shield
            $db->table('auth_identities')
                ->where('user_id', $userId)
                ->update(['secret2' => password_hash($newPwd, PASSWORD_BCRYPT)]);
        }

        return redirect()->to(base_url('voir-utilisateur'))->with('success', 'Profil mis à jour !');
    }

    public function acceuil()
    {
        // RM : Je sécurise l'accès (le "Vigile" du Login)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'))->with('error', 'Veuillez vous connecter.');
        }

        $db = \Config\Database::connect();
        $userId = session()->get('user_id');

        // J-Hope : Je ne récupère que les VRAIS dépôts (points positifs)
        // BTS : Le "where points > 0" évite d'afficher les lignes de retrait des bons d'achat
        $historiqueDepots = $db->table('depot_user')
            ->where('id_utilisateur', $userId)
            ->where('points >', 0)
            ->orderBy('date_depot', 'DESC')
            ->get()
            ->getResultArray();

        // Suga : CALCUL DU NOMBRE TOTAL DE BOUTEILLES DÉPOSÉES
        // BTS : Je fais la somme des points uniquement quand ils sont positifs.
        $queryRecyclage = $db->table('depot_user')
            ->selectSum('points', 'cumul_bouteilles')
            ->where('id_utilisateur', $userId)
            ->where('points >', 0)
            ->get();

        $resultat = $queryRecyclage->getRow();
       
        // Jin : nbPoints devient ton "Score de recyclage" (ex: 36)
        $nbPoints = (int)($resultat->cumul_bouteilles ?? 0);

        // Jungkook : Je recalcule les impacts écologiques sur la base du cumul réel
        $energie = $nbPoints * 3;
        $co2     = $nbPoints * 45;
        $decompo = $nbPoints * 400;
        $petrole = round($nbPoints * 0.06, 2);
        $eau     = $nbPoints * 1.5;

        $impacts = [
            "⚡ Grâce à tes dépôts, on a généré assez d'énergie pour utiliser un PC pendant <strong>$energie heures</strong>!",
            "🌍 Bravo ! Tu as évité l'émission de <strong>$co2 g</strong> de CO2 dans l'atmosphère.",
            "⏳ En recyclant, tu as épargné à la Terre <strong>$decompo ans</strong> de décomposition de plastique.",
            "🛢️ Incroyable : ton geste a permis de préserver <strong>$petrole kg</strong> de pétrole brut.",
            "💧 Super ! Tu as économisé l'équivalent de <strong>$eau litres</strong> d'eau potable.",
            "🍾 Tu as en tout recyclé <strong>$nbPoints</strong> bouteilles, félicitations!"
        ];

        $phraseAleatoire = $impacts[array_rand($impacts)];

        // RM : Je récupère l'objectif de bouteilles défini en session
        $objectifActuel = session()->get('objectif_session') ?? 50;

        // V : J'envoie les données à la vue acceuil.php
        $data = [
            'page_active'      => 'acceuil',
            'nbPoints'         => $nbPoints,
            'phrase_impact'    => $phraseAleatoire,
            'historiqueDepots' => $historiqueDepots,
            'troisDerniers'    => array_slice($historiqueDepots, 0, 3),
            'objectif_actuel'  => $objectifActuel,
            'dateDernier'      => !empty($historiqueDepots) ? $historiqueDepots[0]['date_depot'] : null
        ];

        return view('acceuil', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

    public function bon()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to(base_url('/'));

        $db = \Config\Database::connect();

        $pointsParMagasin = $db->table('depot_user')
            ->select('borne.id_supermarche, SUM(depot_user.points) as total_points')
            ->join('borne', 'borne.id = depot_user.id_borne')
            ->where('depot_user.id_utilisateur', $userId)
            ->groupBy('borne.id_supermarche')
            ->get()
            ->getResultArray();

        $pointsActuels = 0;
        foreach ($pointsParMagasin as $pm) {
            $pointsActuels += $pm['total_points'];
        }

        $data = [
            'page_active'      => 'bon',
            'pointsActuels'    => $pointsActuels,
            'pointsParMagasin' => $pointsParMagasin,
            'supermarches'     => $db->table('supermarche')->get()->getResultArray(),
            'derniersBons'     => $db->table('bon_achat_user')->where('id_utilisateur', $userId)->orderBy('date_creation', 'DESC')->limit(5)->get()->getResult(),
            'historiqueDepots' => $db->table('depot_user')->where('id_utilisateur', $userId)->orderBy('date_depot', 'DESC')->get()->getResultArray()
        ];

        return view('bon', $data);
    }

    public function qr()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to(base_url('/'));

        return view('qr', [
            'qr_code_user' => 'user_' . $userId,
            'prenom'       => session()->get('user_name'),
            'page_active'  => 'qr'
        ]);
    }
    
    // Jungkook : La création de bon (Transactionnel)
    public function creerBon($montant, $idSupermarche)
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to(base_url('/'));

        $db = \Config\Database::connect();
        $pointsARetirer = (float)$montant / 0.02;

        $borne = $db->table('borne')->where('id_supermarche', $idSupermarche)->get()->getRow();

        $db->transStart();
        $db->table('bon_achat_user')->insert([
            'code_barre'     => 'CR-' . strtoupper(substr(md5(uniqid()), 0, 8)),
            'valeur'         => (float)$montant,
            'date_creation'  => date('Y-m-d H:i:s'),
            'id_supermarche' => (int)$idSupermarche,
            'id_utilisateur' => (int)$userId
        ]);

        $db->table('depot_user')->insert([
            'id_utilisateur' => (int)$userId,
            'points'         => -$pointsARetirer,
            'date_depot'     => date('Y-m-d H:i:s'),
            'id_borne'       => $borne->id
        ]);
        $db->transComplete();

        return redirect()->to(base_url('login/bon'))->with('success', 'Bon généré !');
    }

    public function plan()
    {
        $db = \Config\Database::connect();
        $bornes = $db->table('borne')
            ->select('borne.id, borne.niveau, supermarche.nom, supermarche.adresse, supermarche.latitude, supermarche.longitude, SUM(depot_user.points) as total_depots')
            ->join('supermarche', 'supermarche.id = borne.id_supermarche', 'left')
            ->join('depot_user', 'depot_user.id_borne = borne.id', 'left')
            ->groupBy('borne.id')
            ->get()
            ->getResultArray();

        return view('plan', ['page_active' => 'plan', 'bornes' => $bornes]);
    }

    // --- AUTRES MÉTHODES (Gardées telles quelles) ---
    public function parametres() { return view('parametre', ['page_active' => 'parametre']); }
    public function utilisateur() { return view('utilisateur', ['page_active' => 'utilisateur']); }
    public function explications() { return view('explications', ['page_active' => 'acceuil']); }
    public function objectif() { return view('objectif', ['page_active' => 'acceuil']); }
    public function fixerObjectif($valeur) {
        session()->set('objectif_session', $valeur);
        return redirect()->to(base_url('voir-acceuil'));
    }
    // V : Inscription manuelle (Bypass Shield Service pour éviter le crash orange)
    public function enregistrer()
    {
        $db = \Config\Database::connect();
        
        // RM : On récupère les infos du formulaire
        $login  = $this->request->getPost('login');
        $pass   = $this->request->getPost('password');
        $nom    = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');

        // Suga : Protection Honey pot
        if (!empty($this->request->getPost('fake_user'))) {
            return redirect()->to(base_url('/'));
        }

        // Jin : On vérifie si l'identifiant existe déjà
        $existing = $db->table('auth_identities')->where('secret', $login)->get()->getRow();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Cet identifiant est déjà pris.');
        }

        // J-Hope : 1. Insertion dans la table 'users'
        $db->table('users')->insert([
            'username'   => $prenom . ' ' . $nom,
            'active'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $userId = $db->insertID();

        // RM : 2. Insertion dans TA table 'utilisateur' (Colonnes de ton image)
        $db->table('utilisateur')->insert([
            'id'       => $userId, 
            'login'    => $login,
            'password' => password_hash($pass, PASSWORD_BCRYPT),
            'nom'      => $nom,
            'prenom'   => $prenom,
            'qr_code'  => 'user_' . $userId 
        ]);

        // Jungkook : 3. Insertion dans 'auth_identities'
        $db->table('auth_identities')->insert([
            'user_id'    => $userId,
            'type'       => 'email_password',
            'secret'     => $login,
            'secret2'    => password_hash($pass, PASSWORD_BCRYPT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('login'))->with('success', 'Compte créé ! Connectez-vous.');
    }
}