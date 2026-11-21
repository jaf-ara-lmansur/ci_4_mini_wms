<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title??'Create Item')?>-Mini WMS</title>
</head>
<body>
    <div class="container">
        <h1><?= esc($title??'Tambah Barang')?></h1>

        <?php $error= session()->getFlashdata('error'); ?>
        <?php if(! empty ($error)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('items/store') ?>" method="post">
            <?php csrf_field(); ?>

            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" id="sku" name="sku" value="<?= old('sku') ?>" required>
            </div>

            <div class="form-group">
                <label for="item_name">Nama Barang:</label>
                <input type="text" id="item_name" name="item_name" value="<?= old('item_name') ?>" required>
            </div>

            <div class="form-group">
                <label for="min_stock">Minimum Stock:</label>
                <input type="number" id="min_stock" name="min_stock" min="0" value="<?= old('min_stock', 0) ?>" required>
            </div>

            <div class="form-group">
                <label for="current_stock">Current Stock:</label>
                <input type="number" id="current_stock" name="current_stock" min="0" value="<?= old('current_stock', 0) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('items') ?>" class="btn btn-secondary">Batal</a>
        </form>
</body>
</html>