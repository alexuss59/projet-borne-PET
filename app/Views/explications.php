<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Explications - CristaRecycle</title>
    <style>
        /* RM : Mise en page globale avec un fond doux pour la lecture */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background-color: rgb(243, 242, 232);
            display: flex;
            flex-direction: column;
        }

        /* Suga : Header fixe avec bouton retour */
        header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
            border-bottom: 2px solid #777;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-nav {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
        }

        .arrow-back {
            width: 12px;
            height: 12px;
            border-left: 4px solid black;
            border-bottom: 4px solid black;
            transform: rotate(45deg);
            margin-right: 15px;
            display: inline-block;
        }

        .header-title {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: white;
            border: 3px solid #333;
            padding: 20px;
            box-sizing: border-box;
            width: 100%;
        }

        .info-card h2 {
            font-size: 22px;
            color: rgb(70, 146, 55);
            margin-top: 0;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .info-card p {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            font-family: sans-serif;
            font-weight: normal;
            margin-bottom: 0;
        }
        .highlight {
            color: rgb(111, 66, 193);
            font-weight: bold;
        }

        /* V : Le logo de fond */
        .footer-logo {
            margin-top: -60px; 
            padding-bottom: 40px;
            text-align: center;
            width: 100%;
            pointer-events: none;
        }

        .favicon-img {
            width: 60%; 
            max-width: 240px;
            height: auto;
            filter: invert(48%) sepia(13%) saturate(2304%) hue-rotate(69deg) brightness(95%) contrast(85%);
            pointer-events: none;
            user-select: none;
        }

        .btn-action {
            width: 100%;
            padding: 20px;
            background-color: rgb(70, 146, 55);
            color: white;
            text-align: center;
            text-decoration: none;
            font-family: 'Arial Black', sans-serif;
            font-size: 20px;
            text-transform: uppercase;
            border: 3px solid #333;
            margin-top: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <header>
        <a href="<?= base_url('/voir-acceuil') ?>" class="back-nav">
            <span class="arrow-back"></span>
            <span class="header-title">COMPRENDRE LE PROJET</span>
        </a>
    </header>

    <div class="main-content">
        
        <div class="info-card">
            <h2>Pourquoi CristaRecycle ?</h2>
            <p>
                Chaque année, des millions de bouteilles en plastique finissent dans la nature. 
                <span class="highlight">CristaRecycle</span> récompense votre engagement. 
                Nous transformons vos déchets en <span class="highlight">avantages concrets</span>.
            </p>
        </div>

        <div class="info-card">
            <h2>Comment ça marche ?</h2>
            <p>
                Déposez vos bouteilles, scannez votre QR code et cumulez des points. 
                Atteignez vos <span class="highlight">objectifs</span> et générez des bons de réduction.
            </p>
        </div>

        <div class="info-card">
            <h2>Les Enjeux ?</h2>
            <p>Le recyclage limite l'épuisement des ressources et la pollution des océans en 
                <span class="highlight">transformant nos déchets en ressources</span>.
            </p>
        </div>

        <a href="<?= base_url('/voir-acceuil') ?>" class="btn-action">J'ai compris !</a>

        <div class="footer-logo">
            <img src="<?= base_url('favicon.png') ?>" class="favicon-img">
        </div>
    </div>

</body>
</html>