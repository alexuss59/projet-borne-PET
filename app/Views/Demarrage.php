<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bienvenue - Cristalline</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    <style>
        /* RM : On fixe la hauteur pour éviter le scroll bizarre sur mobile */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Arial Black', sans-serif;
            background: linear-gradient(135deg, rgb(52, 153, 131) 0%, rgb(16, 108, 89) 70%);
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Suga : On espace le haut et le bas automatiquement */
            overflow: hidden;
        }

        .header {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center; /* Jin : On centre le logo verticalement dans l'espace du haut */
            padding: 20px;
        }

        .logo-main {
            /* J-Hope : 80% de la largeur du tel pour que ce soit propre */
            width: 80%; 
            max-width: 400px;
            height: auto;
            filter: drop-shadow(0px 15px 25px rgba(0,0,0,0.3));
        }

        .footer-buttons {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 0 40px; /* V : On réduit un peu les marges pour que les boutons respirent */
            box-sizing: border-box;
            margin-bottom: 50px; /* Jimin : On remonte un peu pour éviter la barre iPhone */
        }

        .btn {
            box-sizing: border-box; 
            padding: 20px; /* Jungkook : On réduit le padding interne pour que ça tienne sur l'écran */
            text-align: center;
            font-size: 22px; 
            font-weight: 900;
            text-decoration: none;
            text-transform: uppercase;
            border-radius: 8px; /* Suga : Un petit arrondi c'est plus moderne pour le BTS */
            margin-bottom: 20px;
            transition: 0.3s;
            display: block;
        }

        .btn-violet { 
            background-color: #6f42c1; 
            color: white; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            border: none;
        }

        .btn-transparent { 
            background-color: transparent; 
            color: white; 
            border: 3px solid white;
        }
        
        /* Animation au clic */
        .btn:active { transform: scale(0.95); filter: brightness(0.9); }
    </style>
</head>
<body>

    <div class="header">
        <img src="<?= base_url('favicon.png') ?>?v=<?= time() ?>" alt="Logo Cristalline" class="logo-main">
    </div>

    <div class="footer-buttons">
        <a href="<?= base_url('/login') ?>" class="btn btn-violet">Se Connecter</a>
        <a href="<?= base_url('/creation_compte') ?>" class="btn btn-transparent">Créer un compte</a>
    </div>

</body>
</html>