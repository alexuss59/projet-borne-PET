<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Cristalline</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background-color: rgb(243, 242, 232);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* RM : HEADER - On réduit le padding de 50px à 15px pour gagner de la place */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 2px solid #777;
            background-color: white;
            position: relative;
        }

        /* Suga : Taille des icônes du haut réduite pour mobile */
        .icon-settings,
        .btn-utilisateur {
            width: 30px;
            height: auto;
            cursor: pointer;
        }

        /* Suga : Style de base du logo */
        .logo {
            width: 200px;
            height: auto;
            position: absolute;
            left: 50%;
            top: 46%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            transition: filter 0.3s ease;
            /* RM : Petit effet fluide quand on change de page */
        }

        /* Page Accueil : Vert Cristalline (Déjà configuré) */
        .logo-acceuil {
            filter: invert(42%) sepia(93%) saturate(375%) hue-rotate(65deg) brightness(91%) contrast(85%);
        }

        /* Page Bon : Violet - rgb(23, 139, 182) */
        .logo-bon {
            filter: invert(31%) sepia(84%) saturate(1315%) hue-rotate(235deg) brightness(85%) contrast(92%);
        }

        /* Page QR Code : Bleu - rgb(23, 139, 182) */
        .logo-qr {
            filter: invert(48%) sepia(70%) saturate(2425%) hue-rotate(165deg) brightness(90%) contrast(95%);
        }

        /* Page Plan : Rouge - rgb(157, 29, 29) */
        .logo-plan {
            filter: invert(15%) sepia(95%) saturate(4000%) hue-rotate(355deg) brightness(90%) contrast(100%);
        }

        /* Jimin : NAVIGATION BASSE - On réduit la hauteur pour laisser de la place au contenu */
        nav {
            border-top: 2px solid #333;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 15px 0;
            background: white;
        }

        .nav-icon {
            width: 30px;
            height: auto;
        }

        .bon-large {
            width: 40px;
            /* Jungkook : Le bon reste un peu plus large mais reste discret */
        }

        /* V : Icône active en vert Cristalline */
        .active-page-icon {
            filter: invert(42%) sepia(93%) saturate(375%) hue-rotate(65deg) brightness(91%) contrast(85%) !important;
        }

        /* SECTION CONTENU - Scrollable sur mobile */
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Jin : Pop-ups de déconnexion et sécurité (ajustées pour iPhone) */
        .modal-base {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-inner {
            background: white;
            padding: 30px 20px;
            text-align: center;
            width: 85%;
            max-width: 400px;
            border: 4px solid #333;
            box-sizing: border-box;
        }

        .modal-text {
            font-size: 20px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .modal-btn {
            font-size: 18px;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: bold;
            margin: 0 10px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <header>
        <a href="<?= base_url('/voir-parametres') ?>">
            <img src="<?= base_url('icon_parametres.png') ?>" class="icon-settings <?= ($page_active == 'parametre') ? 'active-page-icon' : '' ?>">
        </a>

        <?php
        $logo_class = 'logo-acceuil'; // Par défaut
        if ($page_active == 'bon') $logo_class = 'logo-bon';
        if ($page_active == 'qr') $logo_class = 'logo-qr';
        if ($page_active == 'plan') $logo_class = 'logo-plan';
        ?>
        <img src="<?= base_url('favicon.png') ?>" class="logo <?= $logo_class ?>">

        <a href="<?= base_url('/voir-utilisateur') ?>">
            <img src="<?= base_url('icon-utilisateur.png') ?>" class="btn-utilisateur <?= ($page_active == 'utlisateur') ? 'active-page-icon' : '' ?>">
        </a>
    </header>

    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <div id="logout-popup" class="modal-base">
        <div class="modal-inner">
            <div class="modal-text">Voulez-vous vous déconnecter ?</div>
            <button onclick="togglePopup(false)" class="modal-btn" style="color:#333;">Annuler</button>
            <button onclick="window.location.href='<?= base_url('/logout') ?>'" class="modal-btn" style="color:rgb(70, 146, 55);">Confirmer</button>
        </div>
    </div>

    <nav>
        <a href="<?= base_url('/voir-qr') ?>">
            <img src="<?= base_url('icon_qr.png') ?>" class="nav-icon <?= ($page_active == 'qr') ? 'active-page-icon' : '' ?>">
        </a>

        <a href="<?= base_url('/voir-bon') ?>">
            <img src="<?= base_url('icon_bon.png') ?>" class="nav-icon bon-large <?= ($page_active == 'bon') ? 'active-page-icon' : '' ?>">
        </a>

        <a href="<?= base_url('/voir-acceuil') ?>">
            <img src="<?= base_url('icon_accueil.png') ?>" class="nav-icon <?= ($page_active == 'acceuil') ? 'active-page-icon' : '' ?>">
        </a>

        <a href="<?= base_url('/voir-plan') ?>">
            <img src="<?= base_url('icon_plan.png') ?>" class="nav-icon <?= ($page_active == 'plan') ? 'active-page-icon' : '' ?>">
        </a>
    </nav>

    <script>
        // J-Hope : Gestion simple des affichages de pop-ups
        function togglePopup(show) {
            document.getElementById('logout-popup').style.display = show ? 'flex' : 'none';
        }

        function toggleSecurity(show) {
            const sec = document.getElementById('security-popup');
            if (sec) sec.style.display = show ? 'flex' : 'none';
        }
    </script>

</body>

</html>