<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="box-container" style="border: 3px solid #333; padding: 35px 25px 60px; position: relative; margin-bottom: 30px; background: white; min-height: 300px; box-sizing: border-box; display: flex; flex-direction: column; width: 100%;">

    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; width: 100%;">
        <span style="font-size: 28px; color: #000; font-family: 'Arial Black', sans-serif; text-transform: uppercase; line-height: 1;">
            dépôts :
        </span>
        <span style="font-size: 28px; color: #000; font-family: sans-serif; font-weight: normal; line-height: 1;">
            <?= $nbPoints ?>
        </span>
    </div>

    <div style="display: flex; flex-direction: column; justify-content: space-around; flex-grow: 1; margin-bottom: 20px; width: 100%;">
        <?php if (!empty($troisDerniers)): ?>
            <?php foreach ($troisDerniers as $depot): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <span style="font-size: 22px; color: #000; font-family: sans-serif; font-weight: normal;">
                        <?= date('d/m/Y', strtotime($depot['date_depot'])) ?>
                    </span>
                    <span style="font-size: 22px; color: #000; font-family: sans-serif; font-weight: normal;color: rgb(70, 146, 55);">
                        <?= $depot['points'] ?> points
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; font-size: 20px; color: #777; margin-top: auto; margin-bottom: auto;">Aucun dépôt</div>
        <?php endif; ?>
    </div>

    <img src="<?= base_url('icon_plus.png') ?>"
        onclick="document.getElementById('modalHistorique').style.display='block'"
        style="position: absolute; bottom: -28px; left: 50%; transform: translateX(-50%); width: 55px; cursor: pointer; z-index: 10;">
</div>

<div id="modalHistorique" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.85);">
    <div style="background-color: white; margin: 10% auto; padding: 25px; border: 3px solid #333; width: 90%; max-height: 80vh; position: relative; display: flex; flex-direction: column;">
        <span onclick="document.getElementById('modalHistorique').style.display='none'"
            style="position: absolute; top: 10px; right: 20px; font-size: 50px; cursor: pointer; line-height: 0.5; z-index: 10;">&times;</span>

        <h2 style="font-family: 'Arial Black', sans-serif; font-size: 24px; margin-bottom: 25px; text-transform: uppercase;">Historique complet</h2>

        <div class="scroll-container" style="overflow-y: auto; flex-grow: 1; padding-right: 5px; -webkit-overflow-scrolling: touch;">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach ($historiqueDepots as $depot): ?>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <span style="font-size: 18px; font-family: sans-serif;"><?= date('d/m/Y', strtotime($depot['date_depot'])) ?></span>
                        <span style="font-size: 18px; font-family: sans-serif; color: rgb(70, 146, 55); font-weight: normal;"><?= $depot['points'] ?> pts</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div style="background: white; border: 3px solid #333; padding: 25px 20px; box-sizing: border-box; width: 100%; min-height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; margin-bottom: 30px;">
    <p style="font-size: 19px; line-height: 1.3; color: #333; font-weight: normal; margin: 0; font-family: sans-serif;">
        <?php if ($nbPoints == 0): ?>
            Vous n'avez fait encore aucun dépôt
        <?php else: ?>
            <?= trim($phrase_impact) ?>
        <?php endif; ?>
    </p>
</div>

<div style="width: 100%; margin-bottom: 20px;">
    <a href="#" onclick="document.getElementById('modalObjectif').style.display='block'; return false;"
        style="display: flex; flex-direction: column; justify-content: center; border: 3px solid #333; padding: 15px; text-decoration: none; color: inherit; background: white; margin-bottom: 30px; min-height: 100px; box-sizing: border-box;">

        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <img src="<?= base_url('succes.png') ?>" style="width: 40px; margin-right: 15px;">
            <span style="font-size: 18px; color: rgb(70, 146, 55); font-weight: 900; text-transform: uppercase; font-family: sans-serif;">
                <?php
                if (isset($objectif_actuel) && $objectif_actuel > 0) {
                    echo ($nbPoints >= $objectif_actuel) ? "Objectif atteint !" : "Objectif : $objectif_actuel";
                } else {
                    echo "pas d'objectif défini";
                }
                ?>
            </span>
        </div>

        <?php if (isset($objectif_actuel) && $objectif_actuel > 0):
            $pourcentage = ($nbPoints / $objectif_actuel) * 100;
            if ($pourcentage > 100) $pourcentage = 100;
        ?>
            <div style="width: 100%; height: 12px; background: #eee; border: 1px solid #333; border-radius: 10px; overflow: hidden;">
                <div style="width: <?= $pourcentage ?>%; height: 100%; background: rgb(70, 146, 55);"></div>
            </div>
        <?php endif; ?>
    </a>

    <a href="<?= base_url('/voir-explications') ?>"
        style="display: flex; align-items: center; justify-content: center; border: 3px solid #333; 
              text-decoration: none; color: white; min-height: 100px; box-sizing: border-box; 
              position: relative; overflow: hidden;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background-image: url('<?= base_url('herbe.jpg') ?>'); 
                    background-size: cover; background-position: center; z-index: 1;">
        </div>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background: rgba(0, 0, 0, 0.3); z-index: 2;">
        </div>
        <div style="position: relative; z-index: 3; display: flex; align-items: center; padding: 15px;">
            <img src="<?= base_url('recyclage.png') ?>" style="width: 45px; margin-right: 15px; filter: brightness(0) invert(1);">
            <span style="font-size: 19px; font-weight: 900; text-transform: uppercase; font-family: 'Arial Black', sans-serif; text-shadow: 2px 2px 5px rgba(0,0,0,0.8);">
                Comprendre CristaRecycle
            </span>
        </div>
    </a>
</div>

<div id="modalObjectif" style="display:none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.85);">
    <div style="background-color: white; margin: 15% auto; padding: 30px; border: 3px solid #333; width: 90%; text-align: center; position: relative;">
        
        <span onclick="document.getElementById('modalObjectif').style.display='none'"
            style="position: absolute; top: 10px; right: 20px; font-size: 50px; cursor: pointer; line-height: 0.5;">&times;</span>

        <h2 style="font-family: 'Arial Black', sans-serif; font-size: 24px; margin-bottom: 20px; text-transform: uppercase;">Fixer un objectif</h2>
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php
            $base = (floor($nbPoints / 10) * 10) + 10;
            if ($nbPoints % 10 == 0 && $nbPoints > 0) {
                $base = $nbPoints + 10;
            }
            if ($nbPoints == 0) {
                $base = 10;
            }
            $paliers = [$base, $base + 10, $base + 20];
            foreach ($paliers as $palier): ?>
                
                <a href="<?= base_url('login/fixerObjectif/' . $palier) ?>"
                    style="display: block; background: rgb(70, 146, 55); margin-left : 16px; color: white; padding: 15px; font-size: 18px; text-decoration: none; font-family: 'Arial Black', sans-serif; border: 2px solid #333; transform: translateX(-15px);">
                    objectif : <?= $palier ?> bouteilles
                </a>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .scroll-container::-webkit-scrollbar {
        display: none;
    }

    .scroll-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<?= $this->endSection() ?>