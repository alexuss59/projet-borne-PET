<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Cristaline</title>
    </head>
<body style="text-align: center; font-family: sans-serif; padding-top: 100px;">

    <h1>Connexion à votre compte</h1>
    <h2>Veuillez présenter le QR Code de l'application sous le lecteur lumineux</h2>

    <form action="/borne-ihm-sauvegarde/public/index.php/borne/verifier_scan" method="POST">
        <input type="text" id="qr_code_input" name="qr_code" style="opacity: 0; position: absolute; z-index: -1;" autofocus>
    </form>

    <br>
    <a href="/borne-ihm-sauvegarde/public/index.php" style="padding: 10px 20px; background: red; color: white; text-decoration: none; border-radius: 5px;">Annuler</a>

    <script>
        document.addEventListener('click', function() {
            document.getElementById('qr_code_input').focus();
        });
    </script>
</body>
</html>
