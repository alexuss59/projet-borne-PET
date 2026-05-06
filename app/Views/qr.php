<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<style>
    /* Suga : On crée un design propre pour que le QR code soit le centre de l'attention */
    .qr-badge {
        width: 100%;
        max-width: 350px;
        margin: 30px auto;
        background: white;
        border: 4px solid #333; /* Style BTS : solide et imposant */
        padding: 30px;
        text-align: center;
        box-sizing: border-box;
    }

    .qr-image {
        width: 100%;
        height: auto;
        border: 1px solid #eee;
        margin: 20px 0;
    }

    .user-tag {
        font-family: 'Arial Black', sans-serif;
        font-size: 22px;
        text-transform: uppercase;
        margin-bottom: 5px;
        color: #000;
    }

    .id-subtext {
        font-family: monospace;
        font-size: 14px;
        color: #666;
        word-break: break-all;
    }

    .btn-retour {
        display: block;
        width: 100%;
        padding: 20px;
        background: #333;
        color: white;
        text-decoration: none;
        font-weight: bold;
        margin-top: 20px;
        border: none;
        cursor: pointer;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<div style="text-align: center; margin-top: 50px;">
    <h2 style="font-family: 'Arial Black'; color:rgb(23, 139, 182);">QR CODE</h2>
    <p>Se connecter en tant que <?= $prenom ?></p>
    
    <div id="qrcode_container" style="display: flex; justify-content: center; margin-bottom: 20px;">
        <div id="qrcode"></div>
    </div>

    <p style="font-weight: bold;">ID : <?= $qr_code_user ?></p>
</div>

<script>
    // Jungkook : On génère le QR code avec les données de la session
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "<?= $qr_code_user ?>", // Ton code style user_1769...
        width: 200,
        height: 200,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
</script>

<p style="text-align: center; font-size: 14px; color: #888; padding: 0 20px;color:rgb(23, 139, 182); ">
    Présentez ce code devant le lecteur de la borne de recyclage pour vous connecter a votre compte.
</p>

<?= $this->endSection() ?>