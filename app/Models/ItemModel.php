<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
    'sku',
    'item_name',
    'category',
    'min_stock',
    'current_stock'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'sku' => 'required|min_length[3]|max_length[50]|is_unique[items.sku]',
        'item_name' => 'required|min_length[3]|max_length[100]',
        'category' => 'required|min_length[3]|max_length[100]',
        'min_stock' => 'required|integer|greater_than_equal_to[0]',
        'current_stock' => 'required|integer|greater_than_equal_to[0]',
    ];

    public function useUpdateValidationRules(int $id): self
    {
        $this->validationRules['sku'] = 'required|min_length[3]|max_length[50]|is_unique[items.sku,id,' . $id . ']';
        return $this;
    }

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
