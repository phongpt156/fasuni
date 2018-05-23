<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;
use Illuminate\Database\QueryException;
use App\Models\Customer;
use App\Models\Branch;

class CustomerController extends WebhookController
{
    public function update(Request $request)
    {
        $customers = $this->getRequestData($request);
        \Log::debug($customers);

        if (!is_null($customers)) {
            foreach ($customers as $customer) {

                try {
                    Customer::updateOrCreate(
                        ['kiotviet_id' => $customer['Id']],
                        ['name' => $customer['Name'], 'gender' => $customer['Gender'], 'phone_number' => $customer['ContactNumber'], 'address' => $customer['Address'], 'email' => optional($customer)->email, 'code' => $customer['Code']]
                    );
                } catch (QueryException $e) {
                    \Log::debug('Cannot save customer: ' . $e->getMessage());
                    return response()->json(['error' => 'Cannot save customers' . $e->getMessage()], 200);
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        \Log::debug(['deleted customer', $request->all()]);
    }
}
