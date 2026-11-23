<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InboundLogModel;
use App\Models\ItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class InboundController extends BaseController
{

protected InboundLogModel $InboundModel;
protected ItemModel $ItemModel;

public function __construct()
    {
        $this->InboundModel = new InboundLogModel();
        $this->ItemModel = new ItemModel();
    }

    public function index()
    {
        $logs = $this->InboundModel
        ->select('inbound_logs.*,items.sku, items.item_name, items.current_stock')
        ->join('items', 'inbound_logs.item_id = items.id', 'left')
        ->orderBy('inbound_logs.id', 'DESC')
        ->findAll();

        return view('inbound/index', ['title'=>'Riwayat Inbound', 'logs'=>$logs]);
    }

    public function create()
    {
        $items = $this->ItemModel->orderBy('item_name', 'ASC')->findAll();
        return view('inbound/create', ['title'=>'Catat Inbound', 'items'=>$items]);
    }

    public function store()
    {
        $payload = [
            'item_id' =>(int) $this->request->getPost('item_id'),
            'quantity' =>(int) $this->request->getPost('quantity'),
            'qa_status' =>trim ((string) $this->request->getPost('qa_status')),
            'reference_no' =>trim ((string) $this->request->getPost('reference_no')),
            'notes' =>trim ((string) $this->request->getPost('notes'))
        ];
        if (!$this->InboundModel->validate($payload)) {
            return redirect()->back()->withInput()->with('errors', $this->InboundModel->errors());
        }
        $db = \Config\Database::connect();
        $db->transStart();

        $this->InboundModel->insert($payload);

        if ($payload['qa_status'] === 'passed') {
           $db->table('items')
           ->where('id', $payload['item_id'])
           ->set('current_stock', 'current_stock + ' . $payload['quantity'], false)
           ->update();
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', ['Failed to update inbound log.']);
        }
        $db->transCommit();
        return redirect()->to('/inbound')->with('success', 'Inbound log created successfully.');
    }
}
