<div class="row">
    <div class="col">
        <a href="<?= site_url('Customers/add'); ?>" class="btn btn-primary mb-3"><i class="fa fa-user-plus"></i> Tambah Customer</a>
        <?= $this->session->flashdata('customers_msg'); ?>
        <div class="table-responsive">
            <table id="customers-table" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>