<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Borne – Bouteille Refusée</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/refus.css') ?>">
</head>
<body>

    <header class="header-error">
        <div class="header-content">
            <div class="icon-circle-white">✖</div>
            <div class="header-text">
                <h1>Bouteille refusée</h1>
                <p>Cette bouteille ne peut pas être acceptée</p>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="error-main-visual">
            <div class="error-circle">
                <span class="cross">✖</span>
            </div>
            <h2>Oups !</h2>
        </div>

        <div class="alert-card">
            <div class="alert-title">
                <img src="https://img.icons8.com/color/48/warning-shield.png" alt="Alerte">
                <h3>
                    <?php 
                        if ($motif == 'FRAUDE') echo "Action suspecte détectée";
                        elseif ($motif == 'TIMEOUT_CONVOYEUR') echo "Bouteille bloquée";
                        else echo "Code-barres non reconnu"; 
                    ?>
                </h3>
            </div>
            <p>
                <?php 
                    if ($motif == 'FRAUDE') {
                        echo "Le système a détecté un retrait de la bouteille pendant le transport. Veuillez ne pas retenir la bouteille.";
                    } elseif ($motif == 'TIMEOUT_CONVOYEUR') {
                        echo "Le convoyeur a mis trop de temps à transporter la bouteille. Vérifiez qu'elle ne soit pas coincée.";
                    } else {
                        echo "Le code-barres n'est pas dans notre base de données ou la bouteille ne correspond pas aux critères acceptés.";
                    }
                ?>
            </p>
        </div>

        <a href="<?= site_url('relancer_tapis') ?>" style="text-decoration: none; color: inherit;">
            <div class="help-card interactive">
                <h3><span class="icon-undo">↺</span> Que faire ?</h3>
                <ul>
                    <li>Vérifiez que la bouteille est en <strong>PET transparent</strong></li>
                    <li>Assurez-vous que le code-barres est <strong>visible</strong> et non endommagé</li>
                    <li><strong>Récupérez votre bouteille dans le bac de rejet</strong></li>
                </ul>
                <div style="text-align: center; margin-top: 15px;">
                    <button class="btn-retour" style="cursor: pointer;">RÉESSAYER</button>
                </div>
            </div>
        </a>
    </main>

    <script>
        setTimeout(function() {
            window.location.href = '<?= site_url('relancer_tapis') ?>';
        }, 12000); // Retour au dépôt après 12 secondes d'inactivité
    </script>

</body>
</html>
