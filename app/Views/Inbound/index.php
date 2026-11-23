<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=esc($title??'Inbound Logs') ?></title>
</head>
<body>
    <h1><?=esc($title??'Inbound Logs') ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="color: green;"><?=esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?=esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

   <div> <a href="<?=site_url('/inbound/create') ?>">Catat Inbound</a>
    <a href="<?=site_url('items') ?>">Manage Barang</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item ID</th>
                <th>SKU</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>QA Status</th>
                <th>Reference No</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($logs)): ?>
                <?php foreach ($logs as $i => $log): ?>
                <tr>
                    <td colspan="8">No inbound logs found.</td>
                </tr>
          
         <td><?=esc($log['id']) ?></td>
                <td><?=esc($log['item_id']) ?></td>
                <td><?=esc($log['sku']) ?></td>
                <td><?=esc($log['item_name']) ?></td>
                <td><?=esc($log['quantity']) ?></td>
                <td><?=esc($log['qa_status']) ?></td>
                <td><?=esc($log['reference_no']) ?></td>
                <td><?=esc($log['notes']) ?></td>
            </tr>
              <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No inbound logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    
</body>
</html>
               