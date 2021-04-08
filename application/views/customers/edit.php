<div class="row">
    <div class="col-md-4">
        <a href="<?= site_url('Customers'); ?>" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>

        <?= $this->session->flashdata('customers_msg'); ?>
        <form action="<?= site_url('Customers/edit/') . $customer['id']; ?>" method="post">
            <div class="form-group">
                <label for="inputName">Nama</label>
                <input type="text" name="name" class="form-control" value="<?= $customer['name']; ?>">
            </div>
            <div class="form-group">
                <label for="inputTelp">Telp</label>
                <input type="number" name="telp" class="form-control" value="<?= $customer['telp']; ?>">
            </div>
            <div class=" form-group">
                <label for="" class="d-block">Jenis Kelamin</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="female" name="gender" class="custom-control-input" value="0" <?= ($customer['gender'] == '0') ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="female">Perempuan</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="male" name="gender" class="custom-control-input" value="1" <?= ($customer['gender'] == '1') ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="male">Laki-Laki</label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputCategory">Kategori</label>
                <select name="category_id" id="inputCategory" class="custom-select">
                    <?php foreach ($categories as $category) : ?>
                        <option <?= ($category['id'] == $customer['category_id']) ? 'selected' : ''; ?> value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-block">Ubah</button>
        </form>
    </div>
</div>