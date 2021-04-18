<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('templates/head'); ?>
</head>

<body>
    <div class="row mb-3">
        <div class="col text-center">
            <h2><?= $title ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <table>
                <tr>
                    <th width="170px">No.Transaksi</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['no_transaction'] ?></td>
                </tr>
                <tr>
                    <th width="170px">Tanggal</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['datetime'] ?></td>
                </tr>
                <tr>
                    <th width="170px">Kasir</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['cashier_name'] ?></td>
                </tr>
                <tr>
                    <th width="170px">Kustomer</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['customer_name'] ?></td>
                </tr>
                <tr>
                    <th width="170px">Keterangan</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['info'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table>
                <tr>
                    <th width="170px">Status</th>
                    <td width="30px"> : </td>
                    <td><?= $sale['status'] ?></td>
                </tr>
                <tr>
                    <th width="170px">Metode Pembayaran</th>
                    <td width="30px"> : </td>
                    <td><?= ($sale['payment_method'] == '1') ? 'CASH' : 'DEBIT'; ?></td>
                </tr>
                <tr>
                    <th width="170px">Total Pembelian</th>
                    <td width="30px"> : </td>
                    <td><?= 'Rp.' . number_format($sale['total_payment'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th width="170px">Jumlah dibayarkan</th>
                    <td width="30px"> : </td>
                    <td><?= 'Rp.' . number_format($sale['amounted_payment'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th width="170px">Kembalian</th>
                    <td width="30px"> : </td>
                    <td><?= 'Rp.' . number_format($sale['change_money'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col">
            <table class="table table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($sale_details as $detail) : ?>
                        <tr>
                            <td><?= $detail['product_name']; ?></td>
                            <td><?= 'Rp.' . number_format($detail['price'], 0, ',', '.'); ?></td>
                            <td><?= $detail['qty']; ?></td>
                            <td><?= 'Rp.' . number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php $total += $detail['subtotal']; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" align="center">TOTAL</td>
                        <td><?= 'Rp.' . number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>

    <?php $this->load->view('templates/scripts/scripts'); ?>
    <script>
        window.print();
        window.onafterprint = function(event) {
            window.location.href = "<?= $redirect ?>"
        }
    </script>
</body>

</html>