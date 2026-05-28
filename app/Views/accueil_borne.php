<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Accueil Crystarecycle</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        html, body {
            -webkit-user-select: none;
            user-select: none;
            overscroll-behavior: none;
            touch-action: none; /* Bloque tous les gestes de navigation (swipe/zoom) */
        }
        a, img, div {
            -webkit-touch-callout: none;
            -webkit-user-drag: none;
        }
    </style>
</head>
<body>

<div class="header-top">
    BORNE DE COLLECTE CRYSTARECYCLE
</div>

<div class="choices-container">

    <div class="choice-card">
        <div>
            <h2>SANS COMPTE</h2>
            <p>Utilisez la borne librement</p>
            <p class="warning">⚠ Impression du bon obligatoire</p>
        </div>
        <a href="<?= site_url('depot_anonyme') ?>" class="btn-start btn-green">DÉPOSER</a>
    </div>

    <div class="choice-card">
        <div>
            <h2>AVEC COMPTE</h2>
            <p>Identifiez-vous pour cumuler vos points</p>
            <p>✔ Stocker vos points<br>✔ Ou imprimer un bon</p>
        </div>
        <a href="<?= site_url('borne/scan') ?>" class="btn-start btn-blue">S'IDENTIFIER</a>
    </div>

</div>

</body>
</html>
