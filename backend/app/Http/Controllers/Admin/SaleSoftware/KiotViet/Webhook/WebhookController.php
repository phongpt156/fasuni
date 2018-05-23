<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;

class WebhookController extends Controller
{
    public function isValidRequest(Request $request)
    {
        if (isset($request->Notifications[0]['Data'])) {
            return true;
        }
        return false;
    }

    public function getRequestData(Request $request)
    {
        if ($this->isValidRequest($request)) {
            return $request->Notifications[0]['Data'];
        }

        return null;
    }
}
