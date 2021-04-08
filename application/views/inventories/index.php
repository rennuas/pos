<div class="row">
    <div class="col">
        <a href="<?= site_url('Inventories/add'); ?>" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Tambah Produk</a>
        <?= $this->session->flashdata('inventory_msg'); ?>
        <div class="table-responsive">
            <table id="inventories-table" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Category</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>