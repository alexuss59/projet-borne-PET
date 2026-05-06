<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Bouteilles (<?= count($codes) ?>)
                </h6>
            </div>
            <div class="card-body">

                <!-- Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <!-- FORMULAIRE -->
                <?php
                $edit = null;
                if (isset($_GET['id']) && !empty($codes)) {
                    foreach ($codes as $c) {
                        if ($c['id'] == $_GET['id']) {
                            $edit = $c;
                            break;
                        }
                    }
                }
                ?>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold mb-3">
                            <?= $edit ? 'Modifier #' . $edit['id'] : 'Nouvelle bouteille' ?>
                        </h6>

                        <form method="post" action="<?= base_url('Cadmin/saveCode') ?>">
                            <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                            
                            <div class="form-group">
                                <label>Code-barres <span class="text-danger"></label>
                                <input type="text" name="code_barre" class="form-control" required 
                                       maxlength="50" value="<?= $edit['code_barre'] ?? '' ?>">
                            </div>

                            <div class="form-group">
                                <label>Marque</label>
                                <input type="text" name="marque" class="form-control" maxlength="100"
                                       value="<?= $edit['marque'] ?? '' ?>" placeholder="Cristaline">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" maxlength="255"
                                       value="<?= $edit['description'] ?? '' ?>" placeholder="Eau plate bouteille 50cl">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 
                                <?= $edit ? 'Modifier' : 'Ajouter' ?>
                            </button>
                            <?php if ($edit): ?>
                                <a href="<?= base_url('Cadmin/codesBarres') ?>" class="btn btn-secondary ml-2">
                                    <i class="fas fa-plus"></i> Nouveau
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- TABLEAU -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="60">ID</th>
                                <th>Code-barres</th>
                                <th>Marque</th>
                                <th>Description</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($codes)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">Aucune bouteille</td></tr>
                            <?php else: ?>
                                <?php foreach ($codes as $c): ?>
                                    <tr class="<?= $edit && $c['id'] == $edit['id'] ? 'table-warning' : '' ?>">
                                        <td><?= $c['id'] ?></td>
                                        <td><code><?= esc($c['code_barre']) ?></code></td>
                                        <td><?= esc($c['marque']) ?></td>
                                        <td><?= esc($c['description']) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('Cadmin/codesBarres?id=' . $c['id']) ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('Cadmin/deleteCode/' . $c['id']) ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Supprimer #<?= $c['id'] ?> ?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
