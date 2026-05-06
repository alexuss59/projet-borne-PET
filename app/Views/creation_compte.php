<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Créer un compte - Cristalline</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    <style>
        /* RM : On prépare le fond avec le dégradé Cristalline */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Arial Black', sans-serif;
            background: linear-gradient(135deg, rgb(6, 125, 100) 0%, rgb(8, 75, 61) 70%);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        /* Jin : Le container qui contient tout le formulaire BTS */
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 28px;
            text-transform: uppercase;
        }

        /* V : Alerte d'erreur si le mot de passe ne correspond pas par exemple */
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 2px solid #f5c6cb;
            font-weight: bold;
            width: 100%;
            box-sizing: border-box;
        }

        /* Jungkook : Les champs de saisie pour le profil utilisateur */
        input {
            width: 100%;
            padding: 15px;
            margin: 8px 0;
            border: 2px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            font-family: sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            position: relative;
        }

        /* Jimin : Le bouton d'enregistrement avec la couleur fétiche */
        .btn-register {
            width: 100%;
            padding: 18px 0;
            background-color: #6f42c1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 20px;
            font-weight: 900;
            margin-top: 20px;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Arial Black', sans-serif;
        }

        .btn-have-account {
            width: 100%;
            padding: 15px 0;
            background-color: transparent;
            color: #6f42c1;
            border: 2px solid #6f42c1;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 900;
            margin-top: 15px;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
            text-transform: uppercase;
            font-family: 'Arial Black', sans-serif;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* RM : On crée un conteneur pour aligner l'œil parfaitement au milieu de l'input */
        .password-group {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            margin: 8px 0;
        }

        /* Jungkook : On retire la marge de l'input car c'est le groupe qui la gère maintenant */
        .password-group input {
            margin: 0;
            padding-right: 50px;
        }

        /* J-Hope : Plus besoin de "top" en pixels, Flexbox s'occupe du centrage vertical */
        .show-pass-btn {
            position: absolute;
            right: 15px;
            background: none;
            border: none;
            cursor: pointer;
            display: none;
            z-index: 10;
            padding: 0;
        }

        .eye-icon {
            width: 25px;
            height: auto;
            display: block;
        }

        /* Suga : Protection contre les robots (Honey pot) */
        .hidden-trap {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
            z-index: -1;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Créer un compte</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/enregistrer') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>

            <input type="text" class="hidden-trap" name="fake_user">
            <input type="password" class="hidden-trap" name="fake_pass">

            <input type="text" name="nom" placeholder="MON NOM" required>
            <input type="text" name="prenom" placeholder="MON PRÉNOM" required>

            <input type="text" name="login" placeholder="IDENTIFIANT"
                autocomplete="off" spellcheck="false" required>

            <div class="password-group">
                <input type="password" id="password" name="password" placeholder="MOT DE PASSE"
                    autocomplete="new-password" required oninput="checkInput('password', 'toggleBtn1')">
                <button type="button" id="toggleBtn1" class="show-pass-btn" onclick="togglePassword('password', 'eyeImg1')">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" id="eyeImg1" class="eye-icon" alt="Voir">
                </button>
            </div>

            <div class="password-group">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="CONFIRMER MOT DE PASSE"
                    autocomplete="new-password" required oninput="checkInput('password_confirm', 'toggleBtn2')">
                <button type="button" id="toggleBtn2" class="show-pass-btn" onclick="togglePassword('password_confirm', 'eyeImg2')">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" id="eyeImg2" class="eye-icon" alt="Voir">
                </button>
            </div>

            <button type="submit" class="btn-register">S'ENREGISTRER</button>
            <a href="<?= base_url('/login') ?>" class="btn-have-account">J'AI DÉJÀ UN COMPTE</a>
            <a href="<?= base_url('/') ?>" class="btn-back">← Retour</a>
        </form>
    </div>

    <script>
        // RM : On vérifie si l'utilisateur écrit pour montrer l'œil
        function checkInput(inputId, btnId) {
            var input = document.getElementById(inputId);
            var toggleBtn = document.getElementById(btnId);
            if (input.value.length > 0) {
                toggleBtn.style.display = "block";
            } else {
                toggleBtn.style.display = "none";
            }
        }

        // V : On bascule entre texte caché et visible
        function togglePassword(inputId, imgId) {
            var x = document.getElementById(inputId);
            var img = document.getElementById(imgId);
            var imgFerme = "<?= base_url('oeil_fermé.jpg') ?>";
            var imgOuvert = "<?= base_url('ouvert.jpg') ?>";

            if (x.type === "password") {
                x.type = "text";
                img.src = imgOuvert;
            } else {
                x.type = "password";
                img.src = imgFerme;
            }
        }
    </script>

</body>

</html>