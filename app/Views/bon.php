<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<style>
    /* Suga : J'importe la police Barcode pour que le code-barres s'affiche réellement */
    @import url('https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap');

    .points-display {
        width: 100%;
        border: 3px solid #333;
        background: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        font-size: 24px;
        margin-bottom: 30px;
    }

    .bons-container {
        width: 100%;
        border: 3px solid #333;
        background: white;
        padding: 20px;
        box-sizing: border-box;
        margin-bottom: 30px;
        position: relative;
    }

    .bons-title {
        font-size: 22px;
        margin-bottom: 20px;
        text-decoration: underline;
        font-family: 'Arial Black';
    }

    .bon-item {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        margin-bottom: 15px;
        font-family: sans-serif;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .purple-text {
        color: #6f42c1;
    }

    .big-action-btn {
        width: 92%;
        border: 4px solid #333;
        background: white;
        padding: 70px 12px;
        text-align: center;
        cursor: pointer;
        display: block;
        text-decoration: none;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 23px;
        margin-left: auto;
        margin-right: auto;
    }

    .big-action-btn .btn-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 2;
    }

    .big-action-btn .btn-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 1;
    }

    .big-action-btn .btn-content {
        position: relative;
        z-index: 3;
        font-size: 22px;
        font-family: 'Arial Black';
        text-transform: uppercase;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.9);
        margin-top: -40px;
    }

    .icon-ticket {
        width: 60px;
        height: auto;
        filter: brightness(0) invert(1);
        margin-top: 10px;
    }

    .barcode-visual {
        font-family: 'Libre Barcode 128', cursive;
        font-size: 80px;
        line-height: 1;
        margin: 15px 0;
        color: #000;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        width: 98%;
        border: 4px solid #333;
        padding: 20px 10px;
        position: relative;
        box-sizing: border-box;
    }

    .scroll-container {
        max-height: 50vh;
        overflow-y: auto;
    }

    select,
    input {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        border: 2px solid #333;
        margin-bottom: 15px;
        box-sizing: border-box;
    }
</style>

<div class="points-display">
    <span>Vos points :</span>
    <span class="purple-text"><?= number_format($pointsActuels, 0) ?></span>
</div>

<div class="bons-container" style="padding-bottom: 60px;">
    <div class="bons-title">Derniers bons :</div>
    <?php if (!empty($derniersBons)): ?>
        <?php foreach (array_slice($derniersBons, 0, 3) as $bon): ?>
            <div class="bon-item" onclick="ouvrirDetailsBon(<?= htmlspecialchars(json_encode($bon)) ?>, false)">
                <span style="text-decoration: underline;"><?= date('d/m/Y', strtotime($bon->date_creation)) ?></span>
                <span class="purple-text"><?= number_format($bon->valeur, 2) ?>€</span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bon-item">Aucun bon généré.</div>
    <?php endif; ?>

    <img src="<?= base_url('icon_plus.png') ?>"
        onclick="document.getElementById('modalHistoriqueBons').style.display='flex'"
        style="position: absolute; bottom: -30px; left: 50%; transform: translateX(-50%); width: 60px; cursor: pointer; z-index: 10;">
</div>

<a href="#" class="big-action-btn" onclick="document.getElementById('modalChoixMontant').style.display='flex'; return false;">
    <div class="btn-bg" style="background-image: url('<?= base_url('icon_cadeau.jpg') ?>');"></div>
    <div class="btn-overlay"></div>
    <div class="btn-content">
        <span>Générer un bon</span><br>
        <img src="<?= base_url('icon_bon.png') ?>" class="icon-ticket">
    </div>
</a>

<a href="#" class="big-action-btn" onclick="document.getElementById('modalListeUtilisables').style.display='flex'; return false;">
    <div class="btn-bg" style="background-image: url('<?= base_url('icon_pieces.jpg') ?>');"></div>
    <div class="btn-overlay"></div>
    <div class="btn-content">
        <span>Utiliser un bon</span><br>
        <img src="<?= base_url('icon_bon.png') ?>" class="icon-ticket">
    </div>
</a>

<div id="modalChoixMontant" class="modal-overlay">
    <div class="modal-content" style="text-align: center;">
        <span onclick="document.getElementById('modalChoixMontant').style.display='none'" style="position: absolute; top: 10px; right: 20px; font-size: 40px; cursor: pointer;">&times;</span>
        <h2 style="font-size: 22px; margin-bottom: 20px; font-family: 'Arial Black';">GÉNÉRER UN BON</h2>

        <select id="selectMagasin" onchange="majPointsMax()">
            <option value="">-- Choisir un magasin --</option>
            <?php foreach ($supermarches as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['nom'] ?></option>
            <?php endforeach; ?>
        </select>

        <p style="font-size: 18px; margin-bottom: 15px;">Dispo : <span id="displayPointsMax" style="font-weight: bold; color: rgb(111, 66, 193);">0.00€</span></p>

        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px;">
            <input type="number" id="inputMontant" step="0.01" placeholder="Montant €" oninput="limiterSaisie(this)" style="text-align: center;" disabled>
            <span style="font-size: 24px; font-weight: bold;">€</span>
        </div>

        <button onclick="validerGeneration()" style="width: 100%; padding: 20px; background: rgb(111, 66, 193); color: white; border: 2px solid #333; font-size: 20px; font-family: 'Arial Black'; cursor: pointer;">CONFIRMER</button>
    </div>
</div>

<div id="modalScanner" class="modal-overlay">
    <div class="modal-content" style="text-align: center; width: 98%;">
        <span onclick="retourListeChoix()" style="position: absolute; top: 10px; right: 20px; font-size: 50px; cursor: pointer;">&times;</span>

        <h2 id="titreMagasin" style="font-size: 22px; font-family: 'Arial Black';">MAGASIN</h2>
        <p id="titreMontant" class="purple-text" style="font-size: 32px; font-weight: bold;">0.00€</p>

        <div style="border: 2px dashed #333; padding: 40px 10px; width: 100%; box-sizing: border-box; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div id="barcodeOutput" class="barcode-visual"></div>
            <div id="codeAlphanum" style="font-size: 16px; font-family: monospace; letter-spacing: 3px; font-weight: bold; margin-top: 15px;"></div>
        </div>

        <button onclick="retourListeChoix()" style="width: 100%; padding: 20px; background: #333; color: white; border: none; font-size: 20px; margin-top: 20px;">RETOUR</button>
    </div>
</div>

<div id="modalListeUtilisables" class="modal-overlay">
    <div class="modal-content">
        <span onclick="this.parentElement.parentElement.style.display='none'" style="position: absolute; top: 10px; right: 20px; font-size: 50px; cursor: pointer;">&times;</span>
        <h2 class="bons-title">Choisir un bon :</h2>
        <div class="scroll-container">
            <?php
            // RM : Je retire le filtre 'valide == 1' pour que tes bons s'affichent enfin
            if (!empty($derniersBons)): ?>
                <?php foreach ($derniersBons as $bon):
                    $mag = array_filter($supermarches, function ($s) use ($bon) {
                        return $s['id'] == $bon->id_supermarche;
                    });
                    $nomMag = !empty($mag) ? reset($mag)['nom'] : "Magasin";
                ?>
                    <div class="bon-item" onclick="afficherScanBon('<?= $bon->code_barre ?>', '<?= $nomMag ?>', '<?= number_format($bon->valeur, 2) ?>')">
                        <span style="font-size: 14px;"><?= $nomMag ?> (<?= date('d/m/Y', strtotime($bon->date_creation)) ?>)</span>
                        <span class="purple-text" style="font-weight: bold;"><?= number_format($bon->valeur, 2) ?>€</span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="font-size: 18px; text-align: center; color: #999;">Aucun bon disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="modalHistoriqueBons" class="modal-overlay">
    <div class="modal-content">
        <span onclick="this.parentElement.parentElement.style.display='none'" style="position: absolute; top: 10px; right: 20px; font-size: 50px; cursor: pointer;">&times;</span>
        <h2 class="bons-title">Historique complet</h2>
        <div class="scroll-container">
            <?php foreach ($derniersBons as $bon): ?>
                <div class="bon-item" onclick="ouvrirDetailsBon(<?= htmlspecialchars(json_encode($bon)) ?>, true)">
                    <span><?= date('d/m/Y', strtotime($bon->date_creation)) ?></span>
                    <span class="purple-text"><?= number_format($bon->valeur, 2) ?>€</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="modalDetailsBon" class="modal-overlay">
    <div class="modal-content" style="text-align: center;">
        <span onclick="fermerDetailsVersHistorique()" style="position: absolute; top: 10px; right: 20px; font-size: 40px; cursor: pointer;">&times;</span>
        <div id="contenuDetails"></div>
        <button onclick="fermerDetailsVersHistorique()" style="width: 100%; padding: 20px; background: #333; color: white; border: none; font-size: 20px; margin-top: 20px;">RETOUR</button>
    </div>
</div>

<script>
    // RM : Je récupère les points et magasins
    const pointsParMagasin = <?= json_encode($pointsParMagasin ?? []) ?>;
    const listeSupermarches = <?= json_encode($supermarches ?? []) ?>;
    const VALEUR_POINT = 0.02;
    let vientDeHistoriqueComplet = false;

    // J-Hope : Je mets à jour le solde dispo par magasin
    function majPointsMax() {
        const idMagasin = document.getElementById('selectMagasin').value;
        const input = document.getElementById('inputMontant');
        const display = document.getElementById('displayPointsMax');

        if (idMagasin !== "") {
            const infoPoints = pointsParMagasin.find(m => String(m.id_supermarche) === String(idMagasin));
            const pointsDispos = infoPoints ? parseFloat(infoPoints.total_points) : 0;
            const maxEuroAutorise = (pointsDispos * VALEUR_POINT).toFixed(2);

            input.disabled = false;
            display.innerText = maxEuroAutorise + "€";
            input.dataset.max = maxEuroAutorise;
        } else {
            input.disabled = true;
            input.value = "";
            display.innerText = "0.00€";
            input.dataset.max = 0;
        }
    }

    // Je limite la saisie au solde réel
    function limiterSaisie(input) {
        let val = parseFloat(input.value);
        const maxAutorise = parseFloat(input.dataset.max) || 0;
        if (val > maxAutorise) input.value = maxAutorise;
    }

    //  Je valide la génération du bon
    function validerGeneration() {
        const idMagasin = document.getElementById('selectMagasin').value;
        const montant = parseFloat(document.getElementById('inputMontant').value);
        if (!idMagasin || isNaN(montant) || montant <= 0) {
            alert("Erreur : Vérifie le magasin et le montant !");
            return;
        }
        window.location.href = "<?= base_url('login/creerBon') ?>/" + montant.toFixed(2) + "/" + idMagasin;
    }

    //  J'affiche le code-barres dans le modal scan
    function afficherScanBon(code, magasin, montant) {
        document.getElementById('modalListeUtilisables').style.display = 'none';
        document.getElementById('titreMagasin').innerText = magasin;
        document.getElementById('titreMontant').innerText = montant + "€";
        document.getElementById('barcodeOutput').innerText = code;
        document.getElementById('codeAlphanum').innerText = code;
        document.getElementById('modalScanner').style.display = 'flex';
    }

    function ouvrirDetailsBon(bon, depuisHistoriqueComplet) {
        vientDeHistoriqueComplet = depuisHistoriqueComplet;
        document.getElementById('modalHistoriqueBons').style.display = 'none';
        const supermarche = listeSupermarches.find(s => String(s.id) === String(bon.id_supermarche));
        document.getElementById('contenuDetails').innerHTML = `
            <h2 class="bons-title" style="text-decoration: none;">Détails du bon</h2>
            <p><strong>Magasin :</strong> ${supermarche ? supermarche.nom : "Magasin"}</p>
            <p><strong>Montant :</strong> <span class="purple-text">${parseFloat(bon.valeur).toFixed(2)}€</span></p>
        `;
        document.getElementById('modalDetailsBon').style.display = 'flex';
    }

    function fermerDetailsVersHistorique() {
        document.getElementById('modalDetailsBon').style.display = 'none';
        if (vientDeHistoriqueComplet) document.getElementById('modalHistoriqueBons').style.display = 'flex';
    }

    function retourListeChoix() {
        document.getElementById('modalScanner').style.display = 'none';
        document.getElementById('modalListeUtilisables').style.display = 'flex';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal-overlay') {
            const modals = document.getElementsByClassName('modal-overlay');
            for (let i = 0; i < modals.length; i++) modals[i].style.display = "none";
        }
    }
</script>

<?= $this->endSection() ?>