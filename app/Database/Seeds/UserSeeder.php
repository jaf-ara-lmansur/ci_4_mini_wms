<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            [ 
                'username' => 'ch-001',
                'role' => 'checker',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'username' => 'ch-002',
                'role' => 'checker',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'username' => 'ch-003',
                'role' => 'checker',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ 
                'username' => 'spv-001',
                'role' => 'spv',
                'password_hash' => password_hash('password', PASSWORD_DEFAULT),
                'created_at' => $now,
                'updated_at' => $now
            ]

        ];
        $this->db->table('users')->insertBatch($data);
    }
}
