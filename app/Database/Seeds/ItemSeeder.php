<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            [ 
                'sku' => 'SKU_M001',
                'item_name' => 'Alumunium sheet 1.5mm',
                'category' => 'Raw Material',
                'min_stock' => 20,
                'current_stock' => 30,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'sku' => 'SKU_M002',
                'item_name' => 'Copper Coil tube 3/4 inch',
                'category' => 'Raw Material',
                'min_stock' => 10,
                'current_stock' => 25,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'sku' => 'SKU_M003',
                'item_name' => 'Axial Fan 230V 50Hz',
                'category' => 'Raw Material',
                'min_stock' => 16,
                'current_stock' => 40,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'sku' => 'SKU_M004',
                'item_name' => 'Propeller Fan 230V 50Hz',
                'category' => 'Raw Material',
                'min_stock' => 16,
                'current_stock' => 25,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        $this->db->table('items')->insertBatch($data);
    }
}
