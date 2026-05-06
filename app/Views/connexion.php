<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Connexion - Cristalline</title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    <style>
        /* RM : Je prépare la scène avec un background stylé pour que l'entrée soit mémorable */
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

        /* Jin : Le container doit être Worldwide Handsome, donc on centre tout parfaitement */
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            /* Suga : J'ai réduit le max-width car 1010px c'est trop large pour un login simple */
            text-align: center;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 32px;
            text-transform: uppercase;
        }

        /* V : On affiche les erreurs avec style, mais on évite le 500% pour ne pas sortir du cadre */
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 2px solid #f5c6cb;
            font-weight: bold;
            width: 100%;
            box-sizing: border-box;
        }

        /* Jungkook : Les inputs sont musclés et prennent toute la place nécessaire (100%) */
        input {
            width: 100%;
            padding: 20px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 18px;
            font-family: sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            position: relative;
        }

        /* Jimin : Un bouton avec une couleur de "Microphone" violet (Borahae!) */
        .btn-login {
            width: 100%;
            padding: 20px 0;
            background-color: #6f42c1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 20px;
            font-weight: 900;
            margin-top: 20px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-create {
            width: 100%;
            padding: 15px 0;
            background-color: transparent;
            color: #6f42c1;
            border: 2px solid #6f42c1;
            border-radius: 4px;
            font-size: 18px;
            font-weight: 900;
            margin-top: 15px;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
            text-transform: uppercase;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            color: #666;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-login:active,
        .btn-create:active {
            transform: scale(0.98);
        }

        /* J-Hope : On cache le bouton "œil" par défaut jusqu'à ce qu'on en ait besoin pour le show */
        /* Suga : On crée un bloc qui contient l'input ET l'œil */
        .password-group {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
            /* RM : Ça centre l'œil verticalement peu importe la hauteur */
            margin: 10px 0;
        }

        /* Jungkook : L'input ne doit plus avoir de margin propre car c'est le groupe qui gère */
        .password-group input {
            margin: 0;
            padding-right: 50px;
            /* Jin : On laisse de la place à droite pour pas que le texte passe sous l'œil */
        }

        /* J-Hope : L'œil se place maintenant par rapport au groupe, pas à toute la page */
        .show-pass-btn {
            position: absolute;
            right: 15px;
            background: none;
            border: none;
            cursor: pointer;
            display: none;
            z-index: 10;
            padding: 0;
            /* RM : Plus besoin de "top" manuel, flexbox fait le travail */
        }

        .eye-icon {
            width: 25px;
            height: auto;
            display: block;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Connexion</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/verifier') ?>" method="post">
            <?= csrf_field() ?>
            <input type="text" name="login" placeholder="IDENTIFIANT" required>

            <div class="password-group">
                <input type="password" id="password" name="password" placeholder="MOT DE PASSE" required oninput="checkInput()">
                <button type="button" id="toggleBtn" class="show-pass-btn" onclick="togglePassword()">
                    <img src="<?= base_url('oeil_fermé.jpg') ?>" id="eyeImg" class="eye-icon" alt="Voir">
                </button>
            </div>

            <button type="submit" class="btn-login">Se Connecter</button>
            <a href="<?= base_url('/creation_compte') ?>" class="btn-create">Créer un compte</a>
            <a href="<?= base_url('/') ?>" class="btn-back">← Retour</a>
        </form>
    </div>

    <script>
        // Jimin : Cette fonction vérifie si on commence à taper pour montrer l'icône
        function checkInput() {
            var passwordInput = document.getElementById("password");
            var toggleBtn = document.getElementById("toggleBtn");
            if (passwordInput.value.length > 0) {
                toggleBtn.style.display = "block";
            } else {
                toggleBtn.style.display = "none";
            }
        }

        // V : On change le type d'input pour révéler le secret, comme un reveal sur scène !
        function togglePassword() {
            var x = document.getElementById("password");
            var img = document.getElementById("eyeImg");

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