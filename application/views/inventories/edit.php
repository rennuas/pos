<div class="row">
    <div class="col-md-4">
        <a href="<?= site_url('Inventories'); ?>" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>

        <?= validation_errors(); ?>
        <?= $this->session->flashdata('inventory_msg'); ?>
        <?= $this->session->flashdata('unit_msg'); ?>
        <?= $this->session->flashdata('category_msg'); ?>

        <form action="<?= site_url('Inventories/edit/') . $inventory['id']; ?>" method="post">
            <div class="form-group">
                <label for="inputName">Nama Product</label>
                <input type="text" name="product_name" class="form-control" value="<?= $inventory['product_name']; ?>">
            </div>
            <div class="form-group">
                <label for="inputTelp">Harga Jual</label>
                <input type="text" name="sale_price" class="form-control money" value="<?= $inventory['sale_price']; ?>">
            </div>
            <div class="form-group">
                <label for="inputTelp">Harga Modal</label>
                <input type="text" name="capitral_price" class="form-control money" value="<?= $inventory['capital_price']; ?>">
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="inputTelp">Stok</label>
                        <input type="number" min="0" name="stock" class="form-control" value="<?= $inventory['stock']; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="inputCategory">Unit</label>
                        <select name="unit_id" id="inputUnit" class="custom-select">
                            <?php foreach ($units as $unit) : ?>
                                <option <?= ($unit['id'] == $inventory['unit_id']) ? 'selected' : ''; ?> value="<?= $unit['id']; ?>"><?= $unit['unit']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="text-right">
                            <a class="ml-auto mt-1" type="button" data-toggle="modal" data-target="#addUnit">Tambah unit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputCategory">Kategori</label>
                <select name="category_id" id="inputCategory" class="custom-select">
                    <?php foreach ($categories as $category) : ?>
                        <option <?= ($category['id'] == $inventory['category_id']) ? 'selected' : ''; ?> value="<?= $category['id']; ?>"><?= $category['category']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="text-right">
                    <a class="ml-auto mt-1" type="button" data-toggle="modal" data-target="#addCategory">Tambah kategori</a>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-block">Ubah</button>
        </form>
    </div>
</div>



<!-- Add Modal Unit -->
<div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('Stock_unit/add'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputCategory">Unit</label>
                        <input type="text" name="unit" class="form-control" required>
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


<!-- Add Modal Category -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('Inventory_categories/add'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputCategory">Kategori</label>
                        <input type="text" name="category" class="form-control" required>
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