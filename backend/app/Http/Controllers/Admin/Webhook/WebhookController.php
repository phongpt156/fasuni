<?php

namespace App\Http\Controllers\Admin\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;

class WebhookController extends Controller
{
    public function handlePayload(Request $request)
    {
        \Log::debug(['payload', $request->all()]);
    }
}
