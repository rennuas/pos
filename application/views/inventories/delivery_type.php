<div class="row">
    <div class="col-md-5">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Tambah Ongkos</button>
        <?= $this->session->flashdata('delivery_msg'); ?>
        <div class="table-responsive">
            <table class="table table-hovered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ongkos</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($types as $type) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>Rp. <?= number_format($type['cost'], 0, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $type['id']; ?>"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $type['id']; ?>"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('Delivery_type/add'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Tipe Ongkos Kirim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputCategory">Ongkos</label>
                        <input type="text" name="cost" class="form-control money" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php foreach ($types as $type) : ?>
    <div class="modal fade" id="editModal<?= $type['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= site_url('Delivery_type/edit/') . $type['id']; ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah Tipe Ongkos Kirim</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputCategory">Ongkos</label>
                            <input type="text" name="cost" class="form-control money" value="<?= $type['cost'] ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Delete Modal -->
<?php foreach ($types as $type) : ?>
    <div class="modal fade" id="deleteModal<?= $type['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Tipe Ongkos Kirim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Yakin untuk menghapus tipe ongkos kirim? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="<?= site_url('Delivery_type/delete/') . $type['id']; ?>" type="submit" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>