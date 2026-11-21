<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class ItemController extends BaseController
{
    protected ItemModel $itemModel;
    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    public function index()
    {
        $data = [
            'title'=> 'Master Barang',
            'items'=> $this->itemModel->orderBy('id', 'ASC')->findAll()
        ];
        return view('items/index', $data);
    }

    public function create()
    {
        return view('items/create', ['title' => 'Tambah Master Barang']);
    }

    public function store()
    {
        $payload =[
            'sku' => trim((string) $this->request->getPost('sku')),
            'item_name' => trim((string) $this->request->getPost('item_name')),
            'category' => trim((string) $this->request->getPost('category')),
            'min_stock' => (int) $this->request->getPost('min_stock'),
            'current_stock' => (int) $this->request->getPost('current_stock')
        ];
        if ($this->itemModel->insert($payload) === false) {
            return redirect()->back()->withInput()->with('errors', $this->itemModel->errors());
        }
        return redirect()->to('/items')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to('/items')->with('error', 'Data barang tidak ditemukan.');
        }
        return view('items/edit', ['title' => 'Edit Master Barang', 'item' => $item]);
    }

    public function update(int $id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to('/items')->with('error', 'Data barang tidak ditemukan.');
        }
        $payload = [
            'id' => $id,
            'sku' => trim((string) $this->request->getPost('sku')),
            'item_name' => trim((string) $this->request->getPost('item_name')),
            'category' => trim((string) $this->request->getPost('category')),
            'min_stock' => (int) $this->request->getPost('min_stock'),
            'current_stock' => (int) $this->request->getPost('current_stock')
        ];
        $this->itemModel->useUpdateValidationRules($id);
        if ($this->itemModel->update($id, $payload) === false) {
            return redirect()->back()->withInput()->with('errors', $this->itemModel->errors());
        }
        return redirect()->to('/items')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return redirect()->to('/items')->with('error', 'Data barang tidak ditemukan.');
        }
        $this->itemModel->delete($id);
        return redirect()->to('/items')->with('success', 'Data barang berhasil dihapus.');
    }
}
