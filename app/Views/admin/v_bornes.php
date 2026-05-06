<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Bornes (<?= count($bornes) ?>)</h6>
            </div>
            <div class="card-body">

                <!-- Liste des bornes -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Niveau</th>
                                <th>Supermarché</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bornes)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucune borne</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($bornes as $borne): ?>
                                    <tr>
                                        <td><?= esc($borne['id']) ?></td>
                                        <td><?= $borne['niveau'] !== null ? esc($borne['niveau']) . ' %' : '-' ?></td>
                                        <td>
                                            <strong><?= esc($borne['nom_supermarche'] ?? '-') ?></strong><br>
                                            <small class="text-muted">ID: <?= esc($borne['id_supermarche'] ?? '-') ?></small>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('Cadmin/bornes?id='.$borne['id']) ?>"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            <a href="<?= base_url('Cadmin/deleteBorne/'.$borne['id']) ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Supprimer cette borne ?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // borne à éditer si ?id= dans l'URL
                $edit = null;
                if (isset($_GET['id'])) {
                    foreach ($bornes as $borne) {
                        if ($borne['id'] == $_GET['id']) {
                            $edit = $borne;
                            break;
                        }
                    }
                }
                ?>

                <!-- Formulaire -->
                <h6 class="font-weight-bold mb-3">
                    <?= $edit ? 'Modifier borne #' . $edit['id'] : 'Ajouter une borne' ?>
                </h6>

                <form method="post" action="<?= base_url('Cadmin/saveBorne') ?>">
                    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Niveau (%)</label>
                            <input type="number" name="niveau" class="form-control"
                                   min="0" max="100" step="1"
                                   value="<?= $edit['niveau'] ?? '' ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Supermarché</label>
                            <select name="id_supermarche" class="form-control">
                                <option value="">-- aucun --</option>
                                <?php foreach ($supermarches as $s): ?>
                                    <option value="<?= $s['id'] ?>"
                                        <?= isset($edit['id_supermarche']) && $edit['id_supermarche'] == $s['id'] ? 'selected' : '' ?>>
                                        <?= esc($s['nom']) ?> (id <?= $s['id'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ESPACE VIDE pour aligner le bouton -->
                        <div class="form-group col-md-5"></div>
                    </div>

                    <div class="form-row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> 
                                <?= $edit ? 'Modifier' : 'Ajouter' ?> la borne
                            </button>
                            <?php if ($edit): ?>
                                <a href="<?= base_url('Cadmin/bornes') ?>" class="btn btn-secondary btn-lg ml-2">
                                    <i class="fas fa-plus"></i> Nouvelle borne
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
