<div class="row">
    <div class="col-md-4">
        <?= validation_errors(); ?>

        <a href="<?= site_url('Customers'); ?>" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>

        <form action="<?= site_url('Customers/add'); ?>" method="post">
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
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-block">Tambah</button>
        </form>
    </div>
</div>