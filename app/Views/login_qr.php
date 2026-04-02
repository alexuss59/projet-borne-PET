<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Identification - Borne PET</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="login-page">

<div class="header">
    <h1>Identification</h1>
    <p>Présentez votre carte ou votre application</p>
</div>

<div class="center-zone">
    <div class="card">
        <h2>Scannez votre QR Code</h2>
        <div class="scan-animation">
            <img src="<?= base_url('assets/img/qr_test.png') ?>" alt="Scanner ici" class="qr-placeholder">
        </div>
        <p>Le dépôt commencera automatiquement après détection.</p>
        
        <input type="text" id="qr-reader" autofocus style="position: absolute; opacity: 0;">
        
        <a href="<?= site_url('/') ?>" class="button secondary">RETOUR</a>
    </div>
</div>

<script>
    const input = document.getElementById('qr-reader');

    // On force le focus sur l'input pour que le Waveshare puisse écrire
    document.addEventListener('click', () => input.focus());
    setInterval(() => { if(document.activeElement !== input) input.focus(); }, 1000);

    // Détection de la fin de saisie (le Waveshare envoie "Entrée" à la fin)
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const qrData = this.value;
            if(qrData.length > 0) {
                // On envoie le code au contrôleur pour vérification
                window.location.href = "<?= site_url('home/verifier_utilisateur/') ?>" + qrData;
            }
        }
    });
</script>

</body>
</html>