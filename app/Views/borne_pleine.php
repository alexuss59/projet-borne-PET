<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borne Pleine – Ecobox</title>
    <!-- Chargement de polices Google Fonts premium -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/pleine.css') ?>">
</head>
<body>

    <div class="full-container">
        <!-- Visualisation animée d'une borne pleine (Vectorielle) -->
        <div class="visual-wrapper">
            <div class="kiosk-frame">
                <div class="kiosk-screen">
                    <svg viewBox="0 0 24 24" class="warning-svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <div class="kiosk-body">
                    <!-- Niveau de remplissage animé -->
                    <div class="fill-level"></div>
                    <div class="bottle-grid">
                        <div class="bottle-item">
                            <svg viewBox="0 0 24 24" class="bottle-svg">
                                <rect x="10" y="2" width="4" height="2" rx="0.5" fill="currentColor"/>
                                <path d="M10 4h4v3h-4V4z" fill="currentColor"/>
                                <path d="M8 9.5a2.5 2.5 0 0 1 2.5-2.5h3a2.5 2.5 0 0 1 2.5 2.5V20a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V9.5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M9 11h6M9 15h6" stroke="currentColor" stroke-width="1" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="bottle-item">
                            <svg viewBox="0 0 24 24" class="bottle-svg">
                                <rect x="10" y="2" width="4" height="2" rx="0.5" fill="currentColor"/>
                                <path d="M10 4h4v3h-4V4z" fill="currentColor"/>
                                <path d="M8 9.5a2.5 2.5 0 0 1 2.5-2.5h3a2.5 2.5 0 0 1 2.5 2.5V20a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V9.5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M9 11h6M9 15h6" stroke="currentColor" stroke-width="1" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="bottle-item">
                            <svg viewBox="0 0 24 24" class="bottle-svg">
                                <rect x="10" y="2" width="4" height="2" rx="0.5" fill="currentColor"/>
                                <path d="M10 4h4v3h-4V4z" fill="currentColor"/>
                                <path d="M8 9.5a2.5 2.5 0 0 1 2.5-2.5h3a2.5 2.5 0 0 1 2.5 2.5V20a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V9.5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M9 11h6M9 15h6" stroke="currentColor" stroke-width="1" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="radial-glow"></div>
        </div>

        <!-- Contenu explicatif vitreux (glassmorphism) -->
        <div class="content-card">
            <h1>Borne de collecte pleine</h1>
            <p class="instruction-main">Le conteneur a atteint sa capacité maximale.</p>
            <p class="instruction-sub">
                Afin de garantir le bon fonctionnement du mécanisme, les dépôts sont temporairement suspendus. Un technicien a été alerté pour procéder au vidage.
            </p>

            <div class="info-action">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24" class="info-svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                </div>
                <div class="action-text">Merci de bien vouloir conserver vos bouteilles pour un prochain dépôt ou d'utiliser une borne adjacente.</div>
            </div>
            
            <div class="status-indicator">
                <div class="pulse-ring"></div>
                <span class="status-label">En attente de vidage...</span>
            </div>

            <div class="connexion-check">
                <div class="spinner-mini"></div>
                <span class="check-text">Vérification automatique en cours</span>
            </div>
        </div>
    </div>

    <script>
        // Interrogation automatique de l'état de la borne
        function verifierStatut() {
            fetch('<?= site_url("check_status") ?>')
                .then(res => res.json())
                .then(data => {
                    // Si l'état repasse à OK, on redirige vers l'accueil
                    if (data.etat === 'OK') {
                        window.location.href = '<?= site_url("/") ?>';
                    }
                })
                .catch(err => console.warn("L'IHM n'arrive pas à joindre le serveur."));
        }

        // Scrutation toutes les 3 secondes
        setInterval(verifierStatut, 3000);
    </script>

</body>
</html>
