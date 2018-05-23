<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;

class ProductController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug(['updated product', $request->all()]);
    }

    public function destroy(Request $request)
    {
        \Log::debug(['deleted product', $request->all()]);
    }
}
