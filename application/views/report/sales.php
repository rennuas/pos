<div class="row">
    <div class="col-md-5">
        <form action="<?= site_url('Report/sales'); ?>" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Mulai</label>
                        <input type="text" placeholder="Start date" data-toggle="datepicker" aria-label="First name" class="form-control start-date">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Akhir</label>
                        <input type="text" placeholder="End date" data-toggle="datepicker" aria-label="Last name" class="form-control end-date">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Produk</label>
                <select name="product" id="selectProduct" class="custom-select">
                    <option value="all">ALL</option>
                </select>
            </div>
            <hr>
            <button class="btn btn-success btn-block">Download Laporan</button>
        </form>
    </div>
</div>