<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borne – Hors Service</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #121212; /* Noir profond */
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            text-align: center;
        }

        .warning-icon {
            font-size: 120px;
            margin-bottom: 20px;
            animation: pulse-warning 2s infinite;
        }

        @keyframes pulse-warning {
            0% { transform: scale(1); opacity: 0.8; filter: drop-shadow(0 0 10px #ff9800); }
            50% { transform: scale(1.05); opacity: 1; filter: drop-shadow(0 0 30px #ff3d00); }
            100% { transform: scale(1); opacity: 0.8; filter: drop-shadow(0 0 10px #ff9800); }
        }

        h1 {
            font-size: 50px;
            color: #ff3d00;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0 0 15px 0;
        }

        p {
            font-size: 24px;
            color: #b0bec5;
            max-width: 600px;
            line-height: 1.5;
        }

        .loader {
            margin-top: 50px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid #ff9800;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .status-text {
            margin-top: 15px;
            font-size: 16px;
            color: #78909c;
        }
    </style>
</head>
<body>

    <div class="warning-icon">⚠️</div>
    <h1>Hors Service</h1>
    <p>Cette borne est momentanément indisponible suite à une perte de connexion avec le système de tri.</p>
    
    <div class="loader"></div>
    <div class="status-text">Tentative de reconnexion en cours...</div>

    <script>
        // Ce script demande à CodeIgniter si l'ESP32 est revenu
        function verifierConnexion() {
            fetch('<?= site_url("check_status") ?>')
                .then(res => res.json())
                .then(data => {
                    // Si l'état repasse à "OK", on relance la borne !
                    if (data.etat === 'OK') {
                        window.location.href = '<?= site_url("/") ?>';
                    }
                })
                .catch(err => console.error("Borne injoignable"));
        }

        // On vérifie toutes les 3 secondes
        setInterval(verifierConnexion, 3000);
    </script>

</body>
</html>
