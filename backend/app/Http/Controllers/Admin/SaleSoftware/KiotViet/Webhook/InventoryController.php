<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SaleSoftware\KiotViet\KiotVietController;
use Illuminate\Database\QueryException;
use App\Models\Inventory;

class InventoryController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug('updated inventory');

        $inventories = $this->getRequestData($request);

        $kiotVietController = new KiotVietController($this->kiotVietService);

        foreach ($inventories as $inventory) {
            $branchId = $kiotVietController->getBranchId($inventory['BranchId']);
            $productId = $kiotVietController->getProductId($inventory['ProductId']);

            try {
                Inventory::updateOrCreate(
                    ['product_id' => $productId, 'branch_id' => $branchId],
                    ['purchase_price' => $inventory['Cost'], 'quantity' => $inventory['OnHand']]
                );
            } catch (QueryException $e) {
                \Log::error('Cannot save inventory: ' . $e->getMessage());
                return response()->json(['error' => 'Cannot save inventory: ' . $e->getMessage()], 500);
            }
        }
    }
}
