<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Borne – Dépôt bouteille</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/depot.css') ?>">
    <style>
        html, body {
            -webkit-user-select: none;
            user-select: none;
            overscroll-behavior: none;
            touch-action: none;
        }
        a, img, div {
            -webkit-touch-callout: none;
            -webkit-user-drag: none;
        }
    </style>
</head>
<body>

    <div class="top-dashboard">
        <div class="info-card">
            <div class="info-icon">👤</div>
            <div class="info-details">
                <span class="info-label"><?= session()->has('user_id') ? 'Client Connecté' : 'Dépôt Anonyme' ?></span>
                <span class="info-value" id="user-name"><?= session()->get('user_nom') ?? 'Client Anonyme' ?></span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">🧴</div>
            <div class="info-details">
                <span class="info-label">Total Bouteilles</span>
                <span class="info-value" id="solde-valeur">0</span>
            </div>
        </div>
    </div>

    <div id="step-analysis" class="screen">
        <div class="bottle-graphic-area">
            <div class="bottle-glow"></div>
            <div class="bottle-emoji">🧴</div>
            <div class="laser-line-horiz"></div>
        </div>

        <div class="scan-indicator">
            <div class="scan-arrow">▼</div>
            <div class="scan-frame"><div class="scan-text-label">SCAN</div></div>
        </div>

        <div class="text-instruction-block">
            <div class="main-instruction">PRÊT POUR VOTRE BOUTEILLE SUIVANTE</div>
            <div class="sub-instruction">Insérez votre bouteille dans le lecteur ci-dessous.</div>
            <div class="hint-instruction">L'écran de confirmation apparaîtra automatiquement.</div>
        </div>

        <div class="btn-main-wrapper">
            <?php if(session()->has('user_id')): ?>
                <a href="<?= site_url('home/imprimer_bon') ?>" id="btn-terminer-analyse" class="btn-main btn-disabled" style="background-color: #004a99; margin-bottom: 10px;">
                    <span class="btn-main-icon">🧾</span> IMPRIMER MON TICKET
                </a>
                <a href="<?= site_url('home/cumuler') ?>" id="btn-cumuler" class="btn-main btn-disabled" style="background-color: #27ae60;">
                    <span class="btn-main-icon">💳</span> CUMULER SUR MON COMPTE
                </a>
            <?php else: ?>
                <a href="<?= site_url('finalisation') ?>" id="btn-terminer-analyse" class="btn-main btn-disabled" style="background-color: #004a99;">
                    <span class="btn-main-icon">🧾</span> IMPRIMER MON TICKET
                </a>
            <?php endif; ?>

            <a href="<?= site_url('fin_de_session') ?>" id="btn-retour-accueil" class="btn-back">
                <span class="icon">✖</span> ANNULER ET QUITTER
            </a>
        </div>
    </div>

    <div id="step-success" class="screen hidden">
        <div class="success-circle">
            <svg viewBox="0 0 52 52" width="110" height="110">
                <path class="checkmark" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>

        <div class="text-instruction-block">
            <div class="main-instruction" style="color:#00ff88;">BOUTEILLE ACCEPTÉE !</div>
            <div class="sub-instruction">Le dépôt a été comptabilisé.</div>
        </div>

        <div class="btn-main-wrapper">
            <?php if(session()->has('user_id')): ?>
                <a href="<?= site_url('home/imprimer_bon') ?>" class="btn-main" style="background-color: #004a99; margin-bottom: 10px;">
                    <span class="btn-main-icon">🧾</span> IMPRIMER MON TICKET
                </a>
                <a href="<?= site_url('home/cumuler') ?>" class="btn-main" style="background-color: #27ae60;">
                    <span class="btn-main-icon">💳</span> CUMULER SUR MON COMPTE
                </a>
            <?php else: ?>
                <a href="<?= site_url('finalisation') ?>" class="btn-main" style="background-color: #004a99;">
                    <span class="btn-main-icon">🧾</span> IMPRIMER MON TICKET
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        let etat = 'ATTENTE';
        let dernierTotal = -1;
        let timerRetour = null;

        function pollBorne() {
            if (etat === 'REDIRECT_REFUS') return;

            fetch('<?= site_url("get_total") ?>')
                .then(res => res.json())
                .then(data => {
                    if (data.etat === 'HS') {
                        window.location.href = '<?= site_url("hs") ?>';
                        return;
                    }
                    if (dernierTotal === -1) { dernierTotal = data.total; }

                    document.getElementById('solde-valeur').innerText = data.total;

                    const btnAnalyse = document.getElementById('btn-terminer-analyse');
                    const btnCumuler = document.getElementById('btn-cumuler');
                    const btnRetour = document.getElementById('btn-retour-accueil');

                    if (data.total > 0) {
                        if (btnAnalyse) btnAnalyse.classList.remove('btn-disabled');
                        if (btnCumuler) btnCumuler.classList.remove('btn-disabled');
                        if (btnRetour) btnRetour.style.display = 'none';
                    } else {
                        if (btnAnalyse) btnAnalyse.classList.add('btn-disabled');
                        if (btnCumuler) btnCumuler.classList.add('btn-disabled');
                        if (btnRetour) btnRetour.style.display = 'flex';
                    }

                    if (data.erreur) {
                        etat = 'REDIRECT_REFUS';
                        window.location.href = '<?= site_url("refus") ?>';
                        return;
                    }

                    if (data.total > dernierTotal && etat === 'ATTENTE') {
                        etat = 'SUCCES';
                        document.getElementById('step-analysis').classList.add('hidden');
                        document.getElementById('step-success').classList.remove('hidden');
                        dernierTotal = data.total;

                        if (timerRetour) clearTimeout(timerRetour);

                        timerRetour = setTimeout(() => {
                            if (etat === 'SUCCES') {
                                etat = 'ATTENTE';
                                document.getElementById('step-success').classList.add('hidden');
                                document.getElementById('step-analysis').classList.remove('hidden');
                            }
                        }, 2000);
                    }
                })
                .catch(err => console.warn('Attente...'));
        }
        setInterval(pollBorne, 800);
    </script>
</body>
</html>
