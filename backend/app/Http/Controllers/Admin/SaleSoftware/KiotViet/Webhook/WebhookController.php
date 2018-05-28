<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;
use App\Exceptions\HttpClient\RequestException;

class WebhookController extends Controller
{
    protected $kiotVietService;

    public function __construct(KiotVietService $kiotVietService)
    {
        $this->kiotVietService = $kiotVietService;
    }

    public function register()
    {
        try {
            $this->kiotVietService->webhookService->register();
        } catch (RequestException $e) {
            \Log::error('Cannot register webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot register webhook: ' . json_decode($e->getMessage())->responseStatus->message], 500);
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function deleteAll()
    {
        try {
            $this->kiotVietService->webhookService->deleteAll();
        } catch (RequestException $e) {
            \Log::error('Cannot delete webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete webhook: ' . json_decode($e->getMessage())->responseStatus->message], 500);
        }

        return response()->json(['status' => 'success'], 200);
    }

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
