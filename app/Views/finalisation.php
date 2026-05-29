<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Borne Ecobox - Merci</title>
    <!-- Polices premium -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/depot.css') ?>">
</head>
<body>
    <header class="balance-header">
        <div class="balance-content">
            <span class="balance-label">UTILISATEUR</span>
            <span id="user-name"><?= esc($user_nom) ?></span>
        </div>
        <div class="balance-content">
            <span class="balance-label">TOTAL POINTS</span>
            <span id="solde-valeur"><?= esc($points_session) ?></span>
        </div>
    </header>

    <main class="container" style="margin-top: 250px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 20px;">
        
        <?php if (isset($raison) && $raison === 'pleine'): ?>
            <!-- Affichage spécifique si la borne devient pleine au milieu du dépôt -->
            <div style="background: rgba(255, 159, 28, 0.15); border: 2px solid #ff9f1c; padding: 25px; border-radius: 20px; max-width: 600px; width: 90%;">
                <h1 style="font-size: 40px; color: #ff9f1c; font-family: 'Outfit', sans-serif; text-transform: uppercase; margin-bottom: 15px;">Borne saturée !</h1>
                <p style="font-size: 22px; color: white; line-height: 1.5;">
                    Le conteneur est désormais plein. Vos <strong><?= esc($points_session) ?></strong> points ont bien été validés et votre ticket de reçu est en cours d'impression.
                </p>
            </div>
        <?php else: ?>
            <!-- Affichage classique -->
            <h1 style="font-size: 55px; color: white; font-family: 'Outfit', sans-serif;">MERCI !</h1>
            <p style="font-size: 26px; color: white;">Votre ticket est en cours d'impression...</p>
        <?php endif; ?>

        <br><br>
        
        <!-- Le bouton manuel redirige vers la fin de session classique -->
        <a href="<?= site_url('fin_de_session') ?>" class="btn-finaliser" style="background-color: #ffcc00; color: #004a99; padding: 20px 45px; font-size: 22px; text-decoration: none; border-radius: 15px; font-weight: bold; font-family: 'Segoe UI', sans-serif; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
            RETOUR À L'ACCUEIL
        </a>
    </main>

    <!-- Script de redirection automatique après 5 secondes -->
    <script>
        setTimeout(function() {
            <?php if (isset($raison) && $raison === 'pleine'): ?>
                // Redirection directe vers la page borne pleine
                window.location.href = '<?= site_url("pleine") ?>';
            <?php else: ?>
                // Redirection classique de fin de session (remise à zéro et accueil)
                window.location.href = '<?= site_url("fin_de_session") ?>';
            <?php endif; ?>
        }, 5000);
    </script>
</body>
</html>
