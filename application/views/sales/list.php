<div class="row">
    <div class="col">
        <a href="<?= site_url('Sales'); ?>" class="btn btn-primary mb-3"><i class="fa fa-file-invoice-dollar"></i> Transaksi </a>
        <?= $this->session->flashdata('transaction_msg'); ?>
        <div class="table-responsive">
            <table id="transaction-table" class="table table-sm">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>No. Transaksi</th>
                        <th>Kasir</th>
                        <th>Kustomer</th>
                        <th>Cash/Debit</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>