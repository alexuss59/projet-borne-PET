<?php

namespace App\Controllers;

class Home extends BaseController
{
    private string $path_compteur = '/dev/shm/compteur_ecobox.txt';
    private string $path_erreur   = '/dev/shm/ecobox_erreur.txt';

    public function index()
    {
        $etat = $this->_obtenirEtat();
        if ($etat === 'HS') {
            return redirect()->to(site_url('hs'));
        }
        if ($etat === 'PLEINE') {
            return redirect()->to(site_url('pleine'));
        }
        return view('accueil_borne');
    }

    public function depot()
    {
        return view('depot');
    }

    public function depot_anonyme()
    {
        $this->_resetFichiers();
        
        // CORRECTION CRITIQUE : On efface tout ID utilisateur restant en mémoire
        session()->remove('user_id');
        session()->set(['user_nom' => 'Client Anonyme']);

        // RETAIN ACTIF (-r)
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'ACTIVER_BORNE' -r");

        return redirect()->to(site_url('depot'));
    }

    public function ajouter_bouteille()
    {
        $actuel = $this->_lireCompteur();
        file_put_contents($this->path_compteur, $actuel + 1);

        return $this->response->setJSON(['status' => 'ok', 'total' => $actuel + 1]);
    }

    public function signaler_erreur()
    {
        $motif = $this->request->getPost('motif');
        if (empty(trim((string)$motif))) {
            $motif = 'BARCODE_INCONNU';
        }
        file_put_contents($this->path_erreur, $motif);

        return $this->response->setJSON(['status' => 'ok', 'motif' => $motif]);
    }

    public function get_total()
    {
        $total  = $this->_lireCompteur();
        $erreur = $this->_lireErreur();
        
        $etat = $this->_obtenirEtat();

        return $this->response->setJSON([
            'total' => $total, 
            'erreur' => $erreur, 
            'etat' => $etat  // On envoie le statut au Javascript !
        ]);
    }

    public function refus()
    {
        $motif = $this->_lireErreur() ?? 'BARCODE_INCONNU';
        return view('refus', ['motif' => $motif]);
    }

    public function relancer_tapis()
    {
        file_put_contents($this->path_erreur, '');

        // PAS DE RETAIN ICI !
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'STOP_TAPIS'");

        return redirect()->to(site_url('depot'));
    }

    public function finalisation()
    {
        $session = session();
        $total = $this->_lireCompteur();
        $raison = $this->request->getGet('raison');
        $user_nom = $session->get('user_nom') ?? 'Client Anonyme';

        // 1. SI CLIENT IDENTIFIÉ : On envoie les infos à l'API d'Adam
        if ($session->has('user_id') && $total > 0) {
            
            // On charge l'outil HTTP de CodeIgniter
            $client = \Config\Services::curlrequest();

            try {
                // Les données envoyées dans le JSON
                $donnees_api = [
                    'id_utilisateur' => $session->get('user_id'),
                    'id_supermarche' => env('SUPERMARCHE_ID'),
                    'points'         => $total
                ];

                // Envoi de la requête POST vers l'URL définie dans le fichier .env
                $client->post(env('API_URL'), [
                    'json' => $donnees_api,
                    'http_errors' => false // Empêche CodeIgniter de planter si l'API d'Adam répond une erreur (404, 500)
                ]);

            } catch (\Exception $e) {
                // Si le réseau plante, on l'écrit dans les logs en silence
                log_message('error', 'Erreur API Adam : ' . $e->getMessage());
            }
        }

        // 2. ACTIONS PHYSIQUES : On coupe le tapis et on lance l'impression du ticket (MQTT)
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'DESACTIVER_BORNE' -r");
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/imprimer' -m " . escapeshellarg((string)$total));

        // 3. SÉCURITÉ : On remet les compteurs à zéro et on déconnecte le client
        $this->_resetFichiers();
        if ($session->has('user_id') || $session->has('user_nom')) {
            $session->destroy();
        }

        // 4. AFFICHAGE : On redirige vers l'écran de remerciement
        return view('finalisation', [
            'points_session' => $total,
            'user_nom'       => $user_nom,
            'raison'         => $raison
        ]);
    }

    public function fin_de_session()
    {
        // RETAIN ACTIF (-r)
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'DESACTIVER_BORNE' -r");
        $this->_resetFichiers();
        
        // CORRECTION CRITIQUE : Déconnecter l'utilisateur quand il annule
        if (session()->has('user_id') || session()->has('user_nom')) {
            session()->destroy();
        }

        return redirect()->to(site_url('/'));
    }

    private function _lireCompteur(): int
    {
        if (!file_exists($this->path_compteur)) return 0;
        $val = trim(file_get_contents($this->path_compteur));
        return is_numeric($val) ? (int)$val : 0;
    }

    private function _lireErreur(): ?string
    {
        if (!file_exists($this->path_erreur)) return null;
        $val = trim(file_get_contents($this->path_erreur));
        return ($val !== '') ? $val : null;
    }

    public function page_scan()
    {
        return view('scan');
    }

    public function verifier_scan()
    {
        $qr_scanne = $this->request->getPost('qr_code');

        if (empty($qr_scanne)) {
            return redirect()->to(site_url('borne/scan'));
        }

        $db = \Config\Database::connect();
        $builder = $db->table('utilisateur');
        $builder->where('qr_code', $qr_scanne);
        $client_trouve = $builder->get()->getRow();

        if ($client_trouve) {
            session()->set([
                'user_id'  => $client_trouve->id,
                'user_nom' => $client_trouve->prenom . ' ' . $client_trouve->nom
            ]);

            // NOUVEAU : On sauvegarde l'ID du client en RAM !
            file_put_contents('/dev/shm/ecobox_user.txt', $client_trouve->id);

            // RETAIN ACTIF (-r)
            shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'ACTIVER_BORNE' -r");
            $this->_resetFichiers();

            return redirect()->to(site_url('depot'));
        } else {
            return redirect()->to(site_url('/'));
        }
    }

    // Affiche la vue Hors Service
    public function hors_service()
    {
        return view('hs');
    }

    // Affiche la vue Borne Pleine
    public function borne_pleine()
    {
        return view('borne_pleine');
    }

    // Fonction API pour le Javascript (Vérifie si l'ESP32 est là)
    public function check_status()
    {
        $etat = $this->_obtenirEtat();
        return $this->response->setJSON(['etat' => $etat]);
    }

    public function cumuler()
    {
        $session = session();
        $userId = $session->get('user_id');

        // On récupère le vrai nombre de bouteilles en RAM
        $nbBouteilles = $this->_lireCompteur();

        if ($userId && $nbBouteilles > 0) {
            $db = \Config\Database::connect();
            $idBorne = env('BORNE_ID');

            // CORRECTION : On insère une NOUVELLE ligne dans l'historique (depot_user)
            $sql = "INSERT INTO depot_user (points, date_depot, id_utilisateur, id_borne) VALUES (?, NOW(), ?, ?)";
            $db->query($sql, [$nbBouteilles, $userId, $idBorne]);

            // On remet tout à zéro via notre méthode interne
            $this->_resetFichiers();

            // On détruit la session utilisateur pour le déconnecter
            $session->destroy();

            return redirect()->to('/')->with('message', 'Points cumulés avec succès !');
        }

        return redirect()->to('/');
    }

    private function _obtenirEtat(): string
    {
        $path_etat = '/dev/shm/ecobox_etat.txt';
        if (!file_exists($path_etat)) {
            return 'HS'; // Par défaut si non existant (erreur de connexion avec le pont)
        }
        $val = strtoupper(trim(file_get_contents($path_etat)));
        if ($val === 'OK' || $val === 'BORNE_VIDE' || $val === 'BORNE VIDE') {
            return 'OK';
        }
        if ($val === 'HS') {
            return 'HS';
        }
        if (in_array($val, ['PLEIN', 'PLEINE', 'BAC_PLEIN', 'BAC PLEIN', 'FULL'])) {
            return 'PLEINE';
        }
        return 'HS';
    }

    private function _resetFichiers(): void
    {
        file_put_contents($this->path_compteur, '0');
        file_put_contents($this->path_erreur, '');
        // On efface l'utilisateur en mémoire
        file_put_contents('/dev/shm/ecobox_user.txt', '0');
    }
}
