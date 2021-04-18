<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pelanggan Belitung</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $customer_belitung ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Reseller</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $customer_reseller ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Produk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $products ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Produk Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $product_categories ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Transaksi Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $monthly_transaction ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Transaksi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $today_transaction ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pendapatan Kotor Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp. ' . number_format($month_gross_income['total_payment'], 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pendapatan Kotor Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp. ' . number_format($today_gross_income['total_payment'], 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Best Seller Produk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Terjual</th>
                                <th>Pendapat Kotor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($bestSellers as $product) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $product['product_name']; ?></td>
                                    <td><?= $product['sold'] . ' ' . $product['unit'] ?></td>
                                    <td> Rp. <?= number_format($product['gross_income'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Pendapatan Kotor</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Hari</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Bulan</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="yearly-tab" data-toggle="tab" href="#yearly" role="tab" aria-controls="yearly" aria-selected="false">Tahun</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                        <canvas id="dailyGrossIncomeChart" width="400" height="200"></canvas>
                    </div>
                    <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                        <canvas id="monthlyGrossIncomeChart" width="400" height="200"></canvas>
                    </div>
                    <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                        <canvas id="yearlyGrossIncomeChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>