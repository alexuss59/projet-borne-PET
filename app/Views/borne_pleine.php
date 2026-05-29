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
        <!-- Visualisation animée d'une borne pleine -->
        <div class="visual-wrapper">
            <div class="kiosk-frame">
                <div class="kiosk-screen">
                    <span class="warning-icon">⚠️</span>
                </div>
                <div class="kiosk-body">
                    <!-- Niveau de remplissage animé -->
                    <div class="fill-level"></div>
                    <div class="bottle-grid">
                        <span>🧴</span>
                        <span>🧴</span>
                        <span>🧴</span>
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
                <div class="action-icon">ℹ️</div>
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
