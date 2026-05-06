<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Supermarchés partenaires</h6>
            </div>
            <div class="card-body">

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Bornes</th> <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($supers)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Aucun supermarché</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($supers as $s): ?>
                                    <tr>
                                        <td><?= esc($s['id']) ?></td>
                                        <td><?= esc($s['nom']) ?></td>
                                        <td><?= esc($s['adresse']) ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-primary"><?= esc($s['nb_bornes'] ?? '0') ?></span>
                                        </td>
                                        <td><?= esc($s['latitude']) ?></td>
                                        <td><?= esc($s['longitude']) ?></td>
                                        <td>
                                            <a href="<?= base_url('Cadmin/supermarches?id='.$s['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('Cadmin/deleteSupermarche/'.$s['id']) ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Supprimer ce supermarché ?');">
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
                // Logique d'édition
                $edit = null;
                if (isset($_GET['id'])) {
                    foreach ($supers as $s) {
                        if ($s['id'] == $_GET['id']) {
                            $edit = $s;
                            break;
                        }
                    }
                }
                ?>

                <h6 class="font-weight-bold mb-3">
                    <?= $edit ? 'Modifier un supermarché' : 'Ajouter un supermarché' ?>
                </h6>

                <form method="post" action="<?= base_url('Cadmin/saveSupermarche') ?>">
                    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control"
                                   value="<?= $edit['nom'] ?? '' ?>" required>
                        </div>
                        <div class="form-group col-md-8">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control"
                                   value="<?= $edit['adresse'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control"
                                   value="<?= $edit['latitude'] ?? '' ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control"
                                   value="<?= $edit['longitude'] ?? '' ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Enregistrer
                    </button>
                    <?php if ($edit): ?>
                        <a href="<?= base_url('Cadmin/supermarches') ?>" class="btn btn-secondary">Annuler</a>
                    <?php endif; ?>
                </form>

            </div>
        </div>
    </div>
</div>