<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  esc($title??'Master Barang')?> - Mini WMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1cd019;
        }
        .container {
            max-width: 960px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
        .btn-warning {
            background-color: #410883;
        }
        .btn-danger {
            background-color: #d91515;
        }
        .row-low {
            background-color: #a2101c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1><?= esc($title??'Manage Barang') ?></h1>
            <a href="<?php echo site_url('items/create') ?>" class="btn btn-primary mb-3">Tambah Barang</a>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Nama Barang</th>
                        <th>Min Stock</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($items)): ?>
                    <?php foreach ($items as $index => $item): ?>
                        <?php
                        $minStock = (int) $item['min_stock']?? 0;
                        $currentStock = (int) $item['current_stock']?? 0;
                        $isLowStock = $currentStock < $minStock;
                        ?>
                        <tr class="<?php echo $isLowStock ? 'row-low' : ''; ?>">
                            <td><?=$index + 1; ?></td>
                            <td><strong><?=($item['sku']) ?></strong></td>
                            <td><?= esc($item['item_name']); ?></td>
                            <td><?=$minStock ?></td>
                            <td><?= $currentStock ?></td>
                            <td>
                                <?php if ($isLowStock): ?>
                                    <span class="badge badge-danger">Stok Rendah</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Stok Aman</span>
                                    <?php endif;?>
                            </td>
                            <td>
                                <a href="<?php echo site_url('items/edit/' . $item['id']); ?>" class="btn btn-warning">Edit</a>

                                <form action="<?php echo site_url('items/delete/' . $item['id']); ?>" method="post" style="display:inline;">
                                    <?php csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Tidak ada data barang.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
</body>
</html>