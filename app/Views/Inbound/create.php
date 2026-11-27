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
    <div>
        <button type="button" id="btn_toggle_scanner">
           Scan Barcode</button>
            <span id="scan_status" style="display: none;"> (Kamera Aktif)</span>
    </div>
    <div id="qr_reader" style="display: none;"></div>
    <form action="<?php echo site_url('inbound/store') ?>" method="post">
            <?php csrf_field(); ?>

            <div class="form-group">
                <label for="item_id">Item:</label>
                <select id="item_id" name="item_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($items as $item): ?>

                        <option value="<?=esc((string) $item['id']) ?>" 
                        data-sku="<?=esc(strtolower(trim((string) ($item['sku'] ?? ''))))?>"
                        <?= (string) old('item_id') === (string) $item['id'] ? 'selected' : '' ?>>
                            <?= esc($item['sku'] . ' - ' . $item['item_name']) ?> (Stok: <?php echo esc($item['current_stock']) ?>)
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

        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formEl = document.querySelector('form[action*="inbound/store"]') || document.querySelector('form');
            const readerEl = document.getElementById('qr_reader');
            const toggleBtn = document.getElementById('btn_toggle_scanner');
            const statusEl = document.getElementById('scan_status');
            const itemSelect = document.getElementById('item_id');
            const qtyInput = document.getElementById('quantity');

            let html5Qrcode= null;
            let isScanning = false;
            let isSubmitting = false;

            function parseSkuQty(decodedText) {
                const raw=String(decodedText||'').trim();
                if (!raw) return null;
                
                const parts = raw.split(':').map(p => p.trim());
                const sku = (parts[0] || '').toLowerCase();
                const qty = parseInt(parts[1] ||'', '10');

                if (!sku || isNaN(qty) || qty <= 0) {
                    return null;
                }
                return { sku, qty };
            }

        function findItemBySku(sku) {
            if (!sku||!itemSelect) return null;

            for(let i=0; i<itemSelect.options.length; i++) {
                const option = itemSelect.options[i];
                const optionSku = (option.getAttribute('data-sku')||'').toLowerCase();
                if (optionSku === sku) {
                    return option;
                }
            }
            return null;
        }

        async function stopScanner() {
            if (html5Qrcode && isScanning) {
                try {
                    await html5Qrcode.stop();
                    html5Qrcode.clear();
                } catch (error) {
                    console.error('Error stopping scanner:', error);
                }
            }
            isScanning = false;
            if(readerEl) readerEl.style.display = 'none';
            if(toggleBtn) toggleBtn.textContent = 'Start Scanner';
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', async function() {
                if (isScanning) {
                    await stopScanner();
                    statusEl.textContent = ' (Kamera Nonaktif)';
                    return;
                } 

                if (typeof Html5Qrcode === 'undefined') {
                    statusEl.textContent = ' (Html5Qrcode library not loaded)';
                    return;
                }

                readerEl.style.display = 'block';
                statusEl.textContent = ' Mengaktifkan Kamera...';
                html5Qrcode = html5Qrcode || new Html5Qrcode("qr_reader");

                try {
                    await html5Qrcode.start(
                        { facingMode: "environment" },
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 150 }
                        },
                        async function (decodedText) {
                            if (isSubmitting) return;
                            const parsed = parseSkuQty(decodedText);
                            if (!parsed) {
                                statusEl.textContent = ' (QR Code tidak valid/Salah format, terbaca: ' + decodedText + ')';
                                return;
                            }

                            const matchedValue = findItemBySku(parsed.sku);
                            if (!matchedValue) {
                                statusEl.textContent = ' (Barang dengan SKU: ' + parsed.sku + ' tidak ditemukan)';
                                return;
                            }

                            isSubmitting = true;
                            statusEl.textContent = ' (Terbaca, ' + parsed.sku + '| ' + parsed.qty + ') - memproses...)';

                            itemSelect.value = matchedValue.value;
                            itemSelect.dispatchEvent(new Event('change'));
                            if (qtyInput) {
                                qtyInput.value = parsed.qty;
                            }

                            await stopScanner();

                            if (formEl) {
                                if(typeof formEl.requestSubmit === 'function') {
                                    formEl.requestSubmit();
                                } else {
                                    formEl.submit();
                            }
                            }
                            },
                            function(){}
                    );
                    isScanning = true;
                    toggleBtn.textContent = 'Stop Scanner';
                    statusEl.textContent = ' (Kamera Aktif, arahkan ke Barcode / QR code)';
                } catch (err) {
                    readerEl.style.display = 'none';
                    console.error('Error starting scanner:', err);
                    statusEl.textContent = ' (Gagal mengaktifkan kamera)';
                }
            });
         }
        });
        </script>
    </div>
</body>
</html>