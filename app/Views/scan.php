<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borne – Identification</title>
    <style>
        /* BASE STYLE - Clair et épuré */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f9f4; /* Fond très légèrement vert/gris clair */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            color: #2c3e50;
        }

        /* CARTE CENTRALE BLANCHE */
        .container {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 550px;
            width: 90%;
            border-top: 6px solid #27ae60; /* Ligne verte en haut */
        }

        /* ICONE QR CODE (SVG propre) */
        .qr-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px auto;
            background-color: #eafaf1;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 2px #27ae60;
        }

        .qr-icon svg {
            width: 70px;
            height: 70px;
            fill: #27ae60;
        }

        /* TEXTES */
        h1 {
            margin: 0 0 15px 0;
            font-size: 32px;
            color: #2c3e50;
            font-weight: 700;
        }

        p {
            font-size: 18px;
            color: #7f8c8d;
            line-height: 1.5;
            margin-bottom: 40px;
        }

        /* ZONE DE TEXTE INVISIBLE (Pour la douchette) */
        /* On la rend quasi invisible pour ne pas polluer le design, mais elle reste active */
        input[type="text"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        /* BOUTON ANNULER */
        .btn-retour {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 40px;
            background-color: #ffffff;
            color: #e74c3c;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid #f1f2f6;
            transition: all 0.2s;
        }

        .btn-retour:hover {
            background-color: #fff0f0;
            border-color: #ffcccc;
            color: #c0392b;
        }

        .btn-retour .icon {
            margin-right: 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="qr-icon">
            <svg viewBox="0 0 24 24">
                <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h-3v2h3v-2zm-3 4h3v2h-3v-2zm-2-6h2v2h-2v-2zm-2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm2-2h2v2h-2v-2z"/>
            </svg>
        </div>

        <h1>Identification</h1>
        <p>Veuillez présenter votre QR Code personnel<br>sous le lecteur optique de la borne.</p>

        <form action="<?= site_url('borne/verifier_scan') ?>" method="post">
            <input type="text" name="qr_code" id="qr_code" autofocus autocomplete="off" required>
            <button type="submit" style="display:none;"></button>
        </form>

        <a href="<?= site_url('fin_de_session') ?>" class="btn-retour">
            <span class="icon">✖</span> ANNULER
        </a>
    </div>

    <script>
        // Maintien de l'autofocus si on clique sur l'écran
        document.addEventListener('click', function() {
            document.getElementById('qr_code').focus();
        });
    </script>

</body>
</html>
