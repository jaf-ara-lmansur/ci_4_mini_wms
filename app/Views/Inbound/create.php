<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc($title??'Catat Barang Masuk') ?></title>
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
        .btn{
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
</style>
<body>
    <div class="container">
        <h1><?php echo esc($title??'Catat Barang Masuk') ?></h1>

    <?php if (! empty(session()->getFlashdata('errors'))): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?php echo esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo site_url('inbound/store') ?>" method="post">
            <?php csrf_field(); ?>

            <div class="form-group">
                <label for="item_id">Item:</label>
                <select id="item_id" name="item_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($items as $item): ?>
                        <option value="<?php echo esc($item['id']) ?>" <?php echo old('item_id') == $item['id'] ? 'selected' : '' ?>>
                            <?php echo esc($item['sku'] . ' - ' . $item['item_name']) ?> (Stok: <?php echo esc($item['current_stock']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="<?php echo old('quantity', 1) ?>" required>
            </div>

            <div class="form-group">
                <label for="qa_status">QA Status:</label>
                <select id="qa_status" name="qa_status" required>
                    <?php $selectedQA = old('qa_status', 'passed'); ?>
                    <option value="">-- Pilih Status QA --</option>
                    <option value="passed" <?= $selectedQA == 'passed' ? 'selected' : '' ?>>Passed</option>
                    <option value="hold" <?= $selectedQA == 'hold' ? 'selected' : '' ?>>Hold</option>
                    <option value="rejected" <?= $selectedQA == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>

            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"><?php echo old('notes') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    
</body>
</html>