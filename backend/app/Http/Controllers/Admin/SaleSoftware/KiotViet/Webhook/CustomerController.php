<?php

namespace App\Http\Controllers\Admin\SaleSoftware\KiotViet\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\KiotViet\KiotVietService;
use Illuminate\Database\QueryException;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\City;
use App\Models\District;

class CustomerController extends WebhookController
{
    public function update(Request $request)
    {
        \Log::debug('updated customer');

        $customers = $this->getRequestData($request);

        if (!is_null($customers)) {
            foreach ($customers as $customer) {
                $birthday = null;
                if (isset($customer->birthDate)) {
                    $birthday = new \Datetime($customer['BirthDate']);
                }

                $cityId = null;
                $districtId = null;
                if (isset($customer['LocationName'])) {
                    preg_match('/(.+) - (.+)/', $customer['LocationName'], $matches);
                    $cityName = $matches[1];
                    $districtName = $matches[2];

                    $city = City::whereName($cityName)->first();
                    if ($city) {
                        $cityId = $city->id;
                    }

                    $district = District::whereName($districtName)->first();
                    if ($district) {
                        $districtId = $district->id;
                    }
                }

                try {
                    Customer::updateOrCreate(
                        ['kiotviet_id' => $customer['Id']],
                        ['name' => $customer['Name'], 'gender' => $customer['Gender'], 'phone_number' => $customer['ContactNumber'], 'address' => $customer['Address'], 'email' => optional($customer)->email, 'code' => $customer['Code'], 'living_city_id' => $cityId, 'district_id' => $districtId]
                    );
                } catch (QueryException $e) {
                    \Log::error('Cannot save customer: ' . $e->getMessage());
                    return response()->json(['error' => 'Cannot save customers' . $e->getMessage()], 500);
                }
            }
        }
    }

    public function destroy(Request $request)
    {
        \Log::debug('deleted customer');

        $kiotVietIds = $this->getRequestData($request);

        try {
            Customer::whereIn('kiotviet_id', $kiotVietIds)->delete();
        } catch (QueryException $e) {
            \Log::error('Cannot delete customers: ' . $e->getMessage());
            return response()->json(['error' => 'Cannot delete customers: ' . $e->getMessage()], 500);
        }
    }
}
