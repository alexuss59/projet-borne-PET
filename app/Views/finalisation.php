<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Borne Ecobox - Merci</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/depot.css') ?>">
</head>
<body>
    <header class="balance-header">
        <div class="balance-content">
            <span class="balance-label">UTILISATEUR</span>
            <span id="user-name"><?= session()->get('user_nom') ?></span>
        </div>
        <div class="balance-content">
            <span class="balance-label">TOTAL POINTS</span>
            <span id="solde-valeur"><?= esc($points_session) ?></span>
        </div>
    </header>

    <main class="container" style="margin-top: 300px; text-align: center;">
        <h1 style="font-size: 50px; color: white;">MERCI !</h1>
        <p style="font-size: 30px; color: white;">Votre ticket est en cours d'impression...</p>
        <br><br>
        <a href="<?= site_url('fin_de_session') ?>" class="btn-finaliser" style="background-color: #ffcc00; color: #004a99; padding: 30px 60px; font-size: 30px; text-decoration: none; border-radius: 15px; font-weight: bold;">
            RETOUR À L'ACCUEIL
        </a>
    </main>
</body>
</html>
