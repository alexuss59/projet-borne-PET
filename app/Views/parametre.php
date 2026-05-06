<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Paramètres</title>
    <style>
        /* RM : On stabilise la page pour éviter les glissements bizarres sur tel */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background-color: rgb(243, 242, 232);
            display: flex;
            flex-direction: column;
            overflow-x: hidden; 
        }

        /* Suga : Header compact avec la flèche de retour alignée */
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

        /* J-Hope : Le menu principal avec un padding réduit (de 100px à 20px) */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .box-container {
            width: 100%;
            border: 3px solid #333;
            background: white;
            box-sizing: border-box;
            margin-top: 10px;
        }

        .menu-item {
            font-size: 18px;
            padding: 25px 20px;
            border-bottom: 1px solid #eee;
            text-align: left;
            cursor: pointer;
        }

        /* Jungkook : Style pour le bouton de déconnexion en rouge */
        .logout-item {
            color: #e74c3c; 
            font-weight: bold; 
            border-bottom: none;
        }

        /* Jin : Design des pop-ups (Modales) */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
        }

        .popup-content {
            background: white; 
            padding: 30px 20px; 
            text-align: left; 
            width: 100%; 
            max-width: 400px;
            border: 4px solid #333; 
            box-sizing: border-box;
        }
        
    </style>
</head>

<body>

    <header>
        <a href="<?= base_url('/voir-acceuil') ?>" class="back-nav">
            <span class="arrow-back"></span>
            <span class="header-title">PARAMÈTRES</span>
        </a>
    </header>

    <div class="main-content">
        <div class="box-container">
            <div onclick="toggleSecurity(true)" class="menu-item">
                Sécurité & Données
            </div>
            <div onclick="togglePopup(true)" class="menu-item logout-item">
                Se déconnecter
            </div>
        </div>
    </div>

    <div id="security-popup" class="popup-overlay">
        <div class="popup-content">
            <h2 style="font-size: 24px; color: rgb(70, 146, 55); text-align: center; margin-bottom: 20px;">SÉCURITÉ</h2>

            <div style="font-size: 14px; line-height: 1.4; font-family: sans-serif;">
                <p><strong>🔒 Protection :</strong><br> Tes identifiants sont strictement confidentiels.</p>
                <p><strong>♻️ Données :</strong><br> Elles servent uniquement à comptabiliser tes points.</p>
                <p><strong>🛡️ Droits :</strong><br> Tu peux supprimer ton compte à tout moment.</p>
            </div>

            <button onclick="toggleSecurity(false)" style="width: 100%; margin-top: 20px; padding: 15px; background: #333; color: white; border: none; font-size: 16px; font-family: 'Arial Black';">FERMER</button>
        </div>
    </div>

    <div id="logout-popup" class="popup-overlay">
        <div class="popup-content" style="text-align: center;">
            <div style="font-size: 20px; margin-bottom: 30px; font-weight: bold;">Voulez-vous vous déconnecter ?</div>
            <div style="display: flex; justify-content: space-around;">
                <button onclick="togglePopup(false)" style="color:#333; font-size: 18px; border: none; background: none; cursor: pointer; font-weight: bold;">ANNULER</button>
                <button onclick="window.location.href='<?= base_url('/logout') ?>'" style="color:rgb(70, 146, 55); font-size: 18px; border: none; background: none; cursor: pointer; font-weight: bold;">CONFIRMER</button>
            </div>
        </div>
    </div>

    <script>
        // Jimin : Ouvre ou ferme la section sécurité
        function toggleSecurity(show) {
            document.getElementById('security-popup').style.display = show ? 'flex' : 'none';
        }

        // V : Ouvre ou ferme la confirmation de déconnexion
        function togglePopup(show) {
            document.getElementById('logout-popup').style.display = show ? 'flex' : 'none';
        }
    </script>

</body>
</html>