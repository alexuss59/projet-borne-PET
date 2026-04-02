<?php
namespace App\Controllers;

class Home extends BaseController
{
    private string $path_compteur = '/dev/shm/compteur_ecobox.txt';
    private string $path_erreur   = '/dev/shm/ecobox_erreur.txt';

    public function index() { return view('accueil_borne'); }
    public function depot() { return view('depot'); }

    public function depot_anonyme() {
        $this->_resetFichiers();
        session()->set(['user_nom' => 'Client Anonyme']);
        // RETAIN ACTIF (-r)
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'ACTIVER_BORNE' -r");
        return redirect()->to(site_url('depot'));
    }

    public function ajouter_bouteille() {
        $actuel = $this->_lireCompteur();
        file_put_contents($this->path_compteur, $actuel + 1);
        return $this->response->setJSON(['status' => 'ok', 'total' => $actuel + 1]);
    }

    public function signaler_erreur() {
        $motif = $this->request->getPost('motif');
        if (empty(trim((string)$motif))) {
            $motif = 'BARCODE_INCONNU';
        }
        file_put_contents($this->path_erreur, $motif);
        return $this->response->setJSON(['status' => 'ok', 'motif' => $motif]);
    }

    public function get_total() {
        $total  = $this->_lireCompteur();
        $erreur = $this->_lireErreur();
        return $this->response->setJSON(['total' => $total, 'erreur' => $erreur]);
    }

    public function refus() {
        $motif = $this->_lireErreur() ?? 'BARCODE_INCONNU';
        return view('refus', ['motif' => $motif]);
    }

    public function relancer_tapis() {
        file_put_contents($this->path_erreur, '');
        // PAS DE RETAIN ICI !
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'STOP_TAPIS'");
        return redirect()->to(site_url('depot'));
    }

    public function finalisation() {
        $total = $this->_lireCompteur();
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'DESACTIVER_BORNE' -r");
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/imprimer' -m " . escapeshellarg((string)$total));
        return view('finalisation', ['points_session' => $total]);
    }

    public function fin_de_session() {
        // RETAIN ACTIF (-r)
        shell_exec("/usr/bin/mosquitto_pub -h 127.0.0.1 -t 'ecobox/action' -m 'DESACTIVER_BORNE' -r");
        $this->_resetFichiers();
        return redirect()->to(site_url('/'));
    }

    private function _lireCompteur(): int {
        if (!file_exists($this->path_compteur)) return 0;
        $val = trim(file_get_contents($this->path_compteur));
        return is_numeric($val) ? (int)$val : 0;
    }

    private function _lireErreur(): ?string {
        if (!file_exists($this->path_erreur)) return null;
        $val = trim(file_get_contents($this->path_erreur));
        return ($val !== '') ? $val : null;
    }

    public function page_scan() {
        return view('scan');
    }

    public function verifier_scan() {
        $qr_scanne = $this->request->getPost('qr_code');

        if (empty($qr_scanne)) {
            return redirect()->to(site_url('borne/scan'));
        }

        $db = \Config\Database::connect();
        
        $builder = $db->table('utilisateur');
        $builder->where('qr_code', $qr_scanne);
        $client_trouve = $builder->get()->getRow();

        if ($client_trouve) {
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

    private function _resetFichiers(): void {
        file_put_contents($this->path_compteur, '0');
        file_put_contents($this->path_erreur, '');
        // On efface l'utilisateur en mémoire
        file_put_contents('/dev/shm/ecobox_user.txt', '0');
    }
}
