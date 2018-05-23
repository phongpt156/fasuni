<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;

class InventoryController extends Controller
{
    public function update(Request $request)
    {
        \Log::debug(['updated inventory', $request->all()]);
    }
}
