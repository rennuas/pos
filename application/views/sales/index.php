<div class="row">
    <div class="col">
        <a href="<?= site_url('Sales/list'); ?>" class="btn btn-primary mb-3"><i class="fa fa-receipt"></i> Histori Penjualan</a>
        <?= $this->session->flashdata('transaction_msg'); ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="form-row">
                    <div class="col">
                        <label for="">No. Transaksi</label>
                        <input type="text" id="no-transaction" class="form-control" name="no_transaction" value="<?= $no_transaction; ?>" readonly="true">
                    </div>
                    <div class="col">
                        <label for="">Tanggal</label>
                        <input type="text" id="datetime" class="form-control" name="date" value="<?= date('d F Y'); ?>" readonly="true">
                    </div>
                    <div class="col">
                        <label for="">Kasir</label>
                        <input type="hidden" id="user-id" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">
                        <input type="text" id="user-name" class="form-control" name="user_name" value="<?= $this->session->userdata('name'); ?>" readonly="true">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-inline mb-3">
                    <div class="form-group mr-3">
                        <label for="inputProduct">Cari Barang : </label>
                        <input type="text" class="form-control ml-3" id="inputProduct" placeholder="Ketikan Nama Barang ...">
                    </div>
                    <div class="form-group mr-3">
                        <label for="inputCustomer" class="mr-3">Customer :</label>
                        <select name="customer_id" id="customers" class="custom-select">
                            <option value="1">Umum</option>
                            <optgroup label="Belitung">
                                <?php foreach ($customers as $customer) : ?>
                                    <?php if ($customer->category_id == '2') : ?>
                                        <option value="<?= $customer->customer_id; ?>"><?= $customer->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Reseller">
                                <?php foreach ($customers as $customer) : ?>
                                    <?php if ($customer->category_id == '3') : ?>
                                        <option value="<?= $customer->customer_id; ?>"><?= $customer->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                        <button class="btn btn-link ml-1" data-toggle="modal" data-target="#addCustomer">Daftar Baru?</button>
                    </div>
                </div>
                <table id="sales-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th width="400px">Nama Barang</th>
                            <th>Harga</th>
                            <th>Tambahan/Pengurangan Harga</th>
                            <th width="100px">Qty</th>
                            <th>Subtotal</th>
                            <th width="50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="total-payment" class="bg-primary rounded text-white text-right px-5 py-3">
                    <h2>Total : Rp. 0</h2>
                    <input type="hidden" name="total-payment" value="0">
                </div>
                <div class="row mt-3 justify-content-end">
                    <div class="col-7">
                        <textarea name="info" class="form-control" id="info" cols="30" rows="3" placeholder="Catatan Transaksi (jika ada)"></textarea>
                    </div>
                    <div class="col-5">
                        <select name="payment_method" id="payment-method" class="custom-select">
                            <option value="1">Cash</option>
                            <option value="2">Debit</option>
                        </select>
                        <table class="table borderless">
                            <tr>
                                <th>Bayar :</th>
                                <td><input type="text" id="amounted-payment" name="amounted_payment" class="form-control money" value="0"></td>
                            </tr>
                            <tr>
                                <th>Kembalian :</th>
                                <td>
                                    <input type="text" id="change" name="change" class="form-control" readonly="true">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="checkbox" name="print_invoice" id="print-invoice" class="mb-3" checked> Print struk
                                    <span class="float-right">Status : <span id="status">Belum dibayar</span></span>
                                    <button id="save-button" type="submit" class="btn btn-primary btn-block">Simpan</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= site_url('Customers/add'); ?>" method="post">
                    <input type="hidden" name="redirect" value="Sales">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Customer Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName">Nama</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputTelp">Telp</label>
                            <input type="number" name="telp" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="d-block">Jenis Kelamin</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="female" name="gender" class="custom-control-input" value="0" checked>
                                <label class="custom-control-label" for="female">Perempuan</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="male" name="gender" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="male">Laki-Laki</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory">Kategori</label>
                            <select name="category_id" id="inputCategory" class="custom-select">
                                <?php foreach ($customer_categories as $category) : ?>
                                    <?php if ($category['id'] != 1) : ?>
                                        <option value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>