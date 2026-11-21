<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title??'Create Item')?>-Mini WMS</title>
</head>
<style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1cd019;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            display: block;
            font-size: 14px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #9e1d0c;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            font-size: 12px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #86bd10;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        ul {
        margin: 0;    
        padding-left: 20px;
        }
</style>
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
                <label for="category">Kategori:</label>
                <input type="text" id="category" name="category" value="<?= old('category') ?>" required>
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