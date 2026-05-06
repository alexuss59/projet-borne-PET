<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mon Compte - CristaRecycle</title>
    <style>
        /* RM : On prépare le conteneur principal pour le mobile */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background-color: rgb(243, 242, 232);
            display: flex;
            flex-direction: column;
        }

        /* Suga : Header compact avec bouton retour */
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

        /* Jimin : Zone de formulaire scrollable */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .edit-form {
            background: white;
            border: 3px solid #333;
            padding: 20px;
            box-sizing: border-box;
            width: 100%;
        }

        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            color: #777;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-family: 'Arial Black', sans-serif;
            border: 2px solid #eee;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        .input-group input:focus {
            border-color: rgb(70, 146, 55);
            outline: none;
        }

        /* J-Hope : Positionnement des icônes œil pour le mot de passe */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* RM : Conteneur pour aligner l'œil parfaitement au milieu de l'input */
        .password-group {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            /* On garde la même marge que tes input-group */
        }

        /* Jungkook : On retire la marge de l'input et on ajoute du padding à droite */
        .password-group input {
            margin: 0 !important;
            padding-right: 50px !important;
        }

        /* J-Hope : L'œil se centre tout seul verticalement grâce au parent Flex */
        .eye-icon {
            position: absolute;
            right: 15px;
            width: 25px;
            /* Taille réduite pour être plus précise */
            height: auto;
            cursor: pointer;
            z-index: 10;
        }

        /* Jungkook : Bouton de sauvegarde stylé */
        .btn-save {
            width: 100%;
            padding: 20px;
            background-color: rgb(70, 146, 55);
            color: white;
            border: none;
            font-family: 'Arial Black', sans-serif;
            font-size: 18px;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-save:active {
            transform: scale(0.98);
        }

        /* V : Le logo favicon en fond, formaté pour ne pas gêner le scroll */
        .footer-logo {
            margin-top: 20px;
            padding-bottom: 40px;
            text-align: center;
            width: 100%;
        }

        .favicon-img {
            width: 50%;
            max-width: 150px;
            height: auto;
            filter: invert(42%) sepia(93%) saturate(375%) hue-rotate(65deg) brightness(91%) contrast(85%);
        }
    </style>
</head>

<body>

    <header>
        <a href="<?= base_url('/voir-acceuil') ?>" class="back-nav">
            <span class="arrow-back"></span>
            <span class="header-title">COMPTE ET UTILISATEURS</span>
        </a>
    </header>

    <div class="main-content">
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background-color: #e74c3c; color: white; padding: 15px; font-size: 14px; margin-bottom: 20px; border: 2px solid #333; font-weight: bold;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/sauvegarder-profil') ?>" method="post" class="edit-form">

            <div class="input-group">
                <label>Identifiant</label>
                <input type="text" name="login" value="<?= session()->get('login') ?>">
            </div>

            <div class="input-group">
                <label>Nom</label>
                <input type="text" name="nom" value="<?= session()->get('nom') ?>">
            </div>

            <div class="input-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?= session()->get('prenom') ?>">
            </div>

            <hr style="border: 1px solid #333; margin: 30px 0;">

            <div class="input-group">
                <label style="color: #e74c3c;">Ancien mot de passe</label>
                <div class="password-group">
                    <input type="password" name="old_password" id="old_password" style="border: 2px solid #e74c3c;">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" class="eye-icon" onclick="togglePwd('old_password', this)">
                </div>
            </div>

            <div class="input-group">
                <label>Nouveau mot de passe</label>
                <div class="password-group">
                    <input type="password" name="new_password" id="new_password">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" class="eye-icon" onclick="togglePwd('new_password', this)">
                </div>
            </div>

            <div class="input-group">
                <label>Confirmer nouveau mot de passe</label>
                <div class="password-group">
                    <input type="password" name="conf_password" id="conf_password">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" class="eye-icon" onclick="togglePwd('conf_password', this)">
                </div>
            </div>
            <button type="submit" class="btn-save">Mettre à jour</button>
        </form>

        <div class="footer-logo">
            <img src="<?= base_url('favicon.png') ?>" class="favicon-img">
        </div>
    </div>

    <script>
        // RM : Fonction pour basculer la visibilité du mot de passe
        function togglePwd(id, img) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                img.src = "<?= base_url('ouvert.jpg') ?>";
            } else {
                input.type = "password";
                img.src = "<?= base_url('oeil_fermé.jpg') ?>";
            }
        }
    </script>
</body>

</html>